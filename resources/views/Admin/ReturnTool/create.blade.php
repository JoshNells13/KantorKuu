@extends('Layout.Dashboard')

@section('content')
    <div class="p-8 max-w-lg">
        <h1 class="text-2xl font-bold text-blue-900 mb-6">Proses Pengembalian</h1>

        <form action="{{route('admin.return-tools.store', ['borrowing' => $borrowing->id]) }}"
            method="POST" class="bg-white p-6 rounded-lg shadow">

            @csrf
            <input type="hidden" name="borrowing_id" value="{{ $borrowing->id }}">

            <div class="mb-4">
                <label class="block mb-2 font-semibold">Peminjam</label>
                <input type="text" value="{{ $borrowing->user->name }}"
                    class="w-full border rounded px-4 py-2 bg-gray-100" readonly>
            </div>

            <div class="mb-4">
                <label class="block mb-2 font-semibold">Alat</label>
                <input type="text" value="{{ $borrowing->tool->name }}"
                    class="w-full border rounded px-4 py-2 bg-gray-100" readonly>
            </div>

            <div class="mb-4">
                <label class="block mb-2 font-semibold">Tgl Seharusnya Kembali</label>
                <input type="date" value="{{ $borrowing->return_date }}"
                    class="w-full border rounded px-4 py-2 bg-gray-100" readonly>
            </div>

            <div class="mb-4">
                <label class="block mb-2 font-semibold">Tgl Pengembalian</label>
                <input type="date" name="returned_at" value="{{ date('Y-m-d') }}"
                    class="w-full border rounded px-4 py-2 focus:ring-2 focus:ring-blue-500" required>
            </div>


            <div class="mb-4">
                <label class="block mb-2 font-semibold">Denda (Optional)</label>
                <input type="number" name="fine" placeholder="Biarkan kosong untuk hitung otomatis"
                    class="w-full border rounded px-4 py-2 focus:ring-2 focus:ring-blue-500">
                <p class="text-xs text-gray-500 mt-1">Denda otomatis: Rp 5.000 / hari keterlambatan.</p>
            </div>

            <div class="mb-4">
                <label class="block mb-2 font-semibold">Catatan</label>
                <textarea name="note" class="w-full border rounded px-4 py-2 focus:ring-2 focus:ring-blue-500"></textarea>
            </div>

            <div class="mt-6 flex justify-end gap-2">
                <a href="{{ route(auth()->user()->role->name . '.borrowings.index') }}"
                    class="px-4 py-2 border rounded hover:bg-gray-50">Batal</a>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    Proses Kembali
                </button>
            </div>
        </form>
    </div>
@endsection
