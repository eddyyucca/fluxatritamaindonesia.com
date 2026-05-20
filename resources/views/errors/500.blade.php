<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>500 - Terjadi Kesalahan</title>
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
            color: #f59e0b;
            line-height: 1;
            margin-bottom: 20px;
            text-shadow: 4px 4px 0px #fde68a;
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
            background-color: #f59e0b;
            color: #ffffff;
            text-decoration: none;
            border-radius: 99px;
            font-weight: 600;
            font-size: 14px;
            transition: background-color 0.2s, transform 0.2s;
            box-shadow: 0 4px 12px rgba(245, 158, 11, 0.2);
        }
        .btn-home:hover {
            background-color: #d97706;
            transform: translateY(-2px);
        }
    </style>
</head>
<body>
    <div class="error-container">
        <div class="error-code">500</div>
        <div class="error-title">Terjadi Kesalahan Server</div>
        <div class="error-desc">Maaf, sistem sedang mengalami masalah teknis saat memproses permintaan Anda. Tim kami telah diberitahu.</div>
        <a href="{{ url('/') }}" class="btn-home">
            <i class="fas fa-arrow-left"></i> Kembali ke Beranda
        </a>
    </div>
</body>
</html>
