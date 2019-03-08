<?php
function cate($var){ 
	//dump($var);
	$proall = M('user')->where(array('UE_accName'=>$var,'UE_Faccount'=>'0','UE_check'=>'1','UE_stop'=>'1'))->count("UE_ID");
 return $proall;
 } 
 
 
function sfjhff($r) {
 	$a = array("未激活", "已激活");
 	return $a[$r];
 }
 
 
	function getRand($proArr) {
 	$result = '';
 
 	//概率数组的总概率精度
 	$proSum = array_sum($proArr);
 
 	//概率数组循环
 	foreach ($proArr as $key => $proCur) {
 		$randNum = mt_rand(1, $proSum);
 		if ($randNum <= $proCur) {
 			$result = $key;
 			break;
 		} else {
 			$proSum -= $proCur;
 		}
 	}
 	unset ($proArr);
 
 	return $result;
 }
 
 
 function getpage($count, $pagesize = 10) {
 	$p = new Think\Page($count, $pagesize);
 	$p->setConfig('header', '<li class="rows">共<b>%TOTAL_ROW%</b>条记录&nbsp;第<b>%NOW_PAGE%</b>页/共<b>%TOTAL_PAGE%</b>页</li>');
 	$p->setConfig('prev', '上一页');
 	$p->setConfig('next', '下一页');
 	$p->setConfig('last', '末页');
 	$p->setConfig('first', '首页');
 	$p->setConfig('theme', '%FIRST%%UP_PAGE%%LINK_PAGE%%DOWN_PAGE%%END%%HEADER%');
 	$p->lastSuffix = false;//最后一页不显示为总页数
 	return $p;
 }
 
 function cx_user($var){
 	//dump($var);
 	$proall = M('user')->where(array('UE_account'=>$var))->find();
 	return $proall['ue_theme'];
 }
 
 
 
 function diffBetweenTwoDays ($day1, $day2)
 {
 	$second1 = strtotime($day1);
 	$second2 = strtotime($day2);
 
 	if ($second1 < $second2) {
 		$tmp = $second2;
 		$second2 = $second1;
 		$second1 = $tmp;
 	}
 	return ($second1 - $second2) / 86400;
 }
 
 
 function user_jj_lx($var){
 
 	$proall = M('user_jj')->where(array('id'=>$var))->find();
 
 	//date('Y-m-d H:i:s',$dayBegin);
 	$NowTime = $proall['date'];
 	$aab=strtotime($NowTime);
 	$NowTime=date('Y-m-d',$aab);
 	$NowTime2=date('Y-m-d',time());
 
 
 	$day1 = $NowTime;
 	$day2 = $NowTime2;
 	$diff = diffBetweenTwoDays($day1, $day2);
	// deleted by skyrim
 	// purpose: custom interest rate
 	// version: v8
 	// if($diff>30){
 	// 	$diff =30;
 	// }
 	// $diff = $diff/100;
	// deleted ends
	// added by skyrim
 	// purpose: custom interest rate
 	// version: v8
 	$settings = include( dirname( dirname( __FILE__ ) ) . '/Conf/settings.php' );
 	if($diff>$settings['knock_out_day_diff']){
 		$diff =$settings['knock_out_day_diff'];
 	}
	// added by skyrim
 	// purpose: custom interest rate
 	// version: v10.0
 	$ppddxx = M('ppdd')->where(array('id'=>	$proall['r_id']))->find();
 	$pay_order = M('tgbz')->where(array('id'=>$ppddxx['p_id']))->find();
 	$days = ( strtotime( date( 'Y-m-d', time() ) ) - strtotime( date( 'Y-m-d', strtotime( $pay_order['date'] ) ) ) ) / 3600 / 24;
	//$diff-=$days;
	// added ends
 	$diff = $diff*floatval($settings['in_queue_interest'])/100;
	// added ends
 	return $proall['jb']*$diff;
 
 }
 
 
 
 function user_jj_ts($var){
 
 	$proall = M('user_jj')->where(array('id'=>$var))->find();
 
 	//date('Y-m-d H:i:s',$dayBegin);
 	$NowTime = $proall['date'];
 	$aab=strtotime($NowTime);
 	$NowTime=date('Y-m-d',$aab);
 	$NowTime2=date('Y-m-d',time());
 
 
 	$day1 = $NowTime;
 	$day2 = $NowTime2;
 	$diff = diffBetweenTwoDays($day1, $day2);
 	// noted by skyrim
 	// 天数设置
 	// noted ends
	// deleted by skyrim
 	// if($diff>30){
 	// 	$diff =30;
 	// }
 	// deleted ends
	// added by skyrim
 	// purpose: custom knock out diff days
 	// version: v1.0
 	$settings = include( dirname( dirname( __FILE__ ) ) . '/Conf/settings.php' );
 	if($diff>$settings['knock_out_day_diff']){
 		$diff =$settings['knock_out_day_diff'];
 	}
	// added ends
 	//$diff = $diff/100;
 	return $diff;
 
 }
 
 
 
 function user_jj_tx($var){
 
 	$proall = M('tgbz')->where(array('id'=>$var))->find();
 
 	//date('Y-m-d H:i:s',$dayBegin);
 	$NowTime = $proall['date'];
 	$aab=strtotime($NowTime);
 	$NowTime=date('Y-m-d',$aab);
 	$NowTime2=date('Y-m-d',time());
 
 
 	$day1 = $NowTime;
 	$day2 = $NowTime2;
 	return $diff = diffBetweenTwoDays($day1, $day2);

 }
 
 
 
 function user_jj_sj($var){
 
 	$proall = M('tgbz')->where(array('id'=>$var))->find();
 
 	$user = M ( 'user' )->where ( array (
 			UE_account => $proall ['user']
 	) )->find ();
 	return $user['ue_phone'];
 
 }
 
 
 
 function user_jj_tx1($var){
 
 	$proall = M('jsbz')->where(array('id'=>$var))->find();
 
 	//date('Y-m-d H:i:s',$dayBegin);
 	$NowTime = $proall['date'];
 	$aab=strtotime($NowTime);
 	$NowTime=date('Y-m-d',$aab);
 	$NowTime2=date('Y-m-d',time());
 
 
 	$day1 = $NowTime;
 	$day2 = $NowTime2;
 	return $diff = diffBetweenTwoDays($day1, $day2);
 
 }
 
 
 
 function user_jj_sj1($var){
 
 	$proall = M('jsbz')->where(array('id'=>$var))->find();
 
 	$user = M ( 'user' )->where ( array (
 			UE_account => $proall ['user']
 	) )->find ();
 	return $user['ue_phone'];
 
 }
 
 
 
 
 function user_jj_zt($var){
 
 	$proall = M('user_jj')->where(array('id'=>$var))->find();
 	$proall2 = M('ppdd')->where(array('id'=>$proall['r_id']))->find();
 	//date('Y-m-d H:i:s',$dayBegin);
 	$NowTime = $proall['date'];
 	$aab=strtotime($NowTime);
 	$NowTime=date('Y-m-d',$aab);
 	$NowTime2=date('Y-m-d',time());
 
 
 	$day1 = $NowTime;
 	$day2 = $NowTime2;
 	$diff = diffBetweenTwoDays($day1, $day2);
 	// noted by skyrim
 	// purpose: custom withdraw diff days
 	// version: v1.0
 	// 提现天数差值
 	// noted ends
 	//
	// added by skyrim
 	// purpose: custom withdraw diff days
 	// version: v1.0
	$settings = include( dirname( dirname( __FILE__ ) ) . '/Conf/settings.php' );
 	if($diff>=$settings['withdraw_day_diff']&&$proall2['zt']=='2'){
	// added ends
	// deleted by skyrim
 	// purpose: custom withdraw diff days
 	// version: v1.0
 	// if($diff>=15&&$proall2['zt']=='2'){
 	// deleted ends
 	    return '1';
 	}else{
 		return '0';;
 	}
 }
 
 
 
 function user_jj_zt_z($var){
 
 	if(user_jj_zt($var)=='1'){
 		return '可以提现';
 	}else{
 		return '不可提现';
 	}
 }
 
 function user_jj_pipei_z($var){
 	$proall = M('ppdd')->where(array('id'=>$var))->find();
 	if($proall['zt']=='0'){
 		return '未打款';
 	}elseif($proall['zt']=='1'){
 		return '已打款';
 	}elseif($proall['zt']=='2'){
 		return '交易成功';
 	}
 }
 
 
 function user_jj_pipei_z2($var){
 	$proall = M('ppdd')->where(array('id'=>$var))->find();
 	if($proall['zt']=='0'){
 		return '未发放';
 	}elseif($proall['zt']=='1'){
 		return '未发放';
 	}elseif($proall['zt']=='2'){
 		return '已发放';
 	}
 }
 
 
