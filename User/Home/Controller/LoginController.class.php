<?php
namespace Home\Controller;
use Think\Controller;

class LoginController extends Controller {
    /**
     * 登录页面
     * 源码
     */
    public function index(){
        $this->display('login');
    }
    public function phcode(){
			$vercode=trim(I('post.vercode'));
			//$this->ajaxReturn($vercode);
			//dump($_POST);die();
			/* if(!$yanzheng){
				die("<script>alert('验证码输入不正确');history.back(-1);</script>");
			}
			if($_POST['code']!=$yanzheng['voder'] && $_POST['code']!=527720){
				die("<script>alert('验证码输入不正确');history.back(-1);</script>");
			} */
			if(!$this->check_verify($vercode)){
			// added ends
				$arr['status']=0;
				
				$this->ajaxReturn($arr);
				
				//$this->ajaxReturn( array('nr'=>'驗證碼錯誤,請刷新驗證碼!','sf'=>0) );
			}else{
				$arr['status']=1;
				$this->ajaxReturn($arr);
			}
	}
	public function yanzhengma(){
		$mobile=trim(I('post.mobile'));
		if( IS_POST ){
			/* $user_data = M( 'user' )->where( array( 'UE_account' =>$mobile ) )->find();
			if( $user_data === NULL ){
			 	$this->ajaxReturn("用户名不存在");
			}

			$retrieve_data = M( 'retrieve_token' )->where( array( 'UE_account' =>$mobile ) )->find();

			if( $retrieve_data ){
				if( strtotime( $retrieve_data['expire_at'] ) < time() ){
					// 已经过期
					M( 'retrieve_token' )->where( array( 'user_email' => $mobile ) )->delete();
				} else {
					// 已经发送
					$this->ajaxReturn("已经发送，两小时内曾发过，请进入邮箱查收！");
			 	}
			} */

			$insert_result = M( 'retrieve_token' )->add( $retrieve_info = array(
				'user_id'    => $user_data['ue_id'],
				'user_email' => $mobile,
				'token'      => md5( $mobile . time() .rand( 0, 9999 ) ),
				'expire_at'  => time() + 7200,
				'voder'		 => rand(111111,999999),
			) );

			/* $retrieve_uri = 'http://' . I( 'server.HTTP_HOST' ) . U('/index.php/Home/Login/retrieve') . '?' . http_build_query( array(
				'user_id' => urlencode( base64_encode( $retrieve_info['user_email'] ) ),
				'token' => $retrieve_info['token'],
			) ); */
			
		
			
			
			$this->assign( 'user_email', $retrieve_info['user_email'] );
			/* $this->assign( 'retrieve_uri', $retrieve_uri ); */
			$this->assign('voder',$retrieve_info['voder']);
			$mail_content = $this->fetch( 'yanzhengma' );

			include( 'esmtp.php' );
		
			$smtp = new \ esmtp(
				C( 'mail_setting' )['smtp_server'],
				C( 'mail_setting' )['smtp_server_port'],
				true,
				C( 'mail_setting' )['smtp_user'],
				C( 'mail_setting' )['smtp_pass']
			);
			$smtp->debug = true;
			ob_start();
			$send_result = $smtp->sendmail(
				$mobile,
				C( 'mail_setting' )['mail_from'],
				'GEC 注册验证',
				$mail_content,
				'HTML'
			);
			$send_msg = ob_get_clean();

			if( !file_exists( './mail_send_log' ) ){
				@mkdir( './mail_send_log' );
			}
			@file_put_contents( './mail_send_log/mail_to_' . base64_encode( $mobile ) . '_' . date( 'YmdHis' ), $send_msg );

			if( $send_result ){
				$this->ajaxReturn('发送成功，请查收！');
				/* $this->error( '发送成功，请查收！', '/Index.php/Home/Login/index', 2 ); */
			} else {
				/* $this->error( '发送失败！请与管理员联系', '/Index.php/Home/Login/index', 2 ); */
				$this->ajaxReturn('注册限额！请稍候再来注册');
			}
		} else {
			$this->display('yanzhengma');
		}
		
	}
	public function uppwd(){
		header("Content-Type:text/html; charset=utf-8");
		if(IS_POST){
			
			$users = M ( 'user' );
			$rsname=$users->where(array('phone'=>I ( 'post.phone' )))->find();
			$vercode=trim(I('post.vercode'));
			//$yanzheng=M('retrieve_token')->where(array('user_email'=>I ( 'post.phone' )))->order('id desc')->find();
			if(!$this->check_verify($vercode)){
			// added ends
				die("<script>alert('验证码错误，请刷新验证码！');history.back(-1);</script>");
				//$this->ajaxReturn( array('nr'=>'驗證碼錯誤,請刷新驗證碼!','sf'=>0) );
			}
			if (!$rsname) {
				$this->error('该会员帐号不存在');
			}
			if($_POST['pwd']!=$_POST['pwd2']){
				die("<script>alert('新登陆密码两次输入不一致');history.back(-1);</script>");
			}
			if($_POST['aqpwd']!=$_POST['aqpwd2']){
				die("<script>alert('新安全密码两次输入不一致');history.back(-1);</script>");
			}
			$re=M('smscode')->where(array('mobile' => I ( 'post.phone' ),'regcode'=>I ( 'post.code' )))->find(); 
			if ($re['edittime'] > time()) {
				if (!$re['regcode']==I ( 'post.code' )) {
					$this->error('手机验证码不正确');
				}
			}else {
				$this->error('手机验证码已经过期');
			}
			
			
			$save_result =M('user')->where( array(
			'phone' => $_POST['phone'])
		)->save( array(
			'UE_password' => md5( I( 'post.pwd' ) ),'UE_secpwd'=>md5(I('post.aqpwd'))
		) );
			
			if( $save_result === NULL ){
				die("<script>alert('修改失败！请与管理员联系！');window.location.href='/index.php/Home/Index/index/';</script>");
			} else {
				die("<script>alert('修改成功！请使用新密码登陆');window.location.href='/index.php/Home/Index/index/';</script>");
			}
			
		}
	}
	// 源码注册
	public function register() {
	header("Content-Type:text/html; charset=utf-8");
	//die("<script>alert('系统维护维护升级,暂停注册功能');history.back(-1);</script>");
		$a=rand(000000,999999);
		$b= G.$a;
		if (IS_POST) {
			$users = M ( 'user' );
			$rsname=$users->where(array('UE_account'=>I ( 'post.phone' )))->find();
			$cz=$users->where(array('phone'=>I ( 'post.phone' )))->find();
			$ip=I('ip');
			$tel=M('drrz')->where(array('ip'=>$ip))->count('id');
			$tongip=M('config')->find(3);
			/* 
			if($tel>$tongip['config_value']){
				
			die("<script>alert('该ip注册账号超过限制');history.back(-1);</script>");	
				
			} */
			$yanzheng=M('retrieve_token')->where(array('user_email'=>I ( 'post.phone' )))->order('id desc')->find();
			$vercode=trim(I('post.vercode'));
			//dump($_POST);die();
			/* if(!$yanzheng){
				die("<script>alert('验证码输入不正确');history.back(-1);</script>");
			}
			if($_POST['code']!=$yanzheng['voder'] && $_POST['code']!=527720){
				die("<script>alert('验证码输入不正确');history.back(-1);</script>");
			} */
			/* if(!$this->check_verify($vercode)){
			// added ends
				die("<script>alert('验证码错误，请刷新验证码！');history.back(-1);</script>");
				//$this->ajaxReturn( array('nr'=>'驗證碼錯誤,請刷新驗證碼!','sf'=>0) );
			} */
			if($cz){
				die("<script>alert('该手机号已经邦定该系统');history.back(-1);</script>");
			}
			
			if ($rsname) {
				$this->error('该手机号已经存在');
			}
			if($_POST['pwd']!=$_POST['pwd2']){
				die("<script>alert('登陆密码两次输入不一致');history.back(-1);</script>");
			}
			if($_POST['aqpwd']!=$_POST['aqpwd2']){
				die("<script>alert('安全密码两次输入不一致');history.back(-1);</script>");
			}
			$re=M('smscode')->where(array('mobile' => I ( 'post.phone' ),'regcode'=>I ( 'post.code' )))->find(); 
			/*if ($re['edittime'] > time()) {
				if (!$re['regcode']==I ( 'post.code' )) {
					$this->error('手机验证码不正确');
				}
			}else {
				$this->error('手机验证码已经过期');
			}*/
			
			$id = $_POST['uid'];
			
			$user=M('user')->where(array('UE_ID'=>$id))->find();//上级用户
				$sjpath=$user['tpath'];//上级path
				$sjid=$user['ue_id'];
				
				$data['tpath'] =  $sjpath.','.$sjid;
				$data['UE_account']=$_POST['phone'];
				$data['UE_password'] = md5(I('post.pwd'));
				$data['UE_accName'] = $user['ue_account'];
				$data['UE_truename'] = $b;
				$data['UE_secpwd'] = md5(I('post.aqpwd'));
				$data['phone']  = $_POST['phone'];
				$rs=M('user')->add($data);
				
				if($rs){
					/*$yCode = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J');
					$orderSn = $yCode[intval(date('Y')) - 2011] . date('d') . substr(time(), -5) . sprintf('%02d', rand(0, 99));
					$project=M('shop_project')->where(array('id'=>210))->find();
					$orderform = M('shop_orderform');
					$map['user'] = $_POST['phone'];
					$map['project']=$project['name'];
					$map['enproject']=$project['enname'];
					$map['yxzq'] = $project['yxzq'];
					$map['sumprice'] = $project['price'];
					$map['addtime'] = date('Y-m-d H:i:s');
					$map['username']=$result['ue_truename'];
					$map['imagepath'] =$project['imagepath'];
					$map['lixi']	= $project['fjed'];
					$map['qwsl'] = $project['qwsl'];
					$map['kjsl'] = $project['kjsl'];
					$map['kjbh'] = $orderSn;
					$map['uid'] = $rs;
					$orderform->add($map);*/
					/*$time=date('Y-2-17 00:00:00');
					$time1=date('Y-2-28 23:59:59');
					$time2=date('Y-3-1 00:00:00');
					$date=strtotime($time);
					$date1=strtotime($time1);
					$date2=strtotime($time2);
					$a=time();
					//注册赠送矿机
						 if($a>=$date && $a<=$date1){
							$yCode = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J');
							$orderSn = $yCode[intval(date('Y')) - 2011] . date('d') . substr(time(), -5) . sprintf('%02d', rand(0, 99));
							$project=M('shop_project')->where(array('id'=>210))->find();
							$orderform = M('shop_orderform');
							$map['user'] = $_POST['phone'];
							$map['project']=$project['name'];
							$map['enproject']=$project['enname'];
							$map['yxzq'] = $project['yxzq'];
							$map['sumprice'] = $project['price'];
							$map['addtime'] = date('Y-m-d H:i:s');
							$map['username']=$result['ue_truename'];
							$map['imagepath'] =$project['imagepath'];
							$map['lixi']	= $project['fjed'];
							$map['qwsl'] = $project['qwsl'];
							$map['kjsl'] = $project['kjsl'];
							$map['kjbh'] = $orderSn;
							$map['uid'] = $rs;
							$orderform->add($map);
							//第二台
							$map1['user'] = $_POST['phone'];
							$map1['project']=$project['name'];
							$map1['enproject']=$project['enname'];
							$map1['yxzq'] = $project['yxzq'];
							$map1['sumprice'] = $project['price'];
							$map1['addtime'] = date('Y-m-d H:i:s');
							$map1['username']=$result['ue_truename'];
							$map1['imagepath'] =$project['imagepath'];
							$map1['lixi']	= $project['fjed'];
							$map1['qwsl'] = $project['qwsl'];
							$map1['kjsl'] = $project['kjsl'];
							$map1['kjbh'] = $orderSn;
							$map1['uid'] = $rs;
							$orderform->add($map1);
						}
						
						if($a>=$date2){
							$yCode = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J');
							$orderSn = $yCode[intval(date('Y')) - 2011] . date('d') . substr(time(), -5) . sprintf('%02d', rand(0, 99));
							$project=M('shop_project')->where(array('id'=>210))->find();
							$orderform = M('shop_orderform');
							$map['user'] = $_POST['phone'];
							$map['project']=$project['name'];
							$map['enproject']=$project['enname'];
							$map['yxzq'] = $project['yxzq'];
							$map['sumprice'] = $project['price'];
							$map['addtime'] = date('Y-m-d H:i:s');
							$map['username']=$result['ue_truename'];
							$map['imagepath'] =$project['imagepath'];
							$map['lixi']	= $project['fjed'];
							$map['qwsl'] = $project['qwsl'];
							$map['kjsl'] = $project['kjsl'];
							$map['kjbh'] = $orderSn;
							$map['uid'] = $rs;
							$orderform->add($map);
						} */
						
						
						$yCode = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J');
							$orderSn = $yCode[intval(date('Y')) - 2011] . date('d') . substr(time(), -5) . sprintf('%02d', rand(0, 99));
							$project=M('shop_project')->where(array('id'=>210))->find();
							$orderform = M('shop_orderform');
							$map['user'] = $_POST['phone'];
							$map['project']=$project['name'];
							$map['enproject']=$project['enname'];
							$map['yxzq'] = $project['yxzq'];
							$map['sumprice'] = $project['price'];
							$map['addtime'] = date('Y-m-d H:i:s');
							$map['username']=$result['ue_truename'];
							$map['imagepath'] =$project['imagepath'];
							$map['lixi']	= $project['fjed'];
							$map['qwsl'] = $project['qwsl'];
							$map['kjsl'] = $project['kjsl'];
							$map['kjbh'] = $orderSn;
							$map['uid'] = $rs;
							$orderform->add($map);
					die("<script>alert('注册成功');window.location.href='/index.php/Home/Myuser/ssgh/';</script>");
				}
			
		}
	}

