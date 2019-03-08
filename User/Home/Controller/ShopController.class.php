<?php

namespace Home\Controller;

use Think\Controller;

class ShopController extends CommonController {
	
	public function index() {
		
		
		
		$caution = M ( 'shopsj' )->where ( array (
				'leixin' => 'jbzgq' ,
				'zt' => 1
		) )->order ( 'id' )->limit ( 0, 12 )->select ();
		
		
		$this->caution=$caution;
		
		
		$caution1 = M ( 'shopsj' )->where ( array (
				'leixin' => 'zsbygq' ,
				'zt' => 1
		) )->order ( 'id' )->limit ( 0, 10 )->select ();
		
		
		$this->caution1=$caution1;
		
		
		$caution2 = M ( 'shopsj' )->where ( array (
				'leixin' => 'zsbxyq' ,
				'zt' => 1
		) )->order ( 'id' )->limit ( 0, 3 )->select ();
		
		
		$this->caution2=$caution2;
		
		
		
		
		$userData = M ( 'user' )->where ( array (
				'UE_ID' => $_SESSION ['uid']
		) )->find ();
		$this->userData = $userData;
		
		$this->display ( 'index' );
		exit('1111');
	}
	
	
	
	public function zsbzg_xx() {
	
	
	
		$caution = M ( 'shopsj' )->where ( array (
				'id'=> I('get.id') ,
				'leixin' => 'jbzgq' ,
				'zt' => 1
		) )->find ();
	
	
		$this->caution=$caution;
	
	
	
	
	
	
	
	
	
		$userData = M ( 'user' )->where ( array (
				'UE_ID' => $_SESSION ['uid']
		) )->find ();
		$this->userData = $userData;
	
		$this->display ( 'zsbzg_xx' );
	}
	
	
	
	
	public function zsbyg_xx() {
	
	
	
		$caution = M ( 'shopsj' )->where ( array (
				'id'=> I('get.id') ,
				'leixin' => 'zsbygq' ,
				'zt' => 1
		) )->find ();
	
	if(!$caution){
		$this->success('產品狀態不可查看!');die;
	}
		
		$this->caution=$caution;
	
	
	
	
	
	
	
	
	
		$userData = M ( 'user' )->where ( array (
				'UE_ID' => $_SESSION ['uid']
		) )->find ();
		$this->userData = $userData;
	
		$this->display ( 'zsbyg_xx' );
	}
	
	
	
	
	public function zsb_xy_xx() {
	
	
	
		$caution = M ( 'shopsj' )->where ( array (
				'id'=> I('get.id') ,
				'leixin' => 'zsbxyq' ,
				'zt' => 1
		) )->find ();
	
		if(!$caution){
			$this->success('產品狀態不可查看!');die;
		}
	
		$this->caution=$caution;
	
	
	
	
	
	
	
	
	
		$userData = M ( 'user' )->where ( array (
				'UE_ID' => $_SESSION ['uid']
		) )->find ();
		$this->userData = $userData;
	
		$this->display ( 'zsb_xy_xx' );
	}
	
	
	
	
	public function zsbzg_xg() {
	
	
	
		$caution = M ( 'shopsj' )->where ( array (
				'id'=> I('get.id') ,
				'user' => $_SESSION['uname'] ,
				'leixin' => 'jbzgq' ,
		) )->find ();
	
	
		$this->caution=$caution;
	
	
	
	
	
	
	
	
	
		$userData = M ( 'user' )->where ( array (
				'UE_ID' => $_SESSION ['uid']
		) )->find ();
		$this->userData = $userData;
	
		$this->display ( 'zsbzg_xg' );
	}
	
	
	
	
	public function zsbyg_xg() {
	
	
	
		$caution = M ( 'shopsj' )->where ( array (
				'id'=> I('get.id') ,
				'user' => $_SESSION['uname'] ,
				'leixin' => 'zsbygq' ,
		) )->find ();
	
	    if($caution['zt']=='1'){
	    	$this->error('當前產品狀態不可操作!');die;
	    }
		
		
		$this->caution=$caution;
	
	
	
	
	
	
	
	
	
		$userData = M ( 'user' )->where ( array (
				'UE_ID' => $_SESSION ['uid']
		) )->find ();
		$this->userData = $userData;
	
		$this->display ( 'zsbyg_xg' );
	}
	
	
	
