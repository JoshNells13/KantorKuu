<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Borrowing;
use App\Models\ReturnTool;
use App\Services\ActivityLogService;
use App\Services\StockService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PetugasController extends Controller
{
    protected $stockService;
    protected $activityLogService;

    public function __construct(StockService $stockService, ActivityLogService $activityLogService)
    {
        $this->stockService = $stockService;
        $this->activityLogService = $activityLogService;
    }

    public function index()
    {
        $borrowings = Borrowing::with(['user', 'tool'])->where('status', '!=', 'dikembalikan')->latest()->get();
        return view('Petugas.ReturnTool.index', compact('borrowings'));
    }

    public function approve(Borrowing $borrowing)
    {
        $qty = $borrowing->qty ?? 1;

        if (!$this->stockService->checkStock($borrowing->tool_id, $qty)) {
            return back()->with('error', 'Stok tidak mencukupi!');
        }

        // Generate PDF Proof
        $borrowing->load(['user', 'tool']);
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('PDF.approval', compact('borrowing'));

        $filename = 'surat_persetujuan_' . $borrowing->id . '_' . time() . '.pdf';
        $path = 'proofs/' . $filename;

        // Ensure directory exists
        if (!\Illuminate\Support\Facades\Storage::disk('public')->exists('proofs')) {
            \Illuminate\Support\Facades\Storage::disk('public')->makeDirectory('proofs');
        }

        \Illuminate\Support\Facades\Storage::disk('public')->put($path, $pdf->output());

        $borrowing->update([
            'status' => 'dipinjam',
            'proof' => $path
        ]);

        $this->stockService->decrementStock($borrowing->tool_id, $qty);

        $this->activityLogService->log(Auth::id(), "Menyetujui peminjaman alat: {$borrowing->tool->name}");

        return redirect()->route('petugas.borrowings.index')->with('success', 'Peminjaman di KantorKuu disetujui, surat persetujuan dibuat, dan stok berhasil dikurangi!');
    }

    public function returnTool(Borrowing $borrowing)
    {
        $borrowing->load(['user', 'tool']);
        return view('Petugas.ReturnTool.create', compact('borrowing'));
    }

    public function storeReturnTool(Request $request, Borrowing $borrowing)
    {
        // This acts as "Approval" for the return
        $returnTool = $borrowing->returnTool;

        if (!$returnTool) {
            $returnTool = ReturnTool::create([
                'borrowing_id' => $borrowing->id,
                'returned_at' => Carbon::now(),
                'fine' => 0,
                'return_condition' => 'Tidak Diketahui'
            ]);
        }

        $dueDate = Carbon::parse($borrowing->return_date);
        $returnedDate = Carbon::now();

        $lateDays = $returnedDate->greaterThan($dueDate)
            ? $dueDate->diffInDays($returnedDate)
            : 0;

        $fine = $lateDays * 5000;

        $returnTool->update([
            'fine' => $fine,
            'returned_at' => $returnedDate
        ]);

        $qty = $borrowing->qty ?? 1;
        $this->stockService->incrementStock($borrowing->tool_id, $qty);

        $this->activityLogService->log(Auth::id(), "Menyetujui pengembalian alat: {$borrowing->tool->name}");

        $borrowing->update(['status' => 'dikembalikan']);

        return redirect()->route('petugas.borrowings.index')->with('success', 'Pengembalian alat berhasil disetujui!');
    }
}
