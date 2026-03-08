@extends('Layout.Dashboard')

@section('content')
    <div class="p-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-blue-900">Riwayat Peminjaman Saya</h1>
            <a href="{{ route('peminjam.borrowings.create') }}"
                class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Pinjam Alat Baru
            </a>
        </div>

        <div class="bg-white rounded-lg shadow overflow-hidden">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600">No</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600">Alat</th>
                        <th class="px-6 py-3 text-center text-xs font-semibold text-gray-600">Tgl Pinjam</th>
                        <th class="px-6 py-3 text-center text-xs font-semibold text-gray-600">Tgl Kembali</th>
                        <th class="px-6 py-3 text-center text-xs font-semibold text-gray-600">Jumlah</th>
                        <th class="px-6 py-3 text-center text-xs font-semibold text-gray-600">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse($borrowings as $item)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4">{{ $item->tool->name }}</td>
                            <td class="px-6 py-4 text-center">{{ date('d M Y', strtotime($item->borrow_date)) }}</td>
                            <td class="px-6 py-4 text-center">{{ date('d M Y', strtotime($item->return_date)) }}</td>
                            <td class="px-6 py-4 text-center">{{ $item->qty }}</td>
                            <td class="px-6 py-4 text-center">
                                @if ($item->status == 'menunggu')
                                    <span
                                        class="bg-yellow-100 text-yellow-800 text-xs font-semibold px-2 py-1 rounded">Menunggu</span>
                                @elseif($item->status == 'dipinjam')
                                    <span
                                        class="bg-blue-100 text-blue-800 text-xs font-semibold px-2 py-1 rounded">Dipinjam</span>
                                    <div class="mt-2">
                                        <form action="{{ route('peminjam.return-tools.store', $item->id) }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="returned_at" value="{{ now() }}">
                                            <button type="submit"
                                                class="text-xs bg-green-500 hover:bg-green-600 text-white px-2 py-1 rounded">
                                                Kembalikan
                                            </button>
                                        </form>
                                    </div>
                                @elseif($item->status == 'dikembalikan' || $item->status == 'selesai')
                                    <span
                                        class="bg-green-100 text-green-800 text-xs font-semibold px-2 py-1 rounded">Selesai</span>
                                @else
                                    <span
                                        class="bg-gray-100 text-gray-800 text-xs font-semibold px-2 py-1 rounded">{{ ucfirst($item->status) }}</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                                Belum ada riwayat peminjaman.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
