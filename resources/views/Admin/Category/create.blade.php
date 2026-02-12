@extends('Layout.Dashboard')

@section('content')
<div class="p-8 max-w-lg">
    <h1 class="text-2xl font-bold text-blue-900 mb-6">Tambah Kategori</h1>

    <form action="{{ route('admin.categories.store') }}" method="POST" class="bg-white p-6 rounded-lg shadow">
        @csrf

        <label class="block mb-2 font-semibold">Nama Kategori</label>
        <input type="text" name="name"
               class="w-full border rounded px-4 py-2 focus:ring-2 focus:ring-blue-500"
               required>

        <div class="mt-4 flex justify-end gap-2">
            <a href="{{ route('admin.categories.index') }}"
               class="px-4 py-2 border rounded">Batal</a>
            <button class="px-4 py-2 bg-blue-600 text-white rounded">
                Simpan
            </button>
        </div>
    </form>
</div>
@endsection
