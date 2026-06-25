<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use App\Models\Faq;

class ContactController extends Controller
{
    public function send(Request $request)
    {
        // バリデーション
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'message' => 'required'
        ]);

        // FAQ全取得
        $faqs = Faq::all();

        // キーワード一致探す
        $faq = $faqs->first(function ($faq) use ($request) {
            return str_contains($request->message, $faq->keyword);
        });

        // ランダムFAQ取得（null対策あり）
        $randomFaq = Faq::whereNotBetween('id', [8, 11])
            ->inRandomOrder()
            ->first();

        // ✅ 安全な回答生成（ここが重要）
        $faqAnswer = $faq->answer 
            ?? $randomFaq->answer 
            ?? '現在回答を用意できていません。';

        // 保存
        Contact::create([
            'name' => $request->name,
            'email' => $request->email,
            'message' => $request->message,
            'answer' => $faqAnswer
        ]);

        // リダイレクト
        return redirect('/contact')
            ->with('success', 'お問い合わせを送信しました。')
            ->with('faqAnswer', $faqAnswer);
    }
}