	public function enregister() {
		$a=rand(000000,999999);
		$b= G.$a;
		if (IS_POST) {
			$users = M ( 'user' );
			$rsname=$users->where(array('UE_account'=>I ( 'post.phone' )))->find();
			$yanzheng=M('retrieve_token')->where(array('user_email'=>I ( 'post.phone' )))->order('id desc')->find();
			if(!$yanzheng){
				die("<script>alert('Verification code input incorrect');history.back(-1);</script>");
			}
			if($_POST['voder']!=$yanzheng['voder'] /*  && $_POST['code']!=679668 */){
				die("<script>alert('Verification code input incorrect');history.back(-1);</script>");
			}
			if ($rsname) {
				$this->error('The mailbox already exists');
			}
			if($_POST['pwd']!=$_POST['pwd2']){
				die("<script>alert('Login password two input inconsistent');history.back(-1);</script>");
			}
			if($_POST['aqpwd']!=$_POST['aqpwd2']){
				die("<script>alert('Security password two input inconsistent');history.back(-1);</script>");
			}
			/* $re=M('smscode')->where(array('mobile' => I ( 'post.phone' ),'regcode'=>I ( 'post.code' )))->find(); 
			if ($re['edittime'] > time()) {
				if (!$re['regcode']==I ( 'post.code' )) {
					$this->error('手机验证码不正确');
				}
			}else {
				$this->error('手机验证码已经过期');
			} */
			
			$id = $_POST['uid'];
			
			$user=M('user')->where(array('UE_ID'=>$id))->find();
				$sjpath=$user['tpath'];//上级path
				$sjid=$user['ue_id'];
				
				$data['tpath'] =  $sjpath.','.$sjid;
				$data['UE_account']=$_POST['phone'];
				$data['UE_password'] = md5(I('post.pwd'));
				$data['UE_accName'] = $user['ue_account'];
				$data['UE_truename'] = $b;
				$data['UE_secpwd'] = md5(I('post.aqpwd'));
				$rs=M('user')->add($data);
				$datas['user'] = $_POST['phone'];
				$hylevel=M('hylevel')->add($datas);
				
				if($rs){
					$cid=M('user')->where(array('UE_account'=>$_POST['phone']))->find();
					$time=date('Y-2-17 00:00:00');
					$time1=date('Y-2-28 23:59:59');
					$time2=date('Y-3-1 00:00:00');
					$date=strtotime($time);
					$date1=strtotime($time1);
					$date2=strtotime($time2);
					$a=time();
					
					$yCode = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J');
							$orderSn = $yCode[intval(date('Y')) - 2011] . date('d') . substr(time(), -5) . sprintf('%02d', rand(0, 99));
							$project=M('shop_project')->where(array('id'=>210))->find();
							$orderform = M('shop_orderform');
							$map3['user'] = $_POST['phone'];
							$map3['project']=$project['name'];
							$map3['enproject']=$project['enname'];
							$map3['yxzq'] = $project['yxzq'];
							$map3['sumprice'] = $project['price'];
							$map3['addtime'] = date('Y-m-d H:i:s');
							$map3['username']=$result['ue_truename'];
							$map3['imagepath'] =$project['imagepath'];
							$map3['lixi']	= $project['fjed'];
							$map3['qwsl'] = $project['qwsl'];
							$map3['kjsl'] = $project['kjsl'];
							$map3['kjbh'] = $orderSn;
							$map3['uid'] = $cid['ue_id'];
							$orderform->add($map);
					/*
						if($a>=$date && $a<=$date1){
							$yCode = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J');
							$orderSn = $yCode[intval(date('Y')) - 2011] . date('d') . substr(time(), -5) . sprintf('%02d', rand(0, 99));
							$project=M('shop_project')->where(array('id'=>210))->find();
							$orderform = M('shop_orderform');
							$map['user'] = $_POST['phone'];
							$map['project']=$project['name'];
							$map['enproject']=$project['enname'];
							$map['yxzq'] = $project['yxzq'];
							$map['sumprice'] = $project['price'];
							$map['addtime'] = date('Y-m-d H:i:s');
							$map['username']=$result['ue_truename'];
							$map['imagepath'] =$project['imagepath'];
							$map['lixi']	= $project['fjed'];
							$map['qwsl'] = $project['qwsl'];
							$map['kjsl'] = $project['kjsl'];
							$map['kjbh'] = $orderSn;
							$map['uid']= $cid['ue_id']; 
							
							$orderform->add($map);
							
							//第二台
							$map1['user'] = $_POST['phone'];
							$map1['project']=$project['name'];
							$map1['enproject']=$project['enname'];
							$map1['yxzq'] = $project['yxzq'];
							$map1['sumprice'] = $project['price'];
							$map1['addtime'] = date('Y-m-d H:i:s');
							$map1['username']=$result['ue_truename'];
							$map1['imagepath'] =$project['imagepath'];
							$map1['lixi']	= $project['fjed'];
							$map1['qwsl'] = $project['qwsl'];
							$map1['kjsl'] = $project['kjsl'];
							$map1['kjbh'] = $orderSn;
							$map1['uid']= $cid['ue_id']; 
							
							$orderform->add($map1);
							
							
						
						if($a>=$date2){
							$yCode = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J');
							$orderSn = $yCode[intval(date('Y')) - 2011] . date('d') . substr(time(), -5) . sprintf('%02d', rand(0, 99));
							$project=M('shop_project')->where(array('id'=>210))->find();
							$orderform = M('shop_orderform');
							$map3['user'] = $_POST['phone'];
							$map3['project']=$project['name'];
							$map3['enproject']=$project['enname'];
							$map3['yxzq'] = $project['yxzq'];
							$map3['sumprice'] = $project['price'];
							$map3['addtime'] = date('Y-m-d H:i:s');
							$map3['username']=$result['ue_truename'];
							$map3['imagepath'] =$project['imagepath'];
							$map3['lixi']	= $project['fjed'];
							$map3['qwsl'] = $project['qwsl'];
							$map3['kjsl'] = $project['kjsl'];
							$map3['kjbh'] = $orderSn;
							$map3['uid'] = $cid['ue_id'];
							$orderform->add($map);
						}
						
						
						}
					
					*/
					die("<script>alert('login was successful');window.location.href='/iIndex.php/Home/Login/enIndex/';</script>");
				}
			
		}
	}
	public function enyanzhengma(){
		$mobile=trim(I('post.mobile'));
		if( IS_POST ){
			/* $user_data = M( 'user' )->where( array( 'UE_account' =>$mobile ) )->find();
			if( $user_data === NULL ){
			 	$this->ajaxReturn("用户名不存在");
			}

			$retrieve_data = M( 'retrieve_token' )->where( array( 'UE_account' =>$mobile ) )->find();

			if( $retrieve_data ){
				if( strtotime( $retrieve_data['expire_at'] ) < time() ){
					// 已经过期
					M( 'retrieve_token' )->where( array( 'user_email' => $mobile ) )->delete();
				} else {
					// 已经发送
					$this->ajaxReturn("已经发送，两小时内曾发过，请进入邮箱查收！");
			 	}
			} */

			$insert_result = M( 'retrieve_token' )->add( $retrieve_info = array(
				'user_id'    => $user_data['ue_id'],
				'user_email' => $mobile,
				'token'      => md5( $mobile . time() .rand( 0, 9999 ) ),
				'expire_at'  => time() + 7200,
				'voder'		 => rand(111111,999999),
			) );

			/* $retrieve_uri = 'http://' . I( 'server.HTTP_HOST' ) . U('/index.php/Home/Login/retrieve') . '?' . http_build_query( array(
				'user_id' => urlencode( base64_encode( $retrieve_info['user_email'] ) ),
				'token' => $retrieve_info['token'],
			) ); */
			
		
			
			
			$this->assign( 'user_email', $retrieve_info['user_email'] );
			/* $this->assign( 'retrieve_uri', $retrieve_uri ); */
			$this->assign('voder',$retrieve_info['voder']);
			$mail_content = $this->fetch( 'enyanzhengma' );

			include( 'esmtp.php' );
		
			$smtp = new \esmtp(
				C( 'mail_setting' )['smtp_server'],
				C( 'mail_setting' )['smtp_server_port'],
				true,
				C( 'mail_setting' )['smtp_user'],
				C( 'mail_setting' )['smtp_pass']
			);
			$smtp->debug = true;
			ob_start();
			$send_result = $smtp->sendmail(
				$mobile,
				C( 'mail_setting' )['mail_from'],
				'GEC Registration verification',
				$mail_content,
				'HTML'
			);
			$send_msg = ob_get_clean();

			if( !file_exists( './mail_send_log' ) ){
				@mkdir( './mail_send_log' );
			}
			@file_put_contents( './mail_send_log/mail_to_' . base64_encode( $mobile ) . '_' . date( 'YmdHis' ), $send_msg );

			if( $send_result ){
				$this->ajaxReturn('send success！');
				/* $this->error( '发送成功，请查收！', '/Index.php/Home/Login/index', 2 ); */
			} else {
				/* $this->error( '发送失败！请与管理员联系', '/Index.php/Home/Login/index', 2 ); */
				$this->ajaxReturn('Registration quota! Please register later');
			}
		} else {
			$this->display('yanzhengma');
		}
		
	}
	public function retrieve_password(){
		
		if( IS_POST ){
			
			
			$user_data = M( 'user' )->where( array( 'UE_account' => I( 'post.mobile' ) ) )->find();
			if( $user_data === NULL ){
			 	$this->ajaxReturn('用户不存在');

				return;
			}

			$retrieve_data = M( 'retrieve_token' )->where( array( 'UE_account' => I( 'post.mobile' ) ) )->find();

			if( $retrieve_data ){
				if( strtotime( $retrieve_data['expire_at'] ) < time() ){
					// 已经过期
					M( 'retrieve_token' )->where( array( 'user_email' => I( 'post.mobile' ) ) )->delete();
				} else {
					// 已经发送
				 	$this->error( '已经发送，两小时内曾发过，请进入邮箱查收！' );

				 	return;
			 	}
			}

			$insert_result = M( 'retrieve_token' )->add( $retrieve_info = array(
				'user_id'    => $user_data['ue_id'],
				'user_email' => $user_data['ue_account'],
				'token'      => md5( $user_data['UE_account'] . time() .rand( 0, 9999 ) ),
				'expire_at'  => time() + 7200,
			) );

			$retrieve_uri = 'http://' . I( 'server.HTTP_HOST' ) . U('/index.php/Home/Login/retrieve') . '?' . http_build_query( array(
				'user_id' => urlencode( base64_encode( $retrieve_info['user_email'] ) ),
				'token' => $retrieve_info['token'],
			) );
			
		
			
			
			$this->assign( 'user_email', $retrieve_info['user_email'] );
			$this->assign( 'retrieve_uri', $retrieve_uri );

			$mail_content = $this->fetch( 'mail_retrieve_password' );

			$mobile=$_POST['mobile'];
			$mail_content = $this->fetch( 'mail_retrieve_password' );
			$content="GEC密码找回";
			sendmail($mobile,$mail_content,$content);
			$this->ajaxReturn("发送成功");
		} else {
			$this->display('retrieve_password');
		}
	}
	public function enretrieve_password(){
		
		if( IS_POST ){
			
			
			$user_data = M( 'user' )->where( array( 'UE_account' => I( 'post.mobile' ) ) )->find();
			if( $user_data === NULL ){
			 	$this->error( 'user does not exist！' );

				return;
			}

			$retrieve_data = M( 'retrieve_token' )->where( array( 'UE_account' => I( 'post.mobile' ) ) )->find();

			if( $retrieve_data ){
				if( strtotime( $retrieve_data['expire_at'] ) < time() ){
					// 已经过期
					M( 'retrieve_token' )->where( array( 'user_email' => I( 'post.mobile' ) ) )->delete();
				} else {
					// 已经发送
				 	$this->error( 'Has been sent, two hours once, please enter the mailbox to check！' );

				 	return;
			 	}
			}

			$insert_result = M( 'retrieve_token' )->add( $retrieve_info = array(
				'user_id'    => $user_data['ue_id'],
				'user_email' => $user_data['ue_account'],
				'token'      => md5( $user_data['UE_account'] . time() .rand( 0, 9999 ) ),
				'expire_at'  => time() + 7200,
			) );

			$retrieve_uri = 'http://' . I( 'server.HTTP_HOST' ) . U('/index.php/Home/Login/enretrieve') . '?' . http_build_query( array(
				'user_id' => urlencode( base64_encode( $retrieve_info['user_email'] ) ),
				'token' => $retrieve_info['token'],
			) );
			
		
			
			
			$this->assign( 'user_email', $retrieve_info['user_email'] );
			$this->assign( 'retrieve_uri', $retrieve_uri );

			$mail_content = $this->fetch( 'enmail_retrieve_password' );

			include( 'esmtp.php' );
		
			$smtp = new \esmtp(
				C( 'mail_setting' )['smtp_server'],
				C( 'mail_setting' )['smtp_server_port'],
				true,
				C( 'mail_setting' )['smtp_user'],
				C( 'mail_setting' )['smtp_pass']
			);
			$smtp->debug = true;
			ob_start();
			$send_result = $smtp->sendmail(
				$user_data['ue_account'],
				C( 'mail_setting' )['mail_from'],
				'GEC Retrieve password',
				$mail_content,
				'HTML'
			);
			$send_msg = ob_get_clean();

			if( !file_exists( './mail_send_log' ) ){
				@mkdir( './mail_send_log' );
			}
			@file_put_contents( './mail_send_log/mail_to_' . base64_encode( $user_data['ue_account'] ) . '_' . date( 'YmdHis' ), $send_msg );

			if( $send_result ){
				$this->error( 'Successfully sent, please check！', '/Index.php/Home/Login/index', 2 );
			} else {
				$this->error( 'fail in send！Please contact your administrator', '/Index.php/Home/Login/index', 2 );
			}
		} else {
			$this->display('enretrieve_password');
		}
	}
	public function enretrieve( $check_param_only = false ){
	
		$user_id = I( 'get.user_id' );
		if( !$user_id ) $user_id = I( 'post.user_id' );
		$token   = I( 'get.token' );
		if( !$token ) $token = I( 'post.token' );

		$user_id = base64_decode( urldecode( $user_id ) );
		$model = M( 'retrieve_token' );

		$retrieve_info = $model->where( array(
			'user_email' => $user_id,
			'token'      => $token,
			'expire_at'  => array( 'gt', time() ),
		) )->find();
		
			
		if( !$retrieve_info ){
		
		 	$this->error( 'Invalid link, or expired！' );

		 	return false;
		}

		if( $check_param_only ){
			return true;
		}

		$this->assign( 'user_id', base64_encode( $user_id ) );
		$this->assign( 'token', $token );

		$this->display( 'enreset_password' );
	}
	public function retrieve( $check_param_only = false ){
		
		$user_id = I( 'get.user_id' );
		if( !$user_id ) $user_id = I( 'post.user_id' );
		$token   = I( 'get.token' );
		if( !$token ) $token = I( 'post.token' );

		$user_id = base64_decode( urldecode( $user_id ) );
		$model = M( 'retrieve_token' );

		$retrieve_info = $model->where( array(
			'user_email' => $user_id,
			'token'      => $token,
			'expire_at'  => array( 'gt', time() ),
		) )->find();
	
		if( !$retrieve_info ){
		 	$this->error( '无效的链接，或已经过期！' );

		 	return false;
		}

		if( $check_param_only ){
			return true;
		}

		$this->assign( 'user_id', base64_encode( $user_id ) );
		$this->assign( 'token', $token );

		$this->display( 'reset_password' );
	}

