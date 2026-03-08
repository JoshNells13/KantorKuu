<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk | KantorKuu</title>
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
                    <span class="material-icons text-white text-2xl">business</span>
                </div>
                <span class="text-2xl font-bold tracking-tight text-slate-900 dark:text-white">KantorKuu</span>
            </a>
            <h1 class="text-3xl font-bold text-slate-900 dark:text-white mb-2">Selamat Datang Kembali</h1>
            <p class="text-slate-500 dark:text-slate-400">Masuk ke akun Anda untuk melanjutkan</p>
        </div>

        <!-- Login Card -->
        <div class="bg-white dark:bg-slate-900 rounded-xl shadow-xl border border-slate-200 dark:border-slate-800 p-8">
            <form action="{{ route('login') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Username Field -->
                <div>
                    <label for="username" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">
                        Username
                    </label>
                    <div class="relative">
                        <span class="material-icons absolute left-3 top-3 text-slate-400 text-xl">person</span>
                        <input type="text" name="username" id="username" value="{{ old('username') }}" required
                            class="w-full pl-11 pr-4 py-3 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg focus:ring-2 focus:ring-primary/50 focus:border-primary transition-all @error('username') border-red-500 @enderror"
                            placeholder="Masukkan username Anda">
                    </div>
                    @error('username')
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
                            placeholder="Masukkan password Anda">
                        <button type="button" onclick="togglePassword()"
                            class="absolute right-3 top-3 text-slate-400 hover:text-slate-600 dark:hover:text-slate-300">
                            <span class="material-icons text-xl" id="toggleIcon">visibility_off</span>
                        </button>
                    </div>
                    @error('password')
                        <p class="mt-1 text-sm text-red-500 flex items-center gap-1">
                            <span class="material-icons text-sm">error</span>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- General Error Message -->
                @if($errors->any() && !$errors->has('username') && !$errors->has('password'))
                    <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-4">
                        <div class="flex items-center gap-2 text-red-600 dark:text-red-400">
                            <span class="material-icons">error</span>
                            <span class="text-sm font-medium">{{ $errors->first() }}</span>
                        </div>
                    </div>
                @endif

                <!-- Submit Button -->
                <button type="submit"
                    class="w-full bg-primary hover:bg-primary/90 text-white font-semibold py-3 rounded-lg shadow-lg shadow-primary/30 transition-all flex items-center justify-center gap-2 hover:shadow-xl">
                    <span class="material-icons">login</span>
                    Masuk
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

            <!-- Register Link -->
            <p class="text-center text-sm text-slate-600 dark:text-slate-400">
                Belum punya akun?
                <a href="{{ route('register.show') }}"
                    class="font-semibold text-primary hover:text-primary/90 hover:underline ml-1">
                    Daftar di sini
                </a>
            </p>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('toggleIcon');

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