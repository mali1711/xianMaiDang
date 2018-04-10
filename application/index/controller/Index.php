<?php
namespace app\index\controller;

use app\admin\validate\AdminValidate;
use think\Controller;
use app\admin\model\AdminModel;
use \think\Request;


class Index extends Controller
{
    public function index()
    {
        return $this->fetch("index/index");
   }
}
