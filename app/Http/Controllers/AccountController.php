<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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

        /** @var \App\Models\User $user */
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

        return redirect('/mypage') -> with('status', '更新しました。');
    }

    public function security() {
        if (!Auth::check()) {
            return redirect('/login');
        }

        return view('security');
    }

    public function editPassword() {
        if (!Auth::check()) {
            return redirect('/login');
        }
        return view('password_edit');
    }

    public function updatePassword(Request $request) {
        if (!Auth::check()) {
            return redirect('/login');
        }
        
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $validated = $request -> validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed|different:current_password',
        ], [
            'current_password.required' =>'現在のパスワードを入力してください。',
            'new_password.required' => '新しいパスワードを入力してください。',
            'new_password.min' => 'パスワードは8文字以上にしてください。',
            'new_password.confirmed' => '新しいパスワード(確認用)が一致しません。',
            'new_password.different' => '現在のパスワードと違うものを入力してください。',
        ]);

        // 現在のパスワードが正しいか照合(なりすまし防止)
        if (!Hash::check($validated['current_password'], $user -> password)){
            return back() -> withErrors(['current_password' => '現在のパスワードが正しくありません。']);
        }

        // 新しいパスワードを保存
        $user -> password = $validated['new_password'];
        $user -> save();

        return redirect('/account/security') -> with('status', 'パスワードを変更しました。');
    }
}