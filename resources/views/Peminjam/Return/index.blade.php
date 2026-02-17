@extends('Layout.Dashboard')

@section('content')
<div class="p-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-blue-900">Riwayat Pengembalian & Denda</h1>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600">No</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600">Alat</th>
                    <th class="px-6 py-3 text-center text-xs font-semibold text-gray-600">Tgl Kembali</th>
                    <th class="px-6 py-3 text-center text-xs font-semibold text-gray-600"> Total harga Dan Denda</th>


                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse($returns as $item)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">{{ $loop->iteration }}</td>
                    <td class="px-6 py-4">{{ $item->borrowing->tool->name }}</td>
                    <td class="px-6 py-4 text-center">{{ date('d M Y', strtotime($item->returned_at)) }}</td>
                    <td class="px-6 py-4 text-center font-bold text-red-600">
                        Rp {{ number_format($item->fine, 0, ',', '.') }}
                    </td>

                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                        Belum ada riwayat pengembalian.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
