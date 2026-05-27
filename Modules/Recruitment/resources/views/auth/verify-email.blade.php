<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Email - Karir PT Fluxa Tritama Indonesia</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { background: #07111f; color: #cbd5e1; }
        .glass { background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.08); backdrop-filter: blur(12px); }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-5">
    <div class="glass p-8 rounded-2xl w-full max-w-md text-center">
        <h2 class="text-2xl font-bold text-white mb-2">Cek Email Anda</h2>
        <p class="text-sm text-slate-400 mb-6">Terima kasih telah mendaftar! Kami telah mengirimkan tautan verifikasi ke email Anda. Silakan cek kotak masuk (atau folder spam) dan klik tautan tersebut untuk mengaktifkan akun Anda.</p>
        
        @if (session('message'))
            <div class="bg-green-500/10 border border-green-500/20 text-green-400 p-3 rounded-lg text-sm mb-4">
                {{ session('message') }}
            </div>
        @endif

        <form action="{{ route('verification.send') }}" method="POST" class="mb-4">
            @csrf
            <button type="submit" class="w-full bg-white/5 border border-white/10 text-white font-bold py-2 rounded-lg hover:bg-white/10 transition">Kirim Ulang Email Verifikasi</button>
        </form>

        <form action="{{ route('career.logout') }}" method="POST">
            @csrf
            <button type="submit" class="text-sky-400 text-sm hover:underline">Logout dan kembali nanti</button>
        </form>
    </div>
</body>
</html>
