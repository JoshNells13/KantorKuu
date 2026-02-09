<a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('admin.dashboard') ? 'bg-blue-700' : 'hover:bg-blue-600' }} rounded-lg transition">
    <i class="fas fa-chart-line"></i>
    <span>Dashboard</span>
</a>

<div class="mt-4 mb-2 text-xs text-blue-200 uppercase font-semibold pl-4">Master Data</div>
<a href="{{ route('users.index') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('users.*') ? 'bg-blue-700' : 'hover:bg-blue-600' }} rounded-lg transition">
    <i class="fas fa-users"></i>
    <span>Data Pengguna</span>
</a>
<a href="{{ route('categories.index') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('categories.*') ? 'bg-blue-700' : 'hover:bg-blue-600' }} rounded-lg transition">
    <i class="fas fa-tags"></i>
    <span>Kategori</span>
</a>
<a href="{{ route('tools.index') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('tools.*') ? 'bg-blue-700' : 'hover:bg-blue-600' }} rounded-lg transition">
    <i class="fas fa-tools"></i>
    <span>Data Alat</span>
</a>

<div class="mt-4 mb-2 text-xs text-blue-200 uppercase font-semibold pl-4">Transaksi</div>
<a href="{{ route('admin.borrowings.index') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('borrowings.*') ? 'bg-blue-700' : 'hover:bg-blue-600' }} rounded-lg transition">
    <i class="fas fa-clipboard-list"></i>
    <span>Peminjaman</span>
</a>
<a href="{{ route('admin.return-tools.index') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('return-tools.*') ? 'bg-blue-700' : 'hover:bg-blue-600' }} rounded-lg transition">
    <i class="fas fa-undo"></i>
    <span>Pengembalian</span>
</a>

<div class="mt-4 mb-2 text-xs text-blue-200 uppercase font-semibold pl-4">Lainnya</div>
<a href="{{ route('admin.activity-logs.index') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('activities.*') ? 'bg-blue-700' : 'hover:bg-blue-600' }} rounded-lg transition">
    <i class="fas fa-history"></i>
    <span>Log Aktivitas</span>
</a>
<form action="{{ route('logout') }}" method="POST">
    @csrf
    <button type="submit" onclick="return confirm('Ingin Keluar?')" class="flex items-center gap-3 px-4 py-3 hover:bg-blue-600 rounded-lg transition w-full text-left">
        <i class="fas fa-file-alt"></i>
        <span>Keluar</span>
    </button>
</form>
