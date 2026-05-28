<!DOCTYPE html>
<html lang="id" class="h-full" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel') - Ghina Tour Travel</title>
    <script>
        (function() {
            const isDark = localStorage.getItem('theme') === 'dark';
            document.documentElement.classList.toggle('dark', isDark);
            document.documentElement.setAttribute('data-theme', isDark ? 'dark' : 'light');
        })();
    </script>
    @vite(['resources/css/app.css', 'resources/css/admin.css', 'resources/js/app.js'])
    @fluxAppearance
    @stack('head')
</head>

<body class="h-full overflow-x-hidden">
    <div class="admin-shell">
        <aside id="sidebar" class="admin-sidebar">
            <div class="admin-brand">
                <h1>Ghinatour Travel</h1>
                <p>Admin Panel</p>
            </div>

            <nav class="admin-nav">
                <p class="admin-nav__label">Menu</p>
                <a href="{{ route('admin.dashboard') }}" class="admin-nav__link {{ request()->routeIs('admin.dashboard') ? 'is-active' : '' }}">
                    <span class="admin-nav__icon"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M3 11 12 3l9 8v10h-6v-6H9v6H3V11Z"/></svg></span>
                    Dashboard
                </a>
                <a href="{{ route('admin.paket.index') }}" class="admin-nav__link {{ request()->routeIs('admin.paket.*') ? 'is-active' : '' }}">
                    <span class="admin-nav__icon"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M21 7.5 12 2 3 7.5v9L12 22l9-5.5v-9ZM12 4.3l5.6 3.4L12 11.1 6.4 7.7 12 4.3Z"/></svg></span>
                    Paket
                </a>
                <a href="{{ route('admin.pesanan.index') }}" class="admin-nav__link {{ request()->routeIs('admin.pesanan.*') ? 'is-active' : '' }}">
                    <span class="admin-nav__icon"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M7 18a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm10 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4ZM7.2 14h7.9a3 3 0 0 0 2.8-1.9L21 4H5.2L4.8 2H1v2h2.2l2.3 11.4A2 2 0 0 0 7.4 17H19v-2H7.4l-.2-1Z"/></svg></span>
                    Pesanan
                </a>
                <a href="{{ route('admin.gallery.index') }}" class="admin-nav__link {{ request()->routeIs('admin.gallery.*') ? 'is-active' : '' }}">
                    <span class="admin-nav__icon"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M21 19V5a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2ZM8.5 11.5l2.5 3 3.5-4.5 4.5 6H5l3.5-4.5Z"/></svg></span>
                    Galeri
                </a>
                <a href="{{ route('admin.company-profile.show') }}" class="admin-nav__link {{ request()->routeIs('admin.company-profile.*') ? 'is-active' : '' }}">
                    <span class="admin-nav__icon"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M4 21V3h16v18h-6v-5h-4v5H4Zm4-14h3V5H8v2Zm5 0h3V5h-3v2ZM8 11h3V9H8v2Zm5 0h3V9h-3v2Z"/></svg></span>
                    Company Profile
                </a>
            </nav>

            <a href="{{ route('home') }}" class="admin-visit">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 12H5m7 7-7-7 7-7"/></svg>
                Kunjungi Website
            </a>
        </aside>

        <div id="sidebarBackdrop" class="admin-backdrop" onclick="closeSidebar()"></div>

        <div class="admin-main">
            <header class="admin-topbar">
                <button type="button" onclick="openSidebar()" class="admin-menu-btn" aria-label="Buka menu">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>

                <div class="ml-auto flex min-w-0 items-center gap-2 sm:gap-5">
                    <label class="tgl" title="Ganti tema">
                        <input type="checkbox" id="adminThemeToggle" />
                        <span class="sl">
                            <svg class="tgl__icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                aria-hidden="true">
                                <circle cx="12" cy="12" r="4" />
                                <path d="M12 2v2m0 16v2M4.93 4.93l1.41 1.41m11.32 11.32 1.41 1.41M2 12h2m16 0h2M4.93 19.07l1.41-1.41M17.66 6.34l1.41-1.41" />
                            </svg>
                            <svg class="tgl__icon" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                <path d="M21 14.2A8.5 8.5 0 0 1 9.8 3a7 7 0 1 0 11.2 11.2Z" />
                            </svg>
                        </span>
                    </label>

                    <div class="relative">
                        <button type="button" onclick="toggleLogoutMenu()" class="admin-profile min-h-11 min-w-11">
                            <span class="hidden max-w-[140px] truncate sm:inline">{{ auth()->user()->name ?? 'Admin Ghina' }}</span>
                            <img src="{{ asset('customer/assets/images/logos/logo.png') }}" alt="Admin">
                        </button>

                        <div id="logoutMenu" class="admin-profile-menu hidden">
                            <form action="{{ route('logout') }}" method="POST" data-confirm="logout" data-confirm-title="Apakah anda yakin ingin keluar?">
                                @csrf
                                <button type="submit" class="admin-profile-menu__logout">Keluar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>

            <main class="admin-content">
                @if (session('success'))
                    <div class="admin-alert admin-alert--success" data-admin-flash="success">{{ session('success') }}</div>
                @endif
                @if (session('failed'))
                    <div class="admin-alert admin-alert--error" data-admin-flash="error">{{ session('failed') }}</div>
                @endif
                @if ($errors->any())
                    <div class="admin-alert admin-alert--error">
                        <ul class="list-disc pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <x-admin-modal />

    <script>
        function openSidebar() {
            document.getElementById('sidebar').classList.add('is-open');
            document.getElementById('sidebarBackdrop').classList.add('is-open');
            document.body.classList.add('overflow-hidden');
        }

        function closeSidebar() {
            document.getElementById('sidebar').classList.remove('is-open');
            document.getElementById('sidebarBackdrop').classList.remove('is-open');
            document.body.classList.remove('overflow-hidden');
        }

        function toggleLogoutMenu() {
            document.getElementById('logoutMenu').classList.toggle('hidden');
        }

        window.addEventListener('click', function(event) {
            const menu = document.getElementById('logoutMenu');
            const profile = document.querySelector('.admin-profile');
            if (menu && profile && !profile.contains(event.target) && !menu.contains(event.target)) {
                menu.classList.add('hidden');
            }
        });

        (function() {
            const html = document.documentElement;
            const toggle = document.getElementById('adminThemeToggle');

            function applyTheme(isDark) {
                html.classList.toggle('dark', isDark);
                html.setAttribute('data-theme', isDark ? 'dark' : 'light');
                if (toggle) toggle.checked = isDark;
            }

            applyTheme(localStorage.getItem('theme') === 'dark');

            toggle?.addEventListener('change', function() {
                const isDark = toggle.checked;
                localStorage.setItem('theme', isDark ? 'dark' : 'light');
                applyTheme(isDark);
            });
        })();
    </script>

    @stack('scripts')
    @livewireScripts
    @fluxScripts
</body>

</html>
