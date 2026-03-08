@extends('Layout.Dashboard')

@section('content')
    <div class="p-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-blue-900">Daftar Alat</h1>
        </div>


        <div class="mb-6">
            <form method="GET" action="{{ route('peminjam.tools') }}" class="flex flex-col md:flex-row gap-4">

                <!-- Search -->
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Cari nama alat atau kategori..." class="border rounded px-4 py-2 w-full md:w-1/3">

                <!-- Category Filter -->
                <select name="category_id" class="border rounded px-4 py-2 w-full md:w-1/4">
                    <option value="">Semua Kategori</option>
                    @foreach ($Category as $category)
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
                <a href="{{ route('peminjam.tools') }}"
                    class="bg-gray-400 text-white px-6 py-2 rounded hover:bg-gray-500 text-center">
                    Reset
                </a>
            </form>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach ($tools as $item)
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
                    <!-- Placeholder Image -->
                    <div class="h-48 bg-gray-200 flex items-center justify-center">
                        <img src="{{ asset('storage/' . ($item->img ?? 'placeholder.png')) }}" alt="{{ $item->name }}"
                            class="object-cover w-full h-full">
                    </div>


                    <div class="p-4">
                        <div class="flex justify-between items-start mb-2">
                            <h3 class="text-lg font-bold text-gray-800">{{ $item->name }}</h3>
                            <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2 py-1 rounded">
                                {{ $item->category->name }}
                            </span>
                        </div>


                        <p class="text-sm text-gray-600 mb-4">
                            Stok: <span
                                class="font-semibold {{ $item->stock > 0 ? 'text-green-600' : 'text-red-600' }}">{{ $item->stock }}</span>
                        </p>

                        @if ($item->stock > 0)
                            <a href="{{ route('peminjam.borrowings.create', ['tool_id' => $item->id]) }}"
                                class="block w-full text-center bg-blue-600 text-white py-2 rounded hover:bg-blue-700 transition">
                                Pinjam Alat
                            </a>
                        @else
                            <button disabled
                                class="block w-full text-center bg-gray-300 text-gray-500 py-2 rounded cursor-not-allowed">
                                Tidak Tersedia
                            </button>
                        @endif


                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection