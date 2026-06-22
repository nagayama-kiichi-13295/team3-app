<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

    // --- 本人の住所だけ取得。他人のIDなら404で弾く
    private function findOwnedAddress($id) {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        return Address::where('id', $id)
            -> where('user_id', $user -> id)
            ->firstOrFail();
    }

    private function validateAddress(Request $request): array {
        return $request -> validate([
            'postal_code' => 'required|max:8',
            'address' => 'required|max:255',
            'phone_number' => 'required|max:20',
        ], [
            'postal_code.required' => '郵便番号を入力してください。',
            'address.required' => '住所を入力してください。',
            'phone_number.required' => '電話番号を入力してください。',
        ]);
    }
}