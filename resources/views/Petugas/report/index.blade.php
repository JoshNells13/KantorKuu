@extends('Layout.Dashboard')

@section('content')
<div class="p-8">
    <div class="flex justify-between items-center mb-6 no-print">
        <h1 class="text-2xl font-bold text-blue-900">Laporan Peminjaman</h1>
        <button onclick="window.print()" class="bg-gray-800 text-white px-4 py-2 rounded hover:bg-gray-900">
            <i class="fas fa-print mr-2"></i> Cetak Laporan
        </button>
    </div>

    <!-- Filter Section -->
    <div class="bg-white p-6 rounded-lg shadow mb-6 no-print">
        <form action="{{ route('petugas.reports') }}" method="GET" class="flex flex-wrap gap-4 items-end">
            <div>
                <label class="block mb-1 text-sm font-semibold">Dari Tanggal</label>
                <input type="date" name="start_date" value="{{ request('start_date') }}"
                       class="border rounded px-4 py-2 focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block mb-1 text-sm font-semibold">Sampai Tanggal</label>
                <input type="date" name="end_date" value="{{ request('end_date') }}"
                       class="border rounded px-4 py-2 focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block mb-1 text-sm font-semibold">Status</label>
                <select name="status" class="border rounded px-4 py-2 focus:ring-2 focus:ring-blue-500">
                    <option value="">Semua Status</option>
                    <option value="menunggu" {{ request('status') == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                    <option value="dipinjam" {{ request('status') == 'dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                    <option value="dikembalikan" {{ request('status') == 'dikembalikan' ? 'selected' : '' }}>Dikembalikan</option>
                    <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                </select>
            </div>
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                Filter
            </button>
            <a href="{{ route('petugas.reports') }}" class="text-gray-600 hover:text-gray-800 py-2">Reset</a>
        </form>
    </div>

    <!-- Report Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="p-6 border-b hidden print:block">
            <h2 class="text-xl font-bold text-center">Laporan Peminjaman Alat</h2>
            <p class="text-center text-gray-600">
                Periode: {{ request('start_date') ?? 'Awal' }} s/d {{ request('end_date') ?? 'Sekarang' }}
            </p>
        </div>

        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600">No</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600">Peminjam</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600">Alat</th>
                    <th class="px-6 py-3 text-center text-xs font-semibold text-gray-600">Tgl Pinjam</th>
                    <th class="px-6 py-3 text-center text-xs font-semibold text-gray-600">Tgl Kembali</th>
                    <th class="px-6 py-3 text-center text-xs font-semibold text-gray-600">Status</th>
                    <th class="px-6 py-3 text-center text-xs font-semibold text-gray-600">Denda</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse($borrowings as $item)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">{{ $loop->iteration }}</td>
                    <td class="px-6 py-4">{{ $item->user->name }}</td>
                    <td class="px-6 py-4">{{ $item->tool->name }}</td>
                    <td class="px-6 py-4 text-center">{{ date('d/m/Y', strtotime($item->borrow_date)) }}</td>
                    <td class="px-6 py-4 text-center">{{ date('d/m/Y', strtotime($item->return_date)) }}</td>
                    <td class="px-6 py-4 text-center">
                        {{ ucfirst($item->status) }}
                    </td>
                    <td class="px-6 py-4 text-center">
                        @if($item->returnTool)
                            Rp {{ number_format($item->returnTool->fine, 0, ',', '.') }}
                        @else
                            -
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                        Tidak ada data laporan.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<style>
    @media print {
        .no-print {
            display: none;
        }
        body {
            background: white;
        }
        .shadow {
            box-shadow: none;
        }
    }
</style>
@endsection