	public function zsb_xy_xg() {
	
	
	
		$caution = M ( 'shopsj' )->where ( array (
				'id'=> I('get.id') ,
				'user' => $_SESSION['uname'] ,
				'leixin' => 'zsbxyq' ,
		) )->find ();
	
		if($caution['zt']=='1'){
			$this->error('當前產品狀態不可操作!');die;
		}
	
	
		$this->caution=$caution;
	
	
	
	
	
	
	
	
	
		$userData = M ( 'user' )->where ( array (
				'UE_ID' => $_SESSION ['uid']
		) )->find ();
		$this->userData = $userData;
	
		$this->display ( 'zsb_xy_xg' );
	}
	
	
	
	
	
	
	public function zsbzg_del() {
	
	
	
		$caution = M ( 'shopsj' )->where ( array (
				'id'=> I('get.id') ,
				'user' => $_SESSION['uname'] ,
				'leixin' => 'jbzgq' ,
		) )->delete();
	
	if($caution){$this->success('刪除成功!');}else{$this->error('刪除失敗!');}

	}
	
	
	public function zsbyg_del() {
	
	
		$caution = M ( 'shopsj' )->where ( array (
				'id'=> I('get.id') ,
				'user' => $_SESSION['uname'] ,
				'leixin' => 'zsbygq' ,
		) )->find ();
		
		if($caution['zt']=='1'){
			$this->error('當前產品狀態不可操作!');die;
		}
		
		
	
		$caution = M ( 'shopsj' )->where ( array (
				'id'=> I('get.id') ,
				'user' => $_SESSION['uname'] ,
				'leixin' => 'zsbygq' ,
		) )->delete();
	
		if($caution){$this->success('刪除成功!');}else{$this->error('刪除失敗!');}
	
	}
	
	public function zsb_xy_del() {
	
	
		$caution = M ( 'shopsj' )->where ( array (
				'id'=> I('get.id') ,
				'user' => $_SESSION['uname'] ,
				'leixin' => 'zsbxyq' ,
		) )->find ();
	
		if($caution['zt']=='1'){
			$this->error('當前產品狀態不可操作!');die;
		}
	
	
	
		$caution = M ( 'shopsj' )->where ( array (
				'id'=> I('get.id') ,
				'user' => $_SESSION['uname'] ,
				'leixin' => 'zsbxyq' ,
		) )->delete();
	
		if($caution){$this->success('刪除成功!');}else{$this->error('刪除失敗!');}
	
	}
	
	
	public function zsbzg() {
	
	
	
	
	
		
		
		
		$User = M ( 'shopsj' ); // 實例化User對象
		$count = $User->where ( array (
				'leixin' => 'jbzgq' ,
				'zt' => 1
		) )->count (); // 查詢滿足要求的總記錄數
		$page = new \Think\Page ( $count, 60 ); // 實例化分頁類 傳入總記錄數和每頁顯示的記錄數(25)
		 
		// $page->lastSuffix=false;
		$page->setConfig ( 'header', '<li class="rows">共<b>%TOTAL_ROW%</b>條記錄    第<b>%NOW_PAGE%</b>頁/共<b>%TOTAL_PAGE%</b>頁</li>' );
		$page->setConfig ( 'prev', '上一頁' );
		$page->setConfig ( 'next', '下一頁' );
		$page->setConfig ( 'last', '末頁' );
		$page->setConfig ( 'first', '首頁' );
		$page->setConfig ( 'theme', '%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%' );
		;
		
		$show = $page->show (); // 分頁顯示輸出
		// 進行分頁數據查詢 注意limit方法的參數要使用Page類的屬性
		$list = $User->where ( array (
				'leixin' => 'jbzgq' ,
				'zt' => 1
		) )->order ( 'id' )->limit ( $page->firstRow . ',' . $page->listRows )->select ();
		$this->assign ( 'list', $list ); // 賦值數據集
		$this->assign ( 'page', $show ); // 賦值分頁輸出
	
	
	
	
	
	
	
		$userData = M ( 'user' )->where ( array (
				'UE_ID' => $_SESSION ['uid']
		) )->find ();
		$this->userData = $userData;
	
		$this->display ( 'zsbzg' );
	}
	
	public function zsbyg_gd() {
	
	
	
	
	
	
	
	
		$User = M ( 'shopsj' ); // 實例化User對象
		$count = $User->where ( array (
				'leixin' => 'zsbygq' ,
				'zt' => 1
		) )->count (); // 查詢滿足要求的總記錄數
		$page = new \Think\Page ( $count, 60 ); // 實例化分頁類 傳入總記錄數和每頁顯示的記錄數(25)
			
		// $page->lastSuffix=false;
		$page->setConfig ( 'header', '<li class="rows">共<b>%TOTAL_ROW%</b>條記錄    第<b>%NOW_PAGE%</b>頁/共<b>%TOTAL_PAGE%</b>頁</li>' );
		$page->setConfig ( 'prev', '上一頁' );
		$page->setConfig ( 'next', '下一頁' );
		$page->setConfig ( 'last', '末頁' );
		$page->setConfig ( 'first', '首頁' );
		$page->setConfig ( 'theme', '%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%' );
		;
	
		$show = $page->show (); // 分頁顯示輸出
		// 進行分頁數據查詢 注意limit方法的參數要使用Page類的屬性
		$list = $User->where ( array (
				'leixin' => 'zsbygq' ,
				'zt' => 1
		) )->order ( 'id' )->limit ( $page->firstRow . ',' . $page->listRows )->select ();
		$this->assign ( 'list', $list ); // 賦值數據集
		$this->assign ( 'page', $show ); // 賦值分頁輸出
	
	
	
	
	
	
	
		$userData = M ( 'user' )->where ( array (
				'UE_ID' => $_SESSION ['uid']
		) )->find ();
		$this->userData = $userData;
	
		$this->display ( 'zsbyg_gd' );
	}
	
	
	public function zsbzgsqjl() {
	
	
	
	
	
	
	
	
		$User = M ( 'shopsj' ); // 實例化User對象
		$count = $User->where ( array (
				'user' => $_SESSION['uname'] ,
				'leixin' => 'jbzgq' 
		) )->count (); // 查詢滿足要求的總記錄數
		$page = new \Think\Page ( $count, 60 ); // 實例化分頁類 傳入總記錄數和每頁顯示的記錄數(25)
			
		// $page->lastSuffix=false;
		$page->setConfig ( 'header', '<li class="rows">共<b>%TOTAL_ROW%</b>條記錄    第<b>%NOW_PAGE%</b>頁/共<b>%TOTAL_PAGE%</b>頁</li>' );
		$page->setConfig ( 'prev', '上一頁' );
		$page->setConfig ( 'next', '下一頁' );
		$page->setConfig ( 'last', '末頁' );
		$page->setConfig ( 'first', '首頁' );
		$page->setConfig ( 'theme', '%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%' );
		;
	
		$show = $page->show (); // 分頁顯示輸出
		// 進行分頁數據查詢 注意limit方法的參數要使用Page類的屬性
		$list = $User->where ( array (
					'user' => $_SESSION['uname'] ,
				'leixin' => 'jbzgq' 

		) )->order ( 'id' )->limit ( $page->firstRow . ',' . $page->listRows )->select ();
		$this->assign ( 'list', $list ); // 賦值數據集
		$this->assign ( 'page', $show ); // 賦值分頁輸出
	
	
	
	
	
	
	
		$userData = M ( 'user' )->where ( array (
				'UE_ID' => $_SESSION ['uid']
		) )->find ();
		$this->userData = $userData;
	
		$this->display ( 'zsbzgsqjl' );
	}
	
	
	
	
	public function zsbygsqjl() {
	
	
	
	
	
	
	
	
		$User = M ( 'shopsj' ); // 實例化User對象
		$count = $User->where ( array (
				'user' => $_SESSION['uname'] ,
				'leixin' => 'zsbygq'
		) )->count (); // 查詢滿足要求的總記錄數
		$page = new \Think\Page ( $count, 60 ); // 實例化分頁類 傳入總記錄數和每頁顯示的記錄數(25)
			
		// $page->lastSuffix=false;
		$page->setConfig ( 'header', '<li class="rows">共<b>%TOTAL_ROW%</b>條記錄    第<b>%NOW_PAGE%</b>頁/共<b>%TOTAL_PAGE%</b>頁</li>' );
		$page->setConfig ( 'prev', '上一頁' );
		$page->setConfig ( 'next', '下一頁' );
		$page->setConfig ( 'last', '末頁' );
		$page->setConfig ( 'first', '首頁' );
		$page->setConfig ( 'theme', '%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%' );
		;
	
		$show = $page->show (); // 分頁顯示輸出
		// 進行分頁數據查詢 注意limit方法的參數要使用Page類的屬性
		$list = $User->where ( array (
				'user' => $_SESSION['uname'] ,
				'leixin' => 'zsbygq'
	
		) )->order ( 'id' )->limit ( $page->firstRow . ',' . $page->listRows )->select ();
		$this->assign ( 'list', $list ); // 賦值數據集
		$this->assign ( 'page', $show ); // 賦值分頁輸出
	
	
	
	
	
	
	
		$userData = M ( 'user' )->where ( array (
				'UE_ID' => $_SESSION ['uid']
		) )->find ();
		$this->userData = $userData;
	
		$this->display ( 'zsbygsqjl' );
	}
	
	
	
