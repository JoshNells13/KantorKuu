@extends('Layout.Dashboard')

@section('content')
<div class="p-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-blue-900">Data Alat</h1>
        <a href="{{ route('tools.create') }}"
           class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
            <i class="fas fa-plus"></i> Tambah
        </a>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600">No</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600">Nama</th>
                    <th class="px-6 py-3 text-center text-xs font-semibold text-gray-600">Stock</th>
                    <th class="px-6 py-3 text-center text-xs font-semibold text-gray-600">Kategori</th>
                    <th class="px-6 py-3 text-center text-xs font-semibold text-gray-600">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @foreach($Tool as $item)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">{{ $loop->iteration }}</td>
                    <td class="px-6 py-4">{{ $item->name }}</td>
                    <td class="px-6 py-4 text-center">{{ $item->stock }}</td>
                    <td class="px-6 py-4 text-center">{{ $item->category->name ?? 'Tidak ada kategori' }}</td>
                    <td class="px-6 py-4 text-center space-x-2">
                        <a href="{{ route('tools.edit', $item) }}"
                           class="text-blue-600 hover:text-blue-800">
                            <i class="fas fa-edit"></i>
                        </a>

                        <form action="{{ route('tools.destroy', $item) }}"
                              method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button onclick="return confirm('Hapus alat ini?')"
                                    class="text-red-600 hover:text-red-800">
                                <i class="fas fa-trash"></i>
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
