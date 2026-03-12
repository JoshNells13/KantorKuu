@extends('Layout.Dashboard')

@section('content')
    <div class="p-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-blue-900">Riwayat Peminjaman Saya</h1>
            <a href="{{ route('peminjam.borrowings.create') }}"
                class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Pinjam Alat Baru
            </a>
        </div>

        <div class="bg-white rounded-lg shadow overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="px-6 py-3 text-left font-semibold text-gray-600">No</th>
                        <th class="px-6 py-3 text-left font-semibold text-gray-600">Alat</th>
                        <th class="px-6 py-3 text-center font-semibold text-gray-600">Tgl Pinjam</th>
                        <th class="px-6 py-3 text-center font-semibold text-gray-600">Tgl Kembali</th>
                        <th class="px-6 py-3 text-center font-semibold text-gray-600">Jumlah</th>
                        <th class="px-6 py-3 text-center font-semibold text-gray-600">Status</th>
                    </tr>
                </thead>

                <tbody class="divide-y">

                    @forelse($borrowings as $item)

                        <tr class="hover:bg-gray-50 transition">

                            <td class="px-6 py-4">
                                {{ $loop->iteration }}
                            </td>

                            <td class="px-6 py-4 font-medium text-gray-800">
                                {{ $item->tool->name }}
                            </td>

                            <td class="px-6 py-4 text-center">
                                {{ date('d M Y', strtotime($item->borrow_date)) }}
                            </td>

                            <td class="px-6 py-4 text-center">
                                {{ date('d M Y', strtotime($item->return_date)) }}
                            </td>

                            <td class="px-6 py-4 text-center">
                                {{ $item->qty }}
                            </td>

                            <td class="px-6 py-4 text-center">

                                {{-- STATUS MENUNGGU --}}
                                @if ($item->status == 'menunggu')

                                    <span class="bg-yellow-100 text-yellow-700 text-xs font-semibold px-3 py-1 rounded-full">
                                        Menunggu
                                    </span>

                                    {{-- STATUS DIPINJAM --}}
                                @elseif($item->status == 'dipinjam')

                                    <div class="flex flex-col items-center gap-2">

                                        <span class="bg-blue-100 text-blue-700 text-xs font-semibold px-3 py-1 rounded-full">
                                            Dipinjam
                                        </span>

                                        <div class="bg-gray-50 border rounded-lg p-3 text-left w-52">

                                            <p class="text-xs text-gray-600 mb-2">
                                                Kondisi Awal:
                                                <span class="font-semibold">
                                                    {{ $item->tool->initial_condition }}
                                                </span>
                                            </p>

                                            @if ($item->proof)
                                                <a href="{{ route('borrowings.download-proof', $item) }}"
                                                    class="inline-flex items-center text-xs bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded mb-2">
                                                    <span class="material-icons text-xs mr-1">download</span>
                                                    Surat
                                                </a>
                                            @endif

                                            <form action="{{ route('peminjam.return-tools.store', $item->id) }}" method="POST"
                                                class="flex flex-col gap-2">

                                                @csrf

                                                <input type="text" name="return_condition" placeholder="Kondisi saat ini..."
                                                    class="text-xs border rounded px-2 py-1 focus:outline-none focus:ring-1 focus:ring-blue-400"
                                                    required>

                                                <button type="submit"
                                                    class="inline-flex justify-center text-xs bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded">
                                                    Kembalikan
                                                </button>

                                            </form>

                                        </div>

                                    </div>

                                    {{-- STATUS VALIDASI --}}
                                @elseif($item->status == 'menunggu_kembali')

                                    <div class="flex flex-col items-center gap-2">

                                        <span class="bg-purple-100 text-purple-700 text-xs font-semibold px-3 py-1 rounded-full">
                                            Menunggu Validasi
                                        </span>

                                        @if ($item->proof)
                                            <a href="{{ route('borrowings.download-proof', $item) }}"
                                                class="inline-flex items-center text-xs bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded">
                                                <span class="material-icons text-xs mr-1">download</span>
                                                Surat
                                            </a>
                                        @endif

                                    </div>

                                    {{-- STATUS SELESAI --}}
                                @elseif($item->status == 'dikembalikan' || $item->status == 'selesai')

                                    <div class="flex flex-col items-center gap-2">

                                        <span class="bg-green-100 text-green-700 text-xs font-semibold px-3 py-1 rounded-full">
                                            Selesai
                                        </span>

                                        @if ($item->proof)
                                            <a href="{{ route('borrowings.download-proof', $item) }}"
                                                class="inline-flex items-center text-xs bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded">
                                                <span class="material-icons text-xs mr-1">download</span>
                                                Surat
                                            </a>
                                        @endif

                                    </div>

                                @else

                                    <span class="bg-gray-100 text-gray-700 text-xs px-3 py-1 rounded-full">
                                        {{ ucfirst($item->status) }}
                                    </span>

                                @endif

                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="6" class="px-6 py-10 text-center text-gray-500">
                                Belum ada riwayat peminjaman.
                            </td>
                        </tr>

                    @endforelse

                </tbody>
            </table>
        </div>
    </div>
@endsection