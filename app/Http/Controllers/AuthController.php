<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // =======================
    // ログイン画面
    // =======================
    public function showLogin()
    {
        return view('login');
    }

    // =======================
    // 登録画面
    // =======================
    public function showRegister()
    {
        return view('register');
    }

    // =======================
    // 確認画面
    // =======================
    public function confirmRegister(Request $request)
    {
        $validated = $request->validate([
            'user_name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
        ], [
            'user_name.required' => '名前を入力してください。',
            'email.required' => 'メールアドレスを入力してください。',
            'email.email' => 'メールアドレスの形式が正しくありません。',
            'email.unique' => 'このメールアドレスは既に使われています。',
            'password.required' => 'パスワードを入力してください。',
            'password.min' => 'パスワードは8文字以上で入力してください。',
        ]);

        // 確認画面へ（まだ保存しない）
        return view('Register_result', $validated);
    }

    // =======================
    // 登録処理（登録ボタン押したらここ）
    // =======================
    public function register(Request $request)
    {
        // 本来ここでDB保存（confirmでバリデ済み）

        User::create([
            'user_name' => $request->user_name,
            'email' => $request->email,
            'password' => bcrypt($request->password) // ←重要（ハッシュ化）
        ]);

        return redirect('/login');
    }

    // =======================
    // 登録戻る
    // =======================
    public function backRegister(Request $request)
    {
        return redirect('/register')->withInput();
    }

    // =======================
    // ログイン処理
    // =======================
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect('/');
        }

        return back()->withErrors([
            'email' => 'メールアドレスまたはパスワードが違います。',
        ])->onlyInput('email');
    }

    // =======================
    // ログアウト
    // =======================
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