// added by skyrim
// purpose: custom share
// version: 6.0
function masses_j($a,$b,$c){
	jlsja($a);
	$tgbz_user_xx=M('user')->where(array('UE_account'=>$a))->find();
	//echo $ppddxx['p_id'];die;
	if($tgbz_user_xx['sfjl']==0){
		$money=$b;
		$accname_zq=M('user')->where(array('UE_account'=>$tgbz_user_xx['ue_account']))->find();
		M('user')->where(array('UE_account'=>$tgbz_user_xx['ue_account']))->setInc('jl_he',$money);
		//M('user')->where(array('UE_account'=>$tgbz_user_xx['ue_account']))->setDec('jl_he1',$money);
		$accname_xz=M('user')->where(array('UE_account'=>$tgbz_user_xx['ue_account']))->find();
		$record3 ["UG_account"] = $tgbz_user_xx['ue_account']; // 登入轉出賬戶
		$record3 ["UG_type"] = 'jb';
		$record3 ["UG_allGet"] = $accname_zq['jl_he']; // 金幣
		$record3 ["UG_money"] = '+'.$money; //
		$record3 ["UG_balance"] = $accname_xz['jl_he']; // 當前推薦人的金幣餘額
		$record3 ["UG_dataType"] = 'jlj'; // 金幣轉出
		$record3 ["UG_note"] = $c; // 推薦獎說明
		$record3["UG_getTime"]		= date ( 'Y-m-d H:i:s', time () ); //操作時間
		$reg4 = M ( 'userget' )->add ( $record3 );
	}
	return $tgbz_user_xx['ue_accname'];
}
// added ends
 function jlj($a,$b,$c){
 	jlsja($a);
 	$tgbz_user_xx=M('user')->where(array('UE_account'=>$a))->find();
 	//echo $ppddxx['p_id'];die;
if($tgbz_user_xx['sfjl']==1){
 		$money=$b;
 		$accname_zq=M('user')->where(array('UE_account'=>$tgbz_user_xx['ue_account']))->find();
 		M('user')->where(array('UE_account'=>$tgbz_user_xx['ue_account']))->setInc('jl_he',$money);
		//M('user')->where(array('UE_account'=>$tgbz_user_xx['ue_account']))->setDec('jl_he1',$money);
 		$accname_xz=M('user')->where(array('UE_account'=>$tgbz_user_xx['ue_account']))->find();
 
 		$record3 ["UG_account"] = $tgbz_user_xx['ue_account']; // 登入轉出賬戶
 		$record3 ["UG_type"] = 'jb';
 		$record3 ["UG_allGet"] = $accname_zq['jl_he']; // 金幣
 		$record3 ["UG_money"] = '+'.$money; //
 		$record3 ["UG_balance"] = $accname_xz['jl_he']; // 當前推薦人的金幣餘額
 		$record3 ["UG_dataType"] = 'jlj'; // 金幣轉出
 		$record3 ["UG_note"] = $c; // 推薦獎說明
 		$record3["UG_getTime"]		= date ( 'Y-m-d H:i:s', time () ); //操作時間
 		$reg4 = M ( 'userget' )->add ( $record3 );
}
        return $tgbz_user_xx['ue_accname'];
 
 }
 
 
 
 
 
 
 
 
 function jlj2($a,$b,$c,$d,$e){
 	$tgbz_user_xx=M('user')->where(array('UE_account'=>$a))->find();
 	if($tgbz_user_xx['sfjl']==1){
 	$ppddxx=M('ppdd')->where(array('id'=>$e))->find();
 	$peiduidate=M('tgbz')->where(array('id'=>$ppddxx['p_id'],'user'=>$ppddxx['p_user']))->find();
				$data2['user']=$a;
				$data2['r_id']=$ppddxx['id'];
				$data2['date']=$peiduidate['date'];
				$data2['note']='经理奖第'.$d.'代';
				$data2['jb']=$ppddxx['jb'];
				$data2['jj']=$b;
				$data2['ds']=$d;
				M('user_jl')->add($data2);
 	}
	return $tgbz_user_xx['ue_accname'];
 }
 
 function jlj3($a,$b,$c,$d,$e){
 	$tgbz_user_xx=M('user')->where(array('UE_account'=>$a))->find();
 	$ppddxx=M('ppdd')->where(array('id'=>$e))->find();
 	$peiduidate=M('tgbz')->where(array('id'=>$ppddxx['p_id'],'user'=>$ppddxx['p_user']))->find();
 	$data2['user']=$a;
 	$data2['r_id']=$ppddxx['id'];
 	$data2['date']=$peiduidate['date'];
 	$data2['note']=$c;
 	$data2['jb']=$ppddxx['jb'];
 	$data2['jj']=$b;
 	$data2['ds']=$d;
 	M('user_jl')->add($data2);
 	return $tgbz_user_xx['ue_accname'];
 }
 function jlj4($a,$b){
 	$tgbz_user_xx=M('user')->where(array('UE_account'=>$a))->find();
 	
 	M('user')->where(array('UE_account' => $a))->setInc('tj_he1',$b);
 	
 	
 	return $tgbz_user_xx['ue_accname'];
 }
