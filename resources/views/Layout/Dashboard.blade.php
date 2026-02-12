<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        @if (auth()->user()->role->name === 'admin')
            Admin Dashboard
        @elseif(auth()->user()->role->name === 'petugas')
            Petugas Dashboard
        @elseif(auth()->user()->role->name === 'peminjam')
            Peminjam Dashboard
        @endif
        - Peminjaman Alat
    </title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-gray-50">
    <div class="flex h-screen bg-gray-100">
        <!-- Sidebar -->
        <div class="w-64 bg-blue-900 text-white shadow-lg">
            <div class="p-6">
                <h1 class="text-2xl font-bold flex items-center gap-2">

                    @if (auth()->user()->role->name === 'admin')
                        <i class="fas fa-tools"></i> Admin Dashboard
                    @elseif(auth()->user()->role->name === 'petugas')
                        <i class="fas fa-tools"></i> Petugas Dashboard
                    @elseif(auth()->user()->role->name === 'peminjam')
                        <i class="fas fa-tools"></i> Peminjam Dashboard
                    @endif
                </h1>
            </div>
            <nav class="px-4 py-6 space-y-2">
                @if (auth()->user()->role->name === 'admin')
                    @include('Layout.sidebar.admin')
                @elseif(auth()->user()->role->name === 'petugas')
                    @include('Layout.sidebar.petugas')
                @elseif(auth()->user()->role->name === 'peminjam')
                    @include('Layout.sidebar.peminjam')
                @endif
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Bar -->
            <div class="bg-white border-b border-gray-200 px-8 py-4 flex justify-between items-center">
                <h2 class="text-2xl font-bold text-gray-800">Dashboard</h2>
            </div>

            <!-- Content Area -->

            @if (session('success'))
                <div id="notif-success"
                    class="fixed top-5 right-5 z-50 flex items-center gap-3 bg-green-600 text-white px-5 py-4 rounded-xl shadow-lg animate-slide-in">
                    <i class="fas fa-circle-check text-xl"></i>
                    <span class="text-sm font-semibold">{{ session('success') }}</span>
                    <button onclick="closeNotif('notif-success')" class="ml-2 text-white/80 hover:text-white">
                        <i class="fas fa-xmark"></i>
                    </button>
                </div>
            @endif

            @if (session('error'))
                <div id="notif-error"
                    class="fixed top-5 right-5 z-50 flex items-center gap-3 bg-red-600 text-white px-5 py-4 rounded-xl shadow-lg animate-slide-in">
                    <i class="fas fa-circle-xmark text-xl"></i>
                    <span class="text-sm font-semibold">{{ session('error') }}</span>
                    <button onclick="closeNotif('notif-error')" class="ml-2 text-white/80 hover:text-white">
                        <i class="fas fa-xmark"></i>
                    </button>
                </div>
            @endif

            @yield('content')
        </div>
    </div>

    <script>
        function closeNotif(id) {
            const el = document.getElementById(id);
            if (el) el.remove();
        }


        setTimeout(() => {
            document.getElementById('notif-success')?.remove();
            document.getElementById('notif-error')?.remove();
        }, 4000);


        const toolSelect = document.getElementById('toolSelect');
        const qtyInput = document.getElementById('qtyInput');

        toolSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const stock = selectedOption.getAttribute('data-stock');

            if (stock) {
                qtyInput.max = stock;
            }
        });
    </script>
</body>

</html>
