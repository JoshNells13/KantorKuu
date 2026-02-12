@extends('Layout.Dashboard')

@section('content')
<div class="p-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-blue-900">Data Kategori</h1>
        <a href="{{ route('admin.categories.create') }}"
           class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 inline-flex items-center gap-2">
            <span class="material-icons text-sm">add</span>
            Tambah
        </a>
    </div>

    @if(session('success'))
        <div class="mb-4 bg-green-100 text-green-700 px-4 py-3 rounded">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600">No</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600">Nama Kategori</th>
                    <th class="px-6 py-3 text-center text-xs font-semibold text-gray-600">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @foreach($categories as $item)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">{{ $loop->iteration }}</td>
                    <td class="px-6 py-4">{{ $item->name }}</td>
                    <td class="px-6 py-4 text-center space-x-2">
                        <a href="{{ route('admin.categories.edit', $item) }}"
                           class="text-blue-600 hover:text-blue-800 inline-flex items-center"
                           title="Edit">
                            <span class="material-icons text-lg">edit</span>
                        </a>

                        <form action="{{ route('admin.categories.destroy', $item) }}"
                              method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button onclick="return confirm('Hapus kategori ini?')"
                                    class="text-red-600 hover:text-red-800 inline-flex items-center"
                                    title="Hapus">
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
