<!DOCTYPE html>
<html lang="id" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - Ghina Tour Travel</title>
    @vite(['resources/css/app.css', 'resources/css/admin.css'])
    @fluxAppearance
</head>

<body class="min-h-dvh overflow-x-hidden bg-[#F5F0E8] px-4 py-8 text-[#3D2008]">
    <main class="mx-auto flex min-h-[calc(100dvh-4rem)] w-full max-w-md flex-col items-center justify-center">
        <section class="w-full rounded-[20px] border border-[#e8dfc8] bg-white px-5 py-8 shadow-[0_4px_32px_rgba(61,32,8,0.10)] sm:px-10">
            <div class="text-center text-[22px] font-extrabold tracking-normal text-[#3D2008]">
                <span class="text-[#B8952A]">Ghina</span> Tour Travel
            </div>

            <div class="mx-auto mt-6 flex justify-center">
                <img src="{{ asset('customer/assets/images/logos/logo.png') }}" class="h-24 w-24 max-w-full object-contain sm:h-[100px] sm:w-[100px]" alt="Logo">
            </div>

            <h1 class="mt-4 text-center text-lg font-bold text-[#3D2008]">@yield('card_title')</h1>
            @hasSection('card_subtitle')
                <p class="mx-auto mt-2 max-w-sm text-center text-sm leading-6 text-[#8a7050]">@yield('card_subtitle')</p>
            @endif

            @if ($errors->any())
                <div class="mt-5 rounded-[10px] border border-[#f5c6c6] bg-[#fff3f3] px-4 py-3 text-sm text-red-700">
                    <ul class="list-disc pl-4">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('error'))
                <div class="mt-5 rounded-[10px] border border-[#f5c6c6] bg-[#fff3f3] px-4 py-3 text-sm text-red-700">{{ session('error') }}</div>
            @endif

            @if (session('status'))
                <div class="mt-5 rounded-[10px] border border-[#bbf7d0] bg-[#f0fdf4] px-4 py-3 text-sm text-green-800">{{ session('status') }}</div>
            @endif

            <div class="mt-7">
                @yield('content')
            </div>
        </section>

        @yield('back_link')
    </main>

    @livewireScripts
    @fluxScripts
    @yield('scripts')
</body>

</html>