	public function zsb_xy_sqjl() {
	
	
	
	
	
	
	
	
		$User = M ( 'shopsj' ); // 實例化User對象
		$count = $User->where ( array (
				'user' => $_SESSION['uname'] ,
				'leixin' => 'zsbxyq'
		) )->count (); // 查詢滿足要求的總記錄數
		$page = new \Think\Page ( $count, 60 ); // 實例化分頁類 傳入總記錄數和每頁顯示的記錄數(25)
			
		// $page->lastSuffix=false;
		$page->setConfig ( 'header', '<li class="rows">共<b>%TOTAL_ROW%</b>條記錄    第<b>%NOW_PAGE%</b>頁/共<b>%TOTAL_PAGE%</b>頁</li>' );
		$page->setConfig ( 'prev', '上一頁' );
		$page->setConfig ( 'next', '下一頁' );
		$page->setConfig ( 'last', '末頁' );
		$page->setConfig ( 'first', '首頁' );
		$page->setConfig ( 'theme', '%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%' );
		;
	
		$show = $page->show (); // 分頁顯示輸出
		// 進行分頁數據查詢 注意limit方法的參數要使用Page類的屬性
		$list = $User->where ( array (
				'user' => $_SESSION['uname'] ,
				'leixin' => 'zsbxyq'
	
		) )->order ( 'id' )->limit ( $page->firstRow . ',' . $page->listRows )->select ();
		$this->assign ( 'list', $list ); // 賦值數據集
		$this->assign ( 'page', $show ); // 賦值分頁輸出
	
	
	
	
	
	
	
		$userData = M ( 'user' )->where ( array (
				'UE_ID' => $_SESSION ['uid']
		) )->find ();
		$this->userData = $userData;
	
		$this->display ( 'zsb_xy_sqjl' );
	}
	
	
	
	
	
	public function zsbyg_dd() {
	
	
	
	
	
	
	
	
		$User = M ( 'zsbyg_dd' ); // 實例化User對象
		$count = $User->where ( array (
				'user' => $_SESSION['uname'] ,
				'leixin' => 'zsbygq'
		) )->count (); // 查詢滿足要求的總記錄數
		$page = new \Think\Page ( $count, 60 ); // 實例化分頁類 傳入總記錄數和每頁顯示的記錄數(25)
			
		// $page->lastSuffix=false;
		$page->setConfig ( 'header', '<li class="rows">共<b>%TOTAL_ROW%</b>條記錄    第<b>%NOW_PAGE%</b>頁/共<b>%TOTAL_PAGE%</b>頁</li>' );
		$page->setConfig ( 'prev', '上一頁' );
		$page->setConfig ( 'next', '下一頁' );
		$page->setConfig ( 'last', '末頁' );
		$page->setConfig ( 'first', '首頁' );
		$page->setConfig ( 'theme', '%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%' );
		;
	
		$show = $page->show (); // 分頁顯示輸出
		// 進行分頁數據查詢 注意limit方法的參數要使用Page類的屬性
		$list = $User->where ( array (
				'user' => $_SESSION['uname'] ,
				'leixin' => 'zsbygq'
	
		) )->order ( 'id DESC' )->limit ( $page->firstRow . ',' . $page->listRows )->select ();
		$this->assign ( 'list', $list ); // 賦值數據集
		$this->assign ( 'page', $show ); // 賦值分頁輸出
	
	
	
	
	
	
	
		$userData = M ( 'user' )->where ( array (
				'UE_ID' => $_SESSION ['uid']
		) )->find ();
		$this->userData = $userData;
	
		$this->display ( 'zsbyg_dd' );
	}
	
	public function zsb_xy_dd() {
	
	
	
	
	
	
	
	
		$User = M ( 'zsbyg_dd' ); // 實例化User對象
		$count = $User->where ( array (
				'user' => $_SESSION['uname'] ,
				'leixin' => 'zsbxyq'
		) )->count (); // 查詢滿足要求的總記錄數
		$page = new \Think\Page ( $count, 60 ); // 實例化分頁類 傳入總記錄數和每頁顯示的記錄數(25)
			
		// $page->lastSuffix=false;
		$page->setConfig ( 'header', '<li class="rows">共<b>%TOTAL_ROW%</b>條記錄    第<b>%NOW_PAGE%</b>頁/共<b>%TOTAL_PAGE%</b>頁</li>' );
		$page->setConfig ( 'prev', '上一頁' );
		$page->setConfig ( 'next', '下一頁' );
		$page->setConfig ( 'last', '末頁' );
		$page->setConfig ( 'first', '首頁' );
		$page->setConfig ( 'theme', '%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%' );
		;
	
		$show = $page->show (); // 分頁顯示輸出
		// 進行分頁數據查詢 注意limit方法的參數要使用Page類的屬性
		$list = $User->where ( array (
				'user' => $_SESSION['uname'] ,
				'leixin' => 'zsbxyq'
	
		) )->order ( 'id DESC' )->limit ( $page->firstRow . ',' . $page->listRows )->select ();
		$this->assign ( 'list', $list ); // 賦值數據集
		$this->assign ( 'page', $show ); // 賦值分頁輸出
	
	
	
	
	
	
	
		$userData = M ( 'user' )->where ( array (
				'UE_ID' => $_SESSION ['uid']
		) )->find ();
		$this->userData = $userData;
	
		$this->display ( 'zsb_xy_dd' );
	}
	
