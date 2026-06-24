<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Contact;
class ContactController extends Controller
{
   public function send(Request $request)
   {
       $request->validate([
           'name' => 'required',
           'email' => 'required|email',
           'message' => 'required'
       ], [
           'name.required' => '名前を入力してください',
           'email.required' => 'メールアドレスを入力してください',
           'email.email' => 'メールアドレスの形式が正しくありません',
           'message.required' => 'お問い合わせ内容を入力してください'
       ]);
       Contact::create([
           'name' => $request->name,
           'email' => $request->email,
           'message' => $request->message
       ]);
       return redirect('/contact')
           ->with('success', 'お問い合わせを受け付けました。');
   }
}