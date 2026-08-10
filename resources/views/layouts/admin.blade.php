<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel - At-Tamam Edu')</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Custom CSS inside the layout to avoid affecting other pages and keep everything contained -->
    <style>
        :root {
            --primary: #4f46e5;
            --primary-hover: #4338ca;
            --secondary: #0f172a;
            --bg-body: #f8fafc;
            --bg-card: #ffffff;
            --text-main: #334155;
            --text-muted: #64748b;
            --border: #e2e8f0;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        body {
            background-color: var(--bg-body);
            color: var(--text-main);
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar Styling */
        .sidebar {
            width: 260px;
            background-color: var(--secondary);
            color: #ffffff;
            padding: 24px;
            display: flex;
            flex-direction: column;
            position: fixed;
            height: 100vh;
            left: 0;
            top: 0;
            z-index: 100;
        }

        .sidebar-brand {
            font-size: 1.25rem;
            font-weight: 800;
            letter-spacing: 0.5px;
            margin-bottom: 32px;
            display: flex;
            align-items: center;
            gap: 10px;
            color: #ffffff;
            text-decoration: none;
        }

        .sidebar-brand-icon {
            font-size: 1.5rem;
        }

        .sidebar-menu {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            color: #94a3b8;
            text-decoration: none;
            font-size: 0.95rem;
            font-weight: 500;
            border-radius: 8px;
            transition: all 0.2s ease-in-out;
        }

        .sidebar-link:hover, .sidebar-link.active {
            color: #ffffff;
            background-color: rgb(255 255 255 / 0.08);
        }

        .sidebar-link.active {
            background-color: var(--primary);
            color: #ffffff;
        }

        .sidebar-footer {
            margin-top: auto;
            border-top: 1px solid rgb(255 255 255 / 0.1);
            padding-top: 20px;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 16px;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            color: #ffffff;
        }

        .user-info {
            display: flex;
            flex-direction: column;
        }

        .user-name {
            font-size: 0.85rem;
            font-weight: 600;
            color: #ffffff;
        }

        .user-role {
            font-size: 0.75rem;
            color: #94a3b8;
        }

        /* Main Content Styling */
        .main-container {
            margin-left: 260px;
            flex: 1;
            padding: 40px;
            width: calc(100% - 260px);
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 32px;
        }

        .header-title {
            font-size: 1.75rem;
            font-weight: 700;
            color: #0f172a;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            border-radius: 8px;
            font-size: 0.9rem;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            border: none;
            transition: all 0.2s;
        }

        .btn-primary {
            background-color: var(--primary);
            color: #ffffff;
        }

        .btn-primary:hover {
            background-color: var(--primary-hover);
        }

        .btn-outline {
            border: 1px solid var(--border);
            background-color: transparent;
            color: var(--text-main);
        }

        .btn-outline:hover {
            background-color: #f1f5f9;
        }

        .btn-danger {
            background-color: var(--danger);
            color: #ffffff;
        }

        .btn-danger:hover {
            background-color: #dc2626;
        }

        .btn-sm {
            padding: 6px 12px;
            font-size: 0.8rem;
            border-radius: 6px;
        }

        /* Table Styling */
        .card {
            background: var(--bg-card);
            border-radius: 12px;
            border: 1px solid var(--border);
            box-shadow: var(--shadow);
            padding: 24px;
            margin-bottom: 24px;
        }

        .table-responsive {
            width: 100%;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }

        th {
            padding: 16px;
            font-weight: 600;
            color: var(--text-muted);
            border-bottom: 1px solid var(--border);
            font-size: 0.85rem;
            text-transform: uppercase;
        }

        td {
            padding: 16px;
            border-bottom: 1px solid var(--border);
            color: var(--text-main);
            font-size: 0.9rem;
        }

        tr:last-child td {
            border-bottom: none;
        }

        /* Form Controls */
        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            font-size: 0.875rem;
            color: var(--text-main);
        }

        .form-control {
            width: 100%;
            padding: 10px 14px;
            border: 1px solid var(--border);
            border-radius: 8px;
            font-size: 0.9rem;
            color: var(--text-main);
            transition: border-color 0.2s;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary);
        }

        select.form-control {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%2364748b'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 14px center;
            background-size: 16px;
            padding-right: 40px;
        }

        /* Badges */
        .badge {
            display: inline-flex;
            padding: 4px 8px;
            border-radius: 6px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: capitalize;
        }

        .badge-success {
            background-color: #ecfdf5;
            color: var(--success);
        }

        .badge-warning {
            background-color: #fffbeb;
            color: var(--warning);
        }

        .badge-danger {
            background-color: #fef2f2;
            color: var(--danger);
        }

        .badge-info {
            background-color: #eff6ff;
            color: var(--primary);
        }

        .alert-success {
            background-color: #ecfdf5;
            color: var(--success);
            padding: 16px;
            border-radius: 8px;
            border: 1px solid #d1fae5;
            margin-bottom: 24px;
            font-weight: 500;
        }
    </style>
    @stack('styles')
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <a href="{{ route('home') }}" class="sidebar-brand">
            <span class="sidebar-brand-icon">🛡️</span>
            <span>At-Tamam Admin</span>
        </a>

        <ul class="sidebar-menu">
            <li>
                <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ Route::is('admin.dashboard') ? 'active' : '' }}">
                    <span>📊</span> Dashboard
                </a>
            </li>
            <li>
                <a href="{{ route('admin.news.index') }}" class="sidebar-link {{ Route::is('admin.news.*') ? 'active' : '' }}">
                    <span>📰</span> Berita (CMS)
                </a>
            </li>
            <li>
                <a href="{{ route('admin.teachers.index') }}" class="sidebar-link {{ Route::is('admin.teachers.*') ? 'active' : '' }}">
                    <span>👨‍🏫</span> Guru & Staf
                </a>
            </li>
            <li>
                <a href="{{ route('admin.ppdb.index') }}" class="sidebar-link {{ Route::is('admin.ppdb.*') ? 'active' : '' }}">
                    <span>📝</span> PPDB Online
                </a>
            </li>
            <li>
                <a href="{{ route('admin.majors.index') }}" class="sidebar-link {{ Route::is('admin.majors.*') ? 'active' : '' }}">
                    <span>💻</span> Jurusan
                </a>
            </li>
        </ul>

        <div class="sidebar-footer">
            <div class="user-profile">
                <div class="user-avatar">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <div class="user-info">
                    <span class="user-name">{{ auth()->user()->name }}</span>
                    <span class="user-role">{{ ucfirst(str_replace('_', ' ', auth()->user()->role)) }}</span>
                </div>
            </div>
            <a href="{{ route('home') }}" class="sidebar-link" style="margin-bottom: 8px;">
                <span>🏠</span> Halaman Utama
            </a>
            <a href="{{ route('logout') }}" class="sidebar-link" style="color: #f87171;">
                <span>🚪</span> Logout
            </a>
        </div>
    </div>

    <!-- Main Content Container -->
    <div class="main-container">
        @if(session('success'))
            <div class="alert-success">
                ✨ {{ session('success') }}
            </div>
        @endif

        @yield('content')
    </div>

    @stack('scripts')
</body>
</html>
