@extends('Layout.Dashboard')

@section('page-title', 'Dashboard Peminjam')

@section('content')
    <div class="space-y-6">
        <!-- Welcome Banner -->
        <div class="bg-gradient-to-r from-primary to-blue-600 rounded-xl p-8 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold mb-2">Selamat Datang, {{ auth()->user()->name }}!</h2>
                    <p class="text-blue-100">Kelola peminjaman alat Anda di KantorKuu dengan mudah dan efisien</p>
                </div>
                <div class="hidden md:block">
                    <span class="material-icons text-8xl opacity-20">construction</span>
                </div>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Active Borrowings -->
            <div class="bg-white dark:bg-slate-900 rounded-xl p-6 border border-slate-200 dark:border-slate-800">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-slate-500 dark:text-slate-400 mb-1">Peminjaman Aktif</p>
                        <h3 class="text-3xl font-bold text-slate-900 dark:text-white">{{ $activeBorrowings ?? 0 }}</h3>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center">
                        <span class="material-icons text-blue-600 dark:text-blue-400 text-2xl">assignment</span>
                    </div>
                </div>
            </div>

            <!-- Pending Returns -->
            <div class="bg-white dark:bg-slate-900 rounded-xl p-6 border border-slate-200 dark:border-slate-800">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-slate-500 dark:text-slate-400 mb-1">Perlu Dikembalikan</p>
                        <h3 class="text-3xl font-bold text-slate-900 dark:text-white">{{ $pendingReturns ?? 0 }}</h3>
                    </div>
                    <div class="w-12 h-12 bg-amber-100 dark:bg-amber-900/30 rounded-lg flex items-center justify-center">
                        <span class="material-icons text-amber-600 dark:text-amber-400 text-2xl">assignment_return</span>
                    </div>
                </div>
            </div>

            <!-- Total Borrowed -->
            <div class="bg-white dark:bg-slate-900 rounded-xl p-6 border border-slate-200 dark:border-slate-800">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-slate-500 dark:text-slate-400 mb-1">Total Dipinjam</p>
                        <h3 class="text-3xl font-bold text-slate-900 dark:text-white">{{ $totalBorrowed ?? 0 }}</h3>
                    </div>
                    <div class="w-12 h-12 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center">
                        <span class="material-icons text-green-600 dark:text-green-400 text-2xl">check_circle</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white dark:bg-slate-900 rounded-xl p-6 border border-slate-200 dark:border-slate-800">
            <h3 class="text-lg font-bold mb-4 flex items-center gap-2">
                <span class="material-icons text-primary">bolt</span>
                Aksi Cepat
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <a href="{{ route('peminjam.tools') }}"
                    class="flex items-center gap-4 p-4 bg-primary/5 hover:bg-primary/10 rounded-lg transition-colors group">
                    <div
                        class="w-12 h-12 bg-primary rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                        <span class="material-icons text-white">inventory_2</span>
                    </div>
                    <div>
                        <h4 class="font-semibold text-slate-900 dark:text-white">Jelajahi Katalog</h4>
                        <p class="text-sm text-slate-500 dark:text-slate-400">Lihat semua alat yang tersedia</p>
                    </div>
                </a>

                <a href="{{ route('peminjam.borrowings.index') }}"
                    class="flex items-center gap-4 p-4 bg-blue-50 dark:bg-blue-900/20 hover:bg-blue-100 dark:hover:bg-blue-900/30 rounded-lg transition-colors group">
                    <div
                        class="w-12 h-12 bg-blue-600 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                        <span class="material-icons text-white">assignment</span>
                    </div>
                    <div>
                        <h4 class="font-semibold text-slate-900 dark:text-white">Peminjaman Saya</h4>
                        <p class="text-sm text-slate-500 dark:text-slate-400">Lihat riwayat peminjaman</p>
                    </div>
                </a>

                <a href="{{ route('peminjam.return-tools.index') }}"
                    class="flex items-center gap-4 p-4 bg-amber-50 dark:bg-amber-900/20 hover:bg-amber-100 dark:hover:bg-amber-900/30 rounded-lg transition-colors group">
                    <div
                        class="w-12 h-12 bg-amber-600 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                        <span class="material-icons text-white">assignment_return</span>
                    </div>
                    <div>
                        <h4 class="font-semibold text-slate-900 dark:text-white">Pengembalian</h4>
                        <p class="text-sm text-slate-500 dark:text-slate-400">Kembalikan alat yang dipinjam</p>
                    </div>
                </a>
            </div>
        </div>

        <!-- Recent Activity (if any) -->
        @if(isset($recentBorrowings) && count($recentBorrowings) > 0)
            <div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800">
                <div class="p-6 border-b border-slate-200 dark:border-slate-800">
                    <h3 class="text-lg font-bold flex items-center gap-2">
                        <span class="material-icons text-primary">history</span>
                        Aktivitas Terbaru
                    </h3>
                </div>
                <div class="divide-y divide-slate-200 dark:divide-slate-800">
                    @foreach($recentBorrowings as $borrowing)
                        <div class="p-6 hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 bg-primary/10 rounded-lg flex items-center justify-center">
                                        <span class="material-icons text-primary">inventory_2</span>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-slate-900 dark:text-white">
                                            {{ $borrowing->tool->name ?? 'Alat' }}
                                        </h4>
                                        <p class="text-sm text-slate-500 dark:text-slate-400">
                                            {{ $borrowing->borrow_date ? \Carbon\Carbon::parse($borrowing->borrow_date)->format('d M Y') : '-' }}
                                        </p>
                                    </div>
                                </div>
                                <span class="px-3 py-1 text-xs font-semibold rounded-full
                                                            @if($borrowing->status == 'approved') bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400
                                                            @elseif($borrowing->status == 'pending') bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400
                                                            @elseif($borrowing->status == 'returned') bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400
                                                            @else bg-gray-100 text-gray-700 dark:bg-gray-900/30 dark:text-gray-400
                                                            @endif">
                                    {{ ucfirst($borrowing->status ?? 'pending') }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
@endsection