@extends('Layout.Dashboard')

@section('content')
    <div class="p-8 max-w-2xl mx-auto">
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-slate-800 dark:text-white mb-2">Ajukan Peminjaman</h1>
            <p class="text-slate-600 dark:text-slate-400">Lengkapi form di bawah untuk mengajukan peminjaman alat di
                KantorKuu</p>
        </div>

        <div class="bg-white dark:bg-slate-800 p-6 rounded-xl shadow-lg">
            @if($selectedTool)
                <!-- Tool Info Card -->
                <div class="mb-6 p-4 bg-blue-50 dark:bg-slate-700 rounded-lg border border-blue-200 dark:border-slate-600">
                    <div class="flex items-center gap-4">
                        <div class="w-16 h-16 bg-gray-200 dark:bg-slate-600 rounded-lg flex items-center justify-center">
                            <span class="material-icons text-4xl text-gray-400">construction</span>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-lg font-bold text-slate-800 dark:text-white">{{ $selectedTool->name }}</h3>
                            <p class="text-sm text-slate-600 dark:text-slate-400">Kategori:
                                {{ $selectedTool->category->name ?? '-' }}</p>
                            <p class="text-sm font-semibold {{ $selectedTool->stock > 0 ? 'text-green-600' : 'text-red-600' }}">
                                Stok tersedia: {{ $selectedTool->stock }}
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            <form action="{{ route('peminjam.borrowings.store') }}" method="POST" class="space-y-5">
                @csrf

                <!-- Hidden Tool ID -->
                @if($selectedTool)
                    <input type="hidden" name="tool_id" value="{{ $selectedTool->id }}">
                @else
                    <!-- If no tool selected, show error message -->
                    <div class="p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg">
                        <div class="flex items-center gap-2 text-red-600 dark:text-red-400">
                            <span class="material-icons">error</span>
                            <p class="font-semibold">Tidak ada alat yang dipilih!</p>
                        </div>
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">
                            Silakan kembali ke <a href="{{ route('peminjam.tools') }}" class="underline font-semibold">Katalog
                                Alat</a> dan pilih alat yang ingin dipinjam.
                        </p>
                    </div>
                @endif

                <!-- Quantity Input -->
                <div>
                    <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">
                        Jumlah (Qty)
                    </label>
                    <div class="relative">
                        <span class="material-icons absolute left-3 top-3 text-slate-400 text-xl">pin</span>
                        <input type="number" name="qty" min="1" @if($selectedTool) max="{{ $selectedTool->stock }}" @endif
                            value="1"
                            class="w-full pl-11 pr-4 py-3 bg-slate-50 dark:bg-slate-700 border border-slate-200 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-primary/50 focus:border-primary transition-all @error('qty') border-red-500 @enderror"
                            placeholder="Masukkan jumlah" @if(!$selectedTool) disabled @endif required>
                    </div>
                    @error('qty')
                        <p class="mt-1 text-sm text-red-500 flex items-center gap-1">
                            <span class="material-icons text-sm">error</span>
                            {{ $message }}
                        </p>
                    @enderror
                    @if($selectedTool)
                        <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                            Maksimal peminjaman: {{ $selectedTool->stock }} unit
                        </p>
                    @endif
                </div>

                <!-- Return Date Input -->
                <div>
                    <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">
                        Tanggal Pengembalian
                    </label>
                    <div class="relative">
                        <span class="material-icons absolute left-3 top-3 text-slate-400 text-xl">calendar_today</span>
                        <input type="date" name="return_date" min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                            class="w-full pl-11 pr-4 py-3 bg-slate-50 dark:bg-slate-700 border border-slate-200 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-primary/50 focus:border-primary transition-all @error('return_date') border-red-500 @enderror"
                            @if(!$selectedTool) disabled @endif required>
                    </div>
                    @error('return_date')
                        <p class="mt-1 text-sm text-red-500 flex items-center gap-1">
                            <span class="material-icons text-sm">error</span>
                            {{ $message }}
                        </p>
                    @enderror
                    <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                        Pilih tanggal pengembalian (minimal besok)
                    </p>
                </div>

                <!-- Action Buttons -->
                <div class="mt-6 flex justify-end gap-3 pt-4 border-t border-slate-200 dark:border-slate-700">
                    <a href="{{ route('peminjam.tools') }}"
                        class="px-6 py-3 border border-slate-300 dark:border-slate-600 text-slate-700 dark:text-slate-300 rounded-lg hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors font-medium inline-flex items-center gap-2">
                        <span class="material-icons text-sm">arrow_back</span>
                        Kembali
                    </a>
                    <button type="submit"
                        class="px-6 py-3 bg-primary hover:bg-primary/90 text-white rounded-lg shadow-lg shadow-primary/30 transition-all font-semibold inline-flex items-center gap-2 hover:shadow-xl disabled:opacity-50 disabled:cursor-not-allowed"
                        @if(!$selectedTool) disabled @endif>
                        <span class="material-icons text-sm">send</span>
                        Ajukan Peminjaman
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection