<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class AuthController extends Controller
{
    // Login method
    public function login()
    {
        return view('auth.login', ['title' => 'Log in']);
    }

    // Authenticate method
    public function authenticate(Request $request)
    {
        $credentials = $request->only('name', 'password');
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect('/authors');
        }
        return back()->withErrors(['name' => 'Failed to authenticate']);
    }

    // Logout method (GET method)
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/'); // Redirect to the home page or wherever you prefer
    }
}
