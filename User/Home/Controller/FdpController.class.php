<?php

namespace Home\Controller;

use Think\Controller;

class FdpController extends CommonController {
	// 首页
	public function index() {
		$this->display();
		$this->redirect('/Home/Index/home');
	}
	
	// 注册模块
	public function reg() {
		//////////////////----------
		$User = M ( 'user' ); // 实例化User对象
	
			$map['zcr']=$_SESSION['uname'];
		$count = $User->where ( $map )->count (); // 查询满足要求的总记录数
		//$page = new \Think\Page ( $count, 3 ); // 实例化分页类 传入总记录数和每页显示的记录数(25)
		
		$p = getpage($count,20);
		
		$list = $User->where ( $map )->order ( 'UE_ID DESC' )->limit ( $p->firstRow, $p->listRows )->select ();
		$this->assign ( 'list', $list ); // 赋值数据集
		$this->assign ( 'page', $p->show() ); // 赋值分页输出
		/////////////////----------------
		
		$this->email=sprintf("%0".strlen(9)."d", mt_rand(0,99999999999)).'@qq.com';
		
		$this->pin1=M('pin')->where(array('user'=>$_SESSION['uname'],'zt'=>'0'))->find();
		//dump($pin1);die;
		$this->moren = $_SESSION ['uname'];
		$this->display ( 'reg' );
	}
	
	 
	
}