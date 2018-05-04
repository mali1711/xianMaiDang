<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
use think\Route;
use think\Config;

/* 商城后台路由 */
Route::controller("/admin","admin/admin"); //管理员模块
Route::controller("/courier","admin/Courier"); //公司内部快递员
Route::controller("/cates","admin/Cates"); //分类模块
Route::controller("/login","admin/Login"); //登录
Route::controller("/products","admin/Products"); //产品管理->产品列表
Route::controller("/allow","admin/Allow"); //权限管理

/* 快递员模块 */
Route::controller("/cindex","courier/Index"); //前台登录注册
Route::controller("/callow","courier/Allow"); //前台登录
Route::controller("/clogin","courier/Login"); //前台登录注册

/* 商城前台路由 */
Route::controller("/indexlogin","index/Login"); //前台登录注册
Route::controller("/goods","index/goods"); //前台登录注册
Route::controller("/cart","index/Shopcart"); //购物车
Route::controller("/order","index/Order"); //订单

