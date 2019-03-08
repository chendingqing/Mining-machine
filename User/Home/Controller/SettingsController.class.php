<?php

namespace Home\Controller;

use Think\Controller;

class SettingsController extends CommonController {
	
	public function __construct(){
		parent::__construct();
		
 		$settings = include( dirname( dirname( __FILE__ ) ) . '/Conf/settings.php' );
 		if( !in_array( $_SESSION['uname'], $settings['admin_users'] ) ){
 			$this->error( 'Sorry, 您没有这个权限！' );
 			
 			die;
 		}
		//var_dump( $_SESSION['uname'] );die;
	}
	
	public function index() {
		$userData = M ( 'user' )->where ( array ('UE_ID' => $_SESSION ['uid']) )->find ();
		$this->userData = $userData;
		
		$user_settings = M ( 'settings' )->where ( array ('user_id' => $_SESSION ['uid']) )->find ();

		$settings = include( APP_PATH . 'Home/Conf/settings.php' );
		
		foreach( $settings as $k=>$v ){
			$this->assign( $k, $v );
		}
		
		$this->display ();
	}
	
	public function save() {
		//if( !IS_AJAX ){
		//	echo '{"errmsg":"非法调用！"}';
		//	
		//	return;
		//}
		
		$settings = include( APP_PATH . 'Home/Conf/settings.php' );
		
		//if( isset( $_POST['jl'][1] ) ){
		//	echo $_POST['jl'][1];
		//}
		
		foreach( $_POST['jl'] as $k=>$v ){
			$_POST['jl'][$k] = $v;
		}
		
		foreach( $settings as $k=>$v ){
			if( isset( $_POST[$k] ) ){
				$settings[$k] = $_POST[$k];
			}
		}
		
		//var_dump( $_POST );
		$file_length = file_put_contents( APP_PATH . 'Home/Conf/settings.php', '<?php return ' . var_export( $settings, true ) . '; ?>' );
		
		if( $file_length ){
			echo '保存成功！';
		} else {
			echo '保存失败！请检查文件权限';
		}
	}
	
}