<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    // ==========================================
    // Show Login / Sign Up Page
    // ==========================================
    public function showLogin()
    {
        return view('auth.login');
    }

    // ==========================================
    // Handle Login
    // ==========================================
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            Auth::login($user);
            $request->session()->regenerate();

            // Requirement 7: Store session data on login
            session([
                'username'   => $user->username,
                'last_login' => now()->toDateTimeString(),
            ]);

            return redirect()->route('home')->with('success', 'Welcome back, ' . $user->username . '!');
        }

        return back()->withErrors([
            'login' => 'Invalid email or password.',
        ])->onlyInput('email');
    }

    // ==========================================
    // Handle Sign Up
    // ==========================================
    public function signup(Request $request)
    {
        $request->validate([
            'username'    => 'required|string|max:10|unique:users,username',
            'countryCode' => 'required|string',
            'phoneNumber' => 'required|string|min:8|max:12|regex:/^\d+$/',
            'email'       => 'required|email|unique:users,email',
            'password'    => 'required|min:8|max:20|confirmed',
        ], [
            'username.unique'      => 'This username is already taken.',
            'email.unique'         => 'This email is already registered.',
            'password.confirmed'   => 'Passwords do not match.',
            'phoneNumber.regex'    => 'Phone number must contain digits only.',
            'phoneNumber.min'      => 'Phone number must be 8-12 digits.',
            'phoneNumber.max'      => 'Phone number must be 8-12 digits.',
        ]);

        $user = User::create([
            'username'    => $request->username,
            'countryCode' => $request->countryCode,
            'phoneNumber' => $request->phoneNumber,
            'email'       => $request->email,
            'password'    => Hash::make($request->password),
        ]);

        Auth::login($user);

        session([
            'username'   => $user->username,
            'last_login' => now()->toDateTimeString(),
        ]);

        return redirect()->route('home')->with('success', 'Account created successfully! Welcome, ' . $user->username . '!');
    }

    // ==========================================
    // Handle Logout
    // ==========================================
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }

    // ==========================================
    // Show Forgot Password Page
    // ==========================================
    public function showPasswordReset()
    {
        return view('auth.password');
    }

    // ==========================================
    // Check Email Exists (AJAX)
    // ==========================================
    public function checkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $exists = User::where('email', $request->email)->exists();

        if ($exists) {
            return response()->json(['status' => 'success', 'message' => 'Email verified']);
        }
        return response()->json(['status' => 'error', 'message' => 'Email not found in our records.']);
    }

    // ==========================================
    // Reset Password (AJAX)
    // ==========================================
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email'       => 'required|email|exists:users,email',
            'newPassword' => 'required|min:8|max:20',
        ], [
            'email.exists'    => 'Email not found.',
            'newPassword.min' => 'Password must be at least 8 characters.',
            'newPassword.max' => 'Password cannot exceed 20 characters.',
        ]);

        $updated = User::where('email', $request->email)
            ->update(['password' => Hash::make($request->newPassword)]);

        if ($updated) {
            return response()->json(['status' => 'success']);
        }
        return response()->json(['status' => 'error', 'message' => 'Failed to reset password. Please try again.']);
    }
}