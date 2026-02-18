<a class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('admin.dashboard') ? 'bg-primary text-white' : 'text-slate-500 dark:text-slate-400 hover:bg-primary/10 hover:text-primary' }} rounded-lg transition-colors"
    href="{{ route('admin.dashboard') }}">
    <span class="material-icons text-[20px]">dashboard</span>
    <span class="font-medium">Dashboard</span>
</a>

<a class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('admin.tools.*') ? 'bg-primary text-white' : 'text-slate-500 dark:text-slate-400 hover:bg-primary/10 hover:text-primary' }} rounded-lg transition-colors"
    href="{{ route('admin.tools.index') }}">
    <span class="material-icons text-[20px]">inventory_2</span>
    <span class="font-medium">Alat</span>
</a>

<a class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('admin.categories.*') ? 'bg-primary text-white' : 'text-slate-500 dark:text-slate-400 hover:bg-primary/10 hover:text-primary' }} rounded-lg transition-colors"
    href="{{ route('admin.categories.index') }}">
    <span class="material-icons text-[20px]">category</span>
    <span class="font-medium">Kategori</span>
</a>

<a class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('admin.borrowings.*') ? 'bg-primary text-white' : 'text-slate-500 dark:text-slate-400 hover:bg-primary/10 hover:text-primary' }} rounded-lg transition-colors"
    href="{{ route('admin.borrowings.index') }}">
    <span class="material-icons text-[20px]">assignment</span>
    <span class="font-medium">Peminjaman</span>
</a>

<a class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('admin.return-tools.*') ? 'bg-primary text-white' : 'text-slate-500 dark:text-slate-400 hover:bg-primary/10 hover:text-primary' }} rounded-lg transition-colors"
    href="{{ route('admin.return-tools.index') }}">
    <span class="material-icons text-[20px]">assignment_return</span>
    <span class="font-medium">Pengembalian</span>
</a>

<a class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('admin.users.*') ? 'bg-primary text-white' : 'text-slate-500 dark:text-slate-400 hover:bg-primary/10 hover:text-primary' }} rounded-lg transition-colors"
    href="{{ route('admin.users.index') }}">
    <span class="material-icons text-[20px]">people</span>
    <span class="font-medium">Pengguna</span>
</a>

<a class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('admin.activity-logs.*') ? 'bg-primary text-white' : 'text-slate-500 dark:text-slate-400 hover:bg-primary/10 hover:text-primary' }} rounded-lg transition-colors"
    href="{{ route('admin.activity-logs.index') }}">
    <span class="material-icons text-[20px]">history</span>
    <span class="font-medium">Log Aktivitas</span>
</a>


