<?php

namespace Home\Controller;

use Think\Controller;

class CommonController extends Controller {

	
	
	
	public function _initialize() {
		
		
		header("Content-Type:text/html; charset=utf-8");
		$settings = include( dirname( APP_PATH ) . '/User/Home/Conf/settings.php' );
		
		if(isMobile()){
			C("DEFAULT_THEME",'wap');
		}
		
		
// 		echo cookie('uid2');
// 	if( $_COOKIE ['uid2'] ==''){
// 		session_unset();
// 		session_destroy();
// 		$this->redirect('Login/index');
// 	}
		$zt=M('system')->where(array('SYS_ID'=>1))->find();
// 		$time2 = date('H');
		if($zt['zt']<>0){
			$this->error('系统升级中,请稍后访问!','/Home/Login/index');die;
		}
		
		

		
        $czmcsy = CONTROLLER_NAME . ACTION_NAME;
		$czmc = ACTION_NAME;
		//echo $czmcsy;die;
		if($czmcsy<>'Indexindex'){
			
		if (! isset ( $_SESSION ['uid'] )) {
			// $this->error('請先登錄!',U('Login/index'));
			
			$this->redirect ( '/Index.php/Home/Login/index' );
		}
		$this->checkAdminSession();
		}
		$_SESSION['user_jb'] = 1;

		$userData = M ( 'user' )->where ( array (
		'UE_ID' => $_SESSION ['uid']
		) )->find ();
		
		
		
		
		
		
		
		
		$zdqx=M('ppdd')->where(array('g_user'=>$_SESSION['uname'],'zt'=>1))->find();
		$time=strtotime($zdqx['jydate']);
		$time1= time();
		
		$data_cha=($time1-$time)/3600;
		$djj=M('ppdd')->where(array('g_user'=>$_SESSION['uname'],'zt'=>1))->find();
		
		$re=M('user')->where(array('UE_account'=>$_SESSION['uname']))->find();
		if($data_cha>48){
				$djmoney=$djj['lkb'];
				$re=M('ppdd')->where(array('g_user'=>$_SESSION['uname'],'zt'=>1))->data(array('zt'=>0,'jydate'=>"",'g_name'=>"",'g_user'=>"",'g_level'=>"",'g_id'=>""))->save();
				if($re){
					$re=M('user')->where(array('UE_account'=>$_SESSION['uname']))->setInc("UE_money",$djmoney);
					$ress=M('user')->where(array('UE_account'=>$_SESSION['uname']))->setDec("djmoney",$djmoney); 
				}
				
			
		}
		$time=date('Y-m-d 00:00:30',time());
		$time1=date('Y-m-d 23:59:59',time());
		$time2=date('Y-m-d 00:01:00',time());
		$date=strtotime($time);
		$date1=strtotime($time2);
		
		
		$lcsj=M(date)->where(array('date'=>$date))->find();
			
		
		if($lcsj==""){
		
			$sjj=M(date)->where(array())->order('id desc')->find();
			
			$map0['date']=$date;
			$map0['price']=$sjj['price'];
			M('date')->add($map0);
			$map11['date']=$date1;
			$map11['price']=$sjj['price'];
			M('date')->add($map11);
		}
		
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
	
	
	
	
	
	
	
	
	
	
	
	public function uploadFacedgc() {
	
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