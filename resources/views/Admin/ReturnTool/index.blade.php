
@extends('Layout.Dashboard')

@section('content')
<div class="p-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-blue-900">Data Pengembalian</h1>
        <!-- Button create is hidden because return is initiated from Borrowing Data usually. -->
        <!-- But to stick to CRUD, we can have a button, but it needs a borrowing_id. -->
        <!-- Just listing data here -->
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600">No</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600">Peminjam</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600">Alat</th>
                    <th class="px-6 py-3 text-center text-xs font-semibold text-gray-600">Tgl Kembali</th>
                    <th class="px-6 py-3 text-center text-xs font-semibold text-gray-600">Total Denda</th>
                    <th class="px-6 py-3 text-center text-xs font-semibold text-gray-600">Kondisi Kembali</th>
                    <th class="px-6 py-3 text-center text-xs font-semibold text-gray-600">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @foreach($returns as $item)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">{{ $loop->iteration }}</td>
                    <td class="px-6 py-4">{{ $item->borrowing->user->name }}</td>
                    <td class="px-6 py-4">{{ $item->borrowing->tool->name }}</td>
                    <td class="px-6 py-4 text-center">{{ $item->returned_at }}</td>
                    <td class="px-6 py-4 text-center">Rp {{ number_format($item->fine, 0, ',', '.') }}</td>
                    <td class="px-6 py-4 text-center text-xs">{{ $item->return_condition ?? '-' }}</td>
                    <td class="px-6 py-4 text-center space-x-2">
                        <a href="{{ route(auth()->user()->role->name . '.return-tools.edit', $item) }}"
                           class="text-blue-600 hover:text-blue-800 inline-flex items-center" title="Edit">
                            <span class="material-icons text-lg">edit</span>
                        </a>

                        <form action="{{ route(auth()->user()->role->name . '.return-tools.destroy', $item) }}"
                              method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button onclick="return confirm('Hapus data pengembalian ini?')"
                                    class="text-red-600 hover:text-red-800 inline-flex items-center" title="Hapus">
                                    <span class="material-icons text-lg">delete</span>
                            </button>
                        </form>
                    </td>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
