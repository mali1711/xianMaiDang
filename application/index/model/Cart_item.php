<?php

namespace app\index\model;

use think\Model;

class Cart_item extends Model
{
    //
    protected $pk = 'cart_item_id';
    protected $table = 'cart_item';


    protected $type = [
        'product_id'    =>  'integer',
        'goods_price'   =>  'float',
        'goods_number'  =>  'integer',
    ];
}
