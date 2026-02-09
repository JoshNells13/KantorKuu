@extends('Layout.Dashboard')

@section('content')
<div class="p-8 max-w-lg">
    <h1 class="text-2xl font-bold text-blue-900 mb-6">Edit Alat</h1>

    <form action="{{ route('tools.update', $tool) }}" method="POST" class="bg-white p-6 rounded-lg shadow">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block mb-2 font-semibold">Kategori</label>
            <select name="category_id" class="w-full border rounded px-4 py-2 focus:ring-2 focus:ring-blue-500" required>
                <option value="">Pilih Kategori</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ $tool->category_id == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label class="block mb-2 font-semibold">Nama Alat</label>
            <input type="text" name="name"
                   value="{{ $tool->name }}"
                   class="w-full border rounded px-4 py-2 focus:ring-2 focus:ring-blue-500"
                       required>
        </div>

        <div class="mb-4">
            <label class="block mb-2 font-semibold">Stock</label>
            <input type="number" name="stock"
                   value="{{ $tool->stock }}"
                   class="w-full border rounded px-4 py-2 focus:ring-2 focus:ring-blue-500"
                   required>
        </div>


        <div class="mt-6 flex justify-end gap-2">
            <a href="{{ route('tools.index') }}"
               class="px-4 py-2 border rounded hover:bg-gray-50">Batal</a>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                Update
            </button>
        </div>
    </form>
</div>
@endsection
