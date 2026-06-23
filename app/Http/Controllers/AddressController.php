<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Models\Address;

class AddressController extends Controller {
    
    public function index() {
        if (!Auth::check()) {
            return redirect('/login');
        }

        /** @var \App\Models\User $user */
        $user = Auth::user();

        $address = Address::where('user_id', $user -> id)
            ->orderBy('id', 'desc')
            ->get();
        
        return view('addresses', ['addresses' => $address]);
    }

    public function create() {
        if (!Auth::check()) {
            return redirect('/login');
        }
        return view('address_form', ['address' => null]);
    }

    public function edit($id) {
        if (!Auth::check()) {
            return redirect('/login');
        }

        $address = $this -> findOwnedAddress($id);

        return view('address_form', ['address' => $address]);
    }

    public function store(Request $request) {
        if (!Auth::check()) {
            return redirect('/login');
        }
        
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $validated = $this -> validateAddress($request);
        $validated['user_id'] = $user -> id;

        Address::create($validated);

        return redirect('/account/addresses') -> with('status', '住所を追加しました。');
    }

    public function update(Request $request, $id) {
        if (!Auth::check()) {
            return redirect('/login');
        }
        $address = $this -> findOwnedAddress($id);
        $validated = $this -> validateAddress($request);
        $address -> update($validated);

        return redirect('/account/addresses') -> with('status', '住所を変更しました。');
    }

    public function destroy($id) {
        if (!Auth::check()) {
            return redirect('/login');
        }

        $address = $this -> findOwnedAddress($id);
        $address -> delete();

        return redirect('/account/addresses') -> with('status', '住所を削除しました。');
    }

    // 郵便番号->住所
    public function lookupZip(Request $request) {
        $zip = preg_replace('/\D/', '', $request -> query('zip', ''));

        if (strlen($zip) !== 7) {
            return response() -> json(['ok' => false, 'message' => '郵便番号は7桁で入力してください。']);
        }

        $res = Http::get('https://zipcloud.ibsnet.co.jp/api/search', ['zipcode' => $zip]);
        $data = $res -> json();

        if (($data['status'] ?? null) !== 200 || empty($data['results'])) {
            return response() -> json(['ok' => false, 'message' => '住所が見つかりませんでした。']);
        }

        $r = $data['results'][0];
        return response() -> json([
            'ok' => true,
            'prefecture' => $r['address1'],
            'city' => $r['address2'],
            'town' => $r['address3'],
        ]);
    }

    // --- 本人の住所だけ取得。他人のIDなら404で弾く
    private function findOwnedAddress($id) {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        return Address::where('id', $id)
            -> where('user_id', $user -> id)
            ->firstOrFail();
    }

    private function validateAddress(Request $request): array {
        $validated = $request -> validate([
            'postal_code' => 'required|max:8',
            'prefecture' => 'required|max:10',
            'city' => 'required|max:50',
            'street' => 'required|max:100',
            'building' => 'nullable|max:100',
            'phone_number' => 'required|max:20',
        ], [
            'postal_code.required' => '郵便番号を入力してください。',
            'prefecture.required' => '都道府県を入力してください。',
            'city.required' => '市区町村を入力してください。',
            'street.required' => '番地を入力してください。',
            'phone_number.required' => '電話番号を入力してください。',
        ]);

        // 分割された項目を一本に繋ぐ
        $address = $validated['prefecture'] . $validated['city'] . $validated['street'];
        if (!empty($validated['building'])) {
            $address .= ' ' . $validated['building'];
        }

        // DBに保存
        return [
            'postal_code' => $validated['postal_code'],
            'address' => $address,
            'phone_number' => $validated['phone_number'],
        ];
    }
}