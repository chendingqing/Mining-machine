<?php

namespace Home\Controller;

use Think\Controller;

class TradingController extends CommonController {
	
	public function zsbhc() {
		
		$userData = M ( 'user' )->where ( array (
				'UE_ID' => $_SESSION ['uid']
		) )->find ();
		$this->userData = $userData;
		
		$this->display ( 'zsbhc' );
	}
	

	// 首頁
	public function jbmc() {
		$User = M ( 'userjyinfo' ); // 實例化User對象
		
		$map ['UJ_usercount'] = $_SESSION ['uname'];
		$map ['UJ_dataType'] = 'mcjb';
		
		
		
		
		$count = $User->where ( $map )->count (); // 查詢滿足要求的總記錄數
		//dump($var)
		$page = new \Think\Page ( $count, 12 ); // 實例化分頁類 傳入總記錄數和每頁顯示的記錄數(25)
		
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
		$list = $User->where ( $map )->order ( 'UJ_ID DESC' )->limit ( $page->firstRow . ',' . $page->listRows )->select ();
		//dump($list);die;
		foreach($list as & $val){
			$val['uj_note'] = explode("#",$val['uj_note']);
		}
		
		$this->assign ( 'list', $list ); // 賦值數據集
		$this->assign ( 'page', $show ); // 賦值分頁輸出
		
		
		//收款方式
		$map1 ['UI_userID'] = $_SESSION ['uid'];
		
		$User1=M('userinfo');
		
		
		$count1 = $User1->where ( $map1 )->count (); // 查詢滿足要求的總記錄數
		//dump($var)
		$page = new \Think\Page ( $count1, 10 ); // 實例化分頁類 傳入總記錄數和每頁顯示的記錄數(25)
		
		// $page->lastSuffix=false;
		$page->setConfig ( 'header', '<li class="rows">共<b>%TOTAL_ROW%</b>條記錄    第<b>%NOW_PAGE%</b>頁/共<b>%TOTAL_PAGE%</b>頁</li>' );
		$page->setConfig ( 'prev', '上一頁' );
		$page->setConfig ( 'next', '下一頁' );
		$page->setConfig ( 'last', '末頁' );
		$page->setConfig ( 'first', '首頁' );
		$page->setConfig ( 'theme', '%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%' );
		;
		
		$show1 = $page->show (); // 分頁顯示輸出
		// 進行分頁數據查詢 注意limit方法的參數要使用Page類的屬性
		$list1 = $User1->where ( $map1 )->order ( 'UI_ID DESC' )->limit ( $page->firstRow . ',' . $page->listRows )->select ();
		//dump($list);die;
		
		$this->assign ( 'list1', $list1 ); // 賦值數據集
		$this->assign ( 'page1', $show1 ); // 賦值分頁輸出
		//收款方式
		
		$userData = M ( 'user' )->where ( array (
				'UE_ID' => $_SESSION ['uid']
		) )->find ();
		$this->userData = $userData;
		$this->sxf = 0.1;
		$this->display ( 'jbmc' );
	}
	
	
	
