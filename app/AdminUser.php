<?php

namespace App;

use App\BaseModel;
use Illuminate\Foundation\Auth\User as Authenticatable;

class AdminUser extends Authenticatable
{
    protected $rememberTokenName = '';//如果不加这个，后台退出的时候报错
    protected $guarded=[];//不可以注入的字段
}
