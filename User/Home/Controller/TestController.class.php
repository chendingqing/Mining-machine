<?php

namespace Home\Controller;

use Think\Controller;

class TestController extends Controller {
	public function index() {
		$user = M ( 'user' );
		$rsuser = $user->field ( 'UE_ID,UE_accName' )->where('UE_ID>11110 and UE_ID<12000')->order ( 'UE_ID desc' )->select ();
		foreach ( $rsuser as $val ) {
			$i = 1;
			unset ( $tpath );
			$tpath = $val ['ue_id'];
			for($tju = $val ['ue_accname']; $i < 2000; $i ++) {
				if ($tju) {
					$tjuser = $user->where ( array ('UE_account' => $tju ) )->field ( 'UE_ID,UE_accName' )->find ();
					if ($tjuser) {
						$tpath = $tpath . ',' . $tjuser ['ue_id'];
						$tju = $tjuser ['ue_accname'];
					} else {
						unset ( $tju );
					}
				} else {
					$user->where ( array ('UE_ID' => $val ['ue_id'] ) )->setField ( 'tpath', $tpath );
					echo $tpath . '<br/>';break;
				}
			}
		}
	}
	//更新信用等级
	public function upppdd(){
		$ppdd=M('ppdd');
		$user=M('user');
		$splist =$ppdd->select();
		foreach($splist as $val){
			$rshy = $user->where(array('UE_account'=>$val['p_user']))->find();

			$gshy = $user->where(array('UE_account'=>$val['g_user']))->find();
			if($rshy){
				//dump($val['user']);
				$ppdd->where(array('p_user'=>$val['p_user']))->setField('p_level',$rshy['level']);
				//dump($result);
			}
			if($gshy){
				$ppdd->where(array('g_user'=>$val['g_user']))->setField('g_level',$gshy['level']);
			}
		}
	}
	public function upshop() {
		$shop = M ( 'shop_orderform' );
		$users = M ( 'user' );
		$splist = $shop->where(' id > 19999 and id<21000')->select ();
		foreach ( $splist as $val ) {
			$rshy = $users->where ( array ('UE_account' => $val ['user'] ) )->find ();
			if ($rshy) {
				$shop->where ( array ('id' => $val ['id'] ) )->setField ( 'uid', $rshy ['ue_id'] );
			}
		}
	}
	
	public function uplevel(){
		$users = M ( 'user' );
		$splist = $users->where(' UE_ID > 0 and UE_ID<9100')->select ();
		foreach ( $splist as $val ) {
			$map['user'] = $val['ue_account'];
			$map['level'] = $val['ue_level'];
			M('hylevel')->add($map);
		}
	}
}




