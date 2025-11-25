<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended('login');
        }
        return back()->withErrors([
            'error' => 'Your credentials are not valid based on our records, try again!',
        ])->onlyInput('email', 'password');
    }

    public function login(Request $request)
    {
        $user = Auth::user();
        return view('login', compact('user')); 
    }

    public function logout(Request $request): RedirectResponse 
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('login');
    }
}
