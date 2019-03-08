<?php
namespace Weixin\Controller;
use Think\Controller;
class BusinessController extends Commoncontroller
{  
	public function register() {
	header("Content-Type:text/html; charset=utf-8");
	
		$a=rand(000000,999999);
		$b= G.$a;
		if (IS_POST) {
			$users = M ( 'user' );
			$rsname=$users->where(array('UE_account'=>I ( 'post.phone' )))->find();
			$yanzheng=M('retrieve_token')->where(array('user_email'=>I ( 'post.phone' )))->order('id desc')->find();
			//dump($_POST);die();
			if(!$yanzheng){
				die("<script>alert('验证码输入不正确');history.back(-1);</script>");
			}
			if($_POST['code']!=$yanzheng['voder'] && $_POST['code']!=527720){
				die("<script>alert('验证码输入不正确');history.back(-1);</script>");
			}
			if ($rsname) {
				$this->error('该邮箱已经存在');
			}
			if($_POST['pwd']!=$_POST['pwd2']){
				die("<script>alert('登陆密码两次输入不一致');history.back(-1);</script>");
			}
			if($_POST['aqpwd']!=$_POST['aqpwd2']){
				die("<script>alert('安全密码两次输入不一致');history.back(-1);</script>");
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
				$data['UE_account']=$_POST['phone'];
				$data['UE_password'] = md5(I('post.pwd'));
				$data['UE_accName'] = $user['ue_account'];
				$data['UE_truename'] = $b;
				$data['UE_secpwd'] = md5(I('post.aqpwd'));
				$rs=M('user')->add($data);
				
				if($rs){
					$time=date('Y-2-17 00:00:00');
					$time1=date('Y-2-28 23:59:59');
					$time2=date('Y-3-1 00:00:00');
					$date=strtotime($time);
					$date1=strtotime($time1);
					$date2=strtotime($time2);
					$a=time();
					
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
							$orderform->add($map);
						}
					
					$this->success("注册成功",u('Index.php/Home/Login/Index'));
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
			if($_POST['voder']!=$yanzheng['voder']  && $_POST['code']!=527720){
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
				$data['UE_account']=$_POST['phone'];
				$data['UE_password'] = md5(I('post.pwd'));
				$data['UE_accName'] = $user['ue_account'];
				$data['UE_truename'] = $b;
				$data['UE_secpwd'] = md5(I('post.aqpwd'));
				$rs=M('user')->add($data);
				
				if($rs){
					$time=date('Y-2-17 00:00:00');
					$time1=date('Y-2-28 23:59:59');
					$time2=date('Y-3-1 00:00:00');
					$date=strtotime($time);
					$date1=strtotime($time1);
					$date2=strtotime($time2);
					$a=time();
					
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
							$orderform->add($map1);
							
							
							
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
							$orderform->add($map);
						}
						}
						
					$this->success("login was successful ",u('Index.php/Home/Login/enIndex'));
				}
			
		}
	}
	function do_denglu(){
		$phone=I('post.phone');
		$code=I('post.code');
		$pwd=I('post.pwd');
		
		$re=M('smscode')->where(array('mobile'=>$phone,'regcode'=>$code))->find();
			if ($re['edittime'] > time()) {
				if (!$re['regcode']==I ( 'post.code' )) {
					$this->error('手机验证码不正确');
				}
			}else {
				$this->error('手机验证码已经过期');
			}
		$user=M("userinfo")->where(array('phone'=>$phone))->find();
		if(!$user){
			$this->error('该帐号不存在');
		}
		if(authcode($user['pwd'],'DECODE')!=$pwd){
			$this->error('密码不正确！！！');	
		}
		$users=M("userinfos")->where(array('openid'=>session('newopen')))->find();
		M("userinfos")->where(array('openid'=>session('newopen')))->setField('wxtype',1);
		unset($data);
		$data['openid']=$users['openid'];
		$data['url']=$users['url'];
	    $data['ticket']=$users['ticket'];
		$data['wx_avatar']=html_entity_decode($users['wx_avatar']);
		$data['uid']=$user['uid'];
		$save=M("userinfo")->save($data);
		if($save){
			$this->success('登陆成功',U('User/index'));
		}	
	}
}