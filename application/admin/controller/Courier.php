<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/8
 * Time: 14:25
 * 快递员操作类
 *
 */

namespace app\admin\controller;
use app\admin\model\CourierModel;
use think\Controller;

class Courier extends Controller
{
    public function getindex()
    {
        $list = CourierModel::all();
        return $this->fetch('Admin/courier',['list'=>$list]);
    }


    /*
     * 添加快递员
     * */
    public function getadd()
    {
        return $this->fetch('Admin/courierlist');
    }

    public function postadd()
    {
        $resquest = request();
        $courier = new CourierModel();
        $data = $resquest->post();
        $data['courier_addtime '] = time();
        $data['password'] = md5($data['password']);
        $courier->data($data);
        $res = $courier->allowField(true)->save();
        if($res){
            $this->success('添加成功');
        }else{
            $this->error('添加失败');
        }
    }

    /*
     * 删除快递员
     * */
    public function getdel()
    {
        $request = request();
        $id = $request->get('id');
        $res = CourierModel::destroy($id);
        if($res){
            return 1;
        }else{
            return 0;
        }
    }

    /*
     * 禁用或者开启快递员
     * */
    public function arop()
    {

    }

    /*
     * 修改管理员
     * */
    public function getedit()
    {

    }

    public function postedit()
    {

    }

    /*
     * 管理员详情
     * */
    public function getDetail()
    {
        $resquest = request();
        $id = $resquest->get('id');
        $info = CourierModel::get($id);
    }
}