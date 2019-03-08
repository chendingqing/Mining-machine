<?php

namespace Shop\Controller;

use Think\Controller;

class CommonController extends Controller {

	
	
	
	public function _initialize() {
		header("Content-Type:text/html; charset=utf-8");
// 		echo cookie('uid2');
// 	if( $_COOKIE ['uid2'] ==''){
// 		session_unset();
// 		session_destroy();
// 		$this->redirect('Login/index');
// 	}
		if(isMobile()){
			C("DEFAULT_THEME",'wap');
		}
		$zt=M('system')->where(array('SYS_ID'=>1))->find();
// 		$time2 = date('H');
		if($zt['zt']<>0){
			$this->error('系统升级中,请稍后访问!','/Home/Login/index');die;
		}
		
		$czmcsy = CONTROLLER_NAME . ACTION_NAME;
		$czmc = ACTION_NAME;
		//echo $czmcsy;die;
		if($czmcsy<>'Loginindex'){
			
		if (! isset ( $_SESSION ['uid'] )) {
			// $this->error('請先登錄!',U('Login/index'));
			
			$this->redirect ( 'Home/Login/index' );
		}
		$this->checkAdminSession();
		}
		$_SESSION['user_jb'] = 1;

		$userData = M ( 'user' )->where ( array (
		'UE_ID' => $_SESSION ['uid']
		) )->find ();
		
		$result = M('font')->find();
		$this->assign("result",$result);
		
		$this->userData=$userData;
	}
	
	public function checkAdminSession() {
		//设置超时为10分
		$nowtime = time();
		$s_time = $_SESSION['logintime'];
		if (($nowtime - $s_time) > 3600000) {
		session_unset();
    	session_destroy();
			$this->error('当前用户登录超时，请重新登录', U('/Home/Login/index'));
		} else {
			$_SESSION['logintime'] = $nowtime;
		}
	}
	
	function check_verify($code) {
		$verify = new \Think\Verify ();
		return $verify->check ( $code );
	}
	
	
	
	
	
	
	
	
	
	public function uploadFace() {
	
		//if (!$this->isPost()) {
		//	$this->error('页面不存在');
		//}
		//echo 'asdfsaf';die;
		$upload = $this->_upload('Pic');
		$this->ajaxReturn($upload);
	}
	
	
	
	
	
	Private function _upload ($path) {
		import('ORG.Net.UploadFile');	//引入ThinkPHP文件上传类
		$obj = new \Think\Upload();	//实例化上传类
		$obj->maxSize = 2000000;	//图片最大上传大小
		$obj->savePath =  $path . '/';	//图片保存路径
		$obj->saveRule = 'uniqid';	//保存文件名
		$obj->uploadReplace = true;	//覆盖同名文件
		$obj->allowExts = array('jpg','jpeg','png','gif');	//允许上传文件的后缀名
	
		$obj->autoSub = true;	//使用子目录保存文件
		$obj->subType = 'date';	//使用日期为子目录名称
		$obj->dateFormat = 'Y_m';	//使用 年_月 形式
		//$obj->upload();die;
		$info   =   $obj->upload();
		if (!$info) {
			return array('status' => 0, 'msg' => $obj->getErrorMsg());
		} else {
			foreach($info as $file){
				$pic = $file['savepath'].$file['savename'];
			}
			//$pic =  $info[0][savename];
			//echo $pic;die;
			return array(
					'status' => 1,
					'path' => $pic
			);
		}
	}
	
	
	
}