<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Masuk') - Peminjaman Alat</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-gradient-to-br from-blue-600 via-blue-500 to-blue-700 min-h-screen flex items-center justify-center">
    <div class="w-full max-w-md">

        @if (session('success'))
            <div id="notif-success"
                class="fixed top-5 right-5 z-50 flex items-center gap-3 bg-green-600 text-white px-5 py-4 rounded-xl shadow-lg animate-slide-in">
                <span class="material-icons text-xl">check_circle</span>
                <span class="text-sm font-semibold">{{ session('success') }}</span>
                <button onclick="closeNotif('notif-success')" class="ml-2 text-white/80 hover:text-white">
                    <span class="material-icons">close</span>
                </button>
            </div>
        @endif

        @if (session('error'))
            <div id="notif-error"
                class="fixed top-5 right-5 z-50 flex items-center gap-3 bg-red-600 text-white px-5 py-4 rounded-xl shadow-lg animate-slide-in">
                <span class="material-icons text-xl">error</span>
                <span class="text-sm font-semibold">{{ session('error') }}</span>
                <button onclick="closeNotif('notif-error')" class="ml-2 text-white/80 hover:text-white">
                    <span class="material-icons">close</span>
                </button>
            </div>
        @endif

        @yield('content')


        <div class="text-center mt-8 text-white text-sm">
            <p>&copy; 2026 Sistem Peminjaman Alat. All rights reserved.</p>
        </div>
    </div>

    <script>
        document.querySelectorAll('button[type="button"]').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const input = this.parentElement.querySelector('input');
                const icon = this.querySelector('i');

                if (input.type === 'password') {
                    input.type = 'text';
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                } else {
                    input.type = 'password';
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                }
            });
        });

        function closeNotif(id) {
            const el = document.getElementById(id);
            if (el) el.remove();
        }

        setTimeout(() => {
            document.getElementById('notif-success')?.remove();
            document.getElementById('notif-error')?.remove();
        }, 4000);
    </script>
</body>

</html>
