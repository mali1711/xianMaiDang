<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;

class Info extends Controller{

    /**
     * 信息首页
     */
    public function getIndex()
    {

    }



    /**
     * 留言列表
     */
    public function getguestbook()
    {
        return $this->fetch('admin/guestbook');
    }



    /**
     * 意见反馈
     */
    public function getfeedback()
    {
        return $this->fetch('admin/feedback');
    }
}
