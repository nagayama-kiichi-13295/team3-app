<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

class MypageController extends Controller
{
    public function show()
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        return view('mypage', ['user' => Auth::user()]);
    }
}
