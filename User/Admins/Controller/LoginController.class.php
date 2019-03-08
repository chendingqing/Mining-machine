<?php
namespace Admins\Controller;
use Think\Controller;

class LoginController extends Controller {
    /**
     * 同步登录功能
     */
    public function index()
    {
        $admin_id = session("admin_id");
        if(!empty($admin_id)){
            $this->redirect('Index/index');
        }

        if(IS_POST){
            $admin_name = I("post.admin_name") ? I("post.admin_name") : "";
            $admin_pass = I("post.admin_pass") ? I("post.admin_pass") : "";
            if(empty($admin_name) || empty($admin_pass)){
                $this->error("请输入账号密码");
            }

            $admin = M("admins") -> where("admin_name = '".$admin_name."' and admin_pass = '".md5($admin_name . $admin_pass)."'") -> find();
            if(empty($admin)){
                $this->error("账号或者密码错误");
            }

            session('admin_id',$admin['admin_id']);
            session('admin_name',$admin['admin_name']);
            $this->success("登录成功");
        }

        $this->display();
    }
}