	public function dbmc() {
		$User = M ( 'userjyinfo' ); // 實例化User對象
	
		$map ['UJ_usercount'] = $_SESSION ['uname'];
		$map ['UJ_dataType'] = 'mcjb';
	
	
	
	
		$count = $User->where ( $map )->count (); // 查詢滿足要求的總記錄數
		//dump($var)
		$page = new \Think\Page ( $count, 12 ); // 實例化分頁類 傳入總記錄數和每頁顯示的記錄數(25)
	
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
		$list = $User->where ( $map )->order ( 'UJ_ID DESC' )->limit ( $page->firstRow . ',' . $page->listRows )->select ();
		//dump($list);die;
		foreach($list as & $val){
			$val['uj_note'] = explode("#",$val['uj_note']);
		}
	
		$this->assign ( 'list', $list ); // 賦值數據集
		$this->assign ( 'page', $show ); // 賦值分頁輸出
	
	
		//收款方式
		$map1 ['UI_userID'] = $_SESSION ['uid'];
	
		$User1=M('userinfo');
	
	
		$count1 = $User1->where ( $map1 )->count (); // 查詢滿足要求的總記錄數
		//dump($var)
		$page = new \Think\Page ( $count1, 10 ); // 實例化分頁類 傳入總記錄數和每頁顯示的記錄數(25)
	
		// $page->lastSuffix=false;
		$page->setConfig ( 'header', '<li class="rows">共<b>%TOTAL_ROW%</b>條記錄    第<b>%NOW_PAGE%</b>頁/共<b>%TOTAL_PAGE%</b>頁</li>' );
		$page->setConfig ( 'prev', '上一頁' );
		$page->setConfig ( 'next', '下一頁' );
		$page->setConfig ( 'last', '末頁' );
		$page->setConfig ( 'first', '首頁' );
		$page->setConfig ( 'theme', '%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%' );
		;
	
		$show1 = $page->show (); // 分頁顯示輸出
		// 進行分頁數據查詢 注意limit方法的參數要使用Page類的屬性
		$list1 = $User1->where ( $map1 )->order ( 'UI_ID DESC' )->limit ( $page->firstRow . ',' . $page->listRows )->select ();
		//dump($list);die;
	
		$this->assign ( 'list1', $list1 ); // 賦值數據集
		$this->assign ( 'page1', $show1 ); // 賦值分頁輸出
		//收款方式
	
		$userData = M ( 'user' )->where ( array (
				'UE_ID' => $_SESSION ['uid']
		) )->find ();
		$this->userData = $userData;
		$this->sxf = 0.1;
		$this->display ( 'dbmc' );
	}
	
	
	
	
	public function jbmcqx() {
		if (!preg_match ( '/^[0-9]{1,10}$/', I ('get.id') )) {
			$this->success('非法操作,將凍結賬號!');
		}else{
			$userinfo = M ( 'message' )->where ( array ('MA_ID' => I ('get.id')) )->find ();
			//dump(I ('get.id'));
			//dump($userinfo['ue_accname']);die;
			if ($userinfo['ma_username']<>$_SESSION ['uname']) {
				$this->success('非法操作,將凍結賬號!');
			}else{
				$reg = M ( 'message' )->where(array ('MA_ID' => I ('get.id')))->delete();
				if ($reg) {
					$this->success('刪除成功!');
				}else {
					$this->success('刪除失敗!');
				}
			}
		}
	}
	public function jbmccl() {
	
		if (IS_AJAX) {
			$data_P = I ( 'post.' );
			//dump($data_P);die;
			//$this->ajaxReturn($data_P['ymm']);die;
			$user = M ( 'user' )->where ( array (
					UE_account => $_SESSION ['uname'] 
			) )->find ();
			$otconfig = M ( 'system' )->where ( array (
					'SYS_ID' => 1
			) )->find ();
			$user1 = M ();
			//! $this->check_verify ( I ( 'post.yzm' ) )
			//! $user1->autoCheckToken ( $_POST )
			//dump($data_P['lxfs']);die;
			$zkbsl = $data_P ['mcsl'] +$data_P ['mcsl'] *$otconfig['a_sxf'];
			if (! $this->check_verify ( I ( 'post.yzm' ) )) {
				$this->ajaxReturn ( array ('nr' => '驗證碼錯誤!','sf' => 0 ) );
			}elseif (! preg_match ( '/^[0-9.]{3,10}$/', $data_P ['mcsl'] )) {
				$this->ajaxReturn ( array ('nr' => '賣出金額必須是大於500,並且是100倍數!','sf' => 0 ) );
			}elseif ($data_P ['mcsl']  <500 ) {
				$this->ajaxReturn ( array ('nr' => '賣出金額必須是大於500,並且是100倍數!','sf' => 0 ) );
			}elseif ($data_P ['mcsl'] % 100 > 0 ||$data_P ['mcsl']=='') {
				$this->ajaxReturn ( array ('nr' => '賣出金額必須是大於500,並且是100倍數!','sf' => 0 ) );
			}elseif (strlen($data_P['note']) > 90) {
				$this->ajaxReturn ( array ('nr' => '收款方式格式錯誤!','sf' => 0 ) );
			}elseif (strlen($data_P['lxfs']) < 2 ||strlen($data_P['lxfs']) > 90) {
				$this->ajaxReturn ( array ('nr' => '聯繫方式格式錯誤!','sf' => 0 ) );
			} elseif ($data_P['note'] == '0' ) {
				$this->ajaxReturn ( array ('nr' => '請選擇收款方式!','sf' => 0 ) );
			} elseif ($user [ue_money] < $zkbsl) {
				$this->ajaxReturn ( array ('nr' => '餘額不足,共需要'.$zkbsl.',賣出數量+手續費10%!','sf' => 0 ) );
			}elseif ($user ['ue_answer'] != $data_P ['ejmm'] ) {
				//$this->error ( '二級密碼錯誤' );
				$this->ajaxReturn ( array ('nr' => '密保錯誤!','sf' => 0 ) );
			}elseif (! $user1->autoCheckToken ( $_POST )) {
				$this->ajaxReturn ( array ('nr' => '新勿重複提交,請刷新頁面!','sf' => 0 ) );
			} else {
	
	               
				$record["UJ_usercount"]	    = $_SESSION ['uname'];//登入的賬戶
				$record["UJ_payaccount"]	= $_SESSION ['uname'];//轉出賬戶
				$record["UJ_JBcount"] 	    = $data_P ['mcsl'];	//賣出的數量
				$record["UJ_note"]	        = $data_P['note'];     //收款賬戶信息
				$record["lxfs"]	        = $data_P['lxfs'];     //收款賬戶信息
				$record["UJ_style"]	        = '賣出';      //類型
				$record["UJ_balance"]	    = $user [ue_money]-$data_P ['mcsl'];      //餘額
				$record["UJ_mymsg"]         = 0;
				$record["UJ_dataType"]      = 'mcjb';
				$record ["UJ_time"] = date ( 'Y-m-d H:i:s', time () );
				$reg = M ( 'userjyinfo' )->add ( $record );

				$note2="出售金幣".$data_P ['mcsl']."個，提交成功";
				$record2["UG_account"]	= $_SESSION ['uname'];
				$record2["UG_type"]  	= 'jb';
				$record2["UG_money"] 	= $data_P ['mcsl']-$data_P ['mcsl']*2; //金幣
				$record2["UG_allGet"]	= $data_P ['mcsl']-$data_P ['mcsl']*2; //推薦獎金總的
				$record2["UG_balance"]	= $user [ue_money]-$data_P ['mcsl']; //當前推薦人的金幣餘額
				$record2["UG_dataType"]	= 'jbmc'; //當前開單人的金幣餘額
				$record2["UG_note"]		= $note2; //推薦獎說
				$record2["UG_getTime"]		= date ( 'Y-m-d H:i:s', time () ); //操作時間
				$reg2 = M ( 'userget' )->add ( $record2 );
				$note1="出售金幣".$data_P ['mcsl']."個，提交成功,扣除".$data_P ['mcsl']*$otconfig['a_sxf']."個金幣當手續費";
				$record1["UG_account"]	= $_SESSION ['uname'];
				$record1["UG_type"]  	= 'jb';
				$record1["UG_money"] 	= ($data_P ['mcsl'] *$otconfig['a_sxf'])-($data_P ['mcsl'] *$otconfig['a_sxf'])*2; //金幣
				$record1["UG_allGet"]	= ($data_P ['mcsl'] *$otconfig['a_sxf'])-($data_P ['mcsl'] *$otconfig['a_sxf'])*2; //推薦獎金總的
				$record1["UG_balance"]	= $user [ue_money]-$zkbsl; //當前推薦人的金幣餘額
				$record1["UG_dataType"]	= 'sxf'; //當前開單人的金幣餘額
				$record1["UG_note"]		= $note1; //推薦獎說明
				$record1["UG_getTime"]		= date ( 'Y-m-d H:i:s', time () );
				$reg1 = M ( 'userget' )->add ( $record1 );
				
				$reg3 = M('user')->where(array ('UE_account' => $_SESSION ['uname'] ) )->setDec('UE_money',$zkbsl);
	
	
 				if ($reg && $reg1 && $reg2 && $reg3) {
 					$this->ajaxReturn ( '金幣賣出成功!' );
 				} else {
 					$this->ajaxReturn ( '金幣賣出失敗!' );
 				}
	
			}
		}
	}
	
	
	
	
	
