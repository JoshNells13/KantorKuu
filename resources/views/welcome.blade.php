<!DOCTYPE html>

<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>EquipRent | Sistem Peminjaman Alat Profesional</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap"
        rel="stylesheet" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
        rel="stylesheet" />
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#135bec",
                        "background-light": "#f6f6f8",
                        "background-dark": "#101622",
                    },
                    fontFamily: {
                        "display": ["Inter", "sans-serif"]
                    },
                    borderRadius: {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "full": "9999px"
                    },
                },
            },
        }
    </script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body
    class="bg-background-light dark:bg-background-dark font-display text-slate-900 dark:text-slate-100 transition-colors duration-200">
    <!-- Navigation Bar -->
    <nav
        class="sticky top-0 z-50 bg-white/80 dark:bg-background-dark/80 backdrop-blur-md border-b border-slate-200 dark:border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo and Main Links -->
                <div class="flex items-center gap-8">
                    <a class="flex items-center gap-2" href="{{ route('home') }}">
                        <div class="w-8 h-8 bg-primary rounded-lg flex items-center justify-center">
                            <span class="material-icons text-white text-xl">construction</span>
                        </div>
                        <span class="text-xl font-bold tracking-tight text-slate-900 dark:text-white">EquipRent</span>
                    </a>
                    <div class="hidden md:flex items-center gap-6">
                        @auth
                            @if(auth()->user()->role->name === 'peminjam')
                                <a class="text-sm font-medium hover:text-primary transition-colors"
                                   href="{{ route('peminjam.tools') }}">Katalog Alat</a>
                                <a class="text-sm font-medium hover:text-primary transition-colors"
                                   href="{{ route('peminjam.borrowings.index') }}">Peminjaman Saya</a>
                            @endif
                        @else
                            <a class="text-sm font-medium hover:text-primary transition-colors" href="#categories">Kategori</a>
                            <a class="text-sm font-medium hover:text-primary transition-colors" href="#how-it-works">Cara Kerja</a>
                        @endauth
                        <a class="text-sm font-medium hover:text-primary transition-colors" href="#support">Bantuan</a>
                    </div>
                </div>
                <!-- Secondary Search & Auth -->
                <div class="flex items-center gap-4">
                    @auth
                        <div class="hidden lg:flex items-center gap-3">
                            <span class="text-sm text-slate-600 dark:text-slate-400">Halo, <strong>{{ auth()->user()->name }}</strong></span>

                            @if(auth()->user()->role->name === 'admin')
                                <a href="{{ route('admin.dashboard') }}"
                                   class="text-sm font-medium px-4 py-2 hover:text-primary transition-colors">
                                    Dashboard Admin
                                </a>
                            @elseif(auth()->user()->role->name === 'petugas')
                                <a href="{{ route('petugas.dashboard') }}"
                                   class="text-sm font-medium px-4 py-2 hover:text-primary transition-colors">
                                    Dashboard Petugas
                                </a>
                            @elseif(auth()->user()->role->name === 'peminjam')
                                <a href="{{ route('peminjam.dashboard') }}"
                                   class="text-sm font-medium px-4 py-2 hover:text-primary transition-colors">
                                    Dashboard
                                </a>
                            @endif

                            <form action="{{ route('logout') }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" onclick="return confirm('Apakah Anda yakin ingin keluar?')"
                                    class="bg-red-500 hover:bg-red-600 text-white text-sm font-semibold px-5 py-2 rounded-lg shadow-sm transition-all">
                                    Keluar
                                </button>
                            </form>
                        </div>
                    @else
                        <div class="hidden lg:flex relative items-center">
                            <span class="material-icons absolute left-3 text-slate-400 text-sm">search</span>
                            <input
                                class="pl-10 pr-4 py-1.5 text-sm bg-slate-100 dark:bg-slate-800 border-none rounded-full focus:ring-2 focus:ring-primary/50 w-48 transition-all"
                                placeholder="Cari alat..." type="text" />
                        </div>
                        <a href="{{ route('login.show') }}"
                           class="text-sm font-medium px-4 py-2 hover:text-primary transition-colors">Masuk</a>
                        <a href="{{ route('register.show') }}"
                           class="bg-primary hover:bg-primary/90 text-white text-sm font-semibold px-5 py-2 rounded-lg shadow-sm transition-all">
                            Daftar
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>
    <!-- Hero Section -->
    <section class="relative py-20 overflow-hidden">
        <div class="absolute inset-0 -z-10 bg-gradient-to-br from-primary/5 via-transparent to-primary/10"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-12">
                <h1 class="text-4xl md:text-6xl font-extrabold tracking-tight mb-6 leading-tight">
                    Alat Profesional, <br />
                    <span class="text-primary">Dikirim ke Lokasi Anda.</span>
                </h1>
                <p class="text-lg text-slate-600 dark:text-slate-400">
                    Hemat biaya operasional. Sewa peralatan berkualitas tinggi untuk proyek berbagai skala.
                    Layanan terpercaya dan pengiriman langsung ke lokasi.
                </p>
            </div>
            <!-- Search Widget -->
            {{-- <div class="max-w-4xl mx-auto">
                <div
                    class="bg-white dark:bg-slate-900 p-2 rounded-xl lg:rounded-full shadow-xl border border-slate-200 dark:border-slate-800 flex flex-col lg:flex-row gap-2">
                    <div
                        class="flex-1 flex items-center px-4 py-2 lg:py-0 border-b lg:border-b-0 lg:border-r border-slate-100 dark:border-slate-800">
                        <span class="material-icons text-slate-400 mr-3">search</span>
                        <input
                            class="w-full bg-transparent border-none focus:ring-0 text-slate-900 dark:text-white placeholder:text-slate-400"
                            placeholder="Cari alat yang Anda butuhkan..." type="text" />
                    </div>
                    <div
                        class="flex-1 flex items-center px-4 py-2 lg:py-0 border-b lg:border-b-0 lg:border-r border-slate-100 dark:border-slate-800">
                        <span class="material-icons text-slate-400 mr-3">calendar_today</span>
                        <input
                            class="w-full bg-transparent border-none focus:ring-0 text-slate-900 dark:text-white placeholder:text-slate-400"
                            placeholder="Tanggal peminjaman" type="text" />
                    </div>
                    <div class="px-2">
                        @auth
                            @if(auth()->user()->role->name === 'peminjam')
                                <a href="{{ route('peminjam.tools') }}"
                                    class="block w-full lg:w-auto bg-primary hover:bg-primary/90 text-white px-8 py-3 rounded-lg lg:rounded-full font-semibold transition-all text-center">
                                    Cari Alat
                                </a>
                            @else
                                <a href="{{ route('login.show') }}"
                                    class="block w-full lg:w-auto bg-primary hover:bg-primary/90 text-white px-8 py-3 rounded-lg lg:rounded-full font-semibold transition-all text-center">
                                    Cari Alat
                                </a>
                            @endif
                        @else
                            <a href="{{ route('login.show') }}"
                                class="block w-full lg:w-auto bg-primary hover:bg-primary/90 text-white px-8 py-3 rounded-lg lg:rounded-full font-semibold transition-all text-center">
                                Cari Alat
                            </a>
                        @endauth
                    </div>
                </div>
                <div class="mt-6 flex flex-wrap justify-center gap-3" id="categories">
                    <span
                        class="text-xs font-semibold text-slate-400 uppercase tracking-widest mr-2 py-1">Populer:</span>
                    @foreach($popularCategories as $category)
                        <button
                            class="px-3 py-1 bg-white dark:bg-slate-800 rounded-full text-xs font-medium border border-slate-200 dark:border-slate-700 hover:border-primary transition-colors">{{ $category->name }}</button>
                    @endforeach
                </div>
            </div> --}}
        </div>
    </section>
    <!-- How It Works Section -->
    <section class="py-20 bg-slate-50 dark:bg-slate-900/50" id="how-it-works">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold mb-4">Cara Kerja</h2>
                <div class="w-16 h-1 bg-primary mx-auto rounded-full"></div>
            </div>
            <div class="grid md:grid-cols-3 gap-12">
                <div class="text-center group">
                    <div
                        class="w-16 h-16 bg-primary/10 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:bg-primary transition-colors">
                        <span
                            class="material-icons text-primary group-hover:text-white text-3xl transition-colors">inventory_2</span>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Telusuri Katalog</h3>
                    <p class="text-slate-600 dark:text-slate-400 leading-relaxed">
                        Akses ribuan alat dari berbagai supplier dan rumah rental profesional dalam satu tempat.
                    </p>
                </div>
                <div class="text-center group">
                    <div
                        class="w-16 h-16 bg-primary/10 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:bg-primary transition-colors">
                        <span
                            class="material-icons text-primary group-hover:text-white text-3xl transition-colors">event_available</span>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Pilih Tanggal</h3>
                    <p class="text-slate-600 dark:text-slate-400 leading-relaxed">
                        Pilih periode sewa dengan tarif harian, mingguan, atau bulanan yang sesuai jadwal Anda.
                    </p>
                </div>
                <div class="text-center group">
                    <div
                        class="w-16 h-16 bg-primary/10 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:bg-primary transition-colors">
                        <span
                            class="material-icons text-primary group-hover:text-white text-3xl transition-colors">local_shipping</span>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Kerja Lebih Smart</h3>
                    <p class="text-slate-600 dark:text-slate-400 leading-relaxed">
                        Ambil alat dari hub terdekat atau pilih pengiriman dan pickup di lokasi Anda.
                    </p>
                </div>
            </div>
        </div>
    </section>
    <!-- Featured Equipment Grid -->
    <section class="py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-end mb-12">
                <div>
                    <h2 class="text-3xl font-bold mb-2">Alat Unggulan</h2>
                    <p class="text-slate-500">Peralatan paling populer yang disewa saat ini.</p>
                </div>
                @auth
                    @if(auth()->user()->role->name === 'peminjam')
                        <a class="text-primary font-semibold flex items-center hover:underline"
                           href="{{ route('peminjam.tools') }}">
                            Lihat Semua <span class="material-icons text-sm ml-1">arrow_forward</span>
                        </a>
                    @else
                        <a class="text-primary font-semibold flex items-center hover:underline"
                           href="{{ route('login.show') }}">
                            Lihat Semua <span class="material-icons text-sm ml-1">arrow_forward</span>
                        </a>
                    @endif
                @else
                    <a class="text-primary font-semibold flex items-center hover:underline"
                       href="{{ route('login.show') }}">
                        Lihat Semua <span class="material-icons text-sm ml-1">arrow_forward</span>
                    </a>
                @endauth
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                @forelse($featuredTools as $tool)
                    <!-- Tool Card -->
                    <div class="bg-white dark:bg-slate-900 rounded-xl overflow-hidden shadow-sm border border-slate-200 dark:border-slate-800 group hover:shadow-lg transition-all">
                        <div class="relative h-48 overflow-hidden">
                            <!-- Placeholder Image -->
                            <div class="w-full h-full bg-gradient-to-br from-slate-100 to-slate-200 dark:from-slate-800 dark:to-slate-700 flex items-center justify-center group-hover:scale-105 transition-transform duration-500">
                                <img src="{{ asset('storage/tools/' . ($tool->image ?? 'placeholder.png')) }}" alt="{{ $tool->name }}"
                                     class="object-cover w-full h-full">
                            </div>
                            <div class="absolute top-3 left-3 flex gap-2">
                                @if($tool->stock > 0)
                                    <span class="bg-emerald-500 text-white text-[10px] font-bold uppercase px-2 py-1 rounded">Tersedia</span>
                                @else
                                    <span class="bg-red-500 text-white text-[10px] font-bold uppercase px-2 py-1 rounded">Habis</span>
                                @endif
                            </div>

                            <div>
                                <span class="absolute top-3 right-3 bg-primary/10 text-primary text-[10px] font-bold uppercase px-2 py-1 rounded">
                                    {{ $tool->price_per_day }} / hari
                            </div>
                        </div>
                        <div class="p-5">
                            <p class="text-xs font-semibold text-primary uppercase tracking-wide mb-1">{{ $tool->category->name ?? 'Umum' }}</p>
                            <h3 class="text-lg font-bold mb-2 text-slate-900 dark:text-white line-clamp-1">{{ $tool->name }}</h3>
                            <div class="flex items-center gap-1 text-slate-400 mb-4">
                                <span class="material-icons text-sm">inventory_2</span>
                                <span class="text-xs font-medium">Stok: {{ $tool->stock }}</span>
                            </div>
                            <div class="flex items-center justify-between mt-auto">
                                <div class="flex items-center gap-1">
                                    <span class="material-icons text-primary text-sm">check_circle</span>
                                    <span class="text-xs text-slate-600 dark:text-slate-400">Siap Dipinjam</span>
                                </div>
                                @auth
                                    @if(auth()->user()->role->name === 'peminjam')
                                        <a href="{{ route('peminjam.borrowings.create', ['tool_id' => $tool->id]) }}"
                                            class="bg-primary/10 text-primary hover:bg-primary hover:text-white p-2 rounded-lg transition-colors">
                                            <span class="material-icons">chevron_right</span>
                                        </a>
                                    @else
                                        <button disabled class="bg-slate-100 dark:bg-slate-800 text-slate-400 p-2 rounded-lg cursor-not-allowed">
                                            <span class="material-icons">chevron_right</span>
                                        </button>
                                    @endif
                                @else
                                    <a href="{{ route('login.show') }}"
                                        class="bg-primary/10 text-primary hover:bg-primary hover:text-white p-2 rounded-lg transition-colors">
                                        <span class="material-icons">chevron_right</span>
                                    </a>
                                @endauth
                            </div>
                        </div>
                    </div>
                @empty
                    <!-- No Tools Available -->
                    <div class="col-span-full text-center py-12">
                        <span class="material-icons text-6xl text-slate-300 dark:text-slate-700 mb-4">construction</span>
                        <h3 class="text-xl font-bold text-slate-600 dark:text-slate-400 mb-2">Belum Ada Alat Tersedia</h3>
                        <p class="text-slate-500 dark:text-slate-500">Alat akan segera ditambahkan. Silakan cek kembali nanti.</p>
                    </div>
                @endforelse

    </section>
    <!-- Footer -->
    <footer class="bg-white dark:bg-slate-900 border-t border-slate-200 dark:border-slate-800 pt-16 pb-8" id="support">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-4 gap-12 mb-12">
                <div class="col-span-1 md:col-span-1">
                    <a class="flex items-center gap-2 mb-6" href="{{ route('home') }}">
                        <div class="w-8 h-8 bg-primary rounded-lg flex items-center justify-center">
                            <span class="material-icons text-white text-xl">construction</span>
                        </div>
                        <span class="text-xl font-bold tracking-tight text-slate-900 dark:text-white">EquipRent</span>
                    </a>
                    <p class="text-slate-500 dark:text-slate-400 text-sm leading-relaxed mb-6">
                        Membuat peralatan profesional dapat diakses oleh semua orang. Alat berkualitas tinggi,
                        persyaratan fleksibel, dan dukungan luar biasa.
                    </p>
                    <div class="flex gap-4">
                        <a class="w-8 h-8 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-600 dark:text-slate-400 hover:bg-primary hover:text-white transition-colors"
                            href="#">
                            <span class="material-icons text-sm">facebook</span>
                        </a>
                        <a class="w-8 h-8 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-600 dark:text-slate-400 hover:bg-primary hover:text-white transition-colors"
                            href="#">
                            <span class="material-icons text-sm">camera_alt</span>
                        </a>
                        <a class="w-8 h-8 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-600 dark:text-slate-400 hover:bg-primary hover:text-white transition-colors"
                            href="#">
                            <span class="material-icons text-sm">alternate_email</span>
                        </a>
                    </div>
                </div>
                <div>
                    <h4 class="font-bold mb-6 text-slate-900 dark:text-white">Tautan Cepat</h4>
                    <ul class="space-y-4 text-sm text-slate-500 dark:text-slate-400">
                        <li><a class="hover:text-primary transition-colors" href="#categories">Semua Kategori</a></li>
                        <li><a class="hover:text-primary transition-colors" href="#how-it-works">Cara Kerja</a></li>
                        @auth
                            @if(auth()->user()->role->name === 'peminjam')
                                <li><a class="hover:text-primary transition-colors" href="{{ route('peminjam.borrowings.index') }}">Peminjaman Saya</a></li>
                            @endif
                        @else
                            <li><a class="hover:text-primary transition-colors" href="{{ route('login.show') }}">Daftar Sekarang</a></li>
                        @endauth
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold mb-6 text-slate-900 dark:text-white">Bantuan</h4>
                    <ul class="space-y-4 text-sm text-slate-500 dark:text-slate-400">
                        <li><a class="hover:text-primary transition-colors" href="#">Pusat Bantuan</a></li>
                        <li><a class="hover:text-primary transition-colors" href="#">Panduan Keamanan</a></li>
                        <li><a class="hover:text-primary transition-colors" href="#">Syarat Layanan</a></li>
                        <li><a class="hover:text-primary transition-colors" href="#">Kebijakan Privasi</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold mb-6 text-slate-900 dark:text-white">Newsletter</h4>
                    <p class="text-sm text-slate-500 dark:text-slate-400 mb-4">Dapatkan update peralatan baru dan penawaran musiman.</p>
                    <div class="flex flex-col gap-2">
                        <input
                            class="px-4 py-2 text-sm bg-slate-100 dark:bg-slate-800 border-none rounded-lg focus:ring-2 focus:ring-primary/50"
                            placeholder="Alamat email Anda" type="email" />
                        <button
                            class="bg-primary text-white text-sm font-semibold px-4 py-2 rounded-lg hover:bg-primary/90 transition-all">Langganan</button>
                    </div>
                </div>
            </div>
            <div
                class="pt-8 border-t border-slate-100 dark:border-slate-800 flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-xs text-slate-400">© 2024 EquipRent. Hak cipta dilindungi undang-undang.</p>
                <div class="flex gap-6">
                    <div class="flex items-center gap-2 text-xs text-slate-400">
                        <span class="material-icons text-xs">language</span>
                        <span>Bahasa Indonesia</span>
                    </div>
                    <div class="flex items-center gap-2 text-xs text-slate-400">
                        <span class="material-icons text-xs">payments</span>
                        <span>IDR (Rp)</span>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</body>

</html>