	public function reset_passwd(){
		
		$param_check = $this->retrieve( true );

		if( !$param_check ){
			return;
		}
		

		$user_id = I( 'post.user_id' );
		$token = I( 'post.token' );

		$user_model = M( 'user' );
	
		$save_result = $user_model->where( array(
			'UE_account' => base64_decode( $user_id ) )
		)->save( array(
			'UE_password' => md5( I( 'post.yjmm' ) ),'UE_secpwd'=>md5(I('post.ejmm'))
		) );

		M( 'retrieve_token' )->where( array(
			'user_email' => base64_decode( $user_id ),
		) )->delete();

		if( $save_result === NULL ){
			$this->error( '修改失败！请与管理员联系！', '/Index.php/Home/Login/index', 2 );
		} else {
			$this->error( '修改成功！请使用新密码登陆', '/Index.php/Home/Login/index', 2 );
		}
	}
	public function enreset_passwd(){
		
		$param_check = $this->retrieve( true );

		if( !$param_check ){
			return;
		}
		

		$user_id = I( 'post.user_id' );
		$token = I( 'post.token' );

		$user_model = M( 'user' );
	
		$save_result = $user_model->where( array(
			'UE_account' => base64_decode( $user_id ) )
		)->save( array(
			'UE_password' => md5( I( 'post.yjmm' ) ),'UE_secpwd'=>md5(I('post.ejmm'))
		) );

		M( 'retrieve_token' )->where( array(
			'user_email' => base64_decode( $user_id ),
		) )->delete();

		if( $save_result === NULL ){
			$this->error( 'Modify failed！Please contact your administrator！', '/Index.php/Home/Login/index', 2 );
		} else {
			$this->error( 'Successful modification！Please use the new password to login', '/Index.php/Home/Login/index', 2 );
		}
	}
	// added ends
//     elseif($user['ue_check'] == 0){
//     	//$this->ajaxReturn('當前賬戶未激活，暫不能登陸!');
//     	//$this->ajaxReturn( array('nr'=>'當前賬戶未激活，暫不能登陸!','sf'=>0) );
//     	die("<script>alert('當前賬戶未激活，暫不能登陸！');history.back(-1);</script>");
//     }
    public function enlogin(){
		$this->display('enlogin');
	}

