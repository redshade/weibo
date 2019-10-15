<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class SessionController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest', [
            'only' => ['create']
        ]);
    }

    // 登录页
    public function create() {
        return view('sessions.create');
    }

    // 登录
    public function store(Request $request) {
        $credentials = $this->validate($request, [
            'email' => 'bail|required|email|max:255|exists:users',
            'password' => 'bail|required|min:6',
        ]);

        if (Auth::attempt($credentials, $request -> has('remember'))) {
            if(Auth::user()->activated) {
                session()->flash('success', '欢迎回来！');
                $fallback = route('users.show', [Auth::user()]);
                return redirect() -> intended($fallback);
            } else {
                Auth::logout();
                session()->flash('warning', '你的账号未激活，请检查邮箱中的注册邮件进行激活');
                return redirect('/');
            }
        } else {
            session() -> flash('danger', '很抱歉，您的账号和密码不匹配');
            return redirect() -> back() -> withInput();
        }
    }

    // 退出
    public function destroy() {
        Auth::logout();
        session() -> flash('success', '您已成功退出！');
        return redirect('login');
    }
}