	public function dbmccl() {
	
		if (IS_AJAX) {
			$data_P = I ( 'post.' );
			//dump($data_P);die;
			//$this->ajaxReturn($data_P['ymm']);die;
			$user = M ( 'user' )->where ( array (
					UE_account => $_SESSION ['uname']
			) )->find ();
			$otconfig = M ( 'system' )->where ( array (
					'SYS_ID' => 1
			) )->find ();
			$user1 = M ();
			//! $this->check_verify ( I ( 'post.yzm' ) )
			//! $user1->autoCheckToken ( $_POST )
			//dump($data_P['dfzh']);die;
			if ($data_P ['leixin']==0) {
				
			
			$zkbsl = $data_P ['mcsl'] ;
			if (! $this->check_verify ( I ( 'post.yzm' ) )) {
				$this->ajaxReturn ( array ('nr' => '驗證碼錯誤!','sf' => 0 ) );
			}elseif (! preg_match ( '/^[0-9.]{3,10}$/', $data_P ['mcsl'] )) {
				$this->ajaxReturn ( array ('nr' => '金額必須是大於500,並且是500倍數!','sf' => 0 ) );
			}elseif ($_SESSION ['uname'] == $data_P ['dfzh']) {
				$this->ajaxReturn ( array ('nr' => '對方賬號不能填寫自己!','sf' => 0 ) );
			} elseif (! preg_match ( '/^[a-zA-Z0-9]{6,12}$/', $data_P ['dfzh'] )) {
				//$this->error ( '用戶名格式不對' );
				$this->ajaxReturn ( array ('nr' => '用戶名格式不對!','sf' => 0 ) );
			}elseif ($data_P ['mcsl'] % 100 > 0 ||$data_P ['mcsl']=='') {
				$this->ajaxReturn ( array ('nr' => '金額必須是大於100,並且是100倍數!','sf' => 0 ) );
			}elseif (strlen($data_P['note']) > 90) {
				$this->ajaxReturn ( array ('nr' => '收款方式格式錯誤!','sf' => 0 ) );
			}elseif (strlen($data_P['lxfs']) < 2 ||strlen($data_P['lxfs']) > 90) {
				$this->ajaxReturn ( array ('nr' => '聯繫方式格式錯誤!','sf' => 0 ) );
			} elseif ($data_P['note'] == '0' ) {
				$this->ajaxReturn ( array ('nr' => '請選擇收款方式!','sf' => 0 ) );
			} elseif ($user [ue_money] < $zkbsl) {
				$this->ajaxReturn ( array ('nr' => '餘額不足,共需要'.$zkbsl.'!','sf' => 0 ) );
			}elseif ($user ['ue_answer'] !=  $data_P ['ejmm']) {
				//$this->error ( '二級密碼錯誤' );
				$this->ajaxReturn ( array ('nr' => '密保錯誤!','sf' => 0 ) );
			}elseif (! $user1->autoCheckToken ( $_POST )) {
				$this->ajaxReturn ( array ('nr' => '新勿重複提交,請刷新頁面!','sf' => 0 ) );
			} else {
				$addaccount = M ( 'user' )->where ( array (
						UE_account => $data_P ['dfzh']
				) )->find ();
				
				if (! $addaccount) {
					//$this->error ( '收款人不存在' );
					$this->ajaxReturn ( array ('nr' => '對方不存在!','sf' => 0 ) );
				} else {
	
				$record["UJ_usercount"]	    = $_SESSION ['uname'];//登入的賬戶
				$record["UJ_payaccount"]	= $_SESSION ['uname'];//轉出賬戶
				$record["UJ_addaccount"]	= $data_P ['dfzh'];//轉出賬戶
				$record["UJ_JBcount"] 	    = $data_P ['mcsl'];	//賣出的數量
				$record["UJ_note"]	        = $data_P['note'];     //收款賬戶信息
				$record["lxfs"]	        = $data_P['lxfs'];     //收款賬戶信息
				$record["UJ_style"]	        = 'jb';      //類型
				$record["UJ_balance"]	    = $user [ue_money]-$data_P ['mcsl'];      //餘額
				$record["UJ_mymsg"]         = 0;
				$record["UJ_dataType"]      = 'dbjy';
				$record ["UJ_time"] = date ( 'Y-m-d H:i:s', time () );
				$reg = M ( 'userjyinfo' )->add ( $record );
	
				$note2="擔保交易金幣".$data_P ['mcsl']."個，提交成功";
				$record2["UG_account"]	= $_SESSION ['uname'];
				$record2["UG_type"]  	= 'jb';
				$record2["UG_money"] 	= $data_P ['mcsl']-$data_P ['mcsl']*2; //金幣
				$record2["UG_allGet"]	= $data_P ['mcsl']-$data_P ['mcsl']*2; //推薦獎金總的
				$record2["UG_balance"]	= $user [ue_money]-$data_P ['mcsl']; //當前推薦人的金幣餘額
				$record2["UG_dataType"]	= 'dbjy'; //當前開單人的金幣餘額
				$record2["UG_note"]		= $note2; //推薦獎說
				$record2["UG_getTime"]		= date ( 'Y-m-d H:i:s', time () ); //操作時間
				$reg2 = M ( 'userget' )->add ( $record2 );
				
	
				$reg3 = M('user')->where(array ('UE_account' => $_SESSION ['uname'] ) )->setDec('UE_money',$zkbsl);
	
	
				if ($reg && $reg2 && $reg3) {
					$this->ajaxReturn ( '發起擔保交易成功!' );
				} else {
					$this->ajaxReturn ( '發起擔保交易失敗!' );
				}
				}
			}
			}elseif($data_P ['leixin']==1){
				

				$zkbsl = $data_P ['mcsl'] ;
				if (! $this->check_verify ( I ( 'post.yzm' ) )) {
					$this->ajaxReturn ( array ('nr' => '驗證碼錯誤!','sf' => 0 ) );
				}elseif (! preg_match ( '/^[0-9.]{3,10}$/', $data_P ['mcsl'] )) {
					$this->ajaxReturn ( array ('nr' => '金額必須是大於500,並且是500倍數!','sf' => 0 ) );
				}elseif ($_SESSION ['uname'] == $data_P ['dfzh']) {
					$this->ajaxReturn ( array ('nr' => '對方賬號不能填寫自己!','sf' => 0 ) );
				} elseif (! preg_match ( '/^[a-zA-Z0-9]{6,12}$/', $data_P ['dfzh'] )) {
					//$this->error ( '用戶名格式不對' );
					$this->ajaxReturn ( array ('nr' => '用戶名格式不對!','sf' => 0 ) );
				}elseif ($data_P ['mcsl'] % 100 > 0 ||$data_P ['mcsl']=='') {
					$this->ajaxReturn ( array ('nr' => '金額必須是大於100,並且是100倍數!','sf' => 0 ) );
				}elseif (strlen($data_P['note']) > 90) {
					$this->ajaxReturn ( array ('nr' => '收款方式格式錯誤!','sf' => 0 ) );
				}elseif (strlen($data_P['lxfs']) < 2 ||strlen($data_P['lxfs']) > 90) {
					$this->ajaxReturn ( array ('nr' => '聯繫方式格式錯誤!','sf' => 0 ) );
				} elseif ($data_P['note'] == '0' ) {
					$this->ajaxReturn ( array ('nr' => '請選擇收款方式!','sf' => 0 ) );
				} elseif ($user [zsbhe] < $zkbsl) {
					$this->ajaxReturn ( array ('nr' => '餘額不足,共需要'.$zkbsl.'!','sf' => 0 ) );
				}elseif ($user ['ue_answer'] !=  $data_P ['ejmm'] ) {
					//$this->error ( '二級密碼錯誤' );
					$this->ajaxReturn ( array ('nr' => '密保錯誤!','sf' => 0 ) );
				}elseif (! $user1->autoCheckToken ( $_POST )) {
					$this->ajaxReturn ( array ('nr' => '新勿重複提交,請刷新頁面!','sf' => 0 ) );
				} else {
					$addaccount = M ( 'user' )->where ( array (
							UE_account => $data_P ['dfzh']
					) )->find ();
				
					if (! $addaccount) {
						//$this->error ( '收款人不存在' );
						$this->ajaxReturn ( array ('nr' => '對方不存在!','sf' => 0 ) );
					} else {
				
						$record["UJ_usercount"]	    = $_SESSION ['uname'];//登入的賬戶
						$record["UJ_payaccount"]	= $_SESSION ['uname'];//轉出賬戶
						$record["UJ_addaccount"]	= $data_P ['dfzh'];//轉出賬戶
						$record["UJ_JBcount"] 	    = $data_P ['mcsl'];	//賣出的數量
						$record["UJ_note"]	        = $data_P['note'];     //收款賬戶信息
						$record["lxfs"]	        = $data_P['lxfs'];     //收款賬戶信息
						$record["UJ_style"]	        = 'zsb';      //類型
						$record["UJ_balance"]	    = $user ['zsbhe']-$data_P ['mcsl'];      //餘額
						$record["UJ_mymsg"]         = 0;
						$record["UJ_dataType"]      = 'dbjy';
						$record ["UJ_time"] = date ( 'Y-m-d H:i:s', time () );
						$reg = M ( 'userjyinfo' )->add ( $record );
				
						$note2="擔保交易鑽石幣".$data_P ['mcsl']."個，提交成功";
						$record2["UG_account"]	= $_SESSION ['uname'];
						$record2["UG_type"]  	= 'zsb';
						$record2["zsb"] 	= $data_P ['mcsl']-$data_P ['mcsl']*2; //金幣
						$record2["zsb1"]	= $data_P ['mcsl']-$data_P ['mcsl']*2; //推薦獎金總的
						$record2["zsbhe"]	= $user ['zsbhe']-$data_P ['mcsl']; //當前推薦人的金幣餘額
						$record2["UG_dataType"]	= 'dbjy'; //當前開單人的金幣餘額
						$record2["UG_note"]		= $note2; //推薦獎說
						$record2["UG_getTime"]		= date ( 'Y-m-d H:i:s', time () ); //操作時間
						$reg2 = M ( 'userget' )->add ( $record2 );
				
				
						$reg3 = M('user')->where(array ('UE_account' => $_SESSION ['uname'] ) )->setDec('zsbhe',$zkbsl);
				
				
						if ($reg && $reg2 && $reg3) {
							$this->ajaxReturn ( '發起擔保交易成功!' );
						} else {
							$this->ajaxReturn ( '發起擔保交易失敗!' );
						}
					}
				}
				
				
				
				
			}
		}
	}
	
