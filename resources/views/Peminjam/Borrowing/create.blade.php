@extends('Layout.Dashboard')

@section('content')
    <div class="p-8 max-w-lg">
        <h1 class="text-2xl font-bold text-blue-900 mb-6">Ajukan Peminjaman</h1>

        <div class="bg-white p-6 rounded-lg shadow">
            <form action="{{ route('peminjam.borrowings.store') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label class="block mb-2 font-semibold">Alat</label>
                    <select name="tool_id" class="w-full border rounded px-4 py-2 focus:ring-2 focus:ring-blue-500" required>
                        <option value="">Pilih Alat</option>
                        @foreach ($tools as $tool)
                            <option value="{{ $tool->id }}" {{ $tool->stock < 1 ? 'disabled' : '' }}>
                                {{ $tool->name }} (Stok: {{ $tool->stock }})
                            </option>
                        @endforeach
                    </select>
                    @error('tool_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block mb-2 font-semibold">Jumlah (Qty)</label>
                    <input type="number" name="qty" min="1"
                        class="w-full border rounded px-4 py-2 focus:ring-2 focus:ring-blue-500" required>
                    @error('qty')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block mb-2 font-semibold">Tgl Kembali</label>
                    <input type="date" name="return_date"
                        class="w-full border rounded px-4 py-2 focus:ring-2 focus:ring-blue-500" min="{{ date('Y-m-d') }}"
                        required>
                    @error('return_date')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-6 flex justify-end gap-2">
                    <a href="{{ route('peminjam.borrowings.index') }}"
                        class="px-4 py-2 border rounded hover:bg-gray-50">Batal</a>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                        Ajukan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
