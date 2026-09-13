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
        p { color: #64748b; line-height: 1.6; margin-bottom: 1.5rem; }
        .btn { display: inline-block; background: #2563eb; color: white; padding: 10px 20px; text-decoration: none; border-radius: 6px; font-weight: bold; margin: 0.25rem; }
        .btn-outline { display: inline-block; background: transparent; color: #64748b; padding: 10px 20px; text-decoration: none; border-radius: 6px; font-weight: bold; border: 1px solid #e2e8f0; margin: 0.25rem; cursor: pointer; font-family: inherit; font-size: 1rem; }
        .btn-outline:hover { background: #f1f5f9; }
    </style>
</head>
<body>
    <div class="container">
        <h1>403</h1>
        <h2>Akses Ditolak!</h2>
        <p>{{ $exception->getMessage() ?: 'Anda tidak diizinkan mengakses halaman ini. Hubungi Administrator jika ini merupakan kesalahan.' }}</p>
        <div>
            <a href="{{ route('login') }}" class="btn">Kembali ke Login</a>
            @auth
            <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                @csrf
                <button type="submit" class="btn-outline">Logout</button>
            </form>
            @endauth
        </div>
    </div>
</body>
</html>
