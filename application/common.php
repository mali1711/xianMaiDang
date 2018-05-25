<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
//导入Config
use think\Config;
use think\Loader;
use think\Session;
// 应用公共文件

function alipay(){
    Loader::import('Org.Pay.wappay.pay');
    $config = config::get('alipay');//支付宝配置文件
    $pay = new \pay($config);
    $res = $pay->pay();
}

/*
 * 短信息发送
 * */
function sendsms($msg,$tel){
    $sms=new \Org\Util\Smsyzm();
    $sms->accountsid = config::get('sms.accountsid');
    $sms->appid = config::get('sms.appid');
    $sms->token=config::get('sms.token');
    $sms->templateid = config::get('sms.templateid');
    return $sms->smsSend($msg,$tel);
}


//发送邮件
//$to 接受方  $title 邮件主题  $content 内容
function sendmail($to,$title,$content){
    //导入三方类库 
    $mail=new \Org\Util\PHPMailer();
    // var_dump($mail);
    //设置字符集
    $mail->CharSet="utf-8";
    //设置采用SMTP方式发送邮件
    $mail->IsSMTP();
    //设置邮件服务器地址
    $mail->Host=Config::get('mailarr.smtp');//C 获取配置文件信息 
    //设置邮件服务器的端口 默认的是25  如果需要谷歌邮箱的话 443 端口号
    $mail->Port=25;
    //设置发件人的邮箱地址
    $mail->From=Config::get('mailarr.username'); //
    // $mail->FromName='我';//
    //设置SMTP是否需要密码验证
    $mail->SMTPAuth=true;
    //发送方
    $mail->Username=Config::get('mailarr.username');
    $mail->Password=Config::get('mailarr.password');//C客户端的授权密码
    $mail->FromName=Config::get('mailarr.formname');//C发件人
    //发送邮件的主题
    $mail->Subject=$title;
    //内容类型 文本型
    $mail->AltBody="text/html";
    //发送的内容
    $mail->Body=$content;
    //设置内容是否为html格式
    $mail->IsHTML(true);
    //设置接收方
    $mail->AddAddress(trim($to));
    if(!$mail->Send()){
        return $mail->ErrorInfo;
        // echo "失败".$mail->ErrorInfo;
    }else{
        return true;
    }
}