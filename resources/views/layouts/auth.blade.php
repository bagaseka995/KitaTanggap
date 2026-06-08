<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'KitaTanggap') — Sistem Informasi Penanganan Bencana</title>
    <meta name="description" content="@yield('meta_description', 'Platform terpadu penanganan bencana di Indonesia — Informasi bencana real-time, manajemen relawan, dan donasi transparan.')">

    {{-- Google Fonts: Inter --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- Tailwind CSS CDN (dev) --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary:   { DEFAULT: '#1F4E79', light: '#2E75B6', dark: '#163859' },
                        secondary: '#2E75B6',
                        accent:    '#C55A11',
                        danger:    '#C0392B',
                        warning:   '#F5C518',
                    },
                    fontFamily: {
                        sans: ['Inter', 'Arial', 'sans-serif'],
                    },
                }
            }
        }
    </script>

    {{-- Alpine.js --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        [x-cloak] { display: none !important; }
        body { font-family: 'Inter', Arial, sans-serif; }

        /* Animasi fade-in untuk kartu auth */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(24px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-up { animation: fadeInUp 0.5s ease both; }

        /* Password strength bar */
        .strength-bar { transition: width 0.3s ease, background-color 0.3s ease; }

        /* Custom checkbox */
        .custom-checkbox:checked { background-color: #1F4E79; border-color: #1F4E79; }

        /* Input focus ring warna brand */
        .input-brand:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(31,78,121,0.2);
            border-color: #1F4E79;
        }
    </style>

    @stack('styles')

    <!-- Firebase SDK (Compat version for simplicity) -->
    <script src="https://www.gstatic.com/firebasejs/9.6.1/firebase-app-compat.js"></script>
    <script src="https://www.gstatic.com/firebasejs/9.6.1/firebase-messaging-compat.js"></script>
    <script src="{{ asset('js/firebase-messaging.js') }}" defer></script>
</head>
<body class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50">

    @yield('content')

    @stack('scripts')
</body>
</html>
