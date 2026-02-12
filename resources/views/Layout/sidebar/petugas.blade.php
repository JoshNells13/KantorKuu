<a class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('petugas.dashboard') ? 'bg-primary text-white' : 'text-slate-500 dark:text-slate-400 hover:bg-primary/10 hover:text-primary' }} rounded-lg transition-colors"
    href="{{ route('petugas.dashboard') }}">
    <span class="material-icons text-[20px]">dashboard</span>
    <span class="font-medium">Dashboard</span>
</a>

<a class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('petugas.borrowings.*') ? 'bg-primary text-white' : 'text-slate-500 dark:text-slate-400 hover:bg-primary/10 hover:text-primary' }} rounded-lg transition-colors"
    href="{{ route('petugas.borrowings.index') }}">
    <span class="material-icons text-[20px]">assignment</span>
    <span class="font-medium">Peminjaman</span>
</a>

<a class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('petugas.reports') ? 'bg-primary text-white' : 'text-slate-500 dark:text-slate-400 hover:bg-primary/10 hover:text-primary' }} rounded-lg transition-colors"
    href="{{ route('petugas.reports') }}">
    <span class="material-icons text-[20px]">bar_chart</span>
    <span class="font-medium">Laporan</span>
</a>
