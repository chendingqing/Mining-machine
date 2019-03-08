<?php
namespace Bang\Controller;
use Think\Controller;

class LoginController extends Controller {
    /**
     * 同步登录功能
     */
    public function index()
    {
        $token = I("get.token") ? I("get.token") : "";
        if(empty($token)){
            echo "<script>alert('请先登录');window.location.href='".HTTP_URL."login.html';</script>";
            exit;
        }

        $prefix = C("DB_WEIQUAN_PREFIX");
        $z_user = M("user",$prefix,"DB_WEIQUAN")->where(array("token" => $token))->find();
        if(empty($z_user)){
            echo "<script>alert('请先登录');window.location.href='".HTTP_URL."login.html';</script>";
            exit;
        }

        $user = M("user")->where(array("UE_account" => $z_user['userid']))->find();
        if(empty($user)){
            $data['UE_account']=$z_user['userid'];
            $data['UE_truename'] = $z_user['username'];
            $data['phone']  = $z_user['userid'];
            $rs=M('user')->add($data);
            if(!$rs){
                echo "<script>alert('同步登陆失败');window.location.href='".HTTP_URL."';</script>";
                exit;
            }
            $user = M("user")->where(array("UE_account" => $z_user['userid']))->find();
        }

        // 登录
        session('uid',$user['ue_id']);
        session('uname',$user['ue_account']);
        $record['date']= date ('Y-m-d H:i:s', time());
        $record['ip'] = get_client_ip();
        $record['user'] = $user['ue_account'];
        $record['leixin'] = 0;
        M ('drrz')->add($record);
        $_SESSION['logintime'] = time();
        $this->redirect('Index/index');
    }
}