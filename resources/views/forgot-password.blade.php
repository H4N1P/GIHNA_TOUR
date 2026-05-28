@extends('components.layout.auth')

@section('title', 'Lupa Password')
@section('card_title', 'Lupa Password')
@section('card_subtitle', 'Masukkan email Anda dan kami akan mengirimkan link untuk mereset password.')

@section('content')
    <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
        @csrf

        <div>
            <label for="email" class="mb-2 block text-[11px] font-bold uppercase tracking-[1px] text-[#8a7050]">Email</label>
            <div class="flex min-h-[50px] items-center gap-3 rounded-full border-[1.5px] {{ $errors->has('email') ? 'border-red-600' : 'border-[#e8dfc8]' }} bg-[#FBF5E6] px-4 focus-within:border-[#B8952A]">
                <svg class="h-[18px] w-[18px] shrink-0 stroke-[#B8952A]" viewBox="0 0 24 24" fill="none" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                    <circle cx="12" cy="7" r="4" />
                </svg>
                <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="Masukkan Email" autocomplete="email" autofocus class="min-w-0 flex-1 bg-transparent text-sm text-[#3D2008] outline-none placeholder:text-[#c4a97a]">
            </div>
            @error('email')
                <p class="mt-1 pl-4 text-xs text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <flux:button type="submit" class="mt-5 h-[52px] w-full rounded-full bg-[#B8952A]! text-sm font-bold tracking-[1.5px] text-white! hover:bg-[#8a6e1a]!">
            KIRIM LINK RESET
        </flux:button>

        <div class="h-px bg-[#e8dfc8]"></div>
    </form>
@endsection

@section('back_link')
    <a href="{{ route('login') }}" class="mt-5 inline-flex min-h-11 items-center justify-center gap-2 text-sm text-[#8a7050] hover:text-[#3D2008]">
        <svg class="h-4 w-4 stroke-current" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <line x1="19" y1="12" x2="5" y2="12" />
            <polyline points="12 19 5 12 12 5" />
        </svg>
        Kembali ke Login
    </a>
@endsection
