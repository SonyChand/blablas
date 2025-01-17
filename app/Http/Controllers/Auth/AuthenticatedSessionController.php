<?php

namespace App\Http\Controllers\Auth;

use Illuminate\View\View;
use App\Traits\LogsActivity;
use Illuminate\Http\Request;
use App\Mail\RegisterNotification;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Validation\ValidationException;

class AuthenticatedSessionController extends Controller
{
    use LogsActivity;
    /**
     * Display the login view.
     */

    public function create(): View
    {
        return view('auth.login', [
            'title' => 'Login',
        ]);
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $description = 'Pengguna ' . $request->user()->name . ' masuk sistem dari IP Address: ' . $request->ip();
        $this->logActivity('login', $request->user(), null, $description);


        return redirect()->intended(route('dashboard.indexSpm', absolute: false))->with('success', 'Login berhasil.');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $description = 'Pengguna ' . $request->user()->name . ' keluar sistem';
        $this->logActivity('logout', $request->user(), null, $description);
        Auth::guard('web')->logout();
        $request->session()->invalidate();

        $request->session()->regenerateToken();


        return redirect(route('login'))->with('success', 'Logout berhasil.');
    }
}