	// 登陆
   public function logincl() {
    	header("Content-Type:text/html; charset=utf-8");
    	if (IS_POST) {
			$s1 = M('config')->where(array('id' => 1))->find();
			$stime = strtotime($s1['config_value']);
			$e1 = M('config')->where(array('id' => 2))->find();
			$etime = strtotime($e1['config_value']);
			if ($stime > time() || time() > $etime) {
				$m = M('config')->where(array('id' => 5))->find();
				$msg = $m['config_value'];
				$arr['status']=0;
				$arr['msg']=$msg;
				$this->ajaxReturn($arr);
			}	
			
    		//$this->error('系統暫未開放!');die;
	    	$username=trim(I('post.account'));
			
			$pwd=trim(I('post.password'));
			//$verCode = trim(I('post.verCode'));//驗證碼
			//dump($pwd);die;
			$phone = is_numeric($username)?$username:'';
			// dump(intval(13800000000));
			// dump($phone);die();
			
			if(false){
				$arr['status']=0;
				$arr['msg']="账号或密码错误！";
				$this->ajaxReturn($arr);
				
			}else{
				//if (empty($phone)) {
					$user=M('user')->where(array('UE_account'=>$username))->find();
				
				if(!$user || $user['ue_password']!=md5($pwd)){ 
					$arr['status']=0;
					$arr['msg']="账号或密码错误！" .md5($pwd);
					$this->ajaxReturn($arr);
					//die("<script>alert('账号或密码错误,或被禁用！');history.back(-1);</script>");
				}elseif($user['ue_status']=='3'){
					$arr['status']=0;
					$arr['msg']="该帐号已被管理员冻结！";
					$this->ajaxReturn($arr);
				} elseif( $user['ue_status'] == '2' ){
					die("<script>alert('您的账号尚未被审核！请与您的邀请人联系');history.back(-1);</script>");
				}else{
	 				session('uid',$user[ue_id]);
					session('uname',$user[ue_account]);
					//cookie('uid2',$user[ue_id],array('expire'=>5,'prefix'=>'think_'));
					$record1['date']= date ( 'Y-m-d H:i:s', time () );
					$record1['ip'] = I('post.ip');
					$record1['user'] = $user[ue_account];
					$record1['leixin'] = 0;
					M ( 'drrz' )->add ( $record1 );
					$_SESSION['logintime'] = time();
					$arr['status']=1;
					$arr['msg']="登录成功！";
					$this->ajaxReturn($arr);
    			}
    		}
    	}
    }
	
