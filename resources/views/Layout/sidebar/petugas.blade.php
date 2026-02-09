<a href="{{ route('petugas.dashboard') }}"
    class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('petugas.dashboard') ? 'bg-blue-700' : 'hover:bg-blue-600' }} rounded-lg transition">
    <i class="fas fa-chart-line"></i>
    <span>Dashboard</span>
</a>

<div class="mt-4 mb-2 text-xs text-blue-200 uppercase font-semibold pl-4">Menu</div>
<a href="{{ route('petugas.borrowings.index') }}"
    class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('petugas.borrowings') ? 'bg-blue-700' : 'hover:bg-blue-600' }} rounded-lg transition">
    <i class="fas fa-clipboard-list"></i>
    <span>Data Peminjaman</span>
</a>
<a href="{{ route('petugas.reports') }}"
    class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('petugas.reports') ? 'bg-blue-700' : 'hover:bg-blue-600' }} rounded-lg transition">
    <i class="fas fa-file-alt"></i>
    <span>Laporan</span>
</a>
<form action="{{ route('logout') }}" method="POST">
    @csrf
    <button type="submit" onclick="return confirm('Ingin Keluar?')"
        class="flex items-center gap-3 px-4 py-3 hover:bg-blue-600 rounded-lg transition w-full text-left">
        <i class="fas fa-file-alt"></i>
        <span>Keluar</span>
    </button>
</form>
