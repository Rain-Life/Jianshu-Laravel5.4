<?php

namespace App\Admin\Controllers;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    //登录展示页
    public function index()
    {
        return view('admin.login.index');
    }

    //登录操作
    public function login()
    {
        //验证
        $this->validate(request(), [
            'name' => 'required|min:2',
            'password' => 'required|min:5|max:10',
        ]);

        $user = request(['name', 'password']);
        if(Auth::guard("admin")->attempt($user)) {
            return redirect('admin/home');
        }

        return redirect('admin/login')->withErrors("用户名密码错误");
    }

    //退出
    public function logout()
    {
        Auth::guard("admin")->logout();
        return redirect("/admin/login");
    }
}