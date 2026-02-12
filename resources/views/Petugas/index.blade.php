@extends('Layout.Dashboard')

@section('page-title', 'Dashboard Petugas')

@section('content')
<div class="space-y-6">
    <!-- Welcome Banner -->
    <div class="bg-gradient-to-r from-primary to-blue-600 rounded-xl p-8 text-white">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold mb-2">Dashboard Petugas 👨‍💼</h2>
                <p class="text-blue-100">Kelola persetujuan dan peminjaman alat</p>
            </div>
            <div class="hidden md:block">
                <span class="material-icons text-8xl opacity-20">assignment_ind</span>
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <!-- Pending Approvals -->
        <div class="bg-white dark:bg-slate-900 rounded-xl p-6 border border-slate-200 dark:border-slate-800">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-amber-100 dark:bg-amber-900/30 rounded-lg flex items-center justify-center">
                    <span class="material-icons text-amber-600 dark:text-amber-400 text-2xl">pending_actions</span>
                </div>
            </div>
            <h3 class="text-3xl font-bold text-slate-900 dark:text-white mb-1">{{ $pendingCount ?? 0 }}</h3>
            <p class="text-sm text-slate-500 dark:text-slate-400">Menunggu Persetujuan</p>
        </div>

        <!-- Active Borrowings -->
        <div class="bg-white dark:bg-slate-900 rounded-xl p-6 border border-slate-200 dark:border-slate-800">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center">
                    <span class="material-icons text-blue-600 dark:text-blue-400 text-2xl">assignment</span>
                </div>
            </div>
            <h3 class="text-3xl font-bold text-slate-900 dark:text-white mb-1">{{ $activeCount ?? 0 }}</h3>
            <p class="text-sm text-slate-500 dark:text-slate-400">Peminjaman Aktif</p>
        </div>

        <!-- Pending Returns -->
        <div class="bg-white dark:bg-slate-900 rounded-xl p-6 border border-slate-200 dark:border-slate-800">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center">
                    <span class="material-icons text-green-600 dark:text-green-400 text-2xl">assignment_return</span>
                </div>
            </div>
            <h3 class="text-3xl font-bold text-slate-900 dark:text-white mb-1">{{ $returnCount ?? 0 }}</h3>
            <p class="text-sm text-slate-500 dark:text-slate-400">Perlu Dikembalikan</p>
        </div>

        <!-- Today's Activity -->
        <div class="bg-white dark:bg-slate-900 rounded-xl p-6 border border-slate-200 dark:border-slate-800">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900/30 rounded-lg flex items-center justify-center">
                    <span class="material-icons text-purple-600 dark:text-purple-400 text-2xl">today</span>
                </div>
            </div>
            <h3 class="text-3xl font-bold text-slate-900 dark:text-white mb-1">{{ $todayCount ?? 0 }}</h3>
            <p class="text-sm text-slate-500 dark:text-slate-400">Aktivitas Hari Ini</p>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <a href="{{ route('petugas.borrowings.index') }}" 
           class="flex items-center gap-4 p-4 bg-primary/5 hover:bg-primary/10 rounded-lg transition-colors group border border-primary/20">
            <div class="w-12 h-12 bg-primary rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                <span class="material-icons text-white">assignment</span>
            </div>
            <div>
                <h4 class="font-semibold text-slate-900 dark:text-white">Semua Peminjaman</h4>
                <p class="text-sm text-slate-500 dark:text-slate-400">Lihat daftar peminjaman</p>
            </div>
        </a>

        <a href="{{ route('petugas.borrowings.index') }}" 
           class="flex items-center gap-4 p-4 bg-amber-50 dark:bg-amber-900/20 hover:bg-amber-100 dark:hover:bg-amber-900/30 rounded-lg transition-colors group border border-amber-200 dark:border-amber-800">
            <div class="w-12 h-12 bg-amber-600 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                <span class="material-icons text-white">pending_actions</span>
            </div>
            <div>
                <h4 class="font-semibold text-slate-900 dark:text-white">Perlu Disetujui</h4>
                <p class="text-sm text-slate-500 dark:text-slate-400">Proses persetujuan</p>
            </div>
        </a>

        <a href="{{ route('petugas.reports') }}" 
           class="flex items-center gap-4 p-4 bg-blue-50 dark:bg-blue-900/20 hover:bg-blue-100 dark:hover:bg-blue-900/30 rounded-lg transition-colors group border border-blue-200 dark:border-blue-800">
            <div class="w-12 h-12 bg-blue-600 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                <span class="material-icons text-white">bar_chart</span>
            </div>
            <div>
                <h4 class="font-semibold text-slate-900 dark:text-white">Laporan</h4>
                <p class="text-sm text-slate-500 dark:text-slate-400">Lihat statistik</p>
            </div>
        </a>
    </div>

    <!--Pending Approvals List -->
    @if(isset($pendingBorrowings) && count($pendingBorrowings) > 0)
    <div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800">
        <div class="p-6 border-b border-slate-200 dark:border-slate-800 flex items-center justify-between">
            <h3 class="text-lg font-bold flex items-center gap-2">
                <span class="material-icons text-amber-500">pending_actions</span>
                Perlu Persetujuan Segera
            </h3>
            <span class="px-3 py-1 bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-400 rounded-full text-sm font-semibold">
                {{ count($pendingBorrowings) }} Pending
            </span>
        </div>
        <div class="divide-y divide-slate-200 dark:divide-slate-800">
            @foreach($pendingBorrowings as $borrowing)
            <div class="p-6 hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-4 flex-1">
                        <div class="w-10 h-10 bg-primary/10 rounded-lg flex items-center justify-center">
                            <span class="material-icons text-primary">inventory_2</span>
                        </div>
                        <div class="flex-1">
                            <h4 class="font-semibold text-slate-900 dark:text-white">{{ $borrowing->tool->name ?? 'Alat' }}</h4>
                            <p class="text-sm text-slate-500 dark:text-slate-400">
                                Peminjam: {{ $borrowing->user->name ?? 'User' }} • 
                                {{ $borrowing->created_at ? $borrowing->created_at->diffForHumans() : '-' }}
                            </p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <form action="{{ route('petugas.borrowings.approve', $borrowing->id) }}" method="POST" class="inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit" 
                                class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg text-sm font-medium transition-colors flex items-center gap-1">
                                <span class="material-icons text-sm">check</span>
                                Setujui
                            </button>
                        </form>
                        <a href="{{ route('petugas.borrowings.index') }}" 
                           class="px-4 py-2 bg-slate-200 dark:bg-slate-700 hover:bg-slate-300 dark:hover:bg-slate-600 text-slate-700 dark:text-slate-300 rounded-lg text-sm font-medium transition-colors">
                            Detail
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection
