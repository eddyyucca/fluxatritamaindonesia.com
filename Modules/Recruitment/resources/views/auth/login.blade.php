<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Pelamar - Karir PT Fluxa Tritama Indonesia</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { background: #07111f; color: #cbd5e1; }
        .glass { background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.08); backdrop-filter: blur(12px); }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-5">
    <div class="glass p-8 rounded-2xl w-full max-w-md">
        <h2 class="text-2xl font-bold text-white mb-2">Login Pelamar</h2>
        <p class="text-sm text-slate-400 mb-6">Masuk untuk melihat status lamaran dan melengkapi profil Anda.</p>
        
        @if ($errors->any())
            <div class="bg-red-500/10 border border-red-500/20 text-red-400 p-3 rounded-lg text-sm mb-4">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('career.login') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required class="w-full bg-white/5 border border-white/10 rounded-lg px-4 py-2 text-white focus:outline-none focus:border-sky-400">
            </div>
            <div class="mb-6">
                <label class="block text-sm font-medium mb-1">Password</label>
                <input type="password" name="password" required class="w-full bg-white/5 border border-white/10 rounded-lg px-4 py-2 text-white focus:outline-none focus:border-sky-400">
            </div>
            <button type="submit" class="w-full bg-gradient-to-r from-teal-400 to-sky-400 text-slate-900 font-bold py-2 rounded-lg">Masuk</button>
        </form>
        <p class="mt-4 text-sm text-center">Belum punya akun? <a href="{{ route('career.register') }}" class="text-sky-400 hover:underline">Daftar sekarang</a></p>
        <p class="mt-2 text-sm text-center"><a href="/" class="text-slate-500 hover:text-slate-300">Kembali ke Beranda</a></p>
    </div>
</body>
</html>
