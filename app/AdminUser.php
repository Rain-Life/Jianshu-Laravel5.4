<?php

namespace App;

use App\BaseModel;
use Illuminate\Foundation\Auth\User as Authenticatable;

class AdminUser extends Authenticatable
{
    protected $rememberTokenName = '';//如果不加这个，后台退出的时候报错
    protected $guarded=[];//不可以注入的字段

    //用户有哪些角色，多对多的关系
    public function roles()
    {
        $this->belongsToMany(\App\AdminRole::class, 'admin_role_user', 'user_id', 'role_id')
            ->withPivot(['user_id', 'role_id']);
    }

    //判断某个用户是否具有某个角色或某些角色
    public function isInRoles($roles)
    {
        return !!$roles->intersect($this->roles)->count();//intersect()取交集，!!返回bool值
    }

    //给用户分配角色
    public function assignRole($role)
    {
        $this->roles()->save($role);
    }

    //取消用户角色
    public function deleteRole($role)
    {
        return $this->roles()->detach($role);
    }
    
    //用户是否有权限
    public function hasPermission($permission)
    {
        return $this->isInRoles($permission->roles);
    }
}
