<?php

namespace app\courier\controller;

use app\index\model\Courier;
use think\Controller;
use think\Request;
use think\Session;

class Index extends Allow{

    /**
     * 个人中心
     * @GET int $id 快递员id  
     * @return page
     */
    public function getindex()
    {
        $id = Session::get('islogin')->courier_id;
        $courier = new Courier();
        $data = $courier->get($id);
        return $this->fetch('index/index',['list'=>$data]);
    }

    
    /**
     * 修改个人信息
     * @GET 1=>密码  2=>邮箱  3=>头像 4=>其他信息
     * @return page
     */

    public function getuppersinfo()
    {
        $request = request();
        $meth = $request->get('meth');
        switch ($meth){
            case 1:
                return $this->fetch();
                break;
            case 2:
                return $this->fetch();
                break;
            case 3:
                return $this->fetch();
                break;
            case 4:
                return $this->fetch();
                break;
            default:
                $this->error('请传入正确的参数');
                break;
        }
    }

    /**
     * 修改个人信息
     * @POST array
     * @return bool
     */
    public function postuppersinfo()
    {
        $data = request()->param();
        $where['courier_id'] = Session::get('islogin')->courier_id;
        $courier = new Courier();
        $res = $courier->where($where)->save($data);
        if($res){
            $this->success('修改成功');
        }else{
            $this->error('修改失败');
        }
    }
    
    /**
     * 查看正在发货的快递
     * @return array
     */
    public function getordering()
    {
        $id = Session::get('islogin')->courier_id;
        $list = Courier::get($id);
        if($list){
            $this->error('您目前没有正在发货的订单');
        }
        return $this->fetch('index/ordering',['list',$list]);
    }


    /**
     * 查看等待发货的快递单
     * @return array
     */
    public function getshipcode1()
    {
        $id = Session::get('islogin')->courier_id;
        $list = Courier::all(['courier_id'=>$id,'status'=>1]);
        return $this->fetch('index/neworder',['list'=>$list]);
    }
    
    
    /**
     * 查看已经发货的快递单
     * @GET int $id
     * @return array
     */
    public function getshipcode2()
    {
        $id = Session::get('islogin')->courier_id;
        $list = Courier::all(['courier_id'=>$id,'status'=>2]);
        return $this->fetch('index/ordered',['list'=>$list]);
    }

    /**
     * 查看出现问题的快递
     * @GET
     */
    public function geterrororder()
    {
        return $this->fetch('index/errorOrder');
    }

    /**
     * 删除已经发货的订单
     * @GET int $id
     * @return bool
     */
    public function getdelshipcode()
    {
        $id = Session::get('islogin')->courier_id;
        return Courier::destroy($id);
    }
    
    /**
     * 修改快递状态
     * @param int $id 订单id
     * @param int $status 1已发货 2 未发货
     * @param string（json） $info 发货信息
     * @return bool
     */
    public function getupshipcode($id,$status)
    {
        $id = request()->param('id');
        $status = request()->param('status');
        $courier = new Courier();
        $res = $courier->save([
            'status'=>$status
            ],['courier_id'=>$id]
        );
        if($res){
            return $status;
        }else{
            return 0;
        }
    }
     
    /**
     * 修改密码
     * @POST $password 新密码
     * @POST $apassword 旧密码
     * @return json
     */
    public function postuppassword()
    {
        $courier = new Courier();
        $data = request()->param();
        if($data['password']==$data['apassword']){
            $id = Session::get('islogin')->id;
            $res = $courier->allowField(true)->save($data,['courier_id'=>$id]);
            if($res){
                $data['status'] = 1;
                $data['info'] = '修改成功';
            }else{
                $data['status'] = 2;
                $data['info'] = '修改失败';
            }
        }else{
            $data['status'] = 0;
            $data['info'] = '两次密码不一致';
        }
        
        return json_encode($data);
    }
    
    /**
     * 请假
     * @POST string $info 请假原因 
     * @POST string $start 请假开始时间
     * @POST string $end 请假结束时间
     * @return bool
     */
    public function postvacation()
    {
        $data = request()->param();
    }
    
    /**
     * 判断假期是否过期
     */
    public function getjudgevacation()
    {
        
    }
    
    /**
     * 修改假期为上班状态
     */
    public function getvacationsta($id)
    {
        if(request()->get('id')){
            $id = request()->get('id');
        }
    }
}