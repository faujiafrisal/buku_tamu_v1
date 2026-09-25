<!DOCTYPE html>
<html lang="id" class="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Buku Tamu Digital - MPP Kota Samarinda')</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- FontAwesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Google Fonts Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                    },
                    colors: {
                        gov: {
                            50: '#f0f4f8',
                            100: '#d9e2ec',
                            500: '#102a43',
                            600: '#0b69a3',
                            700: '#035388',
                            800: '#0b2942',
                            900: '#061d33',
                        }
                    }
                }
            }
        }
    </script>

    <style>
        .gov-card {
            background: rgba(255, 255, 255, 0.94);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
        }
        .dark .gov-card {
            background: rgba(10, 20, 35, 0.90);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
        }

        .gov-pattern {
            background-color: #0f172a;
            background-image: linear-gradient(to bottom, rgba(15, 23, 42, 0.78), rgba(15, 23, 42, 0.90)), url('https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?q=80&w=1920&auto=format&fit=crop');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            background-repeat: no-repeat;
        }
        .dark .gov-pattern {
            background-image: linear-gradient(to bottom, rgba(3, 7, 18, 0.88), rgba(3, 7, 18, 0.96)), url('https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?q=80&w=1920&auto=format&fit=crop');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            background-repeat: no-repeat;
        }

        input[type=range] {
            -webkit-appearance: none;
            appearance: none;
            width: 100%;
            height: 10px;
            border-radius: 9999px;
            background: #cbd5e1;
            outline: none;
        }
        .dark input[type=range] {
            background: #1e293b;
        }
        input[type=range]::-webkit-slider-thumb {
            -webkit-appearance: none;
            appearance: none;
            width: 26px;
            height: 26px;
            border-radius: 50%;
            background: #1e3a8a;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(30, 58, 138, 0.4);
            border: 3px solid #fbbf24;
            transition: transform 0.15s ease, background-color 0.15s ease;
        }
        input[type=range]::-webkit-slider-thumb:hover {
            transform: scale(1.15);
        }
        .dark input[type=range]::-webkit-slider-thumb {
            background: #2563eb;
            border-color: #fbbf24;
        }

        @keyframes slideInRight {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        @keyframes fadeOut {
            from { opacity: 1; }
            to { opacity: 0; }
        }
        .toast-enter {
            animation: slideInRight 0.3s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }
        .toast-exit {
            animation: fadeOut 0.3s ease forwards;
        }
    </style>
    @stack('styles')
</head>
<body class="gov-pattern text-slate-800 dark:text-slate-100 font-sans min-h-screen transition-colors duration-300 flex flex-col justify-between items-center p-3 sm:p-6 md:p-8 selection:bg-blue-600 selection:text-white">

    <!-- Top Header Bar -->
    <header class="w-full max-w-4xl flex items-center justify-between gap-4 mb-5 px-1">
        <div>
            <h1 class="font-bold text-base sm:text-xl text-white leading-tight flex items-center gap-2">
                <i class="fa-solid fa-building-columns text-amber-400"></i> Mal Pelayanan Publik
            </h1>
            <p class="text-xs text-slate-300 font-medium flex items-center gap-2 mt-0.5">
                <span>DPMPTSP Samarinda</span>
                <span>&bull;</span>
                <span id="liveClock" class="font-mono text-amber-400 font-semibold">00:00:00 WITA</span>
            </p>
        </div>

        <div class="flex items-center gap-2">
            @if(request()->is('admin'))
                <a href="{{ route('guestbook.index') }}" class="px-3.5 py-2 rounded-xl bg-blue-900/80 hover:bg-blue-800 text-amber-400 border border-amber-500/30 text-xs font-bold transition-all shadow-sm flex items-center gap-1.5">
                    <i class="fa-solid fa-clipboard-user"></i> Formulir
                </a>
            @else
                <a href="{{ route('guestbook.admin') }}" class="px-3.5 py-2 rounded-xl bg-blue-900/80 hover:bg-blue-800 text-amber-400 border border-amber-500/30 text-xs font-bold transition-all shadow-sm flex items-center gap-1.5">
                    <i class="fa-solid fa-chart-pie"></i> Admin Panel
                </a>
            @endif

            <button id="themeToggleBtn" title="Ganti Tema Visual" class="p-2.5 rounded-xl bg-slate-900/80 border border-slate-700 text-slate-200 hover:bg-slate-800 transition-all shadow-sm text-xs cursor-pointer">
                <i id="themeIcon" class="fa-solid fa-moon text-amber-500"></i>
            </button>
        </div>
    </header>

    @yield('content')

    <!-- Toast Notification Container -->
    <div id="toastContainer" class="fixed bottom-5 right-5 z-50 flex flex-col gap-2 max-w-sm w-full pointer-events-none"></div>

    <footer class="mt-8 text-center text-xs text-slate-400 dark:text-slate-400 font-medium space-y-1">
        <p>&copy; {{ date('Y') }} Pemerintah Kota Samarinda &bull; Mal Pelayanan Publik (MPP) Laravel App</p>
        <p class="text-[11px] text-slate-400">Dinas Penanaman Modal dan Pelayanan Terpadu Satu Pintu (DPMPTSP)</p>
    </footer>

    <script>
        function showToast(message, type = 'info') {
            const container = document.getElementById('toastContainer');
            if (!container) return;

            const toast = document.createElement('div');
            toast.className = `toast-enter pointer-events-auto flex items-center gap-3 p-4 rounded-2xl shadow-xl text-xs font-semibold border ${
                type === 'error' 
                    ? 'bg-rose-950/90 text-rose-200 border-rose-800/80 backdrop-blur-md' 
                    : type === 'success' 
                    ? 'bg-emerald-950/90 text-emerald-200 border-emerald-800/80 backdrop-blur-md' 
                    : 'bg-slate-900/90 text-white border-slate-700/80 backdrop-blur-md'
            }`;

            const iconClass = type === 'error' ? 'fa-circle-exclamation text-rose-400' : type === 'success' ? 'fa-circle-check text-emerald-400' : 'fa-circle-info text-blue-400';
            
            toast.innerHTML = `
                <i class="fa-solid ${iconClass} text-base shrink-0"></i>
                <div class="flex-1 leading-snug">${message}</div>
                <button class="text-slate-400 hover:text-white text-sm ml-2 shrink-0">&times;</button>
            `;

            toast.querySelector('button').addEventListener('click', () => {
                toast.classList.remove('toast-enter');
                toast.classList.add('toast-exit');
                setTimeout(() => toast.remove(), 300);
            });

            container.appendChild(toast);

            setTimeout(() => {
                if (toast.parentNode) {
                    toast.classList.remove('toast-enter');
                    toast.classList.add('toast-exit');
                    setTimeout(() => toast.remove(), 300);
                }
            }, 4500);
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Live Clock Function (WITA)
            function updateClock() {
                const clockEl = document.getElementById('liveClock');
                if (!clockEl) return;
                const now = new Date();
                const timeString = now.toLocaleTimeString('id-ID', { hour12: false });
                clockEl.textContent = `${timeString} WITA`;
            }
            setInterval(updateClock, 1000);
            updateClock();

            // Theme Management
            const themeToggleBtn = document.getElementById('themeToggleBtn');
            const themeIcon = document.getElementById('themeIcon');
            const htmlTag = document.documentElement;

            const savedTheme = localStorage.getItem('theme');
            if (savedTheme === 'dark' || (!savedTheme && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                htmlTag.classList.remove('light');
                htmlTag.classList.add('dark');
                if (themeIcon) themeIcon.className = 'fa-solid fa-sun text-amber-400';
            }

            if (themeToggleBtn) {
                themeToggleBtn.addEventListener('click', function() {
                    if (htmlTag.classList.contains('dark')) {
                        htmlTag.classList.remove('dark');
                        htmlTag.classList.add('light');
                        if (themeIcon) themeIcon.className = 'fa-solid fa-moon text-amber-500';
                        localStorage.setItem('theme', 'light');
                    } else {
                        htmlTag.classList.remove('light');
                        htmlTag.classList.add('dark');
                        if (themeIcon) themeIcon.className = 'fa-solid fa-sun text-amber-400';
                        localStorage.setItem('theme', 'dark');
                    }
                });
            }
        });
    </script>
    @stack('scripts')
</body>
</html>
