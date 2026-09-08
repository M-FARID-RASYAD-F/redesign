<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): mixed
    {
        $request->authenticate();

        $request->session()->regenerate();

        $user = Auth::user();

        // Redirect otomatis sesuai role pengguna (PRD 3.4 & role.md)
        $targetUrl = $user ? $user->dashboard_url : route('admin.dashboard');

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Autentikasi berhasil! Selamat datang kembali, ' . ($user ? $user->name : '') . '.',
                'redirect' => $targetUrl,
            ]);
        }

        return redirect($targetUrl);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