	public function mcjl() {
		$User = M ( 'userjyinfo' ); // 實例化User對象
		
		$map ['UJ_usercount'] = $_SESSION ['uname'];
		$map ['UJ_dataType'] = 'mcjb';
		
		
		
		
		$count = $User->where ( $map )->count (); // 查詢滿足要求的總記錄數
		//dump($var)
		$page = new \Think\Page ( $count, 12 ); // 實例化分頁類 傳入總記錄數和每頁顯示的記錄數(25)
		
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
		$list = $User->where ( $map )->order ( 'UJ_ID DESC' )->limit ( $page->firstRow . ',' . $page->listRows )->select ();
		//dump($list);die;
		foreach($list as & $val){
			$val['uj_note'] = explode("#",$val['uj_note']);
		}
		
		$this->assign ( 'list', $list ); // 賦值數據集
		$this->assign ( 'page', $show ); // 賦值分頁輸出
	    $this->otconfig = M ( 'system' )->where ( array (
					'SYS_ID' => 1
			) )->find ();
		$this->display ( 'mcjl' );
	}
	
	
	
	public function dbmcjl() {
		$User = M ( 'userjyinfo' ); // 實例化User對象
	
		$map ['UJ_usercount'] = $_SESSION ['uname'];
		$map ['UJ_dataType'] = 'dbjy';
	
	
	
	
		$count = $User->where ( $map )->count (); // 查詢滿足要求的總記錄數
		//dump($var)
		$page = new \Think\Page ( $count, 12 ); // 實例化分頁類 傳入總記錄數和每頁顯示的記錄數(25)
	
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
		$list = $User->where ( $map )->order ( 'UJ_ID DESC' )->limit ( $page->firstRow . ',' . $page->listRows )->select ();
		//dump($list);die;
		foreach($list as & $val){
			$val['uj_note'] = explode("#",$val['uj_note']);
		}
	
		$this->assign ( 'list', $list ); // 賦值數據集
		$this->assign ( 'page', $show ); // 賦值分頁輸出
		$this->otconfig = M ( 'system' )->where ( array (
				'SYS_ID' => 1
		) )->find ();
		$this->display ( 'dbmcjl' );
	}
	
	
	
	public function mrjl() {
		$User = M ( 'userjyinfo' ); // 實例化User對象
	
		$map ['UJ_addaccount'] = $_SESSION ['uname'];
		$map ['UJ_dataType'] = 'mcjb';
	
	
	
	
		$count = $User->where ( $map )->count (); // 查詢滿足要求的總記錄數
		//dump($var)
		$page = new \Think\Page ( $count, 12 ); // 實例化分頁類 傳入總記錄數和每頁顯示的記錄數(25)
	
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
		$list = $User->where ( $map )->order ( 'UJ_ID DESC' )->limit ( $page->firstRow . ',' . $page->listRows )->select ();
		//dump($list);die;
		foreach($list as & $val){
			$val['uj_note'] = explode("#",$val['uj_note']);
		}
	
		$this->assign ( 'list', $list ); // 賦值數據集
		$this->assign ( 'page', $show ); // 賦值分頁輸出
		$this->otconfig = M ( 'system' )->where ( array (
				'SYS_ID' => 1
		) )->find ();
		$this->display ( 'mrjl' );
	}
	
	
	public function dbmrjl() {
		$User = M ( 'userjyinfo' ); // 實例化User對象
	
		$map ['UJ_addaccount'] = $_SESSION ['uname'];
		$map ['UJ_dataType'] = 'dbjy';
	
	
	
	
		$count = $User->where ( $map )->count (); // 查詢滿足要求的總記錄數
		//dump($var)
		$page = new \Think\Page ( $count, 12 ); // 實例化分頁類 傳入總記錄數和每頁顯示的記錄數(25)
	
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
		$list = $User->where ( $map )->order ( 'UJ_ID DESC' )->limit ( $page->firstRow . ',' . $page->listRows )->select ();
		//dump($list);die;
		foreach($list as & $val){
			$val['uj_note'] = explode("#",$val['uj_note']);
		}
	
		$this->assign ( 'list', $list ); // 賦值數據集
		$this->assign ( 'page', $show ); // 賦值分頁輸出
		$this->otconfig = M ( 'system' )->where ( array (
				'SYS_ID' => 1
		) )->find ();
		$this->display ( 'dbmrjl' );
	}
	
