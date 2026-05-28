<!doctype html>
<html lang="id" data-theme="light">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Ghina Tour Travel — Serving With Love')</title>
    <meta name="description" content="@yield('description', 'PT Ghina Tour Travel — solusi perjalanan wisata rombongan dengan harga sesuai anggaran Anda. Terpercaya, Fleksibel & Fun.')" />

    <script>
        (function() {
            const isDark = localStorage.getItem('theme') === 'dark';
            document.documentElement.classList.toggle('dark', isDark);
            document.documentElement.setAttribute('data-theme', isDark ? 'dark' : 'light');
        })();
    </script>

    @vite(['resources/css/app.css', 'resources/css/customer.css', 'resources/css/chatbot.css', 'resources/js/app.js'])

    @yield('extra_styles')
</head>

<body class="overflow-x-hidden">

    @include('components.layout.navbar')

    @yield('content')

    @include('components.layout.footer')

    <x-chatbot-widget mode="public" />


    @include('components.customer.lightbox')

    @include('components.layout.scripts')
    @yield('extra_scripts')
</body>

</html>
