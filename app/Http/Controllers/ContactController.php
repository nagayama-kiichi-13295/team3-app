<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use App\Models\Faq;

class ContactController extends Controller
{
    public function send(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'message' => 'required'
        ]);

        $faqs = Faq::all();

        $faq = $faqs->first(function ($faq) use ($request) {
            return str_contains($request->message, $faq->keyword);
        });

        $faqAnswer = $faq
            ? $faq->answer
            : Faq::whereNotBetween('id', [8, 11])
                ->inRandomOrder()
                ->first()
                ->answer;

        // ---------------------------
        // 保存
        // ---------------------------
        Contact::create([
            'name' => $request->name,
            'email' => $request->email,
            'message' => $request->message,
            'answer' => $faqAnswer
        ]);

        // ---------------------------
        // リダイレクト
        // ---------------------------
        return redirect('/contact')
            ->with('success', 'お問い合わせを送信しました。')
            ->with('faqAnswer', $faqAnswer);
    }
}