	public function jydt() {
		$User = M ( 'userjyinfo' ); // 實例化User對象
	
		$map ['UJ_jbmcStage'] = 0;
		$map ['UJ_dataType'] = 'mcjb';
	
	
	
	
		$count = $User->where ( $map )->count (); // 查詢滿足要求的總記錄數
		//dump($var)
		$page = new \Think\Page ( $count, 12 ); // 實例化分頁類 傳入總記錄數和每頁顯示的記錄數(25)
	
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
		$list = $User->where ( $map )->order ( 'UJ_ID DESC' )->limit ( $page->firstRow . ',' . $page->listRows )->select ();
		//dump($list);die;
		foreach($list as & $val){
			$val['uj_note'] = explode("#",$val['uj_note']);
		}
	
		$this->assign ( 'list', $list ); // 賦值數據集
		$this->assign ( 'page', $show ); // 賦值分頁輸出
		$this->otconfig = M ( 'system' )->where ( array (
				'SYS_ID' => 1
		) )->find ();
		$this->display ( 'jydt' );
	}
	
	
	public function mcjlcl() {
		if (!preg_match ( '/^[0-9]{1,10}$/', I ('get.id') )) {
			$this->success('非法操作,將凍結賬號!');
		}else{
			$userinfo = M ( 'userjyinfo' )->where ( array ('UJ_ID' => I ('get.id')) )->find ();
			//dump(I ('get.id'));
			//dump($userinfo['ue_accname']);die;
			if ($userinfo['uj_usercount']<>$_SESSION ['uname']) {
				$this->success('非法操作,將凍結賬號!');
			}else{
				$this->otconfig = M ( 'system' )->where ( array (
						'SYS_ID' => 1
				) )->find ();
				$reg = M ( 'userjyinfo' )->where(array ('UJ_ID' => I ('get.id')) )->find ();
				$reg['uj_note'] = explode("#",$reg['uj_note']);
				$this->reg =$reg;
				//dump(M ( 'userjyinfo' )->where(array ('UJ_ID' => I ('get.id')) )->find());die;
				$this->display ( 'mcjlcl' );
			}
		}
	}
	
	
	public function dbmcjlcl() {
		if (!preg_match ( '/^[0-9]{1,10}$/', I ('get.id') )) {
			$this->success('非法操作,將凍結賬號!');
		}else{
			$userinfo = M ( 'userjyinfo' )->where ( array ('UJ_ID' => I ('get.id')) )->find ();
			//dump(I ('get.id'));
			//dump($userinfo['ue_accname']);die;
			if ($userinfo['uj_usercount']<>$_SESSION ['uname']) {
				$this->success('非法操作,將凍結賬號!');
			}else{
				$this->otconfig = M ( 'system' )->where ( array (
						'SYS_ID' => 1
				) )->find ();
				$reg = M ( 'userjyinfo' )->where(array ('UJ_ID' => I ('get.id')) )->find ();
				$reg['uj_note'] = explode("#",$reg['uj_note']);
				$this->reg =$reg;
				//dump(M ( 'userjyinfo' )->where(array ('UJ_ID' => I ('get.id')) )->find());die;
				$this->display ( 'dbmcjlcl' );
			}
		}
	}
	
	
	public function mrjlcl() {
		if (!preg_match ( '/^[0-9]{1,10}$/', I ('get.id') )) {
			$this->success('非法操作,將凍結賬號!');
		}else{
			$userinfo = M ( 'userjyinfo' )->where ( array ('UJ_ID' => I ('get.id')) )->find ();
			//dump(I ('get.id'));
			if ($userinfo['uj_jbmcstage']==0) {
			//dump($userinfo['ue_accname']);die;
			if ($userinfo['uj_addaccount']<>'') {
				$this->success('訂單已被搶購!');
			}elseif($userinfo['uj_jbmcstage']<>0){
				$this->success('訂單已被搶購!');
			}else{
				$this->otconfig = M ( 'system' )->where ( array (
						'SYS_ID' => 1
				) )->find ();
				$reg = M ( 'userjyinfo' )->where(array ('UJ_ID' => I ('get.id')) )->find ();
				$reg['uj_note'] = explode("#",$reg['uj_note']);
				$this->reg =$reg;
				//dump(M ( 'userjyinfo' )->where(array ('UJ_ID' => I ('get.id')) )->find());die;
				$this->display ( 'mrjlcl' );
			}
		}else{
			
			if ($userinfo['uj_addaccount']<>$_SESSION ['uname']) {
				$this->success('非法操作,將凍結賬號!');
			}else{
				$this->otconfig = M ( 'system' )->where ( array (
						'SYS_ID' => 1
				) )->find ();
				$reg = M ( 'userjyinfo' )->where(array ('UJ_ID' => I ('get.id')) )->find ();
				$reg['uj_note'] = explode("#",$reg['uj_note']);
				$this->reg =$reg;
				//dump(M ( 'userjyinfo' )->where(array ('UJ_ID' => I ('get.id')) )->find());die;
				$this->display ( 'mrjlcl' );
			}
			
		}
		}
	}
	
	
	public function dbmrjlcl() {
		if (!preg_match ( '/^[0-9]{1,10}$/', I ('get.id') )) {
			$this->success('非法操作,將凍結賬號!');
		}else{
			$userinfo = M ( 'userjyinfo' )->where ( array ('UJ_ID' => I ('get.id')) )->find ();
			//dump(I ('get.id'));
			
					
				if ($userinfo['uj_addaccount']<>$_SESSION ['uname']) {
					$this->success('非法操作,將凍結賬號!');
				}else{
					$this->otconfig = M ( 'system' )->where ( array (
							'SYS_ID' => 1
					) )->find ();
					$reg = M ( 'userjyinfo' )->where(array ('UJ_ID' => I ('get.id')) )->find ();
					$reg['uj_note'] = explode("#",$reg['uj_note']);
					$this->reg =$reg;
					//dump(M ( 'userjyinfo' )->where(array ('UJ_ID' => I ('get.id')) )->find());die;
					$this->display ( 'dbmrjlcl' );
				}
					
			
		}
	}
	
	
	public function mc_qxjy() {
		if (!preg_match ( '/^[0-9]{1,10}$/', I ('get.id') )) {
			$this->success('非法操作,將凍結賬號!');
		}else{
			$userinfo = M ( 'userjyinfo' )->where ( array ('UJ_ID' => I ('get.id')) )->find ();
			//dump(I ('get.id'));
			//dump($userinfo['ue_accname']);die;
			if ($userinfo['uj_usercount']<>$_SESSION ['uname']) {
				$this->success('非法操作,將凍結賬號!');
			}elseif($userinfo['uj_jbmcstage']<>0){
				$this->success('當前訂單狀態不可取消!');
			}else{
				$reg1 = M ( 'userjyinfo' )->where(array ('UJ_ID' => I ('get.id')) )->save(array('UJ_jbmcStage'=>5));
				$reg2 = M('user')->where(array ('UE_account' => $userinfo['uj_usercount'] ) )->setInc('UE_money',$userinfo['uj_jbcount']);
				$dqname = M ( 'user' )->where ( array ('UE_account' => $_SESSION ['uname'] ) )->find ();
				
				$note2="取消賣出金幣，提交成功";
				$record2["UG_account"]	= $_SESSION ['uname'];
				$record2["UG_type"]  	= 'jb';
				$record2["UG_money"] 	= $userinfo['uj_jbcount']; //金幣
				$record2["UG_allGet"]	= $userinfo['uj_jbcount']; //推薦獎金總的
				$record2["UG_balance"]	= $dqname['ue_money']; //當前推薦人的金幣餘額
				$record2["UG_dataType"]	= 'jbmc'; //當前開單人的金幣餘額
				$record2["UG_note"]		= $note2; //推薦獎說
				$record2["UG_getTime"]		= date ( 'Y-m-d H:i:s', time () ); //操作時間
				$reg3 = M ( 'userget' )->add ( $record2 );
				
				if ($reg1 && $reg2 && $reg3 ) {
					$this->success( '取消賣出成功!' );
				} else {
					$this->success( '取消賣出失敗!' );
				}
			}
		}
		
		
	}
	
	
	public function dbmc_qxjy() {
		if (!preg_match ( '/^[0-9]{1,10}$/', I ('get.id') )) {
			$this->success('非法操作,將凍結賬號!');
		}else{
			$userinfo = M ( 'userjyinfo' )->where ( array ('UJ_ID' => I ('get.id')) )->find ();
			
			if($userinfo['uj_style']=='jb'){
			
			//dump(I ('get.id'));
			//dump($userinfo['ue_accname']);die;
			if ($userinfo['uj_usercount']<>$_SESSION ['uname']) {
				$this->success('非法操作,將凍結賬號!');
			}elseif($userinfo['uj_jbmcstage']<>0){
				$this->success('當前訂單狀態不可取消!');
			}else{
				$reg1 = M ( 'userjyinfo' )->where(array ('UJ_ID' => I ('get.id')) )->save(array('UJ_jbmcStage'=>5));
				$reg2 = M('user')->where(array ('UE_account' => $userinfo['uj_usercount'] ) )->setInc('UE_money',$userinfo['uj_jbcount']);
				$dqname = M ( 'user' )->where ( array ('UE_account' => $_SESSION ['uname'] ) )->find ();
	
				$note2="取消擔保交易，提交成功";
				$record2["UG_account"]	= $_SESSION ['uname'];
				$record2["UG_type"]  	= 'jb';
				$record2["UG_money"] 	= $userinfo['uj_jbcount']; //金幣
				$record2["UG_allGet"]	= $userinfo['uj_jbcount']; //推薦獎金總的
				$record2["UG_balance"]	= $dqname['ue_money']; //當前推薦人的金幣餘額
				$record2["UG_dataType"]	= 'dbjy'; //當前開單人的金幣餘額
				$record2["UG_note"]		= $note2; //推薦獎說
				$record2["UG_getTime"]		= date ( 'Y-m-d H:i:s', time () ); //操作時間
				$reg3 = M ( 'userget' )->add ( $record2 );
	
				if ($reg1 && $reg2 && $reg3 ) {
					$this->success( '取消擔保成功!' );
				} else {
					$this->success( '取消擔保失敗!' );
				}
			}
			
			}elseif($userinfo['uj_style']=='zsb'){
				
				if ($userinfo['uj_usercount']<>$_SESSION ['uname']) {
					$this->success('非法操作,將凍結賬號!');
				}elseif($userinfo['uj_jbmcstage']<>0){
					$this->success('當前訂單狀態不可取消!');
				}else{
					$reg1 = M ( 'userjyinfo' )->where(array ('UJ_ID' => I ('get.id')) )->save(array('UJ_jbmcStage'=>5));
					$reg2 = M('user')->where(array ('UE_account' => $userinfo['uj_usercount'] ) )->setInc('zsbhe',$userinfo['uj_jbcount']);
					$dqname = M ( 'user' )->where ( array ('UE_account' => $_SESSION ['uname'] ) )->find ();
				
					$note2="取消擔保交易，提交成功";
					$record2["UG_account"]	= $_SESSION ['uname'];
					$record2["UG_type"]  	= 'zsb';
					$record2["zsb"] 	= $userinfo['uj_jbcount']; //金幣
					$record2["zsb1"]	= $userinfo['uj_jbcount']; //推薦獎金總的
					$record2["zsbhe"]	= $dqname['zsbhe']; //當前推薦人的金幣餘額
					$record2["UG_dataType"]	= 'dbjy'; //當前開單人的金幣餘額
					$record2["UG_note"]		= $note2; //推薦獎說
					$record2["UG_getTime"]		= date ( 'Y-m-d H:i:s', time () ); //操作時間
					$reg3 = M ( 'userget' )->add ( $record2 );
				
					if ($reg1 && $reg2 && $reg3 ) {
						$this->success( '取消擔保成功!' );
					} else {
						$this->success( '取消擔保失敗!' );
					}
				}
			}
		}
	
	
	}
	
	
	
