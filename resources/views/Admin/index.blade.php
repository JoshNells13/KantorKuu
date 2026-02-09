@extends('Layout.Dashboard')

@section('content')
    <div class="flex-1 overflow-auto p-8">
        <!-- Statistics Cards -->
        <div class="grid grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow p-6 border-l-4 border-blue-500">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-gray-500 text-sm">Total Jenis Alat</p>
                        <p class="text-3xl font-bold text-blue-900">{{ $totalAlat }}</p>

                    </div>
                    <i class="fas fa-boxes text-3xl text-blue-300"></i>
                </div>

            </div>
            <div class="bg-white rounded-lg shadow p-6 border-l-4 border-blue-500">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-gray-500 text-sm">Total Stok Alat</p>
                        <p class="text-3xl font-bold text-blue-900">{{ $totalStokAlat }}</p>

                    </div>
                    <i class="fas fa-boxes text-3xl text-blue-300"></i>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6 border-l-4 border-blue-400">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-gray-500 text-sm">Alat Dipinjam</p>
                        <p class="text-3xl font-bold text-blue-800">{{ $alatDipinjam }}</p>

                    </div>
                    <i class="fas fa-hand-holding-box text-3xl text-blue-300"></i>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6 border-l-4 border-blue-600">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-gray-500 text-sm">Peminjam Aktif</p>
                        <p class="text-3xl font-bold text-blue-900">{{ $peminjamAktif }}</p>
                    </div>
                    <i class="fas fa-users text-3xl text-blue-300"></i>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow p-6 border-l-4 border-yellow-600">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-gray-500 text-sm">Peminjaman Yang Di Proses/Menunggu</p>
                        <p class="text-3xl font-bold text-yellow-900">{{ $peminjamDiProses }}</p>
                    </div>
                    <i class="fas fa-users text-3xl text-blue-300"></i>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6 border-l-4 border-red-500">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-gray-500 text-sm">Keterlambatan</p>
                        <p class="text-3xl font-bold text-red-600">{{ $keterlambatan }}</p>
                    </div>
                    <i class="fas fa-exclamation-circle text-3xl text-red-300"></i>
                </div>
                <p class="text-red-600 text-sm mt-2"><i class="fas fa-alert"></i> Perlu tindakan</p>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="grid grid-cols-2 gap-6 mb-8">
            <!-- Chart 1 -->
            {{-- <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Peminjaman Per Bulan</h3>
                <div class="h-64 flex items-end gap-2 justify-around px-4">
                    <div class="flex flex-col items-center gap-2">
                        <div class="w-12 bg-blue-500 rounded" style="height: 120px;"></div>
                        <span class="text-xs text-gray-600">Jan</span>
                    </div>
                    <div class="flex flex-col items-center gap-2">
                        <div class="w-12 bg-blue-500 rounded" style="height: 150px;"></div>
                        <span class="text-xs text-gray-600">Feb</span>
                    </div>
                    <div class="flex flex-col items-center gap-2">
                        <div class="w-12 bg-blue-500 rounded" style="height: 180px;"></div>
                        <span class="text-xs text-gray-600">Mar</span>
                    </div>
                    <div class="flex flex-col items-center gap-2">
                        <div class="w-12 bg-blue-600 rounded" style="height: 200px;"></div>
                        <span class="text-xs text-gray-600">Apr</span>
                    </div>
                    <div class="flex flex-col items-center gap-2">
                        <div class="w-12 bg-blue-600 rounded" style="height: 220px;"></div>
                        <span class="text-xs text-gray-600">Mei</span>
                    </div>
                    <div class="flex flex-col items-center gap-2">
                        <div class="w-12 bg-blue-700 rounded" style="height: 240px;"></div>
                        <span class="text-xs text-gray-600">Jun</span>
                    </div>
                </div>
            </div> --}}

            <!-- Chart 2 -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Status Alat</h3>
                <div class="flex items-center justify-center gap-8">
                    <div class="text-center">
                        <div
                            class="w-24 h-24 rounded-full bg-gradient-to-r from-blue-400 to-blue-600 flex items-center justify-center text-white font-bold text-2xl mx-auto mb-2">
                            {{ $persentaseAlatTersedia }}%
                        </div>
                        <p class="text-sm text-gray-600">Tersedia</p>
                    </div>
                    <div>
                        <div class="flex items-center gap-2 mb-3">
                            <div class="w-3 h-3 rounded-full bg-blue-500"></div>
                            <span class="text-sm text-gray-700">Tersedia: {{ $totalStokAlat }}</span>
                        </div>
                        <div class="flex items-center gap-2 mb-3">
                            <div class="w-3 h-3 rounded-full bg-orange-500"></div>
                            <span class="text-sm text-gray-700">Dipinjam: {{ $alatDipinjam }}</span>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activity Table -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-800">Peminjaman Terbaru</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">ID
                                Peminjaman</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">
                                Peminjam</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Alat
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Tgl
                                Peminjaman</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">
                                Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($peminjamanTerbaru as $item)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 text-sm text-gray-800">
                                    #PJM{{ str_pad($item->id, 3, '0', STR_PAD_LEFT) }}</td>
                                <td class="px-6 py-4 text-sm text-gray-800">{{ $item->user->name }}</td>
                                <td class="px-6 py-4 text-sm text-gray-800">{{ $item->tool->name }}</td>
                                <td class="px-6 py-4 text-sm text-gray-800">
                                    {{ \Carbon\Carbon::parse($item->borrow_date)->format('d M Y') }}
                                </td>
                                <td class="px-6 py-4">
                                    @if ($item->status === 'dipinjam')
                                        <span
                                            class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-semibold">Dipinjam</span>
                                    @elseif ($item->status === 'dikembalikan')
                                        <span
                                            class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-semibold">Dikembalikan</span>
                                    @else
                                        <span
                                            class="px-3 py-1 bg-orange-100 text-orange-700 rounded-full text-xs font-semibold">Menunggu</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-6 text-gray-500">
                                    Belum ada data peminjaman
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