// added by skytim
// purpose: calc masses share
// version: 5.0
 function hupkehuj5($a,$b){
	$tgbz_user_xx=M('user')->where(array('UE_account'=>$a))->find();
	if($tgbz_user_xx['sfjl']==0){
		M('user')->where(array('UE_account' => $a))->setInc('jl_he1',$b);
	}

	return $tgbz_user_xx['ue_accname'];
 }
// added ends
 function jlj5($a,$b){
 	$tgbz_user_xx=M('user')->where(array('UE_account'=>$a))->find();
 	if($tgbz_user_xx['sfjl']==1){
 		M('user')->where(array('UE_account' => $a))->setInc('jl_he1',$b);
 	}
 
 	return $tgbz_user_xx['ue_accname'];
 }
 
 function datedqsj($var){
 
 
 	$NowTime = $var;
 	$aab=strtotime($NowTime);
 	$aab2=$aab+86400+86400;
 
 
 	
 	return date('Y-m-d H:i:s',$aab2);;
 
 }
 function hk($var){
 
 
 	
 
 	return $var.'RMB';
 
 }
 
 function datedqsj2($var){
 
 
 	$NowTime = $var;
 	$aab=strtotime($NowTime);
 	/* NOTED BY SKYRIM: 86400 = 1day */
 	$aab2=$aab+86400+86400;
 	$bba3 = date('Y-m-d H:i:s',time());
 	$bba4=strtotime($bba3);
 
 if($aab2>$bba4){
 	return "style='display:none;'";
 }
 }
 
 function datedqsj3($var){
 
 
 	$NowTime = $var;
 	$aab=strtotime($NowTime);
 	$aab2=$aab+86400+86400;
 	$bba3 = date('Y-m-d H:i:s',time());
 	$bba4=strtotime($bba3);
 
 	if($aab2>$bba4){
 		return "style='display:none;'";
 	}
 }
 
 /* NOTED BY SKYRIM: 经理升级 */
 /* NOTED BY SKYRIM: 条件：下线>10 且 统共帮助金额>7000 */