	public function stsj() {
	
		$userData = M ( 'user' )->where ( array (
				'UE_ID' => $_SESSION ['uid']
		) )->find ();
		$this->userData = $userData;
	
		$this->display ( 'stsj' );
	}
	
	public function sjsq() {
	
		$userData = M ( 'user' )->where ( array (
				'UE_ID' => $_SESSION ['uid']
		) )->find ();
		$this->userData = $userData;
	
		$this->display ( 'sjsq' );
	}
	
	public function zsb_xy_add() {
	
		$userData = M ( 'user' )->where ( array (
				'UE_ID' => $_SESSION ['uid']
		) )->find ();
		$this->userData = $userData;
	
		$this->display ( 'zsb_xy_add' );
	}
	
	public function zsbyg() {
	
		$userData = M ( 'user' )->where ( array (
				'UE_ID' => $_SESSION ['uid']
		) )->find ();
		$this->userData = $userData;
	
		$this->display ( 'zsbyg' );
	}
	
	
	public function sjsqcl() {
	
		$data['sjmc']=I('post.sjmc');
		$data['jyxm']=I('post.jyxm');
		$data['lxfs']=I('post.lxfs');
		$data['dz']=I('post.dz');
		$data['slt']=I('post.face180');
		$data['content']=I('post.content');
		$data['user']=$_SESSION['uname'];
		$data['date']=date ( 'Y-m-d H:i:s', time () );
		$data['leixin']='jbzgq';
		
		if(M('shopsj')->add($data)){
			$this->success('申請成功！');
		}else{
			$this->success('申請失敗！');
		}
	//$this->success('成功！');
	
	}
	
	
	
	public function zsbygcl() {
	
		$data['sjmc']=I('post.sjmc');
		$data['jyxm']=I('post.jyxm');
		$data['lxfs']=I('post.lxfs');
		$data['dz']='暫未開獎';
		$data['slt']=I('post.face180');
		$data['content']=I('post.content');
		$data['user']=$_SESSION['uname'];
		$data['date']=date ( 'Y-m-d H:i:s', time () );
		$data['leixin']='zsbygq';
	
		if(M('shopsj')->add($data)){
			$this->success('申請成功！');
		}else{
			$this->success('申請失敗！');
		}
		//$this->success('成功！');
	
	}
	
	
	
	
	
	public function zsbxycl() {
	
		$data['sjmc']=I('post.sjmc');
		$data['jyxm']=I('post.jyxm');
		$data['lxfs']=I('post.lxfs');
		$data['dz']=I('post.dz');
		$data['slt']=I('post.face180');
		$data['content']=I('post.content');
		$data['user']=$_SESSION['uname'];
		$data['date']=date ( 'Y-m-d H:i:s', time () );
		$data['leixin']='zsbxyq';
	
		if(M('shopsj')->add($data)){
			$this->success('申請成功！');
		}else{
			$this->success('申請失敗！');
		}
		//$this->success('成功！');
	
	}
	
	
	
