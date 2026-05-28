@extends('components.layout.auth')

@section('title', 'Reset Password')
@section('card_title', 'Reset Password')
@section('card_subtitle', 'Masukkan password baru Anda di bawah ini.')

@section('content')
    <form method="POST" action="{{ route('password.update') }}" class="space-y-5">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">

        <div>
            <label for="email" class="mb-2 block text-[11px] font-bold uppercase tracking-[1px] text-[#8a7050]">Email</label>
            <div class="flex min-h-[50px] items-center gap-3 rounded-full border-[1.5px] {{ $errors->has('email') ? 'border-red-600' : 'border-[#e8dfc8]' }} bg-[#FBF5E6] px-4 focus-within:border-[#B8952A]">
                <svg class="h-[18px] w-[18px] shrink-0 stroke-[#B8952A]" viewBox="0 0 24 24" fill="none" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                    <circle cx="12" cy="7" r="4" />
                </svg>
                <input type="email" id="email" name="email" value="{{ old('email', $email ?? '') }}" placeholder="Masukkan Email" autocomplete="email" required autofocus class="min-w-0 flex-1 bg-transparent text-sm text-[#3D2008] outline-none placeholder:text-[#c4a97a]">
            </div>
            @error('email')
                <p class="mt-1 pl-4 text-xs text-red-600">{{ $message }}</p>
            @enderror
        </div>

        @foreach ([
            ['id' => 'password', 'name' => 'password', 'label' => 'Password Baru', 'placeholder' => 'Password baru'],
            ['id' => 'password_confirmation', 'name' => 'password_confirmation', 'label' => 'Konfirmasi Password', 'placeholder' => 'Konfirmasi password baru'],
        ] as $field)
            <div>
                <label for="{{ $field['id'] }}" class="mb-2 block text-[11px] font-bold uppercase tracking-[1px] text-[#8a7050]">{{ $field['label'] }}</label>
                <div class="flex min-h-[50px] items-center gap-3 rounded-full border-[1.5px] {{ $errors->has($field['name']) ? 'border-red-600' : 'border-[#e8dfc8]' }} bg-[#FBF5E6] px-4 focus-within:border-[#B8952A]">
                    <svg class="h-[18px] w-[18px] shrink-0 stroke-[#B8952A]" viewBox="0 0 24 24" fill="none" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2" />
                        <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                    </svg>
                    <input type="password" id="{{ $field['id'] }}" name="{{ $field['name'] }}" placeholder="{{ $field['placeholder'] }}" autocomplete="new-password" required class="min-w-0 flex-1 bg-transparent text-sm text-[#3D2008] outline-none placeholder:text-[#c4a97a]">
                    <button type="button" class="flex min-h-11 min-w-11 items-center justify-center" onclick="togglePassword(this)" title="Tampilkan password">
                        <svg class="h-[18px] w-[18px] stroke-[#B8952A]" viewBox="0 0 24 24" fill="none" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                            <circle cx="12" cy="12" r="3" />
                        </svg>
                    </button>
                </div>
                @error($field['name'])
                    <p class="mt-1 pl-4 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>
        @endforeach

        <flux:button type="submit" class="mt-5 h-[52px] w-full rounded-full bg-[#B8952A]! text-sm font-bold tracking-[1.5px] text-white! hover:bg-[#8a6e1a]!">
            RESET PASSWORD
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

@section('scripts')
    <script>
        function togglePassword(btn) {
            const input = btn.parentElement.querySelector('input');
            const icon = btn.querySelector('svg');
            const isHidden = input.type === 'password';
            input.type = isHidden ? 'text' : 'password';
            icon.innerHTML = isHidden
                ? '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"/><path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/><line x1="1" y1="1" x2="23" y2="23"/>'
                : '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>';
        }
    </script>
@endsection
