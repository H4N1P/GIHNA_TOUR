<!doctype html>
<html lang="id" data-theme="light">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Ghina Tour Travel — Serving With Love')</title>
    <meta name="description" content="@yield('description', 'PT Ghina Tour Travel — solusi perjalanan wisata rombongan dengan harga sesuai anggaran Anda. Terpercaya, Fleksibel & Fun.')" />

    @vite(['resources/css/app.css', 'resources/css/customer.css', 'resources/css/chatbot.css', 'resources/js/app.js'])

    @yield('extra_styles')
</head>

<body>

    @include('components.layout.navbar')

    @yield('content')

    @include('components.layout.footer')

    <x-chatbot-widget mode="public" />

    <a href="https://wa.me/{{ preg_replace('/\D/', '', $companyProfile->whatsapp ?? '6281234567890') }}" target="_blank" class="wa-float" aria-label="Hubungi lewat WhatsApp">
        <img src="{{ asset('customer/icon/whatsapp.svg') }}" alt="WhatsApp">
    </a>

    @include('components.layout.scripts')
    @yield('extra_scripts')
</body>

</html>
