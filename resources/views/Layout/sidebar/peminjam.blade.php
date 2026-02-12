<a class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('peminjam.dashboard') ? 'bg-primary text-white' : 'text-slate-500 dark:text-slate-400 hover:bg-primary/10 hover:text-primary' }} rounded-lg transition-colors"
    href="{{ route('peminjam.dashboard') }}">
    <span class="material-icons text-[20px]">dashboard</span>
    <span class="font-medium">Dashboard</span>
</a>

<a class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('peminjam.tools') ? 'bg-primary text-white' : 'text-slate-500 dark:text-slate-400 hover:bg-primary/10 hover:text-primary' }} rounded-lg transition-colors"
    href="{{ route('peminjam.tools') }}">
    <span class="material-icons text-[20px]">inventory_2</span>
    <span class="font-medium">Katalog Alat</span>
</a>

<a class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('peminjam.borrowings.*') ? 'bg-primary text-white' : 'text-slate-500 dark:text-slate-400 hover:bg-primary/10 hover:text-primary' }} rounded-lg transition-colors"
    href="{{ route('peminjam.borrowings.index') }}">
    <span class="material-icons text-[20px]">assignment</span>
    <span class="font-medium">Peminjaman Saya</span>
</a>

<a class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('peminjam.return-tools.*') ? 'bg-primary text-white' : 'text-slate-500 dark:text-slate-400 hover:bg-primary/10 hover:text-primary' }} rounded-lg transition-colors"
    href="{{ route('peminjam.return-tools.index') }}">
    <span class="material-icons text-[20px]">assignment_return</span>
    <span class="font-medium">Pengembalian Saya</span>
</a>

<a class="flex items-center gap-3 px-4 py-3 text-slate-500 dark:text-slate-400 hover:bg-primary/10 hover:text-primary rounded-lg transition-colors"
    href="{{ route('home') }}">
    <span class="material-icons text-[20px]">home</span>
    <span class="font-medium">Beranda</span>
</a>
