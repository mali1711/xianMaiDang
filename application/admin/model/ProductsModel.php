<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/30
 * Time: 20:41
 */

namespace app\admin\model;
use think\Model;

class ProductsModel extends Model
{
    protected $pk = 'products_id';
    protected $table = 'products';
}