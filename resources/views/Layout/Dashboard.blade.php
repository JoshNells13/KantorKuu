<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>
        @if (auth()->user()->role->name === 'admin')
            Dashboard Admin
        @elseif(auth()->user()->role->name === 'petugas')
            Dashboard Petugas
        @elseif(auth()->user()->role->name === 'peminjam')
            Dashboard Peminjam
        @endif
        | KantorKuu
    </title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap"
        rel="stylesheet" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
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
                        "display": ["Inter"]
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
    class="font-display bg-background-light dark:bg-background-dark text-slate-900 dark:text-slate-100 min-h-screen flex">
    <!-- Sidebar -->
    <aside
        class="w-64 bg-white dark:bg-slate-900 border-r border-slate-200 dark:border-slate-800 flex flex-col fixed h-full">
        <div class="p-6 flex items-center gap-3">
            <div class="w-8 h-8 bg-primary rounded flex items-center justify-center">
                <span class="material-icons text-white text-2xl">business</span>
            </div>
            <span class="text-xl font-bold tracking-tight text-primary">KantorKuu</span>
        </div>
        <nav class="flex-1 px-4 space-y-1 mt-4">
            @if (auth()->user()->role->name === 'admin')
                @include('Layout.sidebar.admin')
            @elseif(auth()->user()->role->name === 'petugas')
                @include('Layout.sidebar.petugas')
            @elseif(auth()->user()->role->name === 'peminjam')
                @include('Layout.sidebar.peminjam')
            @endif
        </nav>
        <div class="p-4 border-t border-slate-200 dark:border-slate-800">
            <div class="flex items-center gap-3 p-2">
                <div class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center">
                    <span class="material-icons text-primary">person</span>
                </div>
                <div class="overflow-hidden flex-1">
                    <p class="text-sm font-semibold truncate">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-slate-500 truncate capitalize">{{ auth()->user()->role->name }}</p>
                </div>
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="ml-64 flex-1 flex flex-col min-h-screen">
        <!-- Top Bar -->
        <header
            class="h-16 bg-white dark:bg-slate-900 border-b border-slate-200 dark:border-slate-800 flex items-center justify-between px-8 sticky top-0 z-10">
            <div class="flex items-center gap-4">
                <h1 class="text-xl font-bold">@yield('page-title', 'Dashboard')</h1>
            </div>
            <div class="flex items-center gap-6">
                <div class="relative">
                    <span class="material-icons text-slate-400 hover:text-primary cursor-pointer">notifications</span>
                    <span
                        class="absolute -top-1 -right-1 w-2 h-2 bg-red-500 rounded-full border-2 border-white dark:border-slate-900"></span>
                </div>
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" onclick="return confirm('Apakah Anda yakin ingin keluar?')"
                        class="bg-red-500 text-white px-4 py-2 rounded-lg font-medium flex items-center gap-2 hover:bg-red-600 transition-colors text-sm">
                        <span class="material-icons text-sm">logout</span>
                        <span>Keluar</span>
                    </button>
                </form>
            </div>
        </header>

        <!-- Page Content -->
        <div class="p-8 flex-1">
            <!-- Success/Error Notifications -->
            @if (session('success'))
                <div id="notif-success"
                    class="mb-6 flex items-center gap-3 bg-green-600 text-white px-5 py-4 rounded-xl shadow-lg">
                    <span class="material-icons text-xl">check_circle</span>
                    <span class="text-sm font-semibold">{{ session('success') }}</span>
                    <button onclick="closeNotif('notif-success')" class="ml-auto text-white/80 hover:text-white">
                        <span class="material-icons">close</span>
                    </button>
                </div>
            @endif

            @if (session('error'))
                <div id="notif-error"
                    class="mb-6 flex items-center gap-3 bg-red-600 text-white px-5 py-4 rounded-xl shadow-lg">
                    <span class="material-icons text-xl">error</span>
                    <span class="text-sm font-semibold">{{ session('error') }}</span>
                    <button onclick="closeNotif('notif-error')" class="ml-auto text-white/80 hover:text-white">
                        <span class="material-icons">close</span>
                    </button>
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    <script>
        function closeNotif(id) {
            const el = document.getElementById(id);
            if (el) el.remove();
        }

        setTimeout(() => {
            document.getElementById('notif-success')?.remove();
            document.getElementById('notif-error')?.remove();
        }, 4000);

        // Quantity limit based on stock
        const toolSelect = document.getElementById('toolSelect');
        const qtyInput = document.getElementById('qtyInput');

        if (toolSelect && qtyInput) {
            toolSelect.addEventListener('change', function () {
                const selectedOption = this.options[this.selectedIndex];
                const stock = selectedOption.getAttribute('data-stock');

                if (stock) {
                    qtyInput.max = stock;
                }
            });
        }
    </script>
</body>

</html>