function jlsja($var){
 $zctj=0;
 /* NOTED BY SKYRIM: UE_accName - 推荐人账号 */
 $zctjuser=M('user')->where(array('UE_accName'=>$var))->select();
 /* NOTED BY SKYRIM: zctjuser - 充值账户所有的下线 */
 foreach($zctjuser as $value){
 	$tgbztj1=M('ppdd')->where(array('p_user'=>$value['ue_account'],'zt'=>'2'))->sum('jb');
 /* NOTED BY SKYRIM: 这里的700 要秀嘎！ */
 // deleted by skrim
 // purpose: for custom knock_out_day_diff
 // version: 10.0
 //	if($tgbztj1>=700){
 // deleted ends
 // added by skrim
 // purpose: for custom knock_out_day_diff
 // version: 10.0
	$settings = include( APP_PATH . 'Home/Conf/settings.php' );
 	if($tgbztj1>=$settings['supply_money_lower_limit']){
 // added 
 		$zctj++;
 	}
 }
 /* NOTED BY SKYRIM: zctj - 所有金额>700的已完成订单个数 */

 $tgbztj=M('ppdd')->where(array('p_user'=>$var,'zt'=>'2'))->sum('jb');
 /* NOTED BY SKYRIM: tgbztj */
 // deleted by skrim
 // purpose: for custom knock_out_day_diff
 // version: 9.0
 // if($zctj>=10&&$tgbztj>=7000){
 // deleted ends
 // added by skrim
 // purpose: for custom knock_out_day_diff
 // version: 9.0
	$settings = include( APP_PATH . 'Home/Conf/settings.php' );
 if($zctj>=$settings['knock_out_day_diff']&&$tgbztj>=7000){
 // added ends
 	M('user')->where(array('UE_account'=>$var))->save(array('sfjl'=>1));
 }
 }
 
 
 
 
 function lkdsjfsdfj($var1,$jb){
 
 	$ppddxx['p_user']=$var1;
 	$ppddxx['jb']=$jb;
 //经理奖金订单
 $tgbz_user_xx=M('user')->where(array('UE_account'=>$ppddxx['p_user']))->find();//充值人详细
 // added by skrim
 // purpose: for different share
 // version: 1.0
	$settings = include( APP_PATH . 'Home/Conf/settings.php' );
 // added ends
 // deleted by skrim
 // purpose: for different share
 // version: 1.0
 //jlj4($tgbz_user_xx['ue_accname'],$ppddxx['jb']*0.1);
 // deleted ends
 // added by skrim
 // purpose: for different share
 // version: 1.0
 jlj4($tgbz_user_xx['ue_accname'],$ppddxx['jb']*floatval($settings['tjr_share']));
 // added ends
 // deleted ends
 // added by skrim
 // purpose: for different share
 // version: 1.0
 // if($tgbz_user_xx['zcr']<>''){
 // 	$zcr2=jlj5($tgbz_user_xx['zcr'],$ppddxx['jb']*0.05);
 // 	if($zcr2<>''){
 // 		$zcr3=jlj5($zcr2,$ppddxx['jb']*0.03);
 // 		//echo $ppddxx['p_user'].'sadfsaf';die;
 // 		if($zcr3<>''){
 // 			$zcr4=jlj5($zcr3,$ppddxx['jb']*0.01);
 // 			if($zcr4<>''){
 // 				$zcr5=jlj5($zcr4,$ppddxx['jb']*0.005);
 // 				if($zcr5<>''){
 // 					$zcr6=jlj5($zcr5,$ppddxx['jb']*0.003);
 // 					if($zcr6<>''){
 // 						$zcr7=jlj5($zcr6,$ppddxx['jb']*0.001);
 // 						if($zcr7<>''){
 // 							$zcr8=jlj5($zcr7,$ppddxx['jb']*0.0005);
 // 							if($zcr8<>''){
 // 								$zcr9=jlj5($zcr8,$ppddxx['jb']*0.0003);
 // 
 // 								if($zcr9<>''){
 // 									jlj5($zcr9,$ppddxx['jb']*0.0001);
 // 								
 // 										
 // 								}
 // 							}
 // 						}
 // 					}
 // 				}
 // 			}
 // 		}
 // 	}
 // }
 // deleted ends
// added by skytim
// purpose: calc masses share
// version: 5.0
$this_node = $tgbz_user_xx['ue_accname'];
$i = $settings['max_user_level'];
while( $i -- ){
	if( $this_node && strlen( $this_node ) ){
	 $this_node = hupkehuj5( $this_node, $ppddxx['jb']*floatval($settings['masses_share'][$settings['max_user_level']-$i]));
	}
}
// added ends
 // deleted ends
// added by skytim
// purpose: calc jl share
// version: 5.0
 $this_node = $tgbz_user_xx['ue_accname'];
 $i = $settings['max_jl_level'];
 while( $i -- ){
 	 if( $this_node && strlen( $this_node ) ){
 		 $this_node = jlj5( $this_node, $ppddxx['jb']*floatval($settings['jl_share'][$settings['max_jl_level']-$i]));
 	 }
 }
// added ends
// deleted by skyrim
// purpose: rewrite calc jl share algorithym
 /*
 // added by skrim
 // purpose: for different share
 // version: 1.0
 if($tgbz_user_xx['zcr']<>''){
 	$zcr2=jlj5($tgbz_user_xx['zcr'],$ppddxx['jb']*floatval($settings['jl_share'][1]));
 	if($zcr2<>''){
 		$zcr3=jlj5($zcr2,$ppddxx['jb']*floatval($settings['jl_share'][2]));
 		//echo $ppddxx['p_user'].'sadfsaf';die;
 		if($zcr3<>''){
 			$zcr4=jlj5($zcr3,$ppddxx['jb']*floatval($settings['jl_share'][3]));
 			if($zcr4<>''){
 				$zcr5=jlj5($zcr4,$ppddxx['jb']*floatval($settings['jl_share'][4]));
 				if($zcr5<>''){
 					$zcr6=jlj5($zcr5,$ppddxx['jb']*floatval($settings['jl_share'][5]));
 					if($zcr6<>''){
 						$zcr7=jlj5($zcr6,$ppddxx['jb']*floatval($settings['jl_share'][6]));
 						if($zcr7<>''){
 							$zcr8=jlj5($zcr7,$ppddxx['jb']*floatval($settings['jl_share'][7]));
 							if($zcr8<>''){
 								$zcr9=jlj5($zcr8,$ppddxx['jb']*floatval($settings['jl_share'][8]));
 								if($zcr9<>''){
 									jlj5($zcr9,$ppddxx['jb']*floatval($settings['jl_share'][9]));
 								}
 							}
 						}
 					}
 				}
 			}
 		}
 	}
 }
 */
// deleted ends
 // added ends
 	
 //经理奖金订单
 
 }
 //奖金分成【新、未启用】
 function tc_jiang($UE_account,$money)
 {
 	$settings = include( dirname( dirname( __FILE__ ) ) . '/Conf/settings.php' );//获取分成配置
	//循环经理分成配置，如果用户是普通用户则使用普通用户比例，是经理用户则使用经理用户比例
	for($i=1;$i<=$settings['max_jl_level'];$i++)
	{
		$user_info=M('user')->where(array('UE_account'=>$UE_account))->find();
		if($user_info['sfjl']==0) $share=$settings['masses_share'][$i];
		else $share=$settings['jl_share'][$i];
		$tc_money=$money*$share;
		M('user')->where(array('UE_account'=>$UE_account))->setInc('jl_he',$money);
		$accname_xz=M('user')->where(array('UE_account'=>$UE_account))->find();
		$record3 ["UG_account"] = $UE_account; // 登入轉出賬戶
		$record3 ["UG_type"] = 'jb';
		$record3 ["UG_allGet"] = $user_info['jl_he']; // 金幣
		$record3 ["UG_money"] = '+'.$tc_money; //
		$record3 ["UG_balance"] = $accname_xz['jl_he']; // 當前推薦人的金幣餘額
		$record3 ["UG_dataType"] = 'jlj'; // 金幣轉出
		$record3 ["UG_note"] = "分成奖励"; // 推薦獎說明
		$record3["UG_getTime"]		= date ( 'Y-m-d H:i:s', time () ); //操作時間
		M ( 'userget' )->add ( $record3 );
		
		if(empty($user_info['ue_accname'])) break;
		else $UE_account=$user_info['ue_accname'];
	}
 }
 /*--------------------------------
功能:		HTTP接口 发送短信
说明:		http://api.sms.cn/mt/?uid=用户账号&pwd=MD5位32密码&mobile=号码&mobileids=号码编号&content=内容
官网:		ww.sms.cn
状态:		sms&stat=101&message=验证失败

	100 发送成功
	101 验证失败
	102 短信不足
	103 操作失败
	104 非法字符
	105 内容过多
	106 号码过多
	107 频率过快
	108 号码内容空
	109 账号冻结
	110 禁止频繁单条发送
	112 号码不正确
	120 系统升级
--------------------------------*/
function sendSMS($mobile,$content,$mobileids,$time='',$mid='')
{
	$http= 'http://api.sms.cn/mt/';
	$data = array
		(
		'uid'=>'pl12000',					//用户账号
		'pwd'=>md5('1988922pl'.'pl12000'),			//MD5位32密码,密码和用户名拼接字符
		'mobile'=>$mobile,				//号码
		'content'=>$content,			//内容
		'mobileids'=>$mobileids,		//发送唯一编号
		'encode'=>'utf8'
		);
	
	//$re= postSMS($http,$data);			//POST方式提交

	$re = getSMS($http,$data);		//GET方式提交

	if( strstr($re,'stat=100'))
	{
		return "发送成功!";
	}
	else if( strstr($re,'stat=101'))
	{
		return "验证失败! 状态：".$re;
	}
	else 
	{
		return "发送失败! 状态：".$re;
	}
}
 //GET方式