	public function mr_ljqg() {
		if (!preg_match ( '/^[0-9]{1,10}$/', I ('get.id') )) {
			$this->success('非法操作,將凍結賬號!');
		}else{
			$userinfo = M ( 'userjyinfo' )->where ( array ('UJ_ID' => I ('get.id')) )->find ();
			//dump(I ('get.id'));
			//dump($userinfo['ue_accname']);die;
			if ($userinfo['uj_usercount']==$_SESSION['uname']) {
				$this->success('您不能搶購自己的訂單!');
			}elseif($userinfo['uj_jbmcstage']<>0){
				$this->success('當前訂單狀態不可搶購!');
			}else{
				$reg1 = M ( 'userjyinfo' )->where(array ('UJ_ID' => I ('get.id')) )->save(array('UJ_jbmcStage'=>1,'UJ_addaccount'=>$_SESSION ['uname']));
				if ($reg1 ) {
					$this->success( '搶購成功,請立即去付款!' );
				} else {
					$this->success( '搶購失敗!' );
				}
			}
		}
	
	
	}
	
	
	
	public function dbmr_ljqg() {
		if (!preg_match ( '/^[0-9]{1,10}$/', I ('get.id') )) {
			$this->success('非法操作,將凍結賬號!');
		}else{
			$userinfo = M ( 'userjyinfo' )->where ( array ('UJ_ID' => I ('get.id')) )->find ();
			//dump(I ('get.id'));
			//dump($userinfo['ue_accname']);die;
			if ($userinfo['uj_addaccount']<>$_SESSION['uname']) {
				$this->success('非法操作!');
			}elseif($userinfo['uj_jbmcstage']<>0){
				$this->success('當前訂單狀態不可接受交易!');
			}else{
				$reg1 = M ( 'userjyinfo' )->where(array ('UJ_ID' => I ('get.id')) )->save(array('UJ_jbmcStage'=>1));
				if ($reg1 ) {
					$this->success( '接受交易成功,請立即去付款!' );
				} else {
					$this->success( '接受交易失敗!' );
				}
			}
		}
	
	
	}
	
	
	
