<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class AuthController extends Controller
{
    public function index()
    {
        return Inertia::render('auth/login');
    }

    public function signIn(Request $request)
    {
        $credentials = $request->validate([
            "email" => ["required", "email"],
            "password" => ["required"]
        ]);

        if (Auth::attempt($credentials)) {

            return redirect('/a');
        }

        return back()->withErrors([
            "email" => "The provided credentials do not match our records."
        ]);
    }

    public function signOut()
    {
        Auth::logout();

        return redirect('/');
    }
}
