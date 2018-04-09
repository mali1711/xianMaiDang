<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/27
 * Time: 11:43
 */
namespace app\admin\model;

use think\Model;

class CatesModel extends Model
{
    protected $pk = 'cates_id';
    protected $table = 'cates';

    /*    public function getStatusAttr($value)
        {
            $status = [0=>'<span class="label label-defaunt radius">已停用</span>',1=>'<span class="label label-success radius">已启用</span>'];
            return $status[$value];
        }*/
}