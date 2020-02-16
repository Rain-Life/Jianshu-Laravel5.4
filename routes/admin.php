<?php
//后台
Route::group(['prefix' => 'admin'], function () {
    //登录页
    Route::get('/login', '\App\Admin\Controllers\LoginController@index');
    //登录行为
    Route::post('/login', '\App\Admin\Controllers\LoginController@login');
    //退出
    Route::get('/logout', '\App\Admin\Controllers\LoginController@logout');

    Route::group(['middleware' => 'auth:admin'], function () {
        //后台首页
        Route::get('/home', '\App\Admin\Controllers\homeController@index');

        //Route::group(['middleware' => 'can:system'], function () {//打开权限之前，先打开Providers里边的AuthServiceProvider
            //人员管理模块
            Route::get('/users', '\App\Admin\Controllers\UserController@index');
            Route::get('/users/create', '\App\Admin\Controllers\UserController@create');
            Route::post('/users/store', '\App\Admin\Controllers\UserController@store');
            Route::get('/users/{user}/role', '\App\Admin\Controllers\UserController@role');//查看用户拥有的角色页
            Route::post('/users/{user}/role', '\App\Admin\Controllers\UserController@storeRole');

            //角色
            Route::get('/roles', '\App\Admin\Controllers\RoleController@index');//角色列表
            Route::get('/roles/create', '\App\Admin\Controllers\RoleController@create');//创建角色页
            Route::post('/roles/store', '\App\Admin\Controllers\RoleController@store');//创建行为
            Route::get('/roles/{role}/permission', '\App\Admin\Controllers\RoleController@permission');//查看用户拥有的角色页
            Route::post('/roles/{role}/permission', '\App\Admin\Controllers\RoleController@storePermission');

            //权限
            Route::get('/permissions', '\App\Admin\Controllers\PermissionController@index');//权限列表
            Route::get('/permissions/create', '\App\Admin\Controllers\PermissionController@create');//创建权限页
            Route::post('/permissions/store', '\App\Admin\Controllers\PermissionController@store');//创建行为
        //});

        //Route::group(['middleware' => 'can:post'], function () {
            //审核模块
            Route::get('/posts', '\App\Admin\Controllers\PostController@index');
            Route::post('/posts/{post}/status', '\App\Admin\Controllers\PostController@status');
        //});

        //专题模块
        //Route::group(['middleware' => 'can:topic'], function () {
            Route::resource('topics', '\App\Admin\Controllers\TopicController', ['only' => ['index', 'store', 'create', 'destroy']]);
        //});

        //系统通知模块
        //Route::group(['middleware' => 'can:notice'], function () {
            Route::resource('notices', '\App\Admin\Controllers\NoticeController', ['only' => ['index', 'store', 'create']]);
        //});
    });

});

