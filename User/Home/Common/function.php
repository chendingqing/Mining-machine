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
 
 
 
 
 function isMobile(){
		// 如果有HTTP_X_WAP_PROFILE则一定是移动设备
		//return true;
		if (isset ($_SERVER['HTTP_X_WAP_PROFILE']))
		return true;

		//此条摘自TPM智能切换模板引擎，适合TPM开发
		if(isset ($_SERVER['HTTP_CLIENT']) &&'PhoneClient'==$_SERVER['HTTP_CLIENT'])
		return true;
		//如果via信息含有wap则一定是移动设备,部分服务商会屏蔽该信息
		if (isset ($_SERVER['HTTP_VIA']))
		//找不到为flase,否则为true
		return stristr($_SERVER['HTTP_VIA'], 'wap') ? true : false;
		//判断手机发送的客户端标志,兼容性有待提高
		if (isset ($_SERVER['HTTP_USER_AGENT'])) {
		$clientkeywords = array(
		'nokia','sony','ericsson','mot','samsung','htc','sgh','lg','sharp','sie-','philips','panasonic','alcatel','lenovo','iphone','ipod','blackberry','meizu','android','netfront','symbian','ucweb','windowsce','palm','operamini','operamobi','openwave','nexusone','cldc','midp','wap','mobile'
		);
		//从HTTP_USER_AGENT中查找手机浏览器的关键字
		if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT']))) {
		return true;
		}
		}
		//协议法，因为有可能不准确，放到最后判断
		if (isset ($_SERVER['HTTP_ACCEPT'])) {
		// 如果只支持wml并且不支持html那一定是移动设备
		// 如果支持wml和html但是wml在html之前则是移动设备
		if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html')))) {
		return true;
		}
		}
		return false;
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
 
