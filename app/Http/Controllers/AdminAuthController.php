<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AdminAuthController extends Controller
{
    public function showSignup()
    {
        return view('auth.admin-signup');
    }

    public function signup(Request $request)
    {
        $validated = $request->validate([
            'username' => [
                'required',
                'string',
                'min:3',
                'max:20',
                'regex:/^[a-zA-Z0-9_]+$/',
                'unique:admins,username',
            ],
            'email' => [
                'required',
                'email',
                'max:255',
                'unique:admins,email',
            ],
            'phone' => [
                'required',
                'regex:/^\d{11}$/',
                'unique:admins,phone',
            ],
            'nid' => [
                'required',
                'regex:/^\d{10}$/',
                'unique:admins,nid',
            ],
            'password' => [
                'required',
                'confirmed',
                Password::min(8)->mixedCase()->numbers()->symbols(),
            ],
        ], [
            'username.regex' => 'Username may only contain letters, numbers, and underscores.',
            'phone.regex' => 'Phone number must be 11 digits.',
            'nid.regex' => 'NID number must be 10 digits.',
            'password.confirmed' => 'Passwords do not match.',
        ]);

        $admin = Admin::create([
            'username' => $validated['username'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'nid' => $validated['nid'],
            'password' => Hash::make($validated['password']),
        ]);

        Auth::guard('admin')->login($admin);

        $request->session()->regenerate();

        return redirect()->route('admin.dashboard');
    }

    public function showLogin()
    {
        return view('auth.admin-login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'phone' => [
                'required',
                'regex:/^\d{11}$/',
            ],
            'password' => [
                'required',
                'string',
            ],
        ], [
            'phone.regex' => 'Phone number must be 11 digits.',
        ]);

        $remember = $request->boolean('rememberMe');

        if (Auth::guard('admin')->attempt($credentials, $remember)) {
            $request->session()->regenerate();

            return redirect()->intended(route('admin.dashboard'));
        }

        return back()
            ->withErrors([
                'phone' => 'Invalid admin phone number or password.',
            ])
            ->onlyInput('phone');
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}
