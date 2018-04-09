<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/1
 * Time: 18:05
 */

namespace app\admin\validate;
use think\Validate;

class AdminValidate extends Validate
{
    protected $rule = [
        'admin_name'  =>  'require|max:25|unique:admin',
        'email' =>  'email|unique:admin',
        'iphone' =>  'unique:admin',

    ];

    protected $message   = [
        'admin_name.require' => '名字不能为空',
        'admin_name.unique' => '用户名重复',
        'email.email'=>'格式不正确',
        'email.unique'=>'邮箱已经存在',
        'iphone.unique'=>'手机号已存在',
    ];

    protected $scene = [
        'add' =>  ['admin_name','email'],
    ];

}