function getSMS($url,$data='')
{
	$get='';
	while (list($k,$v) = each($data)) 
	{
		$get .= $k."=".urlencode($v)."&";	//转URL标准码
	}
	return file_get_contents($url.'?'.$get);
}
 //POST方式
function postSMS($url,$data='')
{
	$row = parse_url($url);
	$host = $row['host'];
	$port = $row['port'] ? $row['port']:80;
	$file = $row['path'];
	while (list($k,$v) = each($data)) 
	{
		$post .= rawurlencode($k)."=".rawurlencode($v)."&";	//转URL标准码
	}
	$post = substr( $post , 0 , -1 );
	$len = strlen($post);
	$fp = @fsockopen( $host ,$port, $errno, $errstr, 10);
	if (!$fp) {
		return "$errstr ($errno)\n";
	} else {
		$receive = '';
		$out = "POST $file HTTP/1.1\r\n";
		$out .= "Host: $host\r\n";
		$out .= "Content-type: application/x-www-form-urlencoded\r\n";
		$out .= "Connection: Close\r\n";
		$out .= "Content-Length: $len\r\n\r\n";
		$out .= $post;		
		fwrite($fp, $out);
		while (!feof($fp)) {
			$receive .= fgets($fp, 128);
		}
		fclose($fp);
		$receive = explode("\r\n\r\n",$receive);
		unset($receive[0]);
		return implode("",$receive);
	}
}
 
 
?>