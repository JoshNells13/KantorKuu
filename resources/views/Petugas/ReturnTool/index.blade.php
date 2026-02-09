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
                            <td class="px-6 py-4 text-center">{{ $item->borrow_date }}</td>
                            <td class="px-6 py-4 text-center">{{ $item->return_date }}</td>
                            <td class="px-6 py-4 text-center">
                                @if ($item->status == 'menunggu')
                                    <span
                                        class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs">Menunggu</span>
                                @elseif($item->status == 'dipinjam')
                                    <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs">Dipinjam</span>
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
                                            class="text-green-600 hover:text-green-800" title="Setujui">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </form>
                                @elseif($item->status == 'dipinjam')
                                    <form action="{{ route('petugas.return-tools.store', $item->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('POST')
                                        <button onclick="return confirm('Kembalikan alat ini?')" class="text-green-600 hover:text-green-800" title="Kembalikan">
                                            <i class="fas fa-undo"></i>
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
