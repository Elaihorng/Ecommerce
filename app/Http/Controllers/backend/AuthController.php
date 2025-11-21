<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('frontend.users.login');
    }

    public function login(Request $request)
    {
        // validate user input
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // attempt to log the user in
        if (Auth::attempt($credentials)) {
            
            $request->session()->regenerate();
            return redirect()->intended('/') ->with('success', 'Logged in successfully');;
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }
}
