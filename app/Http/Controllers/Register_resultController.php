
public function confirm(Request $request)
{
    return view('register.confirm', [
        'user_name' => $request->user_name,
        'email' => $request->email,
        'password' => $request->password
    ]);
}
public function complete(Request $request)
{
    // 本来ここでDB保存

    return redirect('/home');
}