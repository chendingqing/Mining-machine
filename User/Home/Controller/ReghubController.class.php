<?php

namespace Home\Controller;

use Think\Controller;

class ReghubController extends CommonController {
	public function censor() {
		
		//var_dump( $users );die;
		
		$userData = M( 'user' )->where( array( 'UE_ID' => $_SESSION ['uid'] ) )->find ();
		$count= M( 'user' )//-/>alias( 'm' )
			//->Table( C('DB_PREFIX') . 'user m' )
			//->join( C('DB_PREFIX') . 'user c pin ON c.sy_user=m.UE_account', 'LEFT' )
			//->join( 'LEFT JOIN ' . C('DB_PREFIX') . 'user ON ' . C('DB_PREFIX') . 'pin.sy_user=' . C('DB_PREFIX') . 'user.UE_account' )
			->join( 'LEFT JOIN ' . C('DB_PREFIX') . 'pin ON ' . C('DB_PREFIX') . 'pin.sy_user=' . C('DB_PREFIX') . 'user.UE_account' )
			->order( C('DB_PREFIX') . 'user.UE_status desc' )
			->where( array( C('DB_PREFIX') . 'user.zcr' => $_SESSION ['uname'] ) )
			->count();
		$p = getpage($count,20);
		$users = M( 'user' )//-/>alias( 'm' )
			//->Table( C('DB_PREFIX') . 'user m' )
			//->join( C('DB_PREFIX') . 'user c pin ON c.sy_user=m.UE_account', 'LEFT' )
			//->join( 'LEFT JOIN ' . C('DB_PREFIX') . 'user ON ' . C('DB_PREFIX') . 'pin.sy_user=' . C('DB_PREFIX') . 'user.UE_account' )
			->join( 'LEFT JOIN ' . C('DB_PREFIX') . 'pin ON ' . C('DB_PREFIX') . 'pin.sy_user=' . C('DB_PREFIX') . 'user.UE_account' )
			->order( C('DB_PREFIX') . 'user.UE_status desc' )
			->where( array( C('DB_PREFIX') . 'user.zcr' => $_SESSION ['uname'] ) )->limit ( $p->firstRow, $p->listRows )
			->select();
		$this->userData = $userData;
		
		$this->assign( 'users', $users );
		$this->assign ( 'page', $p->show()); // 賦值分頁輸出	
		$this->display ();
		return;
		
		/* $userData = M ( 'user' )->where ( array ('UE_ID' => $_SESSION ['uid']) )->find ();
		$this->userData = $userData;
		
		

		$ip=M ( 'drrz' )->where ( array ('user' => $_SESSION ['uname'],'leixin'=>0) )->order ( 'id DESC' )->limit ( 2 )->select();
		
		$this->bcip=$ip[0];
		$this->scip=$ip[1];
		$this->display ( 'grsz' ); */
	}
	
	
	public function confirm_censor() {
		$id = I('get.id');
		$pin = I('get.pin');
		
		$user_info = M( 'user' )->where( array( 'UE_ID' => $id ) )->find ();
		$pin_info = M( 'pin' )->where( array( 'pin' => $pin ) )->find ();
		
		if( !$user_info || !$pin_info ){
			$this->error( '非法操作！' );
		} else {
			M( 'user' )->where( array( 'UE_ID' => $id ) )->save( [
				'UE_status' => 0
			] );
			
			// added by skyrim
			// purpose: masses to manager
			// version: 4.0
			$user_data = M( 'user' )->where( array( 'UE_ID' => $_SESSION ['uid'] ) )->find ();
			$settings = include( APP_PATH . 'Home/Conf/settings.php' );

			$xiaxianmen = M( 'user' )->where( array( 'zcr' => $_SESSION ['uname'] ) )->select();
			if( count( $xiaxianmen ) >= $settings['up_to_jl_threshold'] && $user_data['sfjl'] == 0 ){
				M( 'user' )->where( array( 'UE_ID' => $_SESSION ['uid'] ) )->save( [
					'sfjl' => 1,
				] );
			}
			
			//added ends
			$result = M( 'pin' )->where( array( 'pin' => $pin ) )->save( [
				'zt' => 1,
				'sy_user' => $user_info['ue_account'],
				'sy_date' => date( 'Y-m-d H:i:s' ),
			] );
			
			if( $result ){
				$this->error( '修改成功！', U('Home/Reghub/censor') );
			} else {
				$this->error( '修改失败！' );
			}
		}
	}
	public function get_pin() {
		if( !IS_AJAX ){
			echo json_encode( [ 'id' => -2 ] );
			
			return;
		} 
		
		$pin = M( 'pin' )->where( array(
			'zt' => 0,
			'user' => $_SESSION['uname']
		) )->find();
		
		if( !$pin ){
			echo json_encode( [ 'id' => -1 ] );
		} else {
			echo json_encode( $pin );
		}
	}
	
	public function disable_user() {
		$id = I('get.id');
		
		$this->set_user_status( $id, 1 );
	}
	public function enable_user() {
		$id = I('get.id');
		
		$this->set_user_status( $id, 0 );
	}
	
	public function set_user_status( $id, $status ) {
		//$_SESSION ['uname']
		$user_data = M( 'user' )->where( array(
			'UE_accName' => $_SESSION ['uname'],
			'zcr'        => $_SESSION ['uname'],
			'id'         => $id,
		) )->find ();
		
		if( !$user_data ){
			$this->error( '非法操作！请重新登录后再试' );
			
			return;
		}
		
		$model = M( 'user' );
		$save_result = $user_data = $model->where( array(
			'UE_accName' => $_SESSION ['uname'],
			'zcr'        => $_SESSION ['uname'],
			'UE_ID'      => $id,
		) )->save( [
			'UE_status'  => $status,
		] );
		
		//var_dump( $model->getLastSql() );die;
		
		if( $save_result ){
			$this->error( '修改成功' );
			
			return;
		} else {
			$this->error( '修改失败！请重新登录后再试' );
			
			return;
		}
	}
}