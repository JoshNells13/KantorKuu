@extends('Layout.Dashboard')

@section('content')
    <div class="p-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-blue-900">Data Peminjaman</h1>
            <a href="{{ route(auth()->user()->role->name . '.borrowings.create') }}"
                class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 inline-flex items-center gap-2">
                <span class="material-icons text-sm">add</span>
                Tambah
            </a>
        </div>

        <div class="bg-white rounded-lg shadow overflow-hidden">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600">No</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600">Peminjam</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600">Alat</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600">Jumlah Dipinjam</th>
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
                                            class="text-green-600 hover:text-green-800 inline-flex items-center" title="Setujui">
                                            <span class="material-icons text-lg">check_circle</span>
                                        </button>
                                    </form>
                                @elseif($item->status == 'dipinjam')
                                    <span
                                        class="bg-blue-100 text-blue-800 text-xs font-semibold px-2 py-1 rounded">Dipinjam</span>
                                    <div class="mt-2">
                                        <form action="{{ route('admin.return-tools.store', $item->id) }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="returned_at" value="{{ now() }}">
                                            <button type="submit"
                                                class="text-xs bg-green-500 hover:bg-green-600 text-white px-2 py-1 rounded">
                                                Kembalikan
                                            </button>
                                        </form>
                                    </div>
                                @endif

                                @if ($item->status !== 'dikembalikan')
                                    <a href="{{ route('admin.borrowings.edit', $item) }}"
                                        class="text-blue-600 hover:text-blue-800">
                                        Edit
                                    </a>
                                @else
                                    <span class="text-gray-400 text-sm">Terkunci</span>
                                @endif

                                <form action="{{ route('admin.borrowings.destroy', $item) }}" method="POST"
                                    class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button onclick="return confirm('Hapus data peminjaman ini?')"
                                        class="text-red-600 hover:text-red-800 inline-flex items-center" title="Hapus">
                                        <span class="material-icons text-lg">delete</span>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
