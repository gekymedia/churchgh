<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

/**
 * Class AuthController
 *
 * Provides basic authentication functionality for the ChurchGH platform.
 * Users can log in using either their email or phone number and a
 * password. On successful authentication, users are redirected to the
 * appropriate dashboard based on their role. An optional registration
 * method is provided to allow creation of member accounts; admin users
 * should create member profiles first before inviting members to register.
 */
class AuthController extends Controller
{
    /**
     * Show the login form.
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle an authentication attempt.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'identifier' => 'required|string',
            'password'   => 'required|string',
        ]);

        $identifier = $credentials['identifier'];
        $password   = $credentials['password'];

        // Determine if identifier is an email or phone
        $field = filter_var($identifier, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';
        // Attempt authentication
        if (Auth::attempt([$field => $identifier, 'password' => $password])) {
            $request->session()->regenerate();
            $user = Auth::user();
            // Redirect based on role
            if ($user->role === 'member') {
                return redirect()->route('member.dashboard');
            }
            return redirect()->route('dashboard');
        }
        return back()->withErrors(['identifier' => 'Invalid credentials'])->onlyInput('identifier');
    }

    /**
     * Log the user out of the application.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}