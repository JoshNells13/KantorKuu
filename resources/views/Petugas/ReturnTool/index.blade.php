@extends('Layout.Dashboard')

@section('content')
    <div class="p-8">


        <div class="bg-white rounded-lg shadow overflow-hidden">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600">No</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600">Peminjam</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600">Alat</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600">Jumlah</th>
                        <th class="px-6 py-3 text-center text-xs font-semibold text-gray-600">Tgl Pinjam</th>
                        <th class="px-6 py-3 text-center text-xs font-semibold text-gray-600">Tgl Kembali</th>
                        <th class="px-6 py-3 text-center text-xs font-semibold text-gray-600">Status</th>
                        <th class="px-6 py-3 text-center text-xs font-semibold text-gray-600">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @foreach ($borrowings as $item)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4">{{ $item->user->name }}</td>
                            <td class="px-6 py-4">{{ $item->tool->name }}</td>
                            <td class="px-6 py-4">{{ $item->qty }}</td>
                            <td class="px-6 py-4 text-center">{{ $item->borrow_date }}</td>
                            <td class="px-6 py-4 text-center">{{ $item->return_date }}</td>
                            <td class="px-6 py-4 text-center">
                                @if($item->status == 'dipinjam')
                                    <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs">Dipinjam</span>
                                @elseif($item->status == 'menunggu_kembali')
                                    <span class="px-2 py-1 bg-purple-100 text-purple-800 rounded-full text-xs">Menunggu
                                        Validasi</span>
                                @elseif($item->status == 'dikembalikan')
                                    <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">Selesai</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center space-x-2">
                                @if ($item->status == 'menunggu')
                                    <form action="{{ route(auth()->user()->role->name . '.borrowings.approve', $item) }}"
                                        method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button onclick="return confirm('Setujui peminjaman ini?')"
                                            class="text-green-600 hover:text-green-800 inline-flex items-center" title="Setujui">
                                            <span class="material-icons text-lg">check_circle</span>
                                        </button>
                                    </form>
                                @elseif($item->status == 'menunggu_kembali')
                                    <div class="text-xs text-left mb-2">
                                        <p>Kondisi Awal: <span class="font-semibold">{{ $item->tool->initial_condition }}</span></p>
                                        <p>Kondisi Kembali: <span
                                                class="font-semibold text-purple-600">{{ $item->returnTool->return_condition ?? '-' }}</span>
                                        </p>
                                    </div>
                                    <form action="{{ route(auth()->user()->role->name . '.return-tools.store', $item->id) }}"
                                        method="POST" class="inline">
                                        @csrf
                                        <button
                                            onclick="return confirm('Setujui pengembalian ini? Pastikan kondisi barang sudah sesuai.')"
                                            class="bg-green-600 text-white px-3 py-1 rounded text-xs hover:bg-green-700">
                                            ACC Pengembalian
                                        </button>
                                    </form>
                                @elseif($item->status == 'dipinjam')
                                 <p class="text-xs text-gray-500">Menunggu pengembalian</p>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
