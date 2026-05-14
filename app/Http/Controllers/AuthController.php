<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // ─── Registration ──────────────────────────────────────────────────────────

    /** Show the registration form. */
    public function showRegister()
    {
        return view('auth.register');
    }

    /**
     * Handle registration.
     * We hash the password with bcrypt before it ever touches the DB —
     * never store plain text passwords, ever.
     * Server-side validation runs first so we don't waste a DB call on bad input.
     */
    public function register(Request $request)
    {
        // Server-side validation
        $validated = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        // Hash the password — bcrypt, cost 12. Same as password_hash() but Laravel handles it.
        $user = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        // Log the user in right away and rotate the session ID — prevents session fixation
        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('dashboard')->with('success', 'Welcome to AynBook! Account created successfully.');
    }

    // ─── Login ─────────────────────────────────────────────────────────────────

    /** Show the login form. */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * Handle login.
     * Auth::attempt() calls password_verify() internally — we don't do that manually.
     * If creds are wrong, we return a vague error on purpose (don't hint which field failed).
     */
    public function login(Request $request)
    {
        // Server-side validation
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        // Rotate the session ID on login — classic session fixation prevention
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            // Regenerate session ID on login to prevent session fixation
            $request->session()->regenerate();
            return redirect()->intended(route('dashboard'));
        }

        // Generic error — deliberately vague so we don't leak whether the email exists
        return back()->withErrors([
            'email' => 'These credentials do not match our records.',
        ])->onlyInput('email');
    }

    // ─── Logout ────────────────────────────────────────────────────────────────

    /**
     * Log the user out cleanly.
     * Invalidate the session and regenerate the CSRF token so nothing
     * from the old session can be replayed.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        // Invalidate and regenerate CSRF token to prevent session reuse
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'You have been logged out.');
    }
}