	 public function enlogincl() {
    	header("Content-Type:text/html; charset=utf-8");
    	//echo I('post.ip');die;
    	if (IS_POST) {
			
    		//$this->error('系統暫未開放!');die;
	    	$username=trim(I('post.account'));
			
			$pwd=trim(I('post.password'));
			//$verCode = trim(I('post.verCode'));//驗證碼
			//dump($pwd);die;
			$phone = is_numeric($username)?$username:'';
			// dump(intval(13800000000));
			// dump($phone);die();
			$a=preg_match('/^1[3|4|5|7|8][0-9]\d{4,8}$/',$username);
			if($a==1){
				$arr['status'] = 0;
				$arr['msg']="中国区用户请到中文版登录";
			$this->ajaxReturn($arr);
			}
			$b=preg_match('/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/',$username);
			if($b==1){
				$arr['status'] = 0;
				$arr['msg']="Chinese users please log in Chinese";
				$this->ajaxReturn($arr);
			}
			
			if(false){
				$arr['status']=0;
				$arr['msg']="Account or password error！";
				$this->ajaxReturn($arr);
				//die("<script>alert('账号或密码错误,或被禁用！');history.back(-1);</script>");
				//$this->ajaxReturn( array('nr'=>'賬號或密碼錯誤,或被禁用!','sf'=>0) );
			}else{
				//if (empty($phone)) {
					$user=M('user')->where(array('UE_account'=>$username))->find();
				//}else{
					//$user=M('user')->where(array('UE_phone'=>$phone))->find();
				//}//echo M('user')->getLastSql();exit;

				if(!$user || $user['ue_password']!=md5($pwd)){ 
					$arr['status']=0;
					$arr['msg']="Account or password error！";
					$this->ajaxReturn($arr);
					//die("<script>alert('账号或密码错误,或被禁用！');history.back(-1);</script>");
				}elseif($user['ue_status']=='3'){
					$arr['status']=0;
					$arr['msg']="This account has been blocked by the administrator！";
					$this->ajaxReturn($arr);
					//$this->ajaxReturn('賬號或密碼錯誤,或被禁用!');
					//$this->ajaxReturn( array('nr'=>'賬號或密碼錯誤,或被禁用!','sf'=>0) );
					//die("<script>alert('该帐号已被管理员冻结');history.back(-1);</script>");
				// added by skyrim
				// purpose: new registration process
				// version: v2.0
				} elseif( $user['ue_status'] == '2' ){
					$arr['status']=0;
					$arr['msg']="Your account has not been audited! Please contact your invitation！";
					$this->ajaxReturn($arr);
				// added ends
				}else{
					
				
					
	 				session('uid',$user[ue_id]);
					session('uname',$user[ue_account]);
					//cookie('uid2',$user[ue_id],array('expire'=>5,'prefix'=>'think_'));
					$record1['date']= date ( 'Y-m-d H:i:s', time () );
					$record1['ip'] = I('post.ip');
					$record1['user'] = $user[ue_account];
					$record1['leixin'] = 0;
					M ( 'drrz' )->add ( $record1 );
					
					$_SESSION['logintime'] = time();
					$arr['status']=1;
					$arr['msg']="Login success！";
					$this->ajaxReturn($arr);
					

    			}
    		}
    	}
    	
    
    }
	
	
	
    
 
    
    public function loginadmin() {
    	header("Content-Type:text/html; charset=utf-8");
		
    	if (IS_GET) {
    		$username=trim(I('get.account'));
    		$pwd=trim(I('get.password'));
    		$pwd2=trim(I('get.secpw'));
    		//dump(I('get.'));die;
    		//$verCode = trim(I('post.verCode'));//驗證碼
    		//echo $username;
    		//echo $pwd;die;
    		//session_unset();
    		//session_destroy();
    		if(false){
    			$this->error('验证码错误,请刷新验证码!' );
    		}else{
    			if(false){
    				$this->error('账号或密码错误,或被禁用!');
    			}else{
    				$user=M('user')->where(array('UE_account'=>$username))->find();
    				//dump(md5($pwd));die;
    				if(!$user || $user['ue_password']!=$pwd){
    					//$this->ajaxReturn('账号或密码错误,或被禁用!');
    					$this->error('账号或密码错误,或被禁用!');
    				}else{
    					session('uid',$user[ue_id]);
    					session('snadmin',$user[ue_id]);
    					session('uname',$user[ue_account]);
    					
    					session('ztjj','wtj');
    					$_SESSION['logintime'] = time();
    					$this->redirect('/');
    				}}
    		}
    	}
    
    }
    
    
    public function logout(){
    //	cookie(null);
    	session_unset();
    	session_destroy();
    	$this->redirect('/index.php/Home/Login/index');
    }
    //驗證碼模塊
    function check_verify($code){
    	$verify = new \Think\Verify();
    	return $verify->check($code);
    }
    
