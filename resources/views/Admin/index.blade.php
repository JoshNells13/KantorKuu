@extends('Layout.Dashboard')

@section('page-title', 'Dashboard Admin')

@section('content')
<div class="space-y-6">
    <!-- Welcome Banner -->
    <div class="bg-gradient-to-r from-primary to-indigo-600 rounded-xl p-8 text-white">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold mb-2">Dashboard Administrator</h2>
                <p class="text-blue-100">Kelola sistem peminjaman alat dengan kontrol penuh</p>
            </div>
            <div class="hidden md:block">
                <span class="material-icons text-8xl opacity-20">admin_panel_settings</span>
            </div>
        </div>
    </div>

    <!-- Quick Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Tools -->
        <div class="bg-white dark:bg-slate-900 rounded-xl p-6 border border-slate-200 dark:border-slate-800">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center">
                    <span class="material-icons text-blue-600 dark:text-blue-400 text-2xl">inventory_2</span>
                </div>
            </div>
            <h3 class="text-3xl font-bold text-slate-900 dark:text-white mb-1">{{ $totalTools ?? 0 }}</h3>
            <p class="text-sm text-slate-500 dark:text-slate-400">Total Alat</p>
        </div>

        <!-- Total Borrowings -->
        <div class="bg-white dark:bg-slate-900 rounded-xl p-6 border border-slate-200 dark:border-slate-800">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center">
                    <span class="material-icons text-green-600 dark:text-green-400 text-2xl">assignment</span>
                </div>
            </div>
            <h3 class="text-3xl font-bold text-slate-900 dark:text-white mb-1">{{ $totalBorrowings ?? 0 }}</h3>
            <p class="text-sm text-slate-500 dark:text-slate-400">Total Peminjaman</p>
        </div>

        <!-- Active Borrowings -->
        <div class="bg-white dark:bg-slate-900 rounded-xl p-6 border border-slate-200 dark:border-slate-800">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-amber-100 dark:bg-amber-900/30 rounded-lg flex items-center justify-center">
                    <span class="material-icons text-amber-600 dark:text-amber-400 text-2xl">pending_actions</span>
                </div>
            </div>
            <h3 class="text-3xl font-bold text-slate-900 dark:text-white mb-1">{{ $activeBorrowings ?? 0 }}</h3>
            <p class="text-sm text-slate-500 dark:text-slate-400">Peminjaman Aktif</p>
        </div>

        <!-- Total Users -->
        <div class="bg-white dark:bg-slate-900 rounded-xl p-6 border border-slate-200 dark:border-slate-800">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900/30 rounded-lg flex items-center justify-center">
                    <span class="material-icons text-purple-600 dark:text-purple-400 text-2xl">people</span>
                </div>
            </div>
            <h3 class="text-3xl font-bold text-slate-900 dark:text-white mb-1">{{ $totalUsers ?? 0 }}</h3>
            <p class="text-sm text-slate-500 dark:text-slate-400">Total Pengguna</p>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <a href="{{ route('admin.tools.create') }}" 
           class="flex items-center gap-3 p-4 bg-blue-50 dark:bg-blue-900/20 hover:bg-blue-100 dark:hover:bg-blue-900/30 rounded-lg transition-colors group border border-blue-200 dark:border-blue-800">
            <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                <span class="material-icons text-white text-xl">add</span>
            </div>
            <div>
                <h4 class="font-semibold text-slate-900 dark:text-white text-sm">Tambah Alat</h4>
                <p class="text-xs text-slate-500 dark:text-slate-400">Alat baru</p>
            </div>
        </a>

        <a href="{{ route('admin.categories.create') }}" 
           class="flex items-center gap-3 p-4 bg-green-50 dark:bg-green-900/20 hover:bg-green-100 dark:hover:bg-green-900/30 rounded-lg transition-colors group border border-green-200 dark:border-green-800">
            <div class="w-10 h-10 bg-green-600 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                <span class="material-icons text-white text-xl">add</span>
            </div>
            <div>
                <h4 class="font-semibold text-slate-900 dark:text-white text-sm">Tambah Kategori</h4>
                <p class="text-xs text-slate-500 dark:text-slate-400">Kategori baru</p>
            </div>
        </a>

        <a href="{{ route('admin.users.create') }}" 
           class="flex items-center gap-3 p-4 bg-purple-50 dark:bg-purple-900/20 hover:bg-purple-100 dark:hover:bg-purple-900/30 rounded-lg transition-colors group border border-purple-200 dark:border-purple-800">
            <div class="w-10 h-10 bg-purple-600 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                <span class="material-icons text-white text-xl">person_add</span>
            </div>
            <div>
                <h4 class="font-semibold text-slate-900 dark:text-white text-sm">Tambah User</h4>
                <p class="text-xs text-slate-500 dark:text-slate-400">User baru</p>
            </div>
        </a>

        <a href="{{ route('admin.reports') }}" 
           class="flex items-center gap-3 p-4 bg-amber-50 dark:bg-amber-900/20 hover:bg-amber-100 dark:hover:bg-amber-900/30 rounded-lg transition-colors group border border-amber-200 dark:border-amber-800">
            <div class="w-10 h-10 bg-amber-600 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                <span class="material-icons text-white text-xl">bar_chart</span>
            </div>
            <div>
                <h4 class="font-semibold text-slate-900 dark:text-white text-sm">Lihat Laporan</h4>
                <p class="text-xs text-slate-500 dark:text-slate-400">Statistik</p>
            </div>
        </a>
    </div>

    <!-- Recent Activity & Pending Approvals -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Pending Approvals -->
        @if(isset($pendingBorrowings) && count($pendingBorrowings) > 0)
        <div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800">
            <div class="p-6 border-b border-slate-200 dark:border-slate-800 flex items-center justify-between">
                <h3 class="text-lg font-bold flex items-center gap-2">
                    <span class="material-icons text-amber-500">pending_actions</span>
                    Menunggu Persetujuan
                </h3>
                <span class="px-2 py-1 bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-400 rounded-full text-xs font-semibold">
                    {{ count($pendingBorrowings) }}
                </span>
            </div>
            <div class="divide-y divide-slate-200 dark:divide-slate-800 max-h-96 overflow-y-auto">
                @foreach($pendingBorrowings as $borrowing)
                <div class="p-4 hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
                    <div class="flex items-center justify-between mb-2">
                        <h4 class="font-semibold text-sm text-slate-900 dark:text-white">{{ $borrowing->user->name ?? 'User' }}</h4>
                        <span class="text-xs text-slate-500 dark:text-slate-400">{{ $borrowing->created_at ? $borrowing->created_at->diffForHumans() : '-' }}</span>
                    </div>
                    <p class="text-sm text-slate-600 dark:text-slate-400">{{ $borrowing->tool->name ?? 'Alat' }}</p>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Recent Borrowings -->
        @if(isset($recentBorrowings) && count($recentBorrowings) > 0)
        <div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800">
            <div class="p-6 border-b border-slate-200 dark:border-slate-800">
                <h3 class="text-lg font-bold flex items-center gap-2">
                    <span class="material-icons text-primary">history</span>
                    Aktivitas Terbaru
                </h3>
            </div>
            <div class="divide-y divide-slate-200 dark:divide-slate-800 max-h-96 overflow-y-auto">
                @foreach($recentBorrowings as $borrowing)
                <div class="p-4 hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
                    <div class="flex items-center justify-between mb-2">
                        <h4 class="font-semibold text-sm text-slate-900 dark:text-white">{{ $borrowing->user->name ?? 'User' }}</h4>
                        <span class="px-2 py-1 text-xs font-semibold rounded-full
                            @if($borrowing->status == 'approved') bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400
                            @elseif($borrowing->status == 'pending') bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400
                            @elseif($borrowing->status == 'returned') bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400
                            @else bg-gray-100 text-gray-700 dark:bg-gray-900/30 dark:text-gray-400
                            @endif">
                            {{ ucfirst($borrowing->status ?? 'pending') }}
                        </span>
                    </div>
                    <p class="text-sm text-slate-600 dark:text-slate-400">{{ $borrowing->tool->name ?? 'Alat' }}</p>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
