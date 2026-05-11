<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password – Ghina Tour Travel</title>
    @vite(['resources/css/admin.css'])
    <style>
        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #F5F0E8;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
        }

        .card {
            background: #ffffff;
            border-radius: 20px;
            padding: 2.5rem 2.5rem 2rem;
            width: 100%;
            max-width: 440px;
            box-shadow: 0 4px 32px rgba(61, 32, 8, 0.10);
            border: 1px solid #e8dfc8;
        }

        .brand {
            text-align: center;
            font-size: 22px;
            font-weight: 800;
            color: #3D2008;
            margin-bottom: 1.5rem;
            letter-spacing: -0.5px;
        }

        .brand span {
            color: #B8952A;
        }

        .icon-wrap {
            width: 64px;
            height: 64px;
            background: #FBF5E6;
            border-radius: 50%;
            border: 2px solid #D4AA3A;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
        }

        .card-title {
            text-align: center;
            font-size: 18px;
            font-weight: 700;
            color: #3D2008;
            margin-bottom: 0.5rem;
        }

        .card-subtitle {
            text-align: center;
            font-size: 14px;
            color: #8a7050;
            margin-bottom: 1.75rem;
            line-height: 1.5;
        }

        /* Alert */
        .alert-success {
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            border-radius: 10px;
            padding: 0.75rem 1rem;
            margin-bottom: 1.25rem;
            font-size: 13px;
            color: #166534;
        }

        .alert-error {
            background: #fff3f3;
            border: 1px solid #f5c6c6;
            border-radius: 10px;
            padding: 0.75rem 1rem;
            margin-bottom: 1.25rem;
            font-size: 13px;
            color: #b91c1c;
        }

        .alert-error ul {
            padding-left: 1rem;
        }

        /* Field */
        .field {
            margin-bottom: 1.1rem;
        }

        .label-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 6px;
        }

        label {
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 1px;
            color: #8a7050;
            text-transform: uppercase;
        }

        .input-wrap {
            display: flex;
            align-items: center;
            background: #FBF5E6;
            border: 1.5px solid #e8dfc8;
            border-radius: 50px;
            padding: 0 16px;
            height: 50px;
            gap: 10px;
            transition: border-color 0.2s;
        }

        .input-wrap:focus-within {
            border-color: #B8952A;
        }

        .input-wrap.is-invalid {
            border-color: #dc2626;
        }

        .input-wrap svg {
            width: 18px;
            height: 18px;
            flex-shrink: 0;
            stroke: #B8952A;
        }

        .input-wrap input {
            flex: 1;
            border: none;
            background: transparent;
            font-size: 14px;
            color: #3D2008;
            outline: none;
            font-family: inherit;
        }

        .input-wrap input::placeholder {
            color: #c4a97a;
        }

        .field-error {
            font-size: 12px;
            color: #dc2626;
            margin-top: 5px;
            padding-left: 14px;
        }

        /* Submit */
        .btn-submit {
            width: 100%;
            height: 52px;
            border: none;
            border-radius: 50px;
            background: #B8952A;
            color: #ffffff;
            font-size: 14px;
            font-weight: 700;
            letter-spacing: 1.5px;
            cursor: pointer;
            margin-top: 1.25rem;
            transition: background 0.18s, transform 0.1s;
            font-family: inherit;
        }

        .btn-submit:hover {
            background: #8a6e1a;
        }

        .btn-submit:active {
            transform: scale(0.98);
            background: #6b5413;
        }

        .btn-submit:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        .divider {
            height: 1px;
            background: #e8dfc8;
            margin: 1.5rem 0 0;
        }

        /* Back link */
        .back-link {
            margin-top: 1.4rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            font-size: 13px;
            color: #8a7050;
            text-decoration: none;
            transition: color 0.15s;
        }

        .back-link:hover {
            color: #3D2008;
        }

        .back-link svg {
            width: 14px;
            height: 14px;
            stroke: currentColor;
        }
    </style>
</head>

<body>

    <div class="card">

        {{-- Brand --}}
        <div class="brand"><span>Ghina</span> Tour Travel</div>

        {{-- Logo icon --}}
        <div class="icon-wrap">
            {{-- <img src="{{ asset('customer/assets/images/logos/logo.png') }}" class="w-8 h-8 object-contain" alt="Logo"> --}}
        </div>

        <div class="card-title">Reset Password</div>
        <div class="card-subtitle">
            Masukkan password baru Anda di bawah ini.
        </div>

        {{-- Validation errors --}}
        @if ($errors->any())
            <div class="alert-error">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('password.update') }}">
            @csrf

            <input type="hidden" name="token" value="{{ $token }}">

            {{-- Email --}}
            <div class="field">
                <label for="email">EMAIL</label>
                <div class="input-wrap {{ $errors->has('email') ? 'is-invalid' : '' }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke-width="1.8" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                        <circle cx="12" cy="7" r="4" />
                    </svg>
                    <input type="email" id="email" name="email" value="{{ old('email', $email ?? '') }}"
                        placeholder="Masukkan Email" autocomplete="email" required autofocus>
                </div>
                @error('email')
                    <div class="field-error">{{ $message }}</div>
                @enderror
            </div>

            {{-- Password --}}
            <div class="field">
                <label for="password">PASSWORD BARU</label>
                <div class="input-wrap {{ $errors->has('password') ? 'is-invalid' : '' }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke-width="1.8" stroke-linecap="round"
                        stroke-linejoin="round">
                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2" />
                        <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                    </svg>
                    <input type="password" id="password" name="password" placeholder="Password baru"
                        autocomplete="new-password" required>
                    <button type="button" class="btn-eye" onclick="togglePassword(this)" title="Tampilkan password">
                        <svg id="eye-icon-1" viewBox="0 0 24 24" fill="none" stroke-width="1.8" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                            <circle cx="12" cy="12" r="3" />
                        </svg>
                    </button>
                </div>
                @error('password')
                    <div class="field-error">{{ $message }}</div>
                @enderror
            </div>

            {{-- Confirm Password --}}
            <div class="field">
                <label for="password_confirmation">KONFIRMASI PASSWORD</label>
                <div class="input-wrap {{ $errors->has('password_confirmation') ? 'is-invalid' : '' }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke-width="1.8" stroke-linecap="round"
                        stroke-linejoin="round">
                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2" />
                        <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                    </svg>
                    <input type="password" id="password_confirmation" name="password_confirmation"
                        placeholder="Konfirmasi password baru" autocomplete="new-password" required>
                    <button type="button" class="btn-eye" onclick="togglePassword(this)" title="Tampilkan password">
                        <svg id="eye-icon-2" viewBox="0 0 24 24" fill="none" stroke-width="1.8" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                            <circle cx="12" cy="12" r="3" />
                        </svg>
                    </button>
                </div>
                @error('password_confirmation')
                    <div class="field-error">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn-submit">RESET PASSWORD</button>

            <div class="divider"></div>
        </form>

    </div>

    {{-- Back to login --}}
    <a href="{{ route('login') }}" class="back-link">
        <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <line x1="19" y1="12" x2="5" y2="12" />
            <polyline points="12 19 5 12 12 5" />
        </svg>
        Kembali ke Login
    </a>

    <script>
        function togglePassword(btn) {
            var input = btn.parentElement.querySelector('input');
            var icon = btn.querySelector('svg');
            var isHidden = input.type === 'password';
            input.type = isHidden ? 'text' : 'password';
            icon.innerHTML = isHidden ?
                '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"/><path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/><line x1="1" y1="1" x2="23" y2="23"/>' :
                '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>';
        }
    </script>

</body>

</html>
