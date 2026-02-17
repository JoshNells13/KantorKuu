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

        $borrowing->update(['status' => 'dipinjam']);

        $this->stockService->decrementStock($borrowing->tool_id, $qty);

        $this->activityLogService->log(Auth::id(), "Menyetujui peminjaman alat: {$borrowing->tool->name}");

        return redirect()->route('petugas.borrowings.index')->with('success', 'Peminjaman alat disetujui dan stok berhasil dikurangi!');
    }

    public function returnTool(Borrowing $borrowing)
    {
        $borrowing->load(['user', 'tool']);
        return view('Petugas.ReturnTool.create', compact('borrowing'));
    }

    public function storeReturnTool(Request $request, Borrowing $borrowing)
    {

        // Tambah stok alat
        $qty = $borrowing->qty ?? 1;
        $this->stockService->incrementStock($borrowing->tool_id, $qty);

        $dueDate = Carbon::parse($borrowing->return_date);
        $returnedDate = Carbon::now();

        $lateDays = $returnedDate->greaterThan($dueDate)
            ? $dueDate->diffInDays($returnedDate)
            : 0;

        $fine = $lateDays * 5000;

        $totalfine = $borrowing->total_price + $fine;

        ReturnTool::create([
            'borrowing_id' => $borrowing->id,
            'returned_at'  => $returnedDate,
            'fine'         => $totalfine
        ]);

        $this->activityLogService->log(Auth::id(), "Mengembalikan alat: {$borrowing->tool->name}");

        $borrowing->update(['status' => 'dikembalikan']);

        return redirect()->route('petugas.borrowings.index')->with('success', 'Pengembalian alat berhasil diproses!');
    }
}
