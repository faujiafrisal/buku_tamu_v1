<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class AdminAuthController extends Controller
{
    /**
     * Display the admin login view.
     */
    public function showLogin()
    {
        if (session('admin_authenticated') === true) {
            return redirect()->route('guestbook.admin');
        }

        return view('auth.admin-login');
    }

    /**
     * Handle an incoming admin authentication request with rate limiting.
     */
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ], [
            'username.required' => 'Username wajib diisi.',
            'password.required' => 'Password wajib diisi.',
        ]);

        $throttleKey = 'admin-login:' . Str::lower($request->input('username')) . '|' . $request->ip();

        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            return back()
                ->withInput($request->only('username'))
                ->withErrors(['login' => "Terlalu banyak percobaan login gagal. Silakan coba lagi dalam {$seconds} detik."]);
        }

        $configUsername = config('admin.username', 'admin');
        $configHash = config('admin.password_hash');

        if ($request->input('username') === $configUsername && $configHash && Hash::check($request->input('password'), $configHash)) {
            RateLimiter::clear($throttleKey);

            session()->regenerate();
            session([
                'admin_authenticated' => true,
                'admin_username' => $request->input('username'),
            ]);

            return redirect()->intended(route('guestbook.admin'));
        }

        RateLimiter::hit($throttleKey, 60);

        return back()
            ->withInput($request->only('username'))
            ->withErrors(['login' => 'Username atau password tidak valid.']);
    }

    /**
     * Log the admin user out of the application.
     */
    public function logout(Request $request)
    {
        session()->forget(['admin_authenticated', 'admin_username']);
        session()->invalidate();
        session()->regenerateToken();

        return redirect()->route('admin.login')->with('success', 'Anda telah berhasil logout.');
    }
}
