<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/26
 * Time: 16:33
 */
namespace app\admin\model;

use think\Model;

class AdminModel extends Model
{
    protected $pk = 'admin_id';
    protected $table = 'admin';

/*    public function getStatusAttr($value)
    {
        $status = [0=>'<span class="label label-defaunt radius">已停用</span>',1=>'<span class="label label-success radius">已启用</span>'];
        return $status[$value];
    }*/
}