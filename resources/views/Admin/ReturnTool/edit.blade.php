@extends('Layout.Dashboard')

@section('content')
<div class="p-8 max-w-lg">
    <h1 class="text-2xl font-bold text-blue-900 mb-6">Edit Data Pengembalian</h1>

    <form action="{{ route(auth()->user()->role->name . '.return-tools.update', $return) }}" method="POST" class="bg-white p-6 rounded-lg shadow">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block mb-2 font-semibold">Peminjam</label>
            <input type="text" value="{{ $return->borrowing->user->name }}" class="w-full border rounded px-4 py-2 bg-gray-100" readonly>
        </div>

        <div class="mb-4">
            <label class="block mb-2 font-semibold">Alat</label>
            <input type="text" value="{{ $return->borrowing->tool->name }}" class="w-full border rounded px-4 py-2 bg-gray-100" readonly>
        </div>

        <div class="mb-4">
            <label class="block mb-2 font-semibold">Tgl Pengembalian</label>
            <input type="date" name="returned_at" value="{{ $return->returned_at }}"
                   class="w-full border rounded px-4 py-2 focus:ring-2 focus:ring-blue-500"
                   required>
        </div>

        <div class="mt-6 flex justify-end gap-2">
            <a href="{{ route(auth()->user()->role->name . '.return-tools.index') }}"
               class="px-4 py-2 border rounded hover:bg-gray-50">Batal</a>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                Update
            </button>
        </div>
    </form>
</div>
@endsection
