<?php

namespace Home\Controller;

use Think\Controller;

class ActivationController extends CommonController {
	// 首頁
	public function index() {
		$this->userjihuo = I('get.user');
		$userData = M ( 'user' )->where ( array (
				'UE_ID' => $_SESSION ['uid'] 
		) )->find ();
		$this->userData = $userData;
		$this->display ( 'jhzh' );
	}
	public function jihuo() {
		if (IS_AJAX) {
			$data_P = I ( 'post.' );
			//當前賬號信息
			$user = M ( 'user' )->where ( array ('UE_account' => $_SESSION ['uname'] ) )->find ();
			$user1 = M ();
			// dump(I ( 'post.yzm' ));die;
			// 
			if (false) {
				$this->ajaxReturn ( array (
						'nr' => '驗證碼錯誤!',
						'sf' => 0 
				) );
			} elseif (! preg_match ( '/^[a-zA-Z0-9]{6,12}$/', $data_P ['wjbhname'] )) {
				$this->ajaxReturn ( array (
						'nr' => '玩家用戶名格式不對!',
						'sf' => 0 
				) );
			} elseif (! preg_match ( '/^[a-zA-Z0-9]{6,12}$/', $data_P ['bdzxname'] )) {
				$this->ajaxReturn ( array (
						'nr' => '報單中心用戶名格式不對!',
						'sf' => 0 
				) );
			} elseif ($user [ue_money] < 1500) {
				$this->ajaxReturn ( array (
						'nr' => '餘額不足!',
						'sf' => 0 
				) );
			} else {
				//要激活賬號信息
				$wjbhname = M ( 'user' )->where ( array ('UE_account' => $data_P ['wjbhname'] ) )->find ();
				//報單中心信息
				$bdzxname = M ( 'user' )->where ( array ('UE_account' => $data_P ['bdzxname'] ) )->find ();
				//報單中心許可權
				$bdzx_rs = M ( 'user' )->where ( array ('UE_accName' => $data_P ['bdzxname'],'UE_Faccount'=>'0','UE_check'=>'1','UE_stop'=>'1' ) )->count("UE_ID");
				//dump($bdzx_rs)
				//echo ($bdzx_rs);die;
				if (! $wjbhname) {
					$this->ajaxReturn ( array (
							'nr' => '需激活用戶不存在或已激活!',
							'sf' => 0 
					) );
				} elseif ($wjbhname ['ue_check'] == 1) {
					$this->ajaxReturn ( array (
							'nr' => '用戶名已經激活過了!',
							'sf' => 0 
					) );
				} elseif (! $bdzxname) {
					$this->ajaxReturn ( array (
							'nr' => '報單中心不存在!',
							'sf' => 0 
					) );
				} elseif ($bdzx_rs < 10) {
					$this->ajaxReturn ( array (
							'nr' => '報單人資格不夠!',
							'sf' => 0 
					) );
				} elseif (! $user1->autoCheckToken ( $_POST )) {
					$this->ajaxReturn ( array (
							'nr' => '重複提交,請刷新頁面!',
							'sf' => 0 
					) );
				} else {
					//寫入數據開始
					$date_dq = date ( 'Y-m-d H:i:s', time () );
					$reg10 = M('user')->where(array ('UE_account' => $_SESSION ['uname'] ) )->setDec('UE_money',1500);
					$user = M ( 'user' )->where ( array ('UE_account' => $_SESSION ['uname'] ) )->find ();
					$note1="為新用戶".$wjbhname ['ue_account']."報單成功";
					$record1["UG_account"]	= $_SESSION ['uname'];
					$record1["UG_type"]  	= '推薦費用';
					$record1["UG_money"] 	= '1500'; //金幣
					$record1["UG_allGet"]	= '1500'; //推薦獎金總的
					$record1["UG_balance"]	= $user['ue_money']; //當前推薦人的金幣餘額
					$record1["UG_dataType"]	= 'tjfy'; //當前開單人的金幣餘額
					$record1["UG_note"]		= $note1; //推薦獎說明
					$record1["UG_getTime"]		= $date_dq; //操作時間
					$reg1 = M ( 'userget' )->add ( $record1 );
					
					$reg11 = M('user')->where(array ('UE_account' => $bdzxname ['ue_account'] ) )->setInc('UE_money',50);
					$bdzxname = M ( 'user' )->where ( array ('UE_account' => $data_P ['bdzxname'] ) )->find ();
					
					$note2="新用戶".$wjbhname ['ue_account']."報單獎";
					$record["UG_account"]	= $bdzxname ['ue_account'];
					$record["UG_type"]  	= '報單獎';
					$record["UG_integral"] 	= 0;//種子幣
					$record["UG_money"] 	= 50; //金幣
					$record["UG_allGet"]	= 50; //推薦獎金總的
					$record["UG_balance"]	= $bdzxname ['ue_money']; 
					$record["UG_dataType"]	= 'kdj'; 
					$record["UG_note"]	= $note2;
					$record["UG_othraccount"]= $wjbhname ['ue_account']; //推薦獎說明
					$record["UG_getTime"]		= $date_dq; //操作時間
					$reg2 = M ( 'userget' )->add ( $record );
					
				//	
					
					$reg13 = M('user')->where(array ('UE_account' => $wjbhname ['ue_accname'] ) )->setInc('UE_money',200);
					//更新推薦人信息
					$accName = M ( 'user' )->where ( array ('UE_account' => $wjbhname ['ue_accname']) )->find ();
					
					$note3="推薦新用戶".$wjbhname ['ue_account']."獎";
					$record3["UG_account"]	= $accName ['ue_account'];
					$record3["UG_type"]  	= '推薦獎金';
					$record3["UG_integral"] = '0';
					$record3["UG_money"] 	= '200'; 
					$record3["UG_allGet"]	= '200'; 
					$record3["UG_balance"]	= $accName['ue_money']; 
					$record3["UG_dataType"]	= 'tjj'; 
					$record3["UG_note"]	= $note3; 
					$record3["UG_othraccount"]		= $wjbhname ['ue_account']; 
					$record3["UG_getTime"]		= $date_dq; //操作時間
					//dump($record3);die;
					$reg3 = M ( 'userget' )->add ( $record3 );
					
					$accName1 = M ( 'user' )->where ( array ('UE_account' => $wjbhname ['ue_account']) )->find ();
					
					$accName = $accName1['ue_accname'];
					
					for($i = 1; $i < 10; $i ++) {
						//當前用戶信息
						$accName = M ( 'user' )->where ( array ('UE_account' => $accName) )->find ();
					if ($accName ['ue_accname'] == "") {break;}//當前用戶沒有上級推薦人時跳出
						//當前用戶的推薦人餘額加10
					
						M('user')->where(array ('UE_account' => $accName ['ue_accname'] ) )->setInc('UE_money',10);
						$accName = M ( 'user' )->where ( array ('UE_account' => $accName ['ue_accname']) )->find ();
						
							$note_2="新用戶".$data_P ['wjbhname']."激活管理獎";
			                $record_2["UG_account"]	= $accName ['ue_account'];
			                $record_2["UG_type"]  	= '管理獎';
			                $record_2["UG_money"] 	= '10'; //金幣
			                $record_2["UG_allGet"]	= '10'; //推薦獎金總的
			                $record_2["UG_balance"]	= $accName['ue_money']; //當前推薦人的金幣餘額
			                $record_2["UG_dataType"]	= 'glj'; //當前開單人的金幣餘額
			                $record_2["UG_note"]		= $note_2; //推薦獎說明
			                $record_2["UG_getTime"]		= $date_dq; //操作時間
						//dump($record3);die;
						    M ( 'userget' )->add ( $record_2 );
						    $accName = $accName ['ue_account'];
						
					}
					$reg14=M('user')->where(array('UE_account'=>$data_P ['wjbhname']))->save(array('UE_check'=>'1','UE_activeTime'=>$date_dq));
					
					if($reg10 && $reg1 && $reg2 && $reg3 && $reg11 && $reg13 && $reg14){
					$this->ajaxReturn ( '激活成功!' );
					}else{
						$this->ajaxReturn ( array (
								'nr' => '激活失敗!',
								'sf' => 0
						) );
					}
				}
			}
		}
	}
}