	public function zsbyg_ljgm() {
	
		
		$caution = M ( 'shopsj' )->where ( array (
				'id'=> I('post.id') ,
				'leixin' => 'zsbygq' ,
				'zt' => 1
		) )->find ();
		//echo I('post.gmfs')*$caution['jyxm'];die;
		$user =M('user')->where(array('UE_account'=>$_SESSION['uname']))->find();
		
		if(!$caution){$this->error('不可操作!');die;}
		
		if($caution['lxfs']=='0'){
			$this->error('產品可購份數不足!');
		}elseif(! preg_match ( '/^[0-9]{1,100}$/', I('post.gmfs') )){
			$this->error('購買份數輸入有誤!');
		}elseif($caution['lxfs']<I('post.gmfs')){
			$this->error('產品可購份數不足!');
		}elseif($user['zsbhe']<I('post.gmfs')*$caution['jyxm']){
			$this->error('餘額不足,不可購買!');
		}elseif(I('post.sj')==''){
			$this->error('手機不能為空!');
		}elseif(I('post.shr')==''){
			$this->error('收貨人不能為空!');
		}elseif(I('post.shdz')==''){
			$this->error('收貨地址不能為空!');
		}
		
		
		M('user')->where(array('UE_account'=>$_SESSION['uname']))-> setDec('zsbhe',I('post.gmfs')*$caution['jyxm']);
		 M ( 'shopsj' )->where ( array (
				'id'=> I('post.id') ,
				'leixin' => 'zsbygq' ,
				'zt' => 1
		) )->setDec('lxfs',I('post.gmfs'));
		
		$user = M ('user' )->where ( array ('UE_account' => $_SESSION ['uname'] ) )->find ();
		$note1="鑽石雲購區購買費用";
		$record1["UG_account"]	= $_SESSION ['uname'];
		$record1["UG_type"]  	= 'zsb';
		$record1["zsb"] 	= '-'.(I('post.gmfs')*$caution['jyxm']); //金幣
		//$record1["UG_allGet"]	= '1500'; //推薦獎金總的
		$record1["zsbhe"]	= $user['zsbhe']; //當前推薦人的金幣餘額
		$record1["UG_dataType"]	= 'zsbygq'; //當前開單人的金幣餘額
		$record1["UG_note"]		= $note1; //推薦獎說明
		$record1["UG_getTime"]		= date ( 'Y-m-d H:i:s', time () ); //操作時間
		$reg1 = M ( 'userget' )->add ( $record1 );
		
		
		
		$data['uid']=I('post.id');
		
		$data['user']=$_SESSION['uname'];
		$data['gmfs']=I('post.gmfs');
		$data['sj']=I('post.sj');
		$data['shr']=I('post.shr');
		$data['shdz']=I('post.shdz');
		$data['date']=date ( 'Y-m-d H:i:s', time () );
		$data['leixin']='zsbygq';
		
		$data['cpmc']=$caution['sjmc'];
		$data['sfzj']=0;
		$data['sffh']=0;
	
		if(M('zsbyg_dd')->add($data)){
			$this->success('購買成功！');
		}else{
			$this->success('購買失敗！');
		}
		//$this->success('成功！');
	
	}
	
	
	
	public function zsb_xy_bm() {
	
	
		$caution = M ( 'shopsj' )->where ( array (
				'id'=> I('post.id') ,
				'leixin' => 'zsbxyq' ,
				'zt' => 1
		) )->find ();
		//echo I('post.gmfs')*$caution['jyxm'];die;
		$user =M('user')->where(array('UE_account'=>$_SESSION['uname']))->find();
	
		if(!$caution){$this->error('不可操作!');die;}
	
		if($caution['lxfs']=='0'){
			$this->error('報名名額不足!');
		}elseif($caution['lxfs']<1){
			$this->error('報名名額不足!');
		}elseif($user['zsbhe']<$caution['jyxm']){
			$this->error('餘額不足,不可報名!');
		}elseif(I('post.sj')==''){
			$this->error('手機不能為空!');
		}elseif(I('post.shr')==''){
			$this->error('收貨人不能為空!');
		}elseif(I('post.shdz')==''){
			$this->error('收貨地址不能為空!');
		}
	
	
		M('user')->where(array('UE_account'=>$_SESSION['uname']))-> setDec('zsbhe',$caution['jyxm']);
		M ( 'shopsj' )->where ( array (
		'id'=> I('post.id') ,
		'leixin' => 'zsbygq' ,
		'zt' => 1
		) )->setDec('lxfs',1);
	
		$user = M ('user' )->where ( array ('UE_account' => $_SESSION ['uname'] ) )->find ();
		$note1="鑽石幸運區報名費用";
		$record1["UG_account"]	= $_SESSION ['uname'];
		$record1["UG_type"]  	= 'zsb';
		$record1["zsb"] 	= '-'.$caution['jyxm']; //金幣
		//$record1["UG_allGet"]	= '1500'; //推薦獎金總的
		$record1["zsbhe"]	= $user['zsbhe']; //當前推薦人的金幣餘額
		$record1["UG_dataType"]	= 'zsbxyq'; //當前開單人的金幣餘額
		$record1["UG_note"]		= $note1; //推薦獎說明
		$record1["UG_getTime"]		= date ( 'Y-m-d H:i:s', time () ); //操作時間
		$reg1 = M ( 'userget' )->add ( $record1 );
	
	
	
		$data['uid']=I('post.id');
	
		$data['user']=$_SESSION['uname'];
		$data['gmfs']=$caution['user'];
		$data['sj']=I('post.sj');
		$data['shr']=I('post.shr');
		$data['shdz']=I('post.shdz');
		$data['date']=date ( 'Y-m-d H:i:s', time () );
		$data['leixin']='zsbxyq';
	
		$data['cpmc']=$caution['sjmc'];
		$data['sfzj']=0;
		$data['sffh']=0;
	
		if(M('zsbyg_dd')->add($data)){
			$this->success('報名成功！');
		}else{
			$this->success('報名失敗！');
		}
		//$this->success('成功！');
	
	}
	
	
	public function sjsqclxg() {
	
		$data['sjmc']=I('post.sjmc');
		$data['jyxm']=I('post.jyxm');
		$data['lxfs']=I('post.lxfs');
		$data['dz']=I('post.dz');
		$data['slt']=I('post.face180');
		$data['content']=I('post.content');
		$data['user']=$_SESSION['uname'];
		$data['zt']='0';
		$data['date']=date ( 'Y-m-d H:i:s', time () );
		$data['leixin']='jbzgq';
	
		if(M('shopsj')->where(array('id'=>I('post.id'),'user'=>$_SESSION['uname']))->save($data)){
			$this->success('修改成功！');
		}else{
			$this->success('修改失敗！');
		}
		//$this->success('成功！');
	
	}
	
