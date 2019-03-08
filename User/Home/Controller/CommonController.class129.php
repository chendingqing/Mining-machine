<?php

namespace Home\Controller;

use Think\Controller;

class CommonController extends Controller {

	
	
	
	public function _initialize() {
		
		
		header("Content-Type:text/html; charset=utf-8");
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
		  $this->error('請先登錄!',U('Login/index'));
			
			$this->redirect ( 'Login/index' );
		}
		$this->checkAdminSession();
		}
		$_SESSION['user_jb'] = 1;

		$userData = M ( 'user' )->where ( array (
		'UE_ID' => $_SESSION ['uid']
		) )->find ();
		
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
	
	
	public function getTreeBaseInfo($id) {
		if (! $id)
			return;
		$r = M ( "user" )->where ( array (
				'UE_account' => $id 
		) )->find ();
		if ($r)
			return array (
					"id" => $r ['ue_account'],
					"pId" => $r ['ue_accname'],
					"name" => $r ['ue_account'].$r['ue_truename']
			);
		return;
	}
	
	
	
	public function getTreeInfo($id) {
		
		
		
		static $trees = array ();
		$ids = self::get_childs ( $id );
		if (! $ids){
			return $trees;
		}

		$_SESSION['user_jb']++;
		// if($_SESSION['user_jb']>3){
			// return;
		// }
		//echo $_SESSION['user_jb'].'<br>';
		foreach ( $ids as $v ) {
			
			$trees [] = $this->getTreeBaseInfo ( $v );
			$this->getTreeInfo ( $v );
		
		}
		//if($_SESSION['user_jb']<'10'){
		
		
		//

		return $trees;
	}
	public static function get_childs($id) {

		if (! $id)
			return null;
		
		$childs_id = array ();
		$childs = M ( "user" )->field ( "UE_account" )->where ( array (
				'UE_accName' => $id 
		) )->select ();
		
		foreach ( $childs as $v ) {
			$childs_id [] = $v ['ue_account'];
		}
		
		if ($childs_id)
			return $childs_id;
		return 0;
	}
	public function getTree() {
		// if (!$this->uid) {
		// echo json_encode(array("status" => 1));
		// return ;
		// }
		$base = $this->getTreeBaseInfo ( $_SESSION ['uname'] );
		$znote = $this->getTreeInfo ( $_SESSION ['uname'] );
		$znote [] = $base;
		// dump($znote);die;
		/*
		 * $znote = array(array("id" => 1, "pId" => 0, "name"=>"1000001"), array("id" => 2, "pId" => 1, "name"=>"1000002"), array("id" => 3, "pId" => 2, "name"=>"1000003"), array("id" => 5, "pId" => 2, "name"=>"1000003"), array("id" => 4, "pId" => 1, "name"=>"1000004") );
		 */
		
		echo json_encode ( array ("status" => 0,"data" => $znote ) );
	}
	
	public function getTreeso() {
		
		if(I('post.user')<>''){
		
		if(! preg_match ( '/^[a-zA-Z0-9]{6,12}$/', I('post.user') )){
			
			echo json_encode ( array ("status" => 1,"data" => '用戶名格式不對!' ) );
			
		}else{
		
		if(!M('user')->where(array('UE_account'=>I('post.user')))->find()){
			echo json_encode ( array ("status" => 1,"data" => '用戶不存在!' ) );
		}elseif(I('post.user')==$_SESSION ['uname']){
			echo json_encode ( array ("status" => 1,"data" => '用戶名不能填自己!' ) );
		}else{
			 $account = M('user')->where(array('UE_account'=>I('post.user')))->find();
			 $accname = $account['ue_accname'];
			for ($i=1;$i<=30;$i++){
				
				if($accname== $_SESSION ['uname']){$quanxian = 1;$daishu=$i;break;}
				if($accname== ''){$quanxian = 0;break;}
				$account = M('user')->where(array('UE_account'=>$accname))->find();
				$accname = $account['ue_accname'];
			}
			if($quanxian == 1){
				//echo json_encode ( array ("status" => 2 );
						$base = $this->getTreeBaseInfo ( I('post.user') );
		$znote = $this->getTreeInfo ( I('post.user') );
		$znote [] = $base;
		echo json_encode ( array ("status" => 0,"data" => $znote ,"ds" =>$daishu ) );
			}elseif($quanxian == 0){
				echo json_encode ( array ("status" => 1,"data" => '此會員不在您的線下!' ) );
			}
		
		}
		}
		}else{
			
			//echo json_encode ( array ("status" => 0,'nr'=>I('post.user')) );die;
			// if (!$this->uid) {
			// echo json_encode(array("status" => 1));
			// return ;
			// }
			//die;
			$base = $this->getTreeBaseInfo ( $_SESSION ['uname'] );
			$znote = $this->getTreeInfo ($_SESSION ['uname'] );
			$znote [] = $base;
			// dump($znote);die;
			/*
			 * $znote = array(array("id" => 1, "pId" => 0, "name"=>"1000001"), array("id" => 2, "pId" => 1, "name"=>"1000002"), array("id" => 3, "pId" => 2, "name"=>"1000003"), array("id" => 5, "pId" => 2, "name"=>"1000003"), array("id" => 4, "pId" => 1, "name"=>"1000004") );
			*/
			
			echo json_encode ( array ("status" => 0,"data" => $znote ) );
			
		}
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