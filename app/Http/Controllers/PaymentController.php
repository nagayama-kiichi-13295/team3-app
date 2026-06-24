<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PaymentMethod;

class PaymentController extends Controller {
    public function index() {
        if (!Auth::check()) return redirect('/login');

        /** @var \App\Models\User $user */
        $user = Auth::user();

        $methods = PaymentMethod::where('user_id', $user->id)->orderBy('id', 'desc')->get();

        return view('payment', ['methods' => $methods]);
    }

    public function create() {
        if (!Auth::check()) return redirect('login');
        return view('payment_form');
    }

    public function store(Request $request) {
        if (!Auth::check()) return redirect('login');
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $request->validate([
            'type' => 'required|in:card,paypay',
        ],[
            'type.required' => 'お支払方法を選んでください。',
            'type.in' => 'お支払方法の選択が正しくありません。',
        ]);

        if ($request->input('type') === 'card') {
            $validated = $request -> validate([
                'card_brand' => 'required|in:VISA,Mastercard,JCB,AMEX,その他',
                'card_number' => 'required|regex:/^[0-9 -]{12,23}$/',
                'card_holder' => 'required|max:50',
                'exp_month' => 'required|integer|between:1,12',
                'exp_year' => 'required|integer|min:' . date('Y'),
            ], [
                'card_brand.required' => 'カードブランドを選んでください。',
                'card_number.required' => 'カード番号を入力してください。',
                'card_number.regex' => 'カード番号の形式が正しくありません。',
                'card_holder.required' => '名義を入力してください。',
                'exp_month.required' => '有効期限(月)を入力してください。',
                'exp_year.required' => '有効期限(年)を入力してください。',
                'exp_year.min' => '有効期限が過去になっています。',
            ]);
            
            // 下4桁だけ取り出す。
            $digits = preg_replace('/\D/', '', $request->input('card_number'));

            PaymentMethod::create([
                'user_id' => $user->id,
                'type' => 'card',
                'card_brand' => $validated['card_brand'],
                'card_holder' => $validated['card_holder'],
                'last4' => substr($digits, -4),
                'exp_month' => $validated['exp_month'],
                'exp_year' => $validated['exp_year'],
            ]);
        } else { // paypay
            $validated = $request->validate([
                'paypay_phone' => 'required|regex:/^[0-9-]{10,13}$/',
            ], [
                'paypay_phone.required' => 'PayPayに登録する電話番号を入力してください。',
                'paypay_phone/regex' => '電話番号の形式が正しくありません。',
            ]);

            PaymentMethod::create([
                'user_id' => $user->id,
                'type' => 'paypay',
                'paypay_phone' => $validated['paypay_phone'],
            ]);
        }

        return redirect('/account/payment')->with('status', 'お支払方法を追加しました。');
    }

    public function destroy($id) {
        if (!Auth::check()) return redirect('/login');

        $method = $this -> findOwned($id);
        $method -> delete();

        return redirect('/account/payment') -> with('status', 'お支払方法を削除しました。');
    }

    public function findOwned($id) {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        return PaymentMethod::where('id', $id)->where('user_id', $user->id)->firstOrFail();
    }
}