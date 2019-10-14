<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', [
            'except' => ['create', 'store']
        ]);

        $this->middleware('guest', [
            'only' => ['create']
        ]);
    }

    // 注册页
    public function create() {
        return view('users.create');
    }

    // 个人详情页
    public function show(User $user) {
        $this->authorize('update', $user);
        return view('users.show', compact('user'));
    }

    // 注册
    public function store(Request $request) {
        $this->validate($request, [
           'name' => 'required|max:50',
           'email' => 'required|email|unique:users|max:255',
           'password' => 'required|confirmed|min:6',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        \Auth::login($user);
        session() -> flash('success', '欢迎你，我的朋友 ');
        return redirect() -> route('users.show', [$user]);
    }

    // 更新页
    public function edit(User $user) {
        $this->authorize('update', $user);
        return view('users.edit', compact('user'));
    }

    // 更新用户信息
    public function update(User $user, Request $request) {
        $this->authorize('update', $user);
        $this->validate($request, [
            'name' => 'required|max:50',
            'password' => 'nullable|confirmed|min:6|max:50',
        ]);

        $data = [];
        $data['name'] = $request->name;
        if($request->password) {
            $data['password'] = bcrypt($request->password);
        }

        $user->update($data);

        session()->flash('success', '个人资料更新成功');

        return redirect()->route('users.show', $user);
    }
}
