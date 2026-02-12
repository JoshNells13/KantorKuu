<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Borrowing;
use App\Models\ReturnTool;
use App\Models\Tool;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function admin()
    {
        // Total alat
        $totalAlat = Tool::count();


        // Alat sedang dipinjam
        $alatDipinjam = Borrowing::where('status', 'dipinjam')->count();

        // Peminjam aktif (distinct user)
        $peminjamAktif = Borrowing::whereIn('status', ['menunggu', 'dipinjam'])
            ->distinct('user_id')
            ->count('user_id');

        // Keterlambatan
        $keterlambatan = Borrowing::where('status', 'dipinjam')
            ->where('return_date', '<', Carbon::today())
            ->count();

        // Peminjaman terbaru
        $peminjamanTerbaru = Borrowing::with(['user', 'tool'])
            ->latest()
            ->limit(5)
            ->get();

        //Total Stok Alat
        $totalStokAlat = Tool::sum('stock');



        //Total Peminjaman Alat Yang Sedang Diproses

        $peminjamDiProses = Borrowing::whereIn('status',['menunggu'])->count();

        if ($totalStokAlat > 0) {
            $alatTersedia = max(0, $totalStokAlat - $alatDipinjam);
            $persentaseAlatTersedia = round(($alatTersedia / $totalStokAlat) * 100, 2);
        } else {
            $persentaseAlatTersedia = 0;
        }



        return view('Admin.index', compact(
            'totalAlat',
            'alatDipinjam',
            'peminjamAktif',
            'keterlambatan',
            'peminjamanTerbaru',
            'totalStokAlat',
            'persentaseAlatTersedia',
            'peminjamDiProses'
        ))->with([
            'totalTools' => $totalAlat,
            'totalBorrowings' => Borrowing::count(),
            'activeBorrowings' => $alatDipinjam,
            'totalUsers' => \App\Models\User::count(),
            'pendingBorrowings' => Borrowing::where('status', 'menunggu')->with(['user', 'tool'])->latest()->limit(5)->get(),
            'recentBorrowings' => $peminjamanTerbaru
        ]);
    }

    public function peminjam()
    {
        $userId = auth()->id();
        
        // Active borrowings
        $activeBorrowings = Borrowing::where('user_id', $userId)
            ->whereIn('status', ['menunggu', 'dipinjam'])
            ->count();
        
        // Pending returns
        $pendingReturns = Borrowing::where('user_id', $userId)
            ->where('status', 'dipinjam')
            ->count();
        
        // Total borrowed (all time)
        $totalBorrowed = Borrowing::where('user_id', $userId)->count();
        
        // Recent borrowings
        $recentBorrowings = Borrowing::with(['tool'])
            ->where('user_id', $userId)
            ->latest()
            ->limit(5)
            ->get();
        
        return view('Peminjam.index', compact(
            'activeBorrowings',
            'pendingReturns',
            'totalBorrowed',
            'recentBorrowings'
        ));
    }

    public function petugas()
    {
        // Pending approvals count
        $pendingCount = Borrowing::where('status', 'menunggu')->count();
        
        // Active borrowings
        $activeCount = Borrowing::where('status', 'dipinjam')->count();
        
        // Pending returns (approved but not yet returned)
        $returnCount = Borrowing::where('status', 'dipinjam')->count();
        
        // Today's activity
        $todayCount = Borrowing::whereDate('created_at', Carbon::today())->count();
        
        // Pending borrowings list
        $pendingBorrowings = Borrowing::with(['user', 'tool'])
            ->where('status', 'menunggu')
            ->latest()
            ->limit(10)
            ->get();
        
        return view('Petugas.index', compact(
            'pendingCount',
            'activeCount',
            'returnCount',
            'todayCount',
            'pendingBorrowings'
        ));
    }
}
