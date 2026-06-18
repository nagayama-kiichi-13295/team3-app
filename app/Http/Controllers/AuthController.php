<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller{
    public function showLogin(){
        return view('login');
    }

    public function showRegister(){
        return view('register');
    }

    public function register(Request $request){
        $validated = $request -> validate([
            'user_name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
        ]);

        User::create($validated);

        return redirect('login');

    }

    public function login(Request $request){
        $credentials = $request -> validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)){
            $request -> session() -> regenerate();
            return redirect('/');
        }

        return back() -> withErrors([
            'email' => 'メールアドレスまたはパスワードが違います。',
        ]) -> onlyInput('email');
    }
    public function logout(Request $request){
        Auth::logout();
        $request -> session() -> invalidate();
        $request -> session() -> regenerateToken();
        return redirect('/');
    }
}