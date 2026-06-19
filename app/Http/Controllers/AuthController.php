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

    public function confirmRegister(Request $request){
        $validated = $request -> validate([
            'user_name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
        ], [
            'user_name.required' =>'名前を入力してください。',
            'email.required' =>'メールアドレスを入力してください。',
            'email.email' =>'メールアドレスの形式が正しくありません。',
            'email.unique' =>'このメールアドレスは既に使われています。',
            'password.required' =>'パスワードを入力してください。',
            'password.min' =>'パスワードは8文字以上で入力してください。',            
        ]);
        return view('Register_result', $validated); // 保存せず確認画面へ
    }

    public function backRegister(Request $request) {
        // 送られてきた入力を old() に積んで、登録フォームに戻る
        return redirect('/register') -> withInput();
    }

    public function register(Request $request){
        $validated = $request -> validate([
            'user_name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',  // パス8文字以上じゃないとエラー
        ], [
            'user_name.required' =>'名前を入力してください。',
            'email.required' =>'メールアドレスを入力してください。',
            'email.email' =>'メールアドレスの形式が正しくありません。',
            'email.unique' =>'このメールアドレスは既に使われています。',
            'password.required' =>'パスワードを入力してください。',
            'password.min' =>'パスワードは8文字以上で入力してください。',
        ]);

        User::create($validated); // ここ保存
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