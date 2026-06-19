<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends controller{
    public function showLogin(){
        return view('login');
    }

    public function showRegister(){
        return view('register');
    }

    public function register(Request $request){
        $validated = $request -> validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
        ]);

        User::create($validated);

        return redirect('login');

    }
}