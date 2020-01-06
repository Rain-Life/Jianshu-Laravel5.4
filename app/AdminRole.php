<?php

namespace App;

use App\BaseModel;

class AdminRole extends BaseModel
{
    protected $table = "admin_roles";

    //当前角色的所有权限，角色和权限是多对多的关系
    public function permissions()
    {
        $this->belongsToMany(\App\AdminPermission::class, 'admin_permission_role', 'role_id', 'permission_id')
            ->withPivot(['permission_id', 'role_id']);
    }
    //给角色赋予权限
    public function grantPermission($permission)
    {
        $this->permissions()->save($permission);
    }
    //取消角色的某个权限
    public function deletePermission($permission)
    {
        $this->permissions()->detach($permission);
    }
    //判断角色是否有某个权限
    public function hasPermission($permission)
    {
        return $this->permissions->contains($permission);
    }
}