	public function mr_qryfk() {
		if (!preg_match ( '/^[0-9]{1,10}$/', I ('get.id') )) {
			$this->success('非法操作,將凍結賬號!');
		}else{
			$userinfo = M ( 'userjyinfo' )->where ( array ('UJ_ID' => I ('get.id')) )->find ();
			//dump(I ('get.id'));
			//dump($userinfo['ue_accname']);die;
			if ($userinfo['uj_addaccount']<>$_SESSION['uname']) {
				$this->success('非法操作!');
			}elseif($userinfo['uj_jbmcstage']<>1){
				$this->success('當前訂單狀態不可付款!');
			}else{
				$reg1 = M ( 'userjyinfo' )->where(array ('UJ_ID' => I ('get.id')) )->save(array('UJ_jbmcStage'=>3));
				if ($reg1 ) {
					$this->success( '確認付款成功!' );
				} else {
					$this->success( '確認付款失敗!' );
				}
			}
		}
	
	
	}
	
	
	public function dbmr_qryfk() {
		if (!preg_match ( '/^[0-9]{1,10}$/', I ('get.id') )) {
			$this->success('非法操作,將凍結賬號!');
		}else{
			$userinfo = M ( 'userjyinfo' )->where ( array ('UJ_ID' => I ('get.id')) )->find ();
			//dump(I ('get.id'));
			//dump($userinfo['ue_accname']);die;
			if ($userinfo['uj_addaccount']<>$_SESSION['uname']) {
				$this->success('非法操作!');
			}elseif($userinfo['uj_jbmcstage']<>1){
				$this->success('當前訂單狀態不可付款!');
			}else{
				$reg1 = M ( 'userjyinfo' )->where(array ('UJ_ID' => I ('get.id')) )->save(array('UJ_jbmcStage'=>3));
				if ($reg1 ) {
					$this->success( '確認付款成功!' );
				} else {
					$this->success( '確認付款失敗!' );
				}
			}
		}
	
	
	}
	
	
	public function mc_qrsk() {
		if (!preg_match ( '/^[0-9]{1,10}$/', I ('get.id') )) {
			$this->success('非法操作,將凍結賬號!');
		}else{
			$userinfo = M ( 'userjyinfo' )->where ( array ('UJ_ID' => I ('get.id')) )->find ();
			//dump(I ('get.id'));
			//dump($userinfo['ue_accname']);die;
			if ($userinfo['uj_usercount']<>$_SESSION ['uname']) {
				$this->success('非法操作,將凍結賬號!');
			}elseif($userinfo['uj_jbmcstage']<>3){
				$this->success('當前訂單狀態不可確認收款!');
			}else{
				$reg1 = M ( 'userjyinfo' )->where(array ('UJ_ID' => I ('get.id')) )->save(array('UJ_jbmcStage'=>4));
				$reg2 = M('user')->where(array ('UE_account' => $userinfo['uj_addaccount'] ) )->setInc('UE_money',$userinfo['uj_jbcount']);
				$dqname = M ( 'user' )->where ( array ('UE_account' => $userinfo['uj_addaccount'] ) )->find ();
	
				$note2="搶購金幣成功,賣家已確認收款!";
				$record2["UG_account"]	= $userinfo['uj_addaccount'];
				$record2["UG_type"]  	= 'jb';
				$record2["UG_money"] 	= $userinfo['uj_jbcount']; //金幣
				$record2["UG_allGet"]	= $userinfo['uj_jbcount']; //推薦獎金總的
				$record2["UG_balance"]	= $dqname['ue_money']; //當前推薦人的金幣餘額
				$record2["UG_dataType"]	= 'jbmc'; //當前開單人的金幣餘額
				$record2["UG_note"]		= $note2; //推薦獎說
				$record2["UG_getTime"]		= date ( 'Y-m-d H:i:s', time () ); //操作時間
				$reg3 = M ( 'userget' )->add ( $record2 );
	
				if ($reg1 && $reg2 && $reg3 ) {
					$this->success( '確認收款成功!' );
				} else {
					$this->success( '確認收款失敗!' );
				}
			}
		}
	
	
	}
	
	
	public function dbmc_qrsk() {
		if (!preg_match ( '/^[0-9]{1,10}$/', I ('get.id') )) {
			$this->success('非法操作,將凍結賬號!');
		}else{
			$userinfo = M ( 'userjyinfo' )->where ( array ('UJ_ID' => I ('get.id')) )->find ();
			
			if($userinfo['uj_style']=='jb'){
			////
			//dump(I ('get.id'));
			//dump($userinfo['ue_accname']);die;
			if ($userinfo['uj_usercount']<>$_SESSION ['uname']) {
				$this->success('非法操作,將凍結賬號!');
			}elseif($userinfo['uj_jbmcstage']<>3){
				$this->success('當前訂單狀態不可確認收款!');
			}else{
				$reg1 = M ( 'userjyinfo' )->where(array ('UJ_ID' => I ('get.id')) )->save(array('UJ_jbmcStage'=>4));
				$reg2 = M('user')->where(array ('UE_account' => $userinfo['uj_addaccount'] ) )->setInc('UE_money',$userinfo['uj_jbcount']);
				$dqname = M ( 'user' )->where ( array ('UE_account' => $userinfo['uj_addaccount'] ) )->find ();
	
				$note2="擔保交易成功,賣家已確認收款!";
				$record2["UG_account"]	= $userinfo['uj_addaccount'];
				$record2["UG_type"]  	= 'jb';
				$record2["UG_money"] 	= $userinfo['uj_jbcount']; //金幣
				$record2["UG_allGet"]	= $userinfo['uj_jbcount']; //推薦獎金總的
				$record2["UG_balance"]	= $dqname['ue_money']; //當前推薦人的金幣餘額
				$record2["UG_dataType"]	= 'dbjy'; //當前開單人的金幣餘額
				$record2["UG_note"]		= $note2; //推薦獎說
				$record2["UG_getTime"]		= date ( 'Y-m-d H:i:s', time () ); //操作時間
				$reg3 = M ( 'userget' )->add ( $record2 );
	
				if ($reg1 && $reg2 && $reg3 ) {
					$this->success( '確認收款成功!' );
				} else {
					$this->success( '確認收款失敗!' );
				}
			}
		}elseif($userinfo['uj_style']=='zsb'){
			
			if ($userinfo['uj_usercount']<>$_SESSION ['uname']) {
				$this->success('非法操作,將凍結賬號!');
			}elseif($userinfo['uj_jbmcstage']<>3){
				$this->success('當前訂單狀態不可確認收款!');
			}else{
				$reg1 = M ( 'userjyinfo' )->where(array ('UJ_ID' => I ('get.id')) )->save(array('UJ_jbmcStage'=>4));
				$reg2 = M('user')->where(array ('UE_account' => $userinfo['uj_addaccount'] ) )->setInc('zsbhe',$userinfo['uj_jbcount']);
				$dqname = M ( 'user' )->where ( array ('UE_account' => $userinfo['uj_addaccount'] ) )->find ();
			
				$note2="擔保交易成功,賣家已確認收款!";
				$record2["UG_account"]	= $userinfo['uj_addaccount'];
				$record2["UG_type"]  	= 'zsb';
				$record2["zsb"] 	= $userinfo['uj_jbcount']; //金幣
				$record2["zsb1"]	= $userinfo['uj_jbcount']; //推薦獎金總的
				$record2["zsbhe"]	= $dqname['zsbhe']; //當前推薦人的金幣餘額
				$record2["UG_dataType"]	= 'dbjy'; //當前開單人的金幣餘額
				$record2["UG_note"]		= $note2; //推薦獎說
				$record2["UG_getTime"]		= date ( 'Y-m-d H:i:s', time () ); //操作時間
				$reg3 = M ( 'userget' )->add ( $record2 );
			
				if ($reg1 && $reg2 && $reg3 ) {
					$this->success( '確認收款成功!' );
				} else {
					$this->success( '確認收款失敗!' );
				}
			}
			
		}
		}
	
	}
	
	
	public function zsbhccl() {
		if (IS_AJAX) {
			
				$data_P = I ( 'post.' );
				//dump($data_P);die;
				$user = M ( 'user' )->where ( array (
						UE_account => $_SESSION ['uname']
				) )->find ();
				$user1 = M ();
				//! $this->check_verify ( I ( 'post.yzm' ) )
				//! $user1->autoCheckToken ( $_POST )
				$kkkuan=$data_P ['zchb'];
				
				if (! $this->check_verify ( I ( 'post.yzm' ) )) {
					//$this->error ( '驗證碼錯誤' );
					$this->ajaxReturn ( array ('nr' => '驗證碼錯誤!','sf' => 0 ) );
				} elseif (! preg_match ( '/^[0-9]{1,10}$/', $data_P ['zchb'] )) {
					//$this->error ( '轉賬金額必須100的倍數' );
					$this->ajaxReturn ( array ('nr' => '合成金額必須10的倍數!','sf' => 0 ) );
				} elseif ($data_P ['zchb'] % 10 > 0) {
					//$this->error ( '轉賬金額必須100的倍數' );
					$this->ajaxReturn ( array ('nr' => '合成金額必須10的倍數!','sf' => 0 ) );
				} elseif ($user ['ue_money'] < $kkkuan||$user ['ybhe']<$kkkuan) {
					//$this->error ( '餘額不足' );
					$this->ajaxReturn ( array ('nr' => '餘額不足!','sf' => 0 ) );
				} elseif (! preg_match ( '/^[a-zA-Z0-9.]{1,15}$/', $data_P ['ejmm'] )) {
					//$this->error ( '密碼格式不對' );
					$this->ajaxReturn ( array ('nr' => '密碼格式不對!','sf' => 0 ) );
				} elseif ($user ['ue_secpwd'] != md5 ( $data_P ['ejmm'] )) {
					//$this->error ( '二級密碼錯誤' );
					$this->ajaxReturn ( array ('nr' => '二級密碼錯誤!','sf' => 0 ) );
				} elseif (false) {
					//$this->error ( '非法操作!', U ( 'jbzz' ) );
					$this->ajaxReturn ( array ('nr' => '請勿重複提交,請刷新頁面!','sf' => 0 ) );
				} else {
					
	
					$reg = M('user')->where(array ('UE_account' => $_SESSION['uname'] ) )->setDec('UE_money',$data_P ['zchb']);
					$reg1 = M('user')->where(array ('UE_account' => $_SESSION['uname'] ) )->setDec('ybhe',$data_P ['zchb']);
					$reg2 = M('user')->where(array ('UE_account' => $_SESSION['uname'] ) )->setInc('zsbhe',$data_P ['zchb']);
					$useranme = M('user')->where(array ('UE_account' => $_SESSION['uname'] ) )->find();
				
					$date_dq = date ( 'Y-m-d H:i:s', time () );
						$note3 = "鑽石幣合成";
						$record3 ["UG_account"] = $_SESSION['uname']; // 登入轉出賬戶
						$record3 ["UG_type"] = 'zsb';
						$record3 ["zsb"] = $data_P ['zchb']; // 金幣
						$record3 ["zsb1"] = $data_P ['zchb']; //
						$record3 ["zsbhe"] = $useranme['zsbhe']; // 當前推薦人的金幣餘額
						$record3 ["UG_dataType"] = 'jbhc'; // 金幣轉出
						$record3 ["UG_note"] = $note3; // 推薦獎說明
						$record3["UG_getTime"]		= $date_dq; //操作時間
						$reg4 = M ( 'userget' )->add ( $record3 );
							
						$note4 = "鑽石幣合成";
						$record4 ["UG_account"] = $_SESSION ['uname']; // 登入轉出賬戶
						$record4 ["UG_type"] = 'jb';
						$record4 ["UG_money"] = $data_P ['zchb']-$data_P ['zchb']*2; // 金幣
						$record4 ["UG_allGet"] = $data_P ['zchb']; //
						$record4 ["UG_balance"] = $useranme['ue_money']; // 當前推薦人的金幣餘額
						$record4 ["UG_dataType"] = 'jbhc'; // 金幣轉出
						$record4 ["UG_note"] = $note4; // 推薦獎說明
						$record4["UG_getTime"]		= $date_dq; //操作時間
						$reg5 = M ( 'userget' )->add ( $record4 );
						
						$note4 = "鑽石幣合成";
						$record4 ["UG_account"] = $_SESSION ['uname']; // 登入轉出賬戶
						$record4 ["UG_type"] = 'yb';
						$record4 ["yb"] = $data_P ['zchb']-$data_P ['zchb']*2; // 金幣
						$record4 ["yb1"] = $data_P ['zchb']; //
						$record4 ["ybhe"] = $useranme['ybhe']; // 當前推薦人的金幣餘額
						$record4 ["UG_dataType"] = 'jbhc'; // 金幣轉出
						$record4 ["UG_note"] = $note4; // 推薦獎說明
						$record4["UG_getTime"]		= $date_dq; //操作時間
						$reg6 = M ( 'userget' )->add ( $record4 );
						
						
							
						if ($reg && $reg1 && $reg2 && $reg4 && $reg5) {
							$this->ajaxReturn ( array ('nr' => '合成成功!','sf' => 0 ) );
						} else {
							$this->ajaxReturn ( array ('nr' => '合成失敗!','sf' => 0 ) );
						}
					
				}
			
		}
	}
	
	
	
}