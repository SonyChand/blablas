<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Traits\LogsActivity;

class EmailVerificationPromptController extends Controller
{
    use LogsActivity;
    /**
     * Display the email verification prompt.
     */
    public function __invoke(Request $request): RedirectResponse|View
    {
        if ($request->user()->hasVerifiedEmail() && !$request->session()->has('email_verified_logged')) {
            $description = 'Pengguna ' . $request->user()->email . ' telah verifikasi alamat emailnya';
            $this->logActivity('email_verified', $request->user(), $request->user()->uuid, $description);
            $request->session()->put('email_verified_logged', true);
        }
        return $request->user()->hasVerifiedEmail()
            ? redirect()->intended(route('dashboard.index', absolute: false))->with('success', 'Alamat email sudah terverifikasi.')
            : view('auth.verify-email', [
                'title' => 'Verifikasi Email',
            ]);
    }
}
