<?php

namespace App\Http\Controllers;

use App\Models\Borrowing;
use Illuminate\Support\Facades\Storage;

class BorrowingPdfController extends Controller
{
    public function download(Borrowing $borrowing)
    {
        if (!$borrowing->proof || !Storage::disk('public')->exists($borrowing->proof)) {
            return back()->with('error', 'Surat persetujuan tidak ditemukan!');
        }

        return Storage::disk('public')->download($borrowing->proof, 'Surat_Persetujuan_' . $borrowing->id . '.pdf');
    }
}
