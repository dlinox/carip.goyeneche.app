<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\ResetPasswordEmail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;
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

    public function forgotPassword()
    {
        return Inertia::render('auth/forgot-password');
    }

    public function sendPasswordResetLink(Request $request)
    {
        $request->validate([
            "email" => ["required", "email"]
        ]);

        $user = User::where("email", $request->email)->first();

        if ($user) {
            $token = Crypt::encryptString($request->email);
            Mail::to($user->email)->send(new ResetPasswordEmail($user, $token));
        }

        return back()->with("success", "We have emailed your password reset link!");
    }

    //
    //Route::get('/reset-password/{token}',  [AuthController::class, 'resetPassword'])->middleware('guest')->name('password.reset');



    public function resetPassword(Request $request)
    {
        $token = $request->token;
        $email = Crypt::decryptString($token);
        $user = User::where("email", $email)->first();

        if ($user) {
            return Inertia::render('auth/reset-password', [
                "token" => $token,
                "email" => $email
            ]);
        }

        return Inertia::render('auth/login')->with("error", "Invalid password reset link!");
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            "password" => ["required"],
            "token" => ["required"],
        ]);

        $email = Crypt::decryptString($request->token);

        $user = User::where("email", $email)->first();

        if ($user) {
            $user->password = $request->password;
            $user->save();

            return redirect('/auth/login');
        }

        return back()->with("error", "Invalid password reset link!");
    }
}
