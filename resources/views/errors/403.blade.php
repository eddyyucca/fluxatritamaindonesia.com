<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 - Akses Ditolak</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Inter', sans-serif;
            background-color: #f1f5f9;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .error-container {
            text-align: center;
            max-width: 500px;
            padding: 40px;
        }
        .error-code {
            font-size: 120px;
            font-weight: 800;
            color: #ef4444;
            line-height: 1;
            margin-bottom: 20px;
            text-shadow: 4px 4px 0px #fecaca;
        }
        .error-title {
            font-size: 24px;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 12px;
        }
        .error-desc {
            font-size: 15px;
            color: #64748b;
            margin-bottom: 30px;
            line-height: 1.6;
        }
        .btn-home {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 24px;
            background-color: #ef4444;
            color: #ffffff;
            text-decoration: none;
            border-radius: 99px;
            font-weight: 600;
            font-size: 14px;
            transition: background-color 0.2s, transform 0.2s;
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.2);
        }
        .btn-home:hover {
            background-color: #dc2626;
            transform: translateY(-2px);
        }
    </style>
</head>
<body>
    <div class="error-container">
        <div class="error-code">403</div>
        <div class="error-title">Akses Ditolak</div>
        <div class="error-desc">{{ $exception->getMessage() ?: 'Maaf, Anda tidak memiliki izin atau peran (role) yang sesuai untuk mengakses halaman ini.' }}</div>
        <a href="{{ url('/') }}" class="btn-home">
            <i class="fas fa-arrow-left"></i> Kembali ke Beranda
        </a>
    </div>
</body>
</html>