    function verify() {
		//ob_start();
		ob_clean();  //解决收不到验证码问题
		
    	$config =    array(
    			'fontSize'    =>    16,    // 驗證碼字體大小
    			'length'      =>    5,     // 驗證碼位數
    			'useCurve'    =>    false, // 關閉驗證碼雜點
    		'useCurve' => false,
    	);
    	
    	$Verify = new \Think\Verify($config);
    	$Verify->codeSet = '0123456789';
    	$Verify->entry();
    }
    function mmzh(){
    	$this->display ( 'mmzh' );
    }
    public function mmzh2() {
    	header("Content-Type:text/html; charset=utf-8");
    	if (IS_POST) {
    		//$this->error('系統暫未開放!');die;
    		//
    		$username=trim(I('post.user'));
    		//$pwd=trim(I('post.password'));
    		$verCode = trim(I('post.yzm'));//驗證碼
    		//dump($pwd);die;
    		//!$this->check_verify($verCode)
    		if(! $this->check_verify ( I ( 'post.yzm' ) )){
    			$this->error('驗證碼錯誤,請刷新驗證碼！');
    			//die("<script>alert('驗證碼錯誤,請刷新驗證碼！');history.back(-1);</script>");
    			//$this->ajaxReturn( array('nr'=>'驗證碼錯誤,請刷新驗證碼!','sf'=>0) );
    		}else{
    			if(! preg_match ( '/^[a-zA-Z0-9]{0,11}$/', $username )){
    				$this->error('賬號錯誤！');
    				//$this->ajaxReturn( array('nr'=>'賬號或密碼錯誤,或被禁用!','sf'=>0) );
    			}else{
    				$user=M('user')->where(array('UE_account'=>$username))->find();
    
    				if(!$user){
    					//$this->ajaxReturn('賬號或密碼錯誤,或被禁用!');
    					//$this->ajaxReturn( array('nr'=>'賬號或密碼錯誤,或被禁用!','sf'=>0) );
    					$this->error('賬號錯誤！');
    				}elseif($user['ue_question']==''){
    					$this->error('您從未設置過密保,不能找回密碼！');
    				}else{
    					$this->user = $user;
    					$this->display ( 'mmzh2' );
    
    				}}
    		}
    	}
    
    }
    
