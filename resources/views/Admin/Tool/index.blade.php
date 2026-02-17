@extends('Layout.Dashboard')

@section('content')
    <div class="p-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-blue-900">Data Alat</h1>
            <a href="{{ route('admin.tools.create') }}"
                class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 inline-flex items-center gap-2">
                <span class="material-icons text-sm">add</span>
                Tambah
            </a>
        </div>

        <div class="mb-6">
            <form method="GET" action="{{ route('admin.tools.index') }}" class="flex flex-col md:flex-row gap-4">

                <!-- Search -->
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Cari nama alat atau kategori..." class="border rounded px-4 py-2 w-full md:w-1/3">

                <!-- Filter Category -->
                <select name="category_id" class="border rounded px-4 py-2 w-full md:w-1/4">
                    <option value="">Semua Kategori</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>

                <!-- Button -->
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                    Filter
                </button>

                <!-- Reset -->
                <a href="{{ route('admin.tools.index') }}"
                    class="bg-gray-400 text-white px-6 py-2 rounded hover:bg-gray-500 text-center">
                    Reset
                </a>
            </form>
        </div>

        <div class="bg-white rounded-lg shadow overflow-hidden">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600">No</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600">Nama</th>
                        <th class="px-6 py-3 text-center text-xs font-semibold text-gray-600">Stock</th>
                        <th class="px-6 py-3 text-center text-xs font-semibold text-gray-600">Harga per Hari</th>
                        <th class="px-6 py-3 text-center text-xs font-semibold text-gray-600">Kategori</th>
                        <th class="px-6 py-3 text-center text-xs font-semibold text-gray-600">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @foreach ($tools as $item)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4">{{ $item->name }}</td>
                            <td class="px-6 py-4 text-center">{{ $item->stock }}</td>
                            <td class="px-6 py-4 text-center">Rp {{ number_format($item->price_per_day, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 text-center">{{ $item->category->name ?? 'Tidak ada kategori' }}</td>
                            <td class="px-6 py-4 text-center space-x-2">
                                <a href="{{ route('admin.tools.edit', $item) }}"
                                    class="text-blue-600 hover:text-blue-800 inline-flex items-center" title="Edit">
                                    <span class="material-icons text-lg">edit</span>
                                </a>

                                <form action="{{ route('admin.tools.destroy', $item) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button onclick="return confirm('Hapus alat ini?')"
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