	public function sjsqclxg2() {
	
		$data['sjmc']=I('post.sjmc');
		$data['jyxm']=I('post.jyxm');
		$data['lxfs']=I('post.lxfs');

		$data['slt']=I('post.face180');
		$data['content']=I('post.content');
		$data['user']=$_SESSION['uname'];
		$data['zt']='0';
		$data['date']=date ( 'Y-m-d H:i:s', time () );
		$data['leixin']='zsbygq';
	
		if(M('shopsj')->where(array('id'=>I('post.id'),'user'=>$_SESSION['uname']))->save($data)){
			$this->success('修改成功！');
		}else{
			$this->success('修改失敗！');
		}
		//$this->success('成功！');
	
	}
	
	
	
	
	public function zsb_xy_xg_cl() {
	
		$data['sjmc']=I('post.sjmc');
		$data['jyxm']=I('post.jyxm');
		$data['lxfs']=I('post.lxfs');
		$data['dz']=I('post.dz');
		$data['slt']=I('post.face180');
		$data['content']=I('post.content');
		$data['user']=$_SESSION['uname'];
		$data['zt']='0';
		$data['date']=date ( 'Y-m-d H:i:s', time () );
		$data['leixin']='zsbxyq';
	
		if(M('shopsj')->where(array('id'=>I('post.id'),'user'=>$_SESSION['uname']))->save($data)){
			$this->success('修改成功！');
		}else{
			$this->success('修改失敗！');
		}
		//$this->success('成功！');
	
	}
	
	
	
	
	public function dzp() {
		
		header ( "Content-Type:text/html; charset=utf-8" );
		$User = M ( 'userget' ); // 實例化User對象
		$date1 = I ( 'post.date1', '', '/^(?:(?!0000)[0-9]{4}-(?:(?:0[1-9]|1[0-2])-(?:0[1-9]|1[0-9]|2[0-8])|(?:0[13-9]|1[0-2])-(?:29|30)|(?:0[13578]|1[02])-31)|(?:[0-9]{2}(?:0[48]|[2468][048]|[13579][26])|(?:0[48]|[2468][048]|[13579][26])00)-02-29)$/' );
		$date2 = I ( 'post.date2', '', '/^(?:(?!0000)[0-9]{4}-(?:(?:0[1-9]|1[0-2])-(?:0[1-9]|1[0-9]|2[0-8])|(?:0[13-9]|1[0-2])-(?:29|30)|(?:0[13578]|1[02])-31)|(?:[0-9]{2}(?:0[48]|[2468][048]|[13579][26])|(?:0[48]|[2468][048]|[13579][26])00)-02-29)$/' );
		$map ['UG_account'] = $_SESSION ['uname'];
		$map ['UG_type'] = 'jb';
		$map ['UG_dataType'] = 'xyzpjj';
		//$map ['UG_dataType'] = array('IN',array('mrfh','tjj','kdj','mrldj','glj'));
		
		if (! empty ( $date1 ) && ! empty ( $date2 )) {
			$map ['UG_getTime'] = array (
					array (
							'gt',
							$date1
					),
					array (
							'lt',
							$date2
					),
					'and'
			);
		}
		$count = $User->where ( $map )->count (); // 查詢滿足要求的總記錄數
		$page = new \Think\Page ( $count, 10 ); // 實例化分頁類 傳入總記錄數和每頁顯示的記錄數(25)
		
		// $page->lastSuffix=false;
		$page->setConfig ( 'header', '<li class="rows">共<b>%TOTAL_ROW%</b>條記錄    第<b>%NOW_PAGE%</b>頁/共<b>%TOTAL_PAGE%</b>頁</li>' );
		$page->setConfig ( 'prev', '上一頁' );
		$page->setConfig ( 'next', '下一頁' );
		$page->setConfig ( 'last', '末頁' );
		$page->setConfig ( 'first', '首頁' );
		$page->setConfig ( 'theme', '%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%' );
		;
		
		$show = $page->show (); // 分頁顯示輸出
		// 進行分頁數據查詢 注意limit方法的參數要使用Page類的屬性
		$list = $User->where ( $map )->order ( 'UG_ID DESC' )->limit ( $page->firstRow . ',' . $page->listRows )->select ();
		$this->assign ( 'list', $list ); // 賦值數據集
		$this->assign ( 'page', $show ); // 賦值分頁輸出
		
		
		
		
	
		$userData = M ( 'user' )->where ( array (
				'UE_ID' => $_SESSION ['uid']
		) )->find ();
		$this->userData = $userData;
	
		$this->display ( 'dzp' );
	}

