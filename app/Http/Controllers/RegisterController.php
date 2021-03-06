<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class RegisterController extends Controller
{
    //注册页面
    public function index()
    {
        return view("register.index");
    }

    //注册行为
    public function register()
    {
        //验证
        $this->validate(request(), [
           'name'  => 'required|min:3|unique:users,name',//这里unique:user,name 这种写法的意思是：user表里的name字段需要唯一，也就是说user表中没有记录的name同名
           'email' => 'required|unique:users,email|email',
           'password' => 'required|min:5|max:10|confirmed',//这里的confirmed是在验证【确认密码】是否与输入的密码一致，这个要求参数名为：password_confirmation（看视图）
        ]);

        $name = request('name');
        $email = request('email');
        $password = bcrypt(request('password'));
        $user = User::create(compact('name', 'email', 'password'));

        return redirect('/login');
    }
}
