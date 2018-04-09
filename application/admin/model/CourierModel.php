<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/8
 * Time: 14:26
 */

namespace app\admin\model;

use think\Model;

class CourierModel extends Model
{
    protected $pk = 'courier_id';
    protected $table = 'courier';
}