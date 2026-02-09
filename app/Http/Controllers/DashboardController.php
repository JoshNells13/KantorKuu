<?php

namespace App\Http\Controllers;

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
        ));
    }

    public function peminjam()
    {
        return view('Peminjam.index');
    }

    public function petugas()
    {
        return view('Petugas.index');
    }
}
