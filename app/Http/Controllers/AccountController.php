<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller {

    public function index() {
        if (!Auth::check()){
            return redirect('/login');
        }

        return view('account');
    }


    public function edit() {

        if (!Auth::check()) {
            return redirect('/login');
        }   
        /** @var \App\Models\User $user */
                $user = Auth::user();
        
        return view('account_edit', ['user' => Auth::user()]);
    }

    public function update(Request $request) {
        if (!Auth::check()) {
            return redirect('/login');
        }

        $user = Auth::user();

        $validated = $request -> validate([
            'user_name' => 'required',
            // 自分自身のメールは重複チェックから除外する
            'email' => 'required|email|unique:users,email,' .$user -> id,
        ], [
            'user_name.required' => '名前を入力してください。',
            'email.required' => 'メールアドレスを入力してください',
            'email.email' => 'メールアドレスの形式が正しくありません',
            'email.unique' => 'このメールアドレスは既に使われています。',
        ]);

        $user -> user_name = $validated['user_name'];
        $user -> email = $validated['email'];
        $user -> save();

        return redirect('/account/edit') -> with('status', '更新しました。');
    }
}