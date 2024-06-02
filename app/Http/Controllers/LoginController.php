<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
   public function index(){
        return view('auth.login');
   }

   public function authenticate(Request $request): RedirectResponse
   {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
 
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
 
            return redirect()->intended('dashboard');
        }
 
        return back()->withErrors([
            'email' => 'email ou senha incoretos',
        ])->onlyInput('email');
   }

   public function logout()
   {
        Auth::logout();

        return redirect(route('login'));
   }
}
