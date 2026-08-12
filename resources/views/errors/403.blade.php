<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Akses Ditolak - 403</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: #f8fafc; color: #1e293b; display: flex; align-items: center; justify-content: center; height: 100vh; margin: 0; text-align: center; }
        .container { max-width: 500px; padding: 2rem; background: white; border-radius: 12px; box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1); }
        h1 { font-size: 4rem; margin: 0; color: #ef4444; }
        h2 { font-size: 1.5rem; margin-top: 0.5rem; }
        p { color: #64748b; line-height: 1.6; margin-bottom: 2rem; }
        .btn { background: #2563eb; color: white; padding: 10px 20px; text-decoration: none; border-radius: 6px; font-weight: bold; }
    </style>
</head>
<body>
    <div class="container">
        <h1>403</h1>
        <h2>Akses Ditolak!</h2>
        <p>Anda tidak diizinkan mengakses halaman ini. Hubungi pembimbing jika ini merupakan kesalahan.</p>
        <a href="{{ route('admin.dashboard') }}" class="btn">Kembali ke Dashboard</a>
    </div>
</body>
</html>
