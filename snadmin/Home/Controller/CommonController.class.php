<?php

namespace Home\Controller;

use Think\Controller;

class CommonController extends Controller {
	
	public function _initialize() {
		header("Content-Type:text/html; charset=utf-8");
        $czmcsy = CONTROLLER_NAME . ACTION_NAME;
		$czmc = ACTION_NAME;
		//echo $czmc;die;
		
		
			
		if (! isset ( $_SESSION ['adminuser'] )) {
			// $this->error('請先登錄!',U('Login/index'));
			
			$this->success('請先登錄','/admin8899.php/Home/Login');
			die;
		}
		
		if($_SESSION ['adminqx']<>'1'){
				
			if($czmc<>'main'&&$czmc<>'df1'&&$czmc<>'top'&&$czmc<>'left'&&$czmc<>'userlist'&&$czmc<>'team'&&$czmc<>'rggl'&&$czmc<>'getTreeso'&&$czmc<>'getTree'&&$czmc<>'get_childs'&&$czmc<>'getTreeInfo'&&$czmc<>'getTreeBaseInfo'&&$czmc<>'userbtc'&&$czmc<>'jbzs'){
				$this->error('您暂无权限操作!','/admin8899.php/Home/Index/df1');die;
				//echo '无权限';
			}
				
		}
		
		
		$this->checkAdminSession();
	
	//	$_SESSION['user_jb'] = 1;
	//	static $user_jb = "safsdf";
		// echo $_COOKIE['url'];die;
		

	}
	
	public function checkAdminSession() {
		//设置超时为10分
		$nowtime = time();
		$s_time = $_SESSION['logintime'];
		if (($nowtime - $s_time) > 6000000) {
		session_unset();
    	session_destroy();
			$this->error('当前用户登录超时，请重新登录', U('/admin8899.php/Home/Login/'));
		} else {
			$_SESSION['logintime'] = $nowtime;
		}
	}
	
	function check_verify($code) {
		$verify = new \Think\Verify ();
		return $verify->check ( $code );
	}
	
	
	function diffBetweenTwoDays($day1, $day2)
	{
		$second1 = $day1;
		$second2 = $day2;
	
		/* $second1 = strtotime($day1);
		 $second2 = strtotime($day2); */
	
		if ($second1 < $second2) {
			$tmp = $second2;
			$second2 = $second1;
			$second1 = $tmp;
		}
		//return ($second1 - $second2) / 5;
		return intval(($second1 - $second2) / 3600);
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