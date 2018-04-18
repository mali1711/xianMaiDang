<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/12
 * Time: 16:04
 */

namespace app\index\controller;

use app\index\model\UsersModel;
use think\Controller;
use think\Db;
use think\Request;
use think\Session;

class Login extends Controller
{

    /*
     * 手机号登录
     * */
    public function getloginIphone()
    {
        return $this->fetch('index/wanagid_DengLu');
    }

    public function postloginIphone()
    {
        $request = request();
        $where = $request->post();
        $where['password'] = md5($where['password']);
        $users = new UsersModel();
        $res = $users->get($where);
        if($res){
            session::set('islogin',$res);
            $this->success('登录成功','/');
        }else{
            $this->error('账号或者密码错误');
        }

    }

    public function postmsgsend()
    {
        $code = rand(100000,999999);
        $request = request();
        $iphone = $request->post('iphone');
        $res = sendsms($code,$iphone);
        if($res==true){
            session::set('code',$code);
            return 1;
        }else{
            return '网络延迟，就稍后再试';
        }
    }

    /*
     * 手机注册
     * */
    public function getregister()
    {
        return $this->fetch('index/wangid_ZhuCe');
    }
    
    /*
     *
     * */
    public function postregister()
    {
        $request = request();
        $data = $request->post();
        $code = session::get('code');
        if($data['code']!=$code){
            $this->error('手机验证码错误');
        }else{
            $user = new UsersModel();
            $data['addtime'] = time();
            $data['status'] = 1;
            $res = $user->allowField(true)
                ->validate(
                    [
                        'username'=>'min:5|unique:users',
                        'iphone'=>'unique:users',
                        'password'=>'confirm:agin_password'
                    ],
                    [
                        'username.unique'=>'用户名重复',
                        'username.min'=>'用户名大于5个字符',
                        'iphone.unique'=> '手机已经注册',
                        'password.confirm'=>'两次密码不一致'

                    ]
                )
                ->save($data);
            if($res){
                $this->success('注册成功','/index');
            }else{
                $this->error($user->getError());
            }
        }
    }

}