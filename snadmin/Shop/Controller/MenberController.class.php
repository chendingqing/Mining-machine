<?php

namespace Home\Controller;

use Home\Controller\CommonController;

class MenberController extends CommonController {
	public function wxinfo() {
		$wxconfig = D ( 'wxconfig' );
		if (IS_POST) {
			if (! $wxconfig->create ()) {
				// 如果创建失败 表示验证没有通过 输出错误提示信息
				$this->error ( $wxconfig->getError () );
			} else {
				// 添加
				if (I ( 'post.id' ) == '') {
					$data = $wxconfig->create ();
					$wxconfig->add ( $data );
				} else {
					// 修改
					$data ['id'] = I ( 'post.id' );
					$data = $wxconfig->create ();
					$wxconfig->save ( $data );
				}
			}
		}
		$wx = $wxconfig->find ();
		$this->assign ( 'wx', $wx );
		$this->display ();
	}
	public function wxmenu() {
		$wxmenu = M ( 'Wxmenu' );
		$menutxt = get_menu ();
		$this->assign ( "menu", $menutxt );
		$this->display ();
	}
	public function creatmenu() {
		$data = get_menu ();
		foreach ($data as $k=>$v){
			$data[$k]['view_url']=html_entity_decode($v['view_url']);
		}
//		dump($data);exit;
		foreach ( $data as $k => $d ) {
			if ($d ['pid'] != 0)
				continue;
			$tree ['button'] [$d ['menu_id']] = _deal_data ( $d );
			unset ( $data [$k] );
		}
		foreach ( $data as $k => $d ) {
			$tree ['button'] [$d ['pid']] ['sub_button'] [] = _deal_data ( $d );
			unset ( $data [$k] );
		}
		$tree2 = array ();
		$tree2 ['button'] = array ();
		foreach ( $tree ['button'] as $k => $d ) {
			$tree2 ['button'] [] = $d;
		}
		$tree = json_encode_cn ( $tree2 );
		$weObj = $this->initwx ();
		$res = $weObj->createMenu ( $tree );
		if ($res) {
			$this->success ( "重新创建菜单成功!" );
		} else {
			$this->error ( "重新创建菜单失败：" . $weObj->errCode . '-' . $weObj->errMsg );
		}
	}
	public function medit() {
		$mid = I ( 'get.id' );
		$menu = D ( 'Wxmenu' );
		if (IS_POST) {
			if (! $menu->create ()) {
				$this->error ( $menu->getError () );
			} else {
				if (I ( 'post.menu_id' ) == '') {
					$data = $menu->create ();
					if ($menu->add ( $data )) {
						$this->success ( "添加成功，请重新生成菜单", U ( 'wxmenu' ) );
					}
				} else {
					$data ['menu_id'] = I ( 'post.menu_id' );
					$data = $menu->create ();
					if ($menu->save ( $data )) {
						$this->success ( "修改成功，请重新生成菜单", U ( 'wxmenu' ) );
					}
				}
			}
		} else {
			$rsmenu = $menu->where ( array (
					'menu_id' => $mid 
			) )->find ();
			unset ( $find );
			$find ['menu_type'] = 'none';
			$find ['pid'] = 0;
			$pidmenu = $menu->where ( $find )->select ();
			$this->assign ( 'rsmenu', $rsmenu );
			$this->assign ( "pidmenu", $pidmenu );
			$this->display ();
		}
	}
	public function delmenu() {
		$txtid = I ( 'get.id' );
		$menu = M ( 'Wxmenu' );
		$result = $menu->where ( array('menu_id'=>$txtid) )->delete ();
		 if ($result !== FALSE) {
			$this->success ( "成功删除！", U ( "Menber/wxmenu" ) );
		} else {
			$this->error ( '删除失败！' );
		}
	}
	public function settx(){
		if(!empty($_POST)){
		$txinfo = array ();
		$txinfo ['appid'] = $_POST ['appid'];
		$txinfo ['mchid'] = $_POST ['mchid'];
		$txinfo ['key'] = $_POST ['key'];
		$txinfo ['txmax'] = $_POST ['txmax'];
		$txinfo ['txonemin'] = $_POST ['txonemin'];
		$txinfo ['txaccess'] = $_POST ['txaccess'];
		$txinfo ['txjgtime'] = $_POST ['txjgtime'];
		$txinfo ['txsxf'] = $_POST ['txsxf'];
		//dump($txinfo);exit;
		$txinfo = json_encode ( $txinfo );
		
		$txinfo = '<?php $txinfo = \'' . $txinfo . '\';?>';

		
		file_put_contents ( "./Public/Conf/txinfo.php", $txinfo );
		$this->success ( "操作成功" );
		}else{
		if (file_exists ( './Public/Conf/txinfo.php' )) 

		{
			
			require './Public/Conf/txinfo.php';
			
			$txinfo = json_decode ( $txinfo, true );
		}
		
		$this->assign ( "tx", $txinfo );
		$this->display();
		}
	}
	public function Replyedit() {
		$mid = I ( 'get.id' );
		$replay = D ( 'replay' );
		if (IS_POST) {
			if (! $replay->create ()) {
				$this->error ( $replay->getError () );
			} else {
				if (I ( 'post.id' ) == '') {
					$data = $replay->create ();
					if ($replay->add ( $data )) {
						$this->success ( "添加成功，请重新生成菜单", U ( 'wxmenu' ) );
					}
				} else {
					$data ['id'] = I ( 'post.id' );
					$data = $replay->create ();
					if ($replay->save ( $data )) {
						$this->success ( "修改成功，请重新生成菜单");
					}
				}
			}
		} else {
			empty($mid)?$mid=1:$mid;
			$rsplay = $replay->where ( array ('id' => $mid) )->find ();
			$this->assign ( 'rsplay', $rsplay );
			$this->display ();
		}
	}
	
	
	
}