/* function sendmail($a,$b,$c){
	 require '/mailer/class.phpmailer.php';
	require '/mailer/class.smtp.php';
	date_default_timezone_set('PRC');
	$mail = new PHPMailer(); 
	$mail->SMTPDebug = 3;
	$mail->isSMTP();
	$mail->SMTPAuth=true;
	$mail->Host = 'smtpdm.aliyun.com';
	$mail->SMTPSecure = 'ssl';
	//设置ssl连接smtp服务器的远程服务器端口号 可选465或587
	$mail->Port = 25;
	$mail->Hostname = 'localhost';
	$mail->CharSet = 'UTF-8';
	$mail->FromName = 'GEC';
	$mail->Username ='master.green-entrepreneurship.cc';
	$mail->Password = 'ASDjkl147258';
	$mail->From = 'master.green-entrepreneurship.cc';
	$mail->isHTML(true); 
	$mail->addAddress($a,'这个QQ的昵称');
	$mail->Subject = $c;
	$mail->Body = $b;
	$mail->addAttachment('./src/20151002.png','test.png');
	$status = $mail->send();
	if($status) 
	{
	 echo '发送邮件成功'.date('Y-m-d H:i:s');
	}
	else
	{
	 echo '发送邮件失败，错误信息未：'.$mail->ErrorInfo;
	}
	exit;
 } */
 function cx_user($var){
 	//dump($var);
 	$proall = M('user')->where(array('UE_account'=>$var))->find();
 	return $proall['ue_theme'];
 }
 
 function user_count($var){
	$count=M('user')->where(array('UE_accName'=>$var))->count();

	// $result=M('user')->where(array('UE_accName'=>$result['ue_account']))->count();

	return "$count";
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
 function user_jj_lx($var){
	 $settings = include( dirname( APP_PATH ) . '/User/Home/Conf/settings.php' );
	 $users=M('user');
	 $userget=M('userget');
	 $shop_orderform = M('shop_orderform');
	 $self=$users->where(array('UE_account'=>$_SESSION['uname']))->find();//查询当前会员
	 $proall = $userget->where(array('UG_ID'=>$var))->find();//s查矿车收益数据库里UG_ID等于当前会员的
	 $NowTime = $proall['ug_gettime'];//结算时间
 	 $aab=strtotime($NowTime);//把结算时间日期转换成时间戳
	 $day1 = $aab;//结算时间戳
 	 $day2 = time();//当前时间
	$diff = diffBetweenTwoDays($day1, $day2);//计算$day1、$day2两个日期相差的时间
	 if($diff>$proall['yxzq']){//判断相差时间大于720小时
 		$diff=$proall['yxzq'];//就等于想茶时间等于720小时
 	}
	$lixi=$diff*$proall['lixi'];//相差时间乘以矿机收益
	$zqlx=$proall['lixi']*$proall['status'];//矿机收益乘以.......
	$kcxx= $shop_orderform->where(array('id'=>$proall['kcid']))->find();//查询矿车数据库里id等于矿车收益数据库里的kcid
	$user = $users->where(array('UE_account'=>$proall['ug_account']))->find();//查询user数据表里的会员等于矿车收益里的登录账号
	if($diff==$proall['yxzq']){//判断如果相差时间等于720小时
			$oobs= $shop_orderform->where(array('id'=>$proall['kcid']))->data(array('zt'=>2))->save();//查询矿车数据库里的id等于矿车收益数据库里的kcid，更改矿车数据库里的zt字段等于2（2=当前矿车运行完毕）
		}
	 //每点击一次矿机收益增加记录
	 if($diff>$proall['status']){
		$lixi=$lixi-$zqlx;
		$map['UG_account']=$_SESSION['uname'];
		$map['UG_getTime'] = date('Y-m-d H:i:s',time());
		$map['UG_note'] = $kcxx['project'].'收入';
		//$map['enUG_note'] = $kcxx['enproject'].award;
		$map['UG_money'] = $lixi;
		$map['gmkjh'] = $kcxx['kjbh'];
		//$map['UG_money'] = $zsl;
		$map['UG_dataType'] = 'kjsr';
		$map['nickname'] = $self['ue_truename'];//本人信息
		$map['gzzq'] = $diff;
		$cunru=$userget->add($map);
		$userss = $users->where(array('UE_account'=>$proall['ug_account']))->setInc("UE_money",$lixi);
		//遍历上级 加入奖金
		$settings = include( APP_PATH . 'Home/Conf/settings.php' );
		$ooob=$users->where(array('UE_account'=>$user['ue_accname']))->find();
				if($ooob['level']>=1){
					//$result = $users->where(array('UE_account'=>$_SESSION['uname']))->find();
					$result1 =  $users->where(array('UE_account'=>$self['ue_accname']))->find();
					$order= $shop_orderform->where(array('user'=>$self['ue_account']))->sum('sumprice');
					$order1 = $shop_orderform->where(array('user'=>$result1['ue_account']))->sum('sumprice');
					$money = $lixi;
					
					if($order>$order1){
						$money = $money/2;
					}
					$money=$money*$settings['ztlv'];
					$money=number_format($money,8);
					$tuandui=$users->where(array('UE_account'=>$self['ue_accname']))->setInc('UE_money',$money);
					$resu =	$users->where(array('UE_account'=>$self['ue_accname']))->find();
					$record3 ["UG_account"] = $result1['ue_account']; // 登入轉出賬戶
					$record3 ["UG_type"] = 'lkb';
					$record3 ["UG_allGet"] = $result1['ue_money']; // 金幣
					$record3 ["UG_money"] = '+'.$money; //
					$record3 ["UG_balance"] = $resu['ue_money']; // 當前推薦人的金幣餘額
					$record3 ["UG_dataType"] = 'tdj'; // 金幣轉出
					$record3 ["UG_note"] = "算力收益"; // 推薦獎說明
					$record3 ["enUG_note"]="award";
					$record3["UG_getTime"]		= date ( 'Y-m-d H:i:s', time () ); //操作時間
					$record3["UG_othraccount"] = $self['ue_truename'];
					$record3["nickname"] = $self['ue_truename'];
					$reg4 = $userget->add ( $record3 );
				}				
		//内容见上		
		$proall= $userget->where(array('UG_ID'=>$var))->data(array('status'=>$diff))->save();		
	}
	 return $lixi;
 }
 function masses_j($a,$b,$c,$d){
	$self=M('user')->where(array('UE_account'=>$_SESSION['uname']))->find();
	$nick=M('user')->where(array('UE_account'=>$d))->find();

	$result = M('user')->where(array('UE_account'=>$a))->find();
	$result1 =  M('user')->where(array('UE_account'=>$result['ue_accname']))->find();
	$order= M('shop_orderform')->where(array('user'=>$result['ue_account']))->sum('sumprice');
	$order1 = M('shop_orderform')->where(array('user'=>$result1['ue_account']))->sum('sumprice');
	$money = $b;
	
	if($order>$order1){
		$money = $b/2;
	}
	$money=number_format($money,8);
		$user=M('user')->where(array('UE_account'=>$result['ue_accname']))->find();
		//dump($user);
		if($user){
			$tuandui=M('user')->where(array('UE_account'=>$result['ue_accname']))->setInc('UE_money',$money);
			$resu= M('user')->where(array('UE_account'=>$result['ue_accname']))->find();
		}
		
		if($user){
			$record3 ["UG_account"] = $user['ue_account']; // 登入轉出賬戶
			$record3 ["UG_type"] = 'lkb';
			$record3 ["UG_allGet"] = $user['ue_money']; // 金幣
			$record3 ["UG_money"] = '+'.$money; //
			$record3 ["UG_balance"] = $resu['ue_money']; // 當前推薦人的金幣餘額
			$record3 ["UG_dataType"] = 'tdj'; // 金幣轉出
			$record3 ["UG_note"] = "公会收益"; // 推薦獎說明
			$record3 ["enUG_note"]="award";
			$record3["UG_getTime"]		= date ( 'Y-m-d H:i:s', time () ); //操作時間
			$record3["UG_othraccount"] = $nick['ue_truename'];
			$record3["nickname"] = $self['ue_truename'];
			$reg4 = M ( 'userget' )->add ( $record3 );
		}
		
		
		return $user['ue_account'];
}
 
 function user_jj_tt($var){
	
 
 	$proall = M('userget')->where(array('UG_ID'=>$var))->find();
 	$NowTime = $proall['ug_gettime'];
 	$aab=strtotime($NowTime);
	
 	$day1 = $aab;
 	$day2 = time();
 	$diff = diffBetweenTwoDays($day1, $day2);
 	if($diff>$proall['yxzq']){
 		$diff=$proall['yxzq'];
 	}
	$lixi=$diff*$proall['lixi']*$proall['kcprice'];
	
	$oob=M('userget')->where(array('id'=>$var))->find();
	$kcxx=M('shop_orderform')->where(array('id'=>$oob['kcid']))->find();
	if($diff>$oob['status']){
		$map['UG_account']=$_SESSION['uname'];
		$map['UG_getTime'] = date('Y-m-d H:i:s',time());
		$map['UG_note'] = $kcxx['project'].'收入';
		$map['UG_money'] = $lixi;
		$map['UG_dataType'] = 'kjsr';
		$kcsy=M('userget')->add($map);
		$user = M('user')->where(array('UG_account'=>$oob['ug_account']))->setInc('UE_money',$lixi);
		$proall= M('userget')->where(array('id'=>$var))->data(array('status'=>$diff))->save();
	}
	
	
	
	return $lixi;
 
 }
 
 
 function user_jj_ts($var){
	 $proall= M('userget')->where(array('UG_ID'=>$var))->find();
	 
	 $NowTime = $proall['ug_gettime'];
	 $aab=strtotime($NowTime);
	 
	 $day1 =$aab;
	 $day2=time();
	 
	 $diff = diffBetweenTwoDays($day1,$day2);
	 if($diff>$proall['yxzq']){
		 $diff=$proall['yxzq'];
	 }
		
	 return $diff;
	 
 
 
 }
 

 //计算直推的人数
 function zhitui($var){
 	$zctjuser=M('user')->where(array('UE_accName'=>$var))->select();//提供帮助的人
 	foreach($zctjuser as $value){
 		$zctj++;
 }
     return $zctj;
 }
 
 
 function user_jj_tx($var){
 
 	$proall = M('tgbz')->where(array('id'=>$var))->find();
 
 	//date('Y-m-d H:i:s',$dayBegin);
 	$NowTime = $proall['date'];
 	$aab=strtotime($NowTime);
 	$NowTime=date('Y-m-d',$aab);
 	$NowTime2=date('Y-m-d',time());
 
	$day1 = $aab;
 	$day2 = time();
 	/* $day1 = $NowTime;
 	$day2 = $NowTime2; */
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
 	//$diff = diffBetweenTwoDays($day1, $day2);
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
	return '1';
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
 
 /* function user_jj_pipei_z($var){
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
 } */
 
 
// added by skyrim
// purpose: custom share
// version: 6.0
 //给普通会员发奖
function masses_j1229($a,$b,$c){
	//jlsja($a);
	$tgbz_user_xx=M('user')->where(array('UE_account'=>$a))->find();
	//echo $ppddxx['p_id'];die;
	//if($tgbz_user_xx['sfjl']==0 ){
		
		$money1=$b*0.9;
		$money2=$b*0.1;
		
		$accname_zq=M('user')->where(array('UE_account'=>$tgbz_user_xx['ue_account']))->find();
		M('user')->where(array('UE_account'=>$tgbz_user_xx['ue_account']))->setInc('UE_money',$money1);
		M('user')->where(array('UE_account'=>$tgbz_user_xx['ue_account']))->setInc('jl_he',$money1);
		//M('user')->where(array('UE_account'=>$tgbz_user_xx['ue_account']))->setDec('jl_he1',$money);
		$accname_xz=M('user')->where(array('UE_account'=>$tgbz_user_xx['ue_account']))->find();
		$record3 ["UG_account"] = $tgbz_user_xx['ue_account']; // 登入轉出賬戶
		$record3 ["UG_type"] = 'jb';
		$record3 ["UG_allGet"] = $accname_zq['ue_money']; // 金幣
		$record3 ["UG_money"] = '+'.$money1; //
		$record3 ["UG_balance"] = $accname_xz['ue_money']; // 當前推薦人的金幣餘額
		$record3 ["UG_dataType"] = 'jlj'; // 金幣轉出
		$record3 ["UG_note"] = $c; // 推薦獎說明
		$record3["UG_getTime"]		= date ( 'Y-m-d H:i:s', time () ); //操作時間
		$reg4 = M ( 'userget' )->add ( $record3 );

		$accname_zq1=M('user')->where(array('UE_account'=>$tgbz_user_xx['ue_account']))->find();
		M('user')->where(array('UE_account'=>$tgbz_user_xx['ue_account']))->setInc('UE_integral',$money2);
		$accname_xz1=M('user')->where(array('UE_account'=>$tgbz_user_xx['ue_account']))->find();
		$record3 ["UG_account"] = $tgbz_user_xx['ue_account']; // 登入轉出賬戶
		$record3 ["UG_type"] = 'jf';
		$record3 ["UG_allGet"] = $accname_zq1['ue_integral']; // 金幣
		$record3 ["UG_money"] = '+'.$money2; //
		$record3 ["UG_balance"] = $accname_xz1['ue_integral']; // 當前推薦人的金幣餘額
		$record3 ["UG_dataType"] = 'jlj'; // 金幣轉出
		$record3 ["UG_note"] = '积分奖励'; // 推薦獎說明
		$record3["UG_getTime"]		= date ( 'Y-m-d H:i:s', time () ); //操作時間
		$reg5 = M ( 'userget' )->add ( $record3 );
	//}
	return $tgbz_user_xx['ue_accname'];
}



 function jljj($a,$b,$c){
	 
	 jlpd($a);
	 $nick=M('user')->where(array('UE_account'=>$_SESSION['uname']))->find();
	// dump($nick);die();
	 $user=M('user')->where(array('UE_account'=>$a))->find();
	 if($user['sfjl']==1){
		 $money=$b;
		 $accname_zq=M('user')->where(array('UE_account'=>$user['ue_account']))->find();
		 M('user')->where(array('UE_account'=>$user['ue_account']))->setInc('UE_money',$money);
		 $accname_xz=M('user')->where(array('UE_account'=>$user['ue_account']))->find();
		 
		 $record3 ["UG_account"] = $user['ue_account']; // 登入轉出賬戶
 		 $record3 ["UG_type"] = 'lkb';
 		 $record3 ["UG_allGet"] = $accname_zq['ue_money']; // 金幣
 		 $record3 ["UG_money"] = '+'.$money; //
 		 $record3 ["UG_balance"] = $accname_xz['ue_money']; // 當前推薦人的金幣餘額
 		 $record3 ["UG_dataType"] = 'jlj'; // 金幣轉出
 		 $record3 ["UG_note"] = '会长奖'; // 推薦獎說明
 		 $record3["UG_getTime"]		= date ( 'Y-m-d H:i:s', time () ); //操作時間
		 $record3["UG_othraccount"] = $nick['ue_truename'];
 		 $reg4 = M ( 'userget' )->add ( $record3 );
	 }
	 return $user['ue_accname'];
 }
 function jlpd($a){
	 $user=M('user')->where(array('UE_account'=>$a))->find();
	 $count=M('user')->where(array('UE_accName'=>$a))->count();
	 if($count>=15){
		 xiajirenshu($a,$reshu);
		 $total = $reshu;
		 
		
		 if($total>=200){
			 M('user')->where(array('UE_account'=>$a))->data(array('sfjl'=>1))->save();
		 }
	 }
 }
 /* function xiajirenshu($name,&$arr){
	 	$array = M('user')->where(['UE_accName'=>$name])->select();
	 	// $num = count($array);
	 	// $arr += $num;
	 	foreach($array as $key=>$value){
	 		$arr += $value['ue_money'];
	 		$name = $value['ue_account'];
	 		if($name){
	 			xiajirenshu($name,$arr); 
	 		}
	 	}
 	
 }
//下级总人数
 function xiajirenshus($name,&$arr){
	 	$array = M('user')->where(['UE_accName'=>$name])->select();
	 	$num = count($array);
	 	$arr += $num;
	 	foreach($array as $key=>$value){
	 		$name = $value['ue_account'];
	 		if($name){
	 			xiajirenshus($name,$arr); 
	 		}
	 	}
 } */
 
 /* function kjsl($name,&$arr){
	 	$array = M('user')->where(['UE_accName'=>$name])->select();
		$self=M('shop_orderform')->where(array('user'=>$_SESSION['uname'],zt=>1))->sum('kjsl');
		//echo $self;die();
		$num=$self;
	 	foreach($array as $key=>$value){
	 		$name = $value['ue_account'];
			$num=M('shop_orderform')->where(array('user'=>$name,zt=>1))->sum('kjsl');
			//$num=intval($num);
			$arr += $num;
	 		if($name){
	 			kjsl($name,$arr);
	 		}
	 	}
 } */
 
/* function cyds($name,&$arr){
	 	$array = M('user')->where(['UE_accName'=>$name])->select();
		$num=M('user')->where(array('UE_accName'=>$name,'level'=>2))->count();
	 	$arr += $num;
		
	 	foreach($array as $key=>$value){
	 		$name = $value['ue_account'];
	 		if($name){
	 			cyds($name,$arr);
	 		}
	 	}
 }
 function hbds($name,&$arr){
	 	$array = M('user')->where(['UE_accName'=>$name])->select();
		$num=M('user')->where(array('UE_accName'=>$name,'level'=>3))->count();
	 	$arr += $num;
		
	 	foreach($array as $key=>$value){
	 		$name = $value['ue_account'];
	 		if($name){
	 			hbds($name,$arr);
	 		}
	 	}
 }
 function gjds($name,&$arr){
	 	$array = M('user')->where(['UE_accName'=>$name])->select();
		$num=M('user')->where(array('UE_accName'=>$name,'level'=>4))->count();
	 	$arr += $num;
		
	 	foreach($array as $key=>$value){
	 		$name = $value['ue_account'];
	 		if($name){
	 			gjds($name,$arr);
	 		}
	 	}
 } */

// 给服务中心、站发奖
 /* function jlj($a,$b,&$e,&$f){
 	//jlsja($a);
 	
 	//dump($f);
 	$tgbz_user_xx=M('user')->where(array('UE_account'=>$a))->find();
 	
 	//echo $ppddxx['p_id'];die;
    if($tgbz_user_xx['sfjl']==1){
        
       
        if($e<1){
        	$money=$b*0.9*0.05;
        	$money1=$b*0.1*0.05;
        	
       
	 		//$money=$b;
	 		$accname_zq=M('user')->where(array('UE_account'=>$tgbz_user_xx['ue_account']))->find();
	 		M('user')->where(array('UE_account'=>$tgbz_user_xx['ue_account']))->setInc('UE_money',$money);
	 		M('user')->where(array('UE_account'=>$tgbz_user_xx['ue_account']))->setInc('jl_he',$money);
			//M('user')->where(array('UE_account'=>$tgbz_user_xx['ue_account']))->setDec('jl_he1',$money);
	 		$accname_xz=M('user')->where(array('UE_account'=>$tgbz_user_xx['ue_account']))->find();
	 
	 		$record3 ["UG_account"] = $tgbz_user_xx['ue_account']; // 登入轉出賬戶
	 		$record3 ["UG_type"] = 'jb';
	 		$record3 ["UG_allGet"] = $accname_zq['ue_money']; // 金幣
	 		$record3 ["UG_money"] = '+'.$money; //
	 		$record3 ["UG_balance"] = $accname_xz['ue_money']; // 當前推薦人的金幣餘額
	 		$record3 ["UG_dataType"] = 'jlj'; // 金幣轉出
	 		$record3 ["UG_note"] = '服务站分成奖5%'; // 推薦獎說明
	 		$record3["UG_getTime"]		= date ( 'Y-m-d H:i:s', time () ); //操作時間
	 		$reg4 = M ( 'userget' )->add ( $record3 );

	 		$accname_zq1=M('user')->where(array('UE_account'=>$tgbz_user_xx['ue_account']))->find();
			M('user')->where(array('UE_account'=>$tgbz_user_xx['ue_account']))->setInc('UE_integral',$money1);
			$accname_xz1=M('user')->where(array('UE_account'=>$tgbz_user_xx['ue_account']))->find();
			$record3 ["UG_account"] = $tgbz_user_xx['ue_account']; // 登入轉出賬戶
			$record3 ["UG_type"] = 'jf';
			$record3 ["UG_allGet"] = $accname_zq1['ue_integral']; // 金幣
			$record3 ["UG_money"] = '+'.$money1; //
			$record3 ["UG_balance"] = $accname_xz1['ue_integral']; // 當前推薦人的金幣餘額
			$record3 ["UG_dataType"] = 'jlj'; // 金幣轉出
			$record3 ["UG_note"] = '积分奖励'; // 推薦獎說明
			$record3["UG_getTime"]		= date ( 'Y-m-d H:i:s', time () ); //操作時間
			$reg5 = M ( 'userget' )->add ( $record3 );
	 		$e++;
 		}
	}
	if($tgbz_user_xx['sfjl1']==1){
	    if($f<1){
	    	$money=$b*0.9*0.1;
	    	$money1=$b*0.1*0.1;
	    	$c='服务中心分成奖10%';
	    	if ($e<1){
		    	$money=$b*0.9*0.1;
	    	    $money1=$b*0.1*0.1;
		    	$c='服务中心分成奖10%';
		    }else{
	            $money=$b*0.9*0.05;
	    	    $money1=$b*0.1*0.05;
		    	$c='服务中心分成奖5%';
		    }
	    }else{
	    	return;
	    }
 		//$money=$b;
 		$accname_zq=M('user')->where(array('UE_account'=>$tgbz_user_xx['ue_account']))->find();
 		M('user')->where(array('UE_account'=>$tgbz_user_xx['ue_account']))->setInc('UE_money',$money);
 		M('user')->where(array('UE_account'=>$tgbz_user_xx['ue_account']))->setInc('jl_he',$money);
		//M('user')->where(array('UE_account'=>$tgbz_user_xx['ue_account']))->setDec('jl_he1',$money);
 		$accname_xz=M('user')->where(array('UE_account'=>$tgbz_user_xx['ue_account']))->find();
 
 		$record3 ["UG_account"] = $tgbz_user_xx['ue_account']; // 登入轉出賬戶
 		$record3 ["UG_type"] = 'jb';
 		$record3 ["UG_allGet"] = $accname_zq['ue_money']; // 金幣
 		$record3 ["UG_money"] = '+'.$money; //
 		$record3 ["UG_balance"] = $accname_xz['ue_money']; // 當前推薦人的金幣餘額
 		$record3 ["UG_dataType"] = 'jlj'; // 金幣轉出
 		$record3 ["UG_note"] = $c; // 推薦獎說明
 		$record3["UG_getTime"]		= date ( 'Y-m-d H:i:s', time () ); //操作時間
 		$reg4 = M ( 'userget' )->add ( $record3 );

 		$accname_zq1=M('user')->where(array('UE_account'=>$tgbz_user_xx['ue_account']))->find();
		M('user')->where(array('UE_account'=>$tgbz_user_xx['ue_account']))->setInc('UE_integral',$money1);
		$accname_xz1=M('user')->where(array('UE_account'=>$tgbz_user_xx['ue_account']))->find();
		$record3 ["UG_account"] = $tgbz_user_xx['ue_account']; // 登入轉出賬戶
		$record3 ["UG_type"] = 'jf';
		$record3 ["UG_allGet"] = $accname_zq1['ue_integral']; // 金幣
		$record3 ["UG_money"] = '+'.$money1; //
		$record3 ["UG_balance"] = $accname_xz1['ue_integral']; // 當前推薦人的金幣餘額
		$record3 ["UG_dataType"] = 'jlj'; // 金幣轉出
		$record3 ["UG_note"] = '积分奖励'; // 推薦獎說明
		$record3["UG_getTime"]		= date ( 'Y-m-d H:i:s', time () ); //操作時間
		$reg5 = M ( 'userget' )->add ( $record3 );
 		$f++;
}

        return $tgbz_user_xx['ue_accname'];
 
} */
 
 
 
 
 
 
 
 
 /* function jlj2($a,$b,$c,$d,$e){
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
 } */
// added by skytim
// purpose: calc masses share
// version: 5.0
/*  function hupkehuj5($a,$b){
	$tgbz_user_xx=M('user')->where(array('UE_account'=>$a))->find();
	if($tgbz_user_xx['sfjl']==0){
		M('user')->where(array('UE_account' => $a))->setInc('jl_he1',$b);
	}

	return $tgbz_user_xx['ue_accname'];
 } */
// added ends
 /* function jlj5($a,$b){
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
 
 } */
 
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
		return "100";
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
function tuijianjl($array){
	M('user_jl')->data($array)->add();
}
 
 function tuijian($ue_account){
 	$time=date ( 'Y-m-d H:i:s', time () );
	$user=M('user')->where(array('UE_account'=>$ue_account))->find();//注册人信息
	//dump($user);
	//die();
	//$p_user_account=$user['UE_accName'];
	$p_user=M('user')->where(array('UE_account'=>$user['ue_accname']))->find();//注册人上一代信息
	//dump($p_user);
	//die();
	if($p_user){//如果注册人有上一代
	      $pp_user=D('user')->where(array('UE_account'=>$p_user['ue_accname']))->find();//注册人上二代信息
	     // dump($pp_user);
	      //die();
		if($pp_user){//如果注册人有上二代
			$ppp_user=D('user')->where(array('UE_account'=>$pp_user['ue_accname']))->find();//注册人上三代信息
			if($ppp_user){//如果注册人有上三代
				$pppp_user=D('user')->where(array('UE_account'=>$ppp_user['ue_accname']))->find();//注册人上四代信息
				if($pppp_user){//如果注册人有上四代
					$ppppp_user=D('user')->where(array('UE_account'=>$pppp_user['ue_accname']))->find();//注册人上五代信息
					if($ppppp_user){//如果注册人有上五代
						$pppppp_user=D('user')->where(array('UE_account'=>$ppppp_user['ue_accname']))->find();//注册人上六代信息
						if($pppppp_user){//如果注册人有上六代
							$ppppppp_user=D('user')->where(array('UE_account'=>$pppppp_user['ue_accname']))->find();//注册人上七代信息
							if($ppppppp_user){//如果注册人有上七代
								 D('user')->where(array('UE_account'=>$user['ue_accname']))->setInc('UE_money',120);//注册人上一代加120元
								D('user')->where(array('UE_account'=>$user['ue_accname']))->setInc('UE_integral',120);//注册人上一代加120积分
								$array=array('user'=>$p_user['ue_account'],
										'date'=>$time,
										'note'=>"推荐奖",
										'ds'=>1,
										'jiangjin'=>120,
										'jifen'=>120,
								);
								tuijianjl($array);
								D('user')->where(array('UE_account'=>$p_user['ue_accname']))->setInc('UE_money',20);//注册人上二代加20元
								D('user')->where(array('UE_account'=>$p_user['ue_accname']))->setInc('UE_integral',20);//注册人上二代加20积分
								$array=array('user'=>$pp_user['ue_account'],
										'date'=>$time,
										'note'=>"推荐奖",
										'ds'=>1,
										'jiangjin'=>20,
										'jifen'=>20,
								);
								tuijianjl($array);
								D('user')->where(array('UE_account'=>$pp_user['ue_accname']))->setInc('UE_money',20);//注册人上三代加20元
								D('user')->where(array('UE_account'=>$pp_user['ue_accname']))->setInc('UE_integral',20);//注册人上三代加20积分
								$array=array('user'=>$ppp_user['ue_account'],
										'date'=>$time,
										'note'=>"推荐奖",
										'ds'=>1,
										'jiangjin'=>20,
										'jifen'=>20,
								);
								tuijianjl($array);
								D('user')->where(array('UE_account'=>$ppp_user['ue_accname']))->setInc('UE_money',20);//注册人上四代加20元
								D('user')->where(array('UE_account'=>$ppp_user['ue_accname']))->setInc('UE_integral',20);//注册人上四代加20积分
								$array=array('user'=>$pppp_user['ue_account'],
										'date'=>$time,
										'note'=>"推荐奖",
										'ds'=>1,
										'jiangjin'=>20,
										'jifen'=>20,
								);
								tuijianjl($array);
								D('user')->where(array('UE_account'=>$pppp_user['ue_accname']))->setInc('UE_money',20);//注册人上五代加20元
								D('user')->where(array('UE_account'=>$pppp_user['ue_accname']))->setInc('UE_integral',20);//注册人上五代加20积分
								$array=array('user'=>$ppppp_user['ue_account'],
										'date'=>$time,
										'note'=>"推荐奖",
										'ds'=>1,
										'jiangjin'=>20,
										'jifen'=>20,
								);
								tuijianjl($array);
								D('user')->where(array('UE_account'=>$ppppp_user['ue_accname']))->setInc('UE_money',20);//注册人上六代加20元
								D('user')->where(array('UE_account'=>$ppppp_user['ue_accname']))->setInc('UE_integral',20);//注册人上六代加20积分
								$array=array('user'=>$pppppp_user['ue_account'],
										'date'=>$time,
										'note'=>"推荐奖",
										'ds'=>1,
										'jiangjin'=>20,
										'jifen'=>20,
								);
								tuijianjl($array);
							}else{//如果注册人没有上七代
								 D('user')->where(array('UE_account'=>$user['ue_accname']))->setInc('UE_money',120);//注册人上一代加120元
								D('user')->where(array('UE_account'=>$user['ue_accname']))->setInc('UE_integral',120);//注册人上一代加120积分
								$array=array('user'=>$p_user['ue_account'],
										'date'=>$time,
										'note'=>"推荐奖",
										'ds'=>1,
										'jiangjin'=>120,
										'jifen'=>120,
								);
								tuijianjl($array);
								D('user')->where(array('UE_account'=>$p_user['ue_accname']))->setInc('UE_money',20);//注册人上二代加20元
								D('user')->where(array('UE_account'=>$p_user['ue_accname']))->setInc('UE_integral',20);//注册人上二代加20积分
								$array=array('user'=>$pp_user['ue_account'],
										'date'=>$time,
										'note'=>"推荐奖",
										'ds'=>1,
										'jiangjin'=>20,
										'jifen'=>20,
								);
								tuijianjl($array);
								D('user')->where(array('UE_account'=>$pp_user['ue_accname']))->setInc('UE_money',20);//注册人上三代加20元
								D('user')->where(array('UE_account'=>$pp_user['ue_accname']))->setInc('UE_integral',20);//注册人上三代加20积分
								$array=array('user'=>$ppp_user['ue_account'],
										'date'=>$time,
										'note'=>"推荐奖",
										'ds'=>1,
										'jiangjin'=>20,
										'jifen'=>20,
								);
								tuijianjl($array);
								D('user')->where(array('UE_account'=>$ppp_user['ue_accname']))->setInc('UE_money',20);//注册人上四代加20元
								D('user')->where(array('UE_account'=>$ppp_user['ue_accname']))->setInc('UE_integral',20);//注册人上四代加20积分
								$array=array('user'=>$pppp_user['ue_account'],
										'date'=>$time,
										'note'=>"推荐奖",
										'ds'=>1,
										'jiangjin'=>20,
										'jifen'=>20,
								);
								tuijianjl($array);
								D('user')->where(array('UE_account'=>$pppp_user['ue_accname']))->setInc('UE_money',20);//注册人上五代加20元
								D('user')->where(array('UE_account'=>$pppp_user['ue_accname']))->setInc('UE_integral',20);//注册人上五代加20积分
								$array=array('user'=>$ppppp_user['ue_account'],
										'date'=>$time,
										'note'=>"推荐奖",
										'ds'=>1,
										'jiangjin'=>20,
										'jifen'=>20,
								);
								tuijianjl($array);
								D('user')->where(array('UE_account'=>$ppppp_user['ue_accname']))->setInc('UE_money',20);//注册人上六代加20元
								D('user')->where(array('UE_account'=>$ppppp_user['ue_accname']))->setInc('UE_integral',20);//注册人上六代加20积分
								$array=array('user'=>$pppppp_user['ue_account'],
										'date'=>$time,
										'note'=>"推荐奖",
										'ds'=>1,
										'jiangjin'=>20,
										'jifen'=>20,
								);
								tuijianjl($array);
							}
						}else{//如果注册人没有上六代
							    D('user')->where(array('UE_account'=>$user['ue_accname']))->setInc('UE_money',120);//注册人上一代加120元
								D('user')->where(array('UE_account'=>$user['ue_accname']))->setInc('UE_integral',120);//注册人上一代加120积分
								$array=array('user'=>$p_user['ue_account'],
										'date'=>$time,
										'note'=>"推荐奖",
										'ds'=>1,
										'jiangjin'=>120,
										'jifen'=>120,
								);
								tuijianjl($array);
								D('user')->where(array('UE_account'=>$p_user['ue_accname']))->setInc('UE_money',20);//注册人上二代加20元
								D('user')->where(array('UE_account'=>$p_user['ue_accname']))->setInc('UE_integral',20);//注册人上二代加20积分
								$array=array('user'=>$pp_user['ue_account'],
										'date'=>$time,
										'note'=>"推荐奖",
										'ds'=>1,
										'jiangjin'=>20,
										'jifen'=>20,
								);
								tuijianjl($array);
								D('user')->where(array('UE_account'=>$pp_user['ue_accname']))->setInc('UE_money',20);//注册人上三代加20元
								D('user')->where(array('UE_account'=>$pp_user['ue_accname']))->setInc('UE_integral',20);//注册人上三代加20积分
								$array=array('user'=>$ppp_user['ue_account'],
										'date'=>$time,
										'note'=>"推荐奖",
										'ds'=>1,
										'jiangjin'=>20,
										'jifen'=>20,
								);
								tuijianjl($array);
								D('user')->where(array('UE_account'=>$ppp_user['ue_accname']))->setInc('UE_money',20);//注册人上四代加20元
								D('user')->where(array('UE_account'=>$ppp_user['ue_accname']))->setInc('UE_integral',20);//注册人上四代加20积分
								$array=array('user'=>$pppp_user['ue_account'],
										'date'=>$time,
										'note'=>"推荐奖",
										'ds'=>1,
										'jiangjin'=>20,
										'jifen'=>20,
								);
								tuijianjl($array);
								D('user')->where(array('UE_account'=>$pppp_user['ue_accname']))->setInc('UE_money',20);//注册人上五代加20元
								D('user')->where(array('UE_account'=>$pppp_user['ue_accname']))->setInc('UE_integral',20);//注册人上五代加20积分
								$array=array('user'=>$ppppp_user['ue_account'],
										'date'=>$time,
										'note'=>"推荐奖",
										'ds'=>1,
										'jiangjin'=>20,
										'jifen'=>20,
								);
								tuijianjl($array);
						}
					}else{//如果注册人没有上五代
						        D('user')->where(array('UE_account'=>$user['ue_accname']))->setInc('UE_money',120);//注册人上一代加120元
								D('user')->where(array('UE_account'=>$user['ue_accname']))->setInc('UE_integral',120);//注册人上一代加120积分
								$array=array('user'=>$p_user['ue_account'],
										'date'=>$time,
										'note'=>"推荐奖",
										'ds'=>1,
										'jiangjin'=>120,
										'jifen'=>120,
								);
								tuijianjl($array);
								D('user')->where(array('UE_account'=>$p_user['ue_accname']))->setInc('UE_money',20);//注册人上二代加20元
								D('user')->where(array('UE_account'=>$p_user['ue_accname']))->setInc('UE_integral',20);//注册人上二代加20积分
								$array=array('user'=>$pp_user['ue_account'],
										'date'=>$time,
										'note'=>"推荐奖",
										'ds'=>1,
										'jiangjin'=>20,
										'jifen'=>20,
								);
								tuijianjl($array);
								D('user')->where(array('UE_account'=>$pp_user['ue_accname']))->setInc('UE_money',20);//注册人上三代加20元
								D('user')->where(array('UE_account'=>$pp_user['ue_accname']))->setInc('UE_integral',20);//注册人上三代加20积分
								$array=array('user'=>$ppp_user['ue_account'],
										'date'=>$time,
										'note'=>"推荐奖",
										'ds'=>1,
										'jiangjin'=>20,
										'jifen'=>20,
								);
								tuijianjl($array);
								D('user')->where(array('UE_account'=>$ppp_user['ue_accname']))->setInc('UE_money',20);//注册人上四代加20元
								D('user')->where(array('UE_account'=>$ppp_user['ue_accname']))->setInc('UE_integral',20);//注册人上四代加20积分
								$array=array('user'=>$pppp_user['ue_account'],
										'date'=>$time,
										'note'=>"推荐奖",
										'ds'=>1,
										'jiangjin'=>20,
										'jifen'=>20,
								);
								tuijianjl($array);
					}
				}else{//如果注册人没有上四代
					            D('user')->where(array('UE_account'=>$user['ue_accname']))->setInc('UE_money',120);//注册人上一代加120元
								D('user')->where(array('UE_account'=>$user['ue_accname']))->setInc('UE_integral',120);//注册人上一代加120积分
								$array=array('user'=>$p_user['ue_account'],
										'date'=>$time,
										'note'=>"推荐奖",
										'ds'=>1,
										'jiangjin'=>120,
										'jifen'=>120,
								);
								tuijianjl($array);
								D('user')->where(array('UE_account'=>$p_user['ue_accname']))->setInc('UE_money',20);//注册人上二代加20元
								D('user')->where(array('UE_account'=>$p_user['ue_accname']))->setInc('UE_integral',20);//注册人上二代加20积分
								$array=array('user'=>$pp_user['ue_account'],
										'date'=>$time,
										'note'=>"推荐奖",
										'ds'=>1,
										'jiangjin'=>20,
										'jifen'=>20,
								);
								tuijianjl($array);
								D('user')->where(array('UE_account'=>$pp_user['ue_accname']))->setInc('UE_money',20);//注册人上三代加20元
								D('user')->where(array('UE_account'=>$pp_user['ue_accname']))->setInc('UE_integral',20);//注册人上三代加20积分
								$array=array('user'=>$ppp_user['ue_account'],
										'date'=>$time,
										'note'=>"推荐奖",
										'ds'=>1,
										'jiangjin'=>20,
										'jifen'=>20,
								);
								tuijianjl($array);
				}
			    }else{//如果注册人没有上三代
				                D('user')->where(array('UE_account'=>$user['ue_accname']))->setInc('UE_money',120);//注册人上一代加120元
								D('user')->where(array('UE_account'=>$user['ue_accname']))->setInc('UE_integral',120);//注册人上一代加120积分
								$array=array('user'=>$p_user['ue_account'],
										'date'=>$time,
										'note'=>"推荐奖",
										'ds'=>1,
										'jiangjin'=>120,
										'jifen'=>120,
								);
								tuijianjl($array);
								D('user')->where(array('UE_account'=>$p_user['ue_accname']))->setInc('UE_money',20);//注册人上二代加20元
								D('user')->where(array('UE_account'=>$p_user['ue_accname']))->setInc('UE_integral',20);//注册人上二代加20积分
								$array=array('user'=>$pp_user['ue_account'],
										'date'=>$time,
										'note'=>"推荐奖",
										'ds'=>1,
										'jiangjin'=>20,
										'jifen'=>20,
								);
								tuijianjl($array);
			}
			 
		        }else{//如果注册人没有上二代
			                    D('user')->where(array('UE_account'=>$user['ue_accname']))->setInc('UE_money',120);//注册人上一代加120元
								D('user')->where(array('UE_account'=>$user['ue_accname']))->setInc('UE_integral',120);//注册人上一代加120积分
								$array=array('user'=>$p_user['ue_account'],
										    'date'=>$time,
										     'note'=>"推荐奖",
										     'ds'=>1,
										     'jiangjin'=>120,
										     'jifen'=>120,
								);
								tuijianjl($array);
		}
		}else{
			//如果注册人没有上一代
		 die("<script>alert('该用户没有邀请人！');history.back(-1);</script>");

	}
}
?>