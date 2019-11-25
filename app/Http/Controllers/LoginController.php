<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    //登录页面
    public function index()
    {
        return view("login.index");
    }

    //登录行为
    public function login()
    {
        //验证
        $this->validate(request(), [
            'email' => 'required|email',
            'password' => 'required|min:5|max:10',
        ]);
        $userInfo = request(['email', 'password']);
        $isRemember = request('is_remember');

        if(true == \Auth::attempt($userInfo, $isRemember)) {
            return redirect('/posts');
        }

        return redirect('/login')->withErrors('用户名密码错误');
    }

    //登出行为
    public function logout()
    {

    }
}
