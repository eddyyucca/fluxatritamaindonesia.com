<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — PT Fluxa Tritama Indonesia</title>
    <meta name="description" content="Login ke portal PT Fluxa Tritama Indonesia">
    <meta name="theme-color" content="#07111f">
    <link rel="icon" type="image/svg+xml" href="{{ asset('assets/images/favicon.ico') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}">
    <style>
        body {
            background: #07111f;
            min-height: 100vh;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
        }

        .input-field {
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.12);
            color: #e2e8f0;
            transition: border-color 0.2s, background 0.2s;
        }

        .input-field:focus {
            outline: none;
            border-color: #3b82f6;
            background: rgba(59, 130, 246, 0.08);
        }

        .input-field::placeholder {
            color: rgba(148, 163, 184, 0.5);
        }

        .btn-login {
            background: linear-gradient(135deg, #1d4ed8, #3b82f6);
            transition: opacity 0.2s, transform 0.1s;
        }

        .btn-login:hover {
            opacity: 0.9;
            transform: translateY(-1px);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .glow-ring {
            box-shadow: 0 0 40px rgba(59, 130, 246, 0.15);
        }

        .bg-grid {
            background-image:
                linear-gradient(rgba(59, 130, 246, 0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(59, 130, 246, 0.03) 1px, transparent 1px);
            background-size: 40px 40px;
        }

        .toggle-password {
            color: rgba(148, 163, 184, 0.6);
            cursor: pointer;
            transition: color 0.2s;
        }

        .toggle-password:hover {
            color: #94a3b8;
        }

        .error-shake {
            animation: shake 0.4s ease-in-out;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            20%       { transform: translateX(-6px); }
            60%       { transform: translateX(6px); }
            80%       { transform: translateX(-3px); }
        }

        .floating-orb {
            position: fixed;
            border-radius: 50%;
            filter: blur(80px);
            pointer-events: none;
        }
    </style>
</head>
<body class="bg-grid flex items-center justify-center min-h-screen px-4">

    {{-- Ambient orbs --}}
    <div class="floating-orb w-96 h-96 bg-blue-600 opacity-10 top-0 -left-20"></div>
    <div class="floating-orb w-80 h-80 bg-indigo-700 opacity-8 bottom-10 right-10"></div>

    <div class="w-full max-w-md">

        {{-- Logo & Brand --}}
        <div class="text-center mb-8">
            <a href="{{ route('home') }}" class="inline-block">
                <img src="{{ asset('assets/images/logo-white-transparent.png') }}"
                     alt="PT Fluxa Tritama Indonesia"
                     class="h-10 mx-auto mb-4 opacity-90">
            </a>
            <h1 class="text-2xl font-bold text-white tracking-tight">Selamat Datang</h1>
            <p class="text-slate-400 text-sm mt-1">Masuk ke portal PT Fluxa Tritama Indonesia</p>
        </div>

        {{-- Login Card --}}
        <div class="login-card glow-ring rounded-2xl p-8 {{ $errors->any() ? 'error-shake' : '' }}">

            {{-- Error alert --}}
            @if ($errors->any())
                <div class="mb-5 p-3 rounded-lg bg-red-500/10 border border-red-500/20 flex items-start gap-3">
                    <i class="fa-solid fa-circle-exclamation text-red-400 mt-0.5 flex-shrink-0"></i>
                    <div>
                        @foreach ($errors->all() as $error)
                            <p class="text-red-300 text-sm">{{ $error }}</p>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Session status (e.g. after password reset) --}}
            @if (session('status'))
                <div class="mb-5 p-3 rounded-lg bg-green-500/10 border border-green-500/20 flex items-center gap-3">
                    <i class="fa-solid fa-circle-check text-green-400 flex-shrink-0"></i>
                    <p class="text-green-300 text-sm">{{ session('status') }}</p>
                </div>
            @endif

            <form method="POST" action="{{ route('login.post') }}" novalidate>
                @csrf

                {{-- Email --}}
                <div class="mb-5">
                    <label for="email" class="block text-sm font-medium text-slate-300 mb-2">
                        <i class="fa-solid fa-envelope text-blue-400 mr-1.5"></i>Email
                    </label>
                    <input
                        id="email"
                        name="email"
                        type="email"
                        autocomplete="email"
                        value="{{ old('email') }}"
                        required
                        class="input-field w-full rounded-lg px-4 py-3 text-sm"
                        placeholder="nama@perusahaan.com"
                    >
                </div>

                {{-- Password --}}
                <div class="mb-6">
                    <div class="flex items-center justify-between mb-2">
                        <label for="password" class="text-sm font-medium text-slate-300">
                            <i class="fa-solid fa-lock text-blue-400 mr-1.5"></i>Password
                        </label>
                    </div>
                    <div class="relative">
                        <input
                            id="password"
                            name="password"
                            type="password"
                            autocomplete="current-password"
                            required
                            class="input-field w-full rounded-lg px-4 py-3 pr-11 text-sm"
                            placeholder="••••••••"
                        >
                        <button
                            type="button"
                            onclick="togglePassword()"
                            class="toggle-password absolute right-3 top-1/2 -translate-y-1/2"
                            aria-label="Tampilkan password"
                        >
                            <i id="eye-icon" class="fa-solid fa-eye text-base"></i>
                        </button>
                    </div>
                </div>

                {{-- Remember me --}}
                <div class="flex items-center gap-2 mb-6">
                    <input
                        id="remember"
                        name="remember"
                        type="checkbox"
                        class="w-4 h-4 rounded border-slate-600 bg-slate-800 text-blue-500 cursor-pointer"
                    >
                    <label for="remember" class="text-sm text-slate-400 cursor-pointer select-none">
                        Ingat saya di perangkat ini
                    </label>
                </div>

                {{-- Submit --}}
                <button type="submit" class="btn-login w-full py-3 rounded-lg text-white font-semibold text-sm tracking-wide">
                    <i class="fa-solid fa-arrow-right-to-bracket mr-2"></i>Masuk
                </button>
            </form>
        </div>

        {{-- Back to website --}}
        <div class="text-center mt-6">
            <a href="{{ route('home') }}" class="text-slate-500 hover:text-slate-300 text-sm transition-colors inline-flex items-center gap-1.5">
                <i class="fa-solid fa-arrow-left text-xs"></i>
                Kembali ke Website
            </a>
        </div>

        {{-- Footer --}}
        <p class="text-center text-slate-600 text-xs mt-8">
            &copy; {{ date('Y') }} PT Fluxa Tritama Indonesia. All rights reserved.
        </p>
    </div>

    <script>
        function togglePassword() {
            const input = document.getElementById('password');
            const icon  = document.getElementById('eye-icon');
            const isHidden = input.type === 'password';
            input.type = isHidden ? 'text' : 'password';
            icon.classList.toggle('fa-eye', !isHidden);
            icon.classList.toggle('fa-eye-slash', isHidden);
        }
    </script>
</body>
</html>
