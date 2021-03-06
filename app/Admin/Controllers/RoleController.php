<?php

namespace App\Admin\Controllers;

class RoleController extends Controller
{
    //角色列表
    public function index()
    {
        $roles = \App\AdminRole::paginate(10);
        return view("/admin/role/index", compact('roles'));
    }
    //创建角色
    public function create()
    {
        return view("/admin/role/add");
    }
    //创建角色行为
    public function store()
    {
        $this->validate(request(), [
            'name' => 'required|min:3',
            'description' => 'required'
        ]);

        \App\AdminRole::create(request(['name', 'description']));

        return redirect('/admin/roles');
    }
    //角色权限关系页面
    public function permission(\App\AdminRole $role)
    {
        //获取所有权限
        $permissions = \App\AdminPermission::all();
        //获取当前角色权限
        $myPermissions = $role->permissions();//我在数据库里边插入了相应的数据，但是还是获取不到，应该就是这个地方的问题

        return view("/admin/role/permission", compact('permissions', 'myPermissions', 'role'));
    }

    //储存角色权限行为
    //todo  这块有些问题，到时候重新看一遍吧
    public function storePermission(\App\AdminRole $role)
    {
        $this->validate(request(),[
            'permissions' => 'required|array'
        ]);

        $permissions = \App\AdminPermission::find(request('permissions'));
        $myPermissions = $role->permissions();

        // 对已经有的权限
        $addPermissions = $permissions->diff($myPermissions);

        foreach ($addPermissions as $permission) {
            $role->grantPermission($permission);
        }

        $deletePermissions = $myPermissions->diff($permissions);
        foreach ($deletePermissions as $permission) {
            $role->deletePermission($permission);
        }

        return back();
    }
}