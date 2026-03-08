<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar | KantorKuu</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap"
        rel="stylesheet" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
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
    class="bg-background-light dark:bg-background-dark font-display flex items-center justify-center min-h-screen p-4">
    <div class="w-full max-w-md">
        <!-- Logo Header -->
        <div class="text-center mb-8">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-2 mb-6">
                <div class="w-10 h-10 bg-primary rounded-lg flex items-center justify-center">
                    <span class="material-icons text-white text-2xl">construction</span>
                </div>
                <span class="text-2xl font-bold tracking-tight text-slate-900 dark:text-white">KantorKuu</span>
            </a>
            <h1 class="text-3xl font-bold text-slate-900 dark:text-white mb-2">Buat Akun Baru</h1>
            <p class="text-slate-500 dark:text-slate-400">Daftar untuk mulai menyewa peralatan</p>
        </div>

        <!-- Register Card -->
        <div class="bg-white dark:bg-slate-900 rounded-xl shadow-xl border border-slate-200 dark:border-slate-800 p-8">
            <form action="{{ route('register') }}" method="POST" class="space-y-5">
                @csrf

                <!-- Name Field -->
                <div>
                    <label for="name" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">
                        Nama Lengkap
                    </label>
                    <div class="relative">
                        <span class="material-icons absolute left-3 top-3 text-slate-400 text-xl">badge</span>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" required
                            class="w-full pl-11 pr-4 py-3 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg focus:ring-2 focus:ring-primary/50 focus:border-primary transition-all @error('name') border-red-500 @enderror"
                            placeholder="Masukkan nama lengkap">
                    </div>
                    @error('name')
                        <p class="mt-1 text-sm text-red-500 flex items-center gap-1">
                            <span class="material-icons text-sm">error</span>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Username Field -->
                <div>
                    <label for="username" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">
                        Username
                    </label>
                    <div class="relative">
                        <span class="material-icons absolute left-3 top-3 text-slate-400 text-xl">person</span>
                        <input type="text" name="username" id="username" value="{{ old('username') }}" required
                            class="w-full pl-11 pr-4 py-3 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg focus:ring-2 focus:ring-primary/50 focus:border-primary transition-all @error('username') border-red-500 @enderror"
                            placeholder="Pilih username unik">
                    </div>
                    @error('username')
                        <p class="mt-1 text-sm text-red-500 flex items-center gap-1">
                            <span class="material-icons text-sm">error</span>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Email Field -->
                <div>
                    <label for="email" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">
                        Email
                    </label>
                    <div class="relative">
                        <span class="material-icons absolute left-3 top-3 text-slate-400 text-xl">email</span>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" required
                            class="w-full pl-11 pr-4 py-3 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg focus:ring-2 focus:ring-primary/50 focus:border-primary transition-all @error('email') border-red-500 @enderror"
                            placeholder="Masukkan email Anda">
                    </div>
                    @error('email')
                        <p class="mt-1 text-sm text-red-500 flex items-center gap-1">
                            <span class="material-icons text-sm">error</span>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Password Field -->
                <div>
                    <label for="password" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">
                        Password
                    </label>
                    <div class="relative">
                        <span class="material-icons absolute left-3 top-3 text-slate-400 text-xl">lock</span>
                        <input type="password" name="password" id="password" required
                            class="w-full pl-11 pr-12 py-3 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg focus:ring-2 focus:ring-primary/50 focus:border-primary transition-all @error('password') border-red-500 @enderror"
                            placeholder="Buat password (min. 8 karakter)">
                        <button type="button" onclick="togglePassword('password', 'toggleIcon1')"
                            class="absolute right-3 top-3 text-slate-400 hover:text-slate-600 dark:hover:text-slate-300">
                            <span class="material-icons text-xl" id="toggleIcon1">visibility_off</span>
                        </button>
                    </div>
                    @error('password')
                        <p class="mt-1 text-sm text-red-500 flex items-center gap-1">
                            <span class="material-icons text-sm">error</span>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Password Confirmation Field -->
                <div>
                    <label for="password_confirmation"
                        class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">
                        Konfirmasi Password
                    </label>
                    <div class="relative">
                        <span class="material-icons absolute left-3 top-3 text-slate-400 text-xl">lock</span>
                        <input type="password" name="password_confirmation" id="password_confirmation" required
                            class="w-full pl-11 pr-12 py-3 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg focus:ring-2 focus:ring-primary/50 focus:border-primary transition-all"
                            placeholder="Ketik ulang password Anda">
                        <button type="button" onclick="togglePassword('password_confirmation', 'toggleIcon2')"
                            class="absolute right-3 top-3 text-slate-400 hover:text-slate-600 dark:hover:text-slate-300">
                            <span class="material-icons text-xl" id="toggleIcon2">visibility_off</span>
                        </button>
                    </div>
                </div>

                <!-- Info Note -->
                <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                    <div class="flex items-start gap-2 text-blue-600 dark:text-blue-400">
                        <span class="material-icons text-sm mt-0.5">info</span>
                        <span class="text-xs">Akun yang terdaftar akan otomatis menjadi <strong>Peminjam</strong>. Untuk
                            mendapatkan akses Admin/Petugas, hubungi administrator sistem.</span>
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit"
                    class="w-full bg-primary hover:bg-primary/90 text-white font-semibold py-3 rounded-lg shadow-lg shadow-primary/30 transition-all flex items-center justify-center gap-2 hover:shadow-xl">
                    <span class="material-icons">how_to_reg</span>
                    Daftar Sekarang
                </button>
            </form>

            <!-- Divider -->
            <div class="relative my-6">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-slate-200 dark:border-slate-700"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="px-2 bg-white dark:bg-slate-900 text-slate-500">atau</span>
                </div>
            </div>

            <!-- Login Link -->
            <p class="text-center text-sm text-slate-600 dark:text-slate-400">
                Sudah punya akun?
                <a href="{{ route('login.show') }}"
                    class="font-semibold text-primary hover:text-primary/90 hover:underline ml-1">
                    Masuk di sini
                </a>
            </p>
        </div>
    </div>

    <script>
        function togglePassword(inputId, iconId) {
            const passwordInput = document.getElementById(inputId);
            const toggleIcon = document.getElementById(iconId);

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.textContent = 'visibility';
            } else {
                passwordInput.type = 'password';
                toggleIcon.textContent = 'visibility_off';
            }
        }
    </script>
</body>

</html>