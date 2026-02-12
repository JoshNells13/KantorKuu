@extends('Layout.Dashboard')

@section('content')
    <div class="p-8 max-w-lg">
        <h1 class="text-2xl font-bold text-blue-900 mb-6">Tambah Peminjaman</h1>

        <form action="{{ route(auth()->user()->role->name . '.borrowings.store') }}" method="POST"
            class="bg-white p-6 rounded-lg shadow">
            @csrf

            <div class="mb-4">
                <label class="block mb-2 font-semibold">Peminjam</label>
                <select name="user_id" class="w-full border rounded px-4 py-2 focus:ring-2 focus:ring-blue-500" required>
                    <option value="">Pilih Peminjam</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->username }})</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label class="block mb-2 font-semibold">Alat</label>
                <select name="tool_id" id="toolSelect"
                    class="w-full border rounded px-4 py-2 focus:ring-2 focus:ring-blue-500" required>
                    <option value="">Pilih Alat</option>
                    @foreach ($tools as $tool)
                        <option value="{{ $tool->id }}" data-stock="{{ $tool->stock }}">
                            {{ $tool->name }} (Stok: {{ $tool->stock }})
                        </option>
                    @endforeach
                </select>

            </div>

            <div class="mb-4">
                <label class="block mb-2 font-semibold">Jumlah (Qty)</label>
                <input type="number" name="qty" min="1" id="qtyInput"
                    class="w-full border rounded px-4 py-2 focus:ring-2 focus:ring-blue-500" required>
            </div>


            <div class="mb-4">
                <label class="block mb-2 font-semibold">Tgl Kembali</label>
                <input type="date" name="return_date"
                    class="w-full border rounded px-4 py-2 focus:ring-2 focus:ring-blue-500" required>
            </div>

            <div class="mb-4">
                <label class="block mb-2 font-semibold">Status</label>
                <select name="status" class="w-full border rounded px-4 py-2 focus:ring-2 focus:ring-blue-500" required>
                    <option value="menunggu">Menunggu</option>
                    <option value="dipinjam">Dipinjam</option>
                    <option value="dikembalikan">Dikembalikan</option>
                </select>
            </div>

            <div class="mt-6 flex justify-end gap-2">
                <a href="{{ route('admin.borrowings.index') }}" class="px-4 py-2 border rounded hover:bg-gray-50">Batal</a>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    Simpan
                </button>
            </div>
        </form>
    </div>
@endsection