	public function dzpcl() {
		$user=M('user');
		$userxx=$user->where(array('UE_account'=>$_SESSION ['uname']))->find();
		if($userxx['ue_money']>=5){
		$prize_arr = array(
				'0' => array('id'=>1,'jj'=>88,'min'=>1,'max'=>29,'prize'=>'一等奖','v'=>0.1),
				'1' => array('id'=>2,'jj'=>18,'min'=>302,'max'=>328,'prize'=>'二等奖','v'=>0.5),
				'2' => array('id'=>3,'jj'=>8,'min'=>242,'max'=>268,'prize'=>'三等奖','v'=>2),
				'3' => array('id'=>4,'jj'=>5.8,'min'=>182,'max'=>208,'prize'=>'四等奖','v'=>35),
				'4' => array('id'=>5,'jj'=>3.8,'min'=>122,'max'=>148,'prize'=>'五等奖','v'=>30),
				'5' => array('id'=>6,'jj'=>2.8,'min'=>62,'max'=>88,'prize'=>'六等奖','v'=>32.4),
				'6' => array('id'=>7,'jj'=>1.8,'min'=>array(32,92,152,212,272,332),
						'max'=>array(58,118,178,238,298,358),'prize'=>'七等奖','v'=>0)
		);
		
		
		
		foreach ($prize_arr as $key => $val) {
			$arr[$val['id']] = $val['v'];
		}
		
		$rid = getRand($arr); //根据概率获取奖项id 
		
		$res = $prize_arr[$rid-1]; //中奖项
		$min = $res['min'];
		$max = $res['max'];
		if($res['id']==7){ //七等奖
			$i = mt_rand(0,5);
			$result['angle'] = mt_rand($min[$i],$max[$i]);
		}else{
			$result['angle'] = mt_rand($min,$max); //随机生成一个角度
		}
		$result['prize'] = $res['prize'];
		
		
		
		
		
		
		$user->where(array('UE_account'=>$_SESSION ['uname']))->setDec('UE_money',5);
		$userxx=$user->where(array('UE_account'=>$_SESSION ['uname']))->find();
		
		$note4 = "幸運轉盤扣費";
		$record4 ["UG_account"] = $_SESSION ['uname']; // 登入轉出賬戶
		$record4 ["UG_type"] = 'jb';
		$record4 ["UG_money"] = '-5'; // 金幣
		$record4 ["UG_allGet"] = '-5'; //
		$record4 ["UG_balance"] = $userxx['ue_money']; // 當前推薦人的金幣餘額
		$record4 ["UG_dataType"] = 'xyzpkk'; // 金幣轉出
		$record4 ["UG_note"] = $note4; // 推薦獎說明
		$record4["UG_getTime"]		= date ( 'Y-m-d H:i:s', time () ); //操作時間
		$reg5 = M ( 'userget' )->add ( $record4 );
		
		
		$user->where(array('UE_account'=>$_SESSION ['uname']))->setInc('UE_money',$res['jj']);
		$userxx=$user->where(array('UE_account'=>$_SESSION ['uname']))->find();
		
		$note4 = "幸運轉盤中".$res['prize'];
		$record4 ["UG_account"] = $_SESSION ['uname']; // 登入轉出賬戶
		$record4 ["UG_type"] = 'jb';
		$record4 ["UG_money"] = $res['jj']; // 金幣
		$record4 ["UG_allGet"] = $res['jj']; //
		$record4 ["UG_balance"] = $userxx['ue_money']; // 當前推薦人的金幣餘額
		$record4 ["UG_dataType"] = 'xyzpjj'; // 金幣轉出
		$record4 ["UG_note"] = $note4; // 推薦獎說明
		$record4["UG_getTime"]		= date ( 'Y-m-d H:i:s', time () ); //操作時間
		$reg5 = M ( 'userget' )->add ( $record4 );
		
		
		
		
		
		
		echo json_encode($result);
		
		}else{
			$result['prize'] = 'yebz';
			echo json_encode($result);
		}
		
		
		
	}
	
}