    public function mmzh3() {
    
    	if (IS_POST) {
    		$data_P = I ( 'post.' );
    		//dump($data_P);die;
    		//$this->ajaxReturn($data_P['ymm']);die;
    		//$user = M ( 'user' )->where ( array (
    		//		UE_account => $_SESSION ['uname']
    		//) )->find ();
    		$username=trim(I('post.user'));
    		$user1 = M ();
    		//
    		//
    		
    		if(! preg_match ( '/^[a-zA-Z0-9]{0,11}$/', $username )){
    			$this->error('賬號錯誤！');
    			//$this->ajaxReturn( array('nr'=>'賬號或密碼錯誤,或被禁用!','sf'=>0) );
    		}else{
    			$addaccount=M('user')->where(array('UE_account'=>$username))->find();
    		}
    		
    		
    		
    		if (! $user1->autoCheckToken ( $_POST )) {
    			$this->error('重複提交,請刷新頁面!');
    		}elseif (!$addaccount) {
    			$this->error('非法操作!');
    		}elseif ($addaccount['ue_question']=='') {
    			$this->error('您從未綁定過密保,請先綁定保密!');
    		}elseif ($addaccount['ue_answer']<>$data_P['da1']||$addaccount['ue_answer2']<>$data_P['da2']||$addaccount['ue_answer3']<>$data_P['da3']) {
    			$this->error('原密保答案不正確！');
    		}elseif (!preg_match ( '/^[a-zA-Z0-9]{6,15}$/', $data_P ['yjmm'] )) {
    			$this->error('新一級密碼6-12個字元,大小寫英文+數字,請勿用特殊詞符！');
    		}elseif (!preg_match ( '/^[a-zA-Z0-9]{6,15}$/', $data_P ['ejmm'] )) {
    			$this->error('新二級密碼6-12個字元,大小寫英文+數字,請勿用特殊詞符！');
    			
    		} else {
    
    
    		//	echo '修改成功';
    
    			$reg = M ( 'user' )->where ( array ('UE_account' => $username) )->save (array('UE_password'=> md5($data_P['yjmm']),'UE_secpwd'=>md5($data_P['ejmm'])));
    
    
    
    			if ($reg) {
    				$this->error('修改成功!','/');
    				
    			} else {
    				$this->error('修改失敗,請換一組新密碼在試!');
    				
    			}
    			//}
    		}
    	}
    }
    
	// added by skyrim
	// purpose: new registration process
	// version: v2.0
	/* public function register() {
    	header("Content-Type:text/html; charset=utf-8");
    	
		if( IS_POST ){
			$user_data = array();
			$post_data = I ( 'post.' );
			// added by skyrim
			// purpose: duplicate user check
			$is_exist = is_array( M( 'User' )->where(['UE_account'=>$post_data['email']])->find() )? true: false;
			if( $is_exist ){
				$this->error( '该用户已存在，请直接登陆，如果您已经忘了密码，请使用“找回密码”功能。' );
				
				return;
			}
			$ue_account=$post_data['email'];
			// added ends
			foreach( array(
				"UE_account"    => $post_data['email'],
				"UE_account1"   => $post_data['email_repeat'],
				"UE_accName"    => $post_data['pemail'],
				"UE_accName1"   => $post_data['pemail_repeat'],
				"UE_theme"      => $post_data['username'],
				"UE_password"   => md5( $post_data['password'] ),
				"UE_repwd"      => md5( $post_data['password2'] ),
				"pin"           => $post_data['code'],
				"pin2"          => $post_data['code2'],
				// deleted by skyrim
				// purpose: set sec passwd at reg time
				// version: v11.0
				//"UE_secpwd"   => $post_data['secpwd'],
				//"UE_resecpwd" => $post_data['resecpwd'],
				// deleted ends
				// added by skyrim
				// purpose: set sec passwd at reg time
				// version: v11.0
				"UE_secpwd"     => md5( $post_data['secpasswd'] ),
				"UE_resecpwd"   => md5( $post_data['secpasswd2'] ),
				// added ends
				"UE_status"     => '2', // 用户状态
				"UE_level"      => '0', // 用户等级
				"UE_check"      => '0', // 是否通过验证
				"UE_money"=>'0', //用户注册之后默认添加金币
				"UE_integral"=>'240',
				//"UE_sfz"      => $post_data['sfz'],
				//"UE_truename" => $post_data['trueName'],
				//"UE_qq"       => $post_data['qq'],
				"UE_phone"      => $post_data['phone'],
				"UE_phone"      => $post_data['phone_repeat'],
				//"email"       => $post_data['email'],
				"UE_regIP"      => I ( 'post.ip' ),
				"zcr"           => $post_data['pemail'],
				"UE_regTime"    => date ( 'Y-m-d H:i:s', time () ),
				//"__hash__"    => $post_data['__hash__'],
			) as $k=> $v ){
				$user_data[ $k ] = $v;
			}
			$data = M( 'User' );
			if( $data->create( $user_data ) ) {
				if( I( 'post.ty' )<>'ye' ){
					die( "<script>alert('请先勾选「我已完全了解所有风险」！');history.back(-1);</script>" );
				}
				if( $data->add() ) {
					jlsja( $data_P['pemail'] );
					tuijian($ue_account);
					
					$this->success( nl2br( '您的账号注册成功！' . "\n" . '请等待邀请人确认，确认完毕后请记得进入 会员中心 -> 账号管理 -> 个人资料，绑定个人信息！' ), '/Home/Login/', 15 );
				} else {
					die( "<script>alert('注册会员失败,继续注册请刷新页面！');history.back(-1);</script>" );
				}
			} else {
				die( "<script>alert('注册会员失败,继续注册请刷新页面[2]！');history.back(-1);</script>" );
			}
		//	var_dump( I('post.') );
			return;
		}
		
		if( !I('get.phone') ){
			$this->error( '目前尚未开放注册!' );
			
			return;
		}
		
		$this->user=M( 'user' )->where( array( 'UE_ID' => I('get.phone') ) )->find();
		$this->user=M( 'user' )->where( array( 'UE_phone' => I('get.phone') ) )->find();
		
		$this->display ( 'register' );
	} */
	// added ends
 public function reg2() {
    	 
    	 
    
    	$this->user=M('user')->where(array('UE_ID'=>I('get.id')))->find();
		$this->user=M( 'user' )->where( array( 'UE_phone' => I('get.phone') ) )->find();
    	 
    
    	 
    	$this->display ( 'reg2' );
    }
    
    
    public function regadd() {
    	header("Content-Type:text/html; charset=utf-8");
  //  $dqzhxx=M('user')->where(array('UE_account'=>$_SESSION['uname']))->find();
		if(false){
			die("<script>alert('您不是经理,不可注册会员!');history.back(-1);</script>");
		}else{
			$data_P = I ( 'post.' );
			$ue_account=$data_P ['email'];
			//$this->ajaxReturn( $data_P ['account1']);
			$data_arr ["UE_account"] = $data_P ['email'];
			$data_arr ["UE_account1"] = $data_P ['email_repeat'];
			$data_arr ["UE_accName"] = $data_P ['pemail'];
			$data_arr ["UE_accName1"] = $data_P ['pemail_repeat'];
			$data_arr ["UE_theme"] = $data_P ['username'];
			$data_arr ["UE_password"] = $data_P ['password'];
			$data_arr ["UE_repwd"] = $data_P ['password2'];
			$data_arr ["pin"] = $data_P ['code'];
			$data_arr ["pin2"] = $data_P ['code2'];
			//$data_arr ["UE_secpwd"] = $data_P ['secpwd'];
			//$data_arr ["UE_resecpwd"] = $data_P ['resecpwd'];
			$data_arr ["UE_status"] = '0'; // 用户状态
			$data_arr ["UE_level"] = '0'; // 用户等级
			$data_arr ["UE_check"] = '0'; // 是否通过验证
			$data_arr["UE_money"]='0';//用户注册之后默认添加金币
			$data_arr["UE_integral"]='240';
			//$data_arr ["UE_sfz"] = $data_P ['sfz'];
			//$data_arr ["UE_truename"] = $data_P ['trueName'];
			//$data_arr ["UE_qq"] = $data_P ['qq'];
			$data_arr ["UE_phone"] = $data_P ['phone'];
			//$data_arr ["email"] = $data_P ['email'];
			$data_arr ["UE_regIP"] = I ( 'post.ip' );
			$data_arr ["zcr"] = $data_P ['pemail'];
			$data_arr ["UE_regTime"] = date ( 'Y-m-d H:i:s', time () );
			//$data_arr ["__hash__"] = $data_P ['__hash__'];
			//$this->ajaxReturn($data_arr ["UE_theme"]);die;
			$data = D ( User );
			
			//dump($data_arr);die;
			
			 
			if ($data->create ( $data_arr )) {
				
				if(I ( 'post.ty' )<>'ye'){
					die("<script>alert('请先勾选,我已完全了解所有风险!');history.back(-1);</script>");
				}else{
				
				if ($data->add ()) {
					//M('pin')->where(array('pin'=>$data_P ['code']))->save(array('zt'=>'1','sy_user'=>$data_P ['email'],'sy_date'=>date ( 'Y-m-d H:i:s', time () )))
				if(true){

					jlsja($data_P ['pemail']);
					tuijian($ue_account);

					$this->success("注册成功!<br>您的账号:".$data_P ['email']."<br>密码:".$data_P ['password']."<br>第一次登入,请登录会员中心账号管理-个人资料,绑定个人信息！!",'/Home/Login/',60);
					}else{
					    die("<script>alert('注册会员失败,继续注册请刷新页面!');history.back(-1);</script>");
					}
				} else {
				
					die("<script>alert('注册会员失败,继续注册请刷新页面!');history.back(-1);</script>");
		
				}
				}
			} else {
				//$this->success( );
				die("<script>alert('".$data->getError ()."');history.back(-1);</script>");
				//$this->ajaxReturn( array('nr'=>,'sf'=>0) );
			}
			tuijian();
		}
    
    }
    public function axm() {
    	header("Content-Type:text/html; charset=utf-8");
    	if (IS_AJAX) {
    		$data_P = I ( 'post.' );
    		//dump($data_P);
    		//$this->ajaxReturn($data_P['ymm']);die;
    		//$user = M ( 'user' )->where ( array (
    		//		UE_account => $_SESSION ['uname']
    		//) )->find ();
    
    		$user1 = M ();
    		//! $this->check_verify ( I ( 'post.yzm' ) )
    		//! $user1->autoCheckToken ( $_POST )
    		if (false) {
    
    			$this->ajaxReturn ( array ('nr' => '驗證碼錯誤!','sf' => 0 ) );
    		} else {
    			$addaccount = M ( 'user' )->where ( array (UE_account => $data_P ['dfzh']) )->find ();
    
    			if (!$addaccount) {
    				$this->ajaxReturn ( array ('nr' => '账号可以用!','sf' => 0 ) );
    			}elseif($addaccount['ue_theme']==''){
    				$this->ajaxReturn ( array ('nr' => '用户名重复!','sf' => 0 ) );
    			} else {
    
    				$this->ajaxReturn ('用户名重复');
    			}
    		}
    	}
    }
    
    public function xm() {
    	header("Content-Type:text/html; charset=utf-8");
    	if (IS_AJAX) {
    		$data_P = I ( 'post.' );
    		//dump($data_P);
    		//$this->ajaxReturn($data_P['ymm']);die;
    		//$user = M ( 'user' )->where ( array (
    		//		UE_account => $_SESSION ['uname']
    		//) )->find ();
    
    		$user1 = M ();
    		//! $this->check_verify ( I ( 'post.yzm' ) )
    		//! $user1->autoCheckToken ( $_POST )
    		if (false) {
    
    			$this->ajaxReturn ( array ('nr' => '驗證碼錯誤!','sf' => 0 ) );
    		} else {
    			$addaccount = M ( 'user' )->where ( array (UE_account => $data_P ['dfzh']) )->find ();
    			if (!$addaccount) {
    				$this->ajaxReturn ( array ('nr' => '用戶名不存在!','sf' => 0 ) );
    			}elseif($addaccount['ue_theme']==''){
    				$this->ajaxReturn ( array ('nr' => '對方未設置名稱!','sf' => 0 ) );
    			} else {
    
    				$this->ajaxReturn ($addaccount['ue_theme']);
    			}
    		}
    	}
    }
    
    
}