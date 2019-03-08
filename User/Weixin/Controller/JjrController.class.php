<?php
namespace Home\Controller;
use Home\Controller\BasisController;
use Vendor\Wechat\Wechat;
use Vendor\Wechat\Snoopy;
class JjrController extends BasisController{  
	public function yjtx(){
		$result = M ( 'accountinfo' )->where ( 'uid=' . session ( 'uid' ) )->find ();
		$this->assign ( 'result', $result );
		$this->display ();
    }
	//提现验证
	public function txorder(){
		$time=time();
	$uid=session('uid');
	//dump($uid);exit;
	$money=I('post.money');
	$pwd=I('post.pwd');
	$user=M("userinfo")->where("uid={$uid}")->find();
	if(empty($money) || empty($pwd)){
	echo"<script>alert('请完善提现信息');window.history.go(-1);</script>";
	exit;
	}
	if(empty($user)){
	echo"<script>alert('未找到该用户信息');window.history.go(-1);</script>";
	exit;
	}else{
	$password=authcode($user['pwd'], 'DECODE');
	if($pwd!=$password){
		
		$this->success("您输入的密码有误");
		exit;
	}

	}
	   $prices=M("accountinfo")->where("uid={$uid}")->find();
		//dump($prices);exit;
		$price=$prices['yjye'];
		if($money>$price){
		echo"<script>alert('佣金余额不足');window.history.go(-1);</script>";
		    exit;
		}
        if (file_exists ( './Public/Conf/txinfo.php' )) 
		{
			require './Public/Conf/txinfo.php';
			$txinfo = json_decode ( $txinfo, true );
		}
		$tx=M("balance")->where("bptype='佣金提现'and uid={$uid}")->order("bpid desc")->find();
		$jgtime=$txinfo['txjgtime']*3600;
		if(($time-$jgtime)<$tx['bptime']){
			$this->success('两次提现需间隔'.$txinfo['txjgtime'].'小时');
		     exit;
		
		}
		$orderno='TX'.session('uid').randomkeys(10);
		if($money<$txinfo['txmax']){
			$this->success('提现金额不能小于'.$txinfo['txmax'].'元');
		     exit;   
		}elseif($money>$txinfo['txonemin']){
			$this->success('单次提现金额不能大于'.$txinfo['txonemin'].'元');
		     exit;    
		}elseif($money>=$txinfo['txaccess'] && $money<=$txinfo['txonemin']){
		if($txinfo['txsxf']){
        $data=array();
		$data['uid']=$uid;
		$data['bpprice']=$money-$money*($txinfo['txsxf']/100);
		$data['bptype']="佣金提现";
		$data['bptime']=$time;
		$data['sxfprice']=$money*($txinfo['txsxf']/100);
		$data['isverified']	=0;
		$data['orderno']=$orderno;
		$data['msg']='您的申请已提交我们将在24小时内通过审核';
		}else{
		 $data=array();
		 $data['uid']=$uid;
		 $data['bpprice']=$money;
		$data['bptype']="佣金提现";
		$data['bptime']=$time;
		$data['isverified']	=0;
		$data['orderno']=$orderno;
		$data['msg']='您的申请已提交我们将在24小时内通过审核';
		}
		$newyjye=$price-$money;
		M("accountinfo")->where("uid={$uid}")->setField('yjye',$newyjye);
		M("balance")->add($data);
            echo"<script>alert('您的申请已提交我们将在24小时内通过审核');window.history.go(-1);</script>";
		    exit;
		}else{
			 import ( 'ComPay', APP_PATH . 'Common/fukuan', '.class.php' );
			 if($txinfo['txsxf']){
       $option['mchid']=$txinfo['mchid'];
	   $option['appid']=$txinfo['appid'];
	   $option['apikey']=$txinfo['apikey'];
	   $option['openid']=$user['openid'];
	   $option['amount']=($money-$money*($txinfo['txsxf']/100))*100;
	   $option['desc']="佣金";
	   $option['partnertradeno']=$orderno;
			 }else{
			 $option['mchid']=$txinfo['mchid'];
	         $option['appid']=$txinfo['appid'];
	         $option['apikey']=$txinfo['apikey'];
	         $option['openid']=$user['openid'];
	         $option['amount']=$money*100;
	         $option['desc']="佣金";
	         $option['partnertradeno']=$orderno;
			 }
        $cash = new \ComPay;
		
		$cash->setApiKey($txinfo['key']);
		$msg=$cash->ComPay($option);
		//dump();exit;
		if($msg['result_code']=="SUCCESS"){
			$returnMsg='发放成功';
			$isverified=1;
			$array=array();
			$array['uid']=$uid;
			$array['price']=-$money;
			$array['addtime']=time();
			$array['orderno']=$orderno;
			$array['remarks']='订单'.$orderno.'提现';
			$array['ousername']=$user['nickname'];
			M("caiwu")->add($array);
		}else{
		   $returnMsg=$msg['return_msg'];
		   $isverified=0;
		}
		if($txinfo['txsxf']){
		 $data=array();
		 $data['uid']=$uid;
		$data['bpprice']=$money-$money*($txinfo['txsxf']/100);
		$data['bptype']="佣金提现";
		$data['bptime']=$time;
		$data['sxfprice']=$money*($txinfo['txsxf']/100);
		$data['isverified']	= $isverified;
		$data['orderno']=$orderno;
		$data['msg']=$returnMsg;
		}else{
		 $data=array();
		 $data['uid']=$uid;
		$data['bpprice']=$money;
		$data['bptype']="佣金提现";
		$data['bptime']=$time;
		$data['isverified']	= $isverified;
		$data['orderno']=$orderno;
		$data['msg']=$returnMsg;
		}
		$prices=M("accountinfo")->where("uid={$uid}")->find();
		$price=$prices['yjye'];
		if($money>$price){
		echo"<script>alert('佣金余额不足');window.history.go(-1);</script>";
		   
		}
		$newyjye=$price-$money;
		M("accountinfo")->where("uid={$uid}")->setField('yjye',$newyjye);
		if($isverified==1){
		  $weObj=$this->init();
			  $datas = array();
                    $datas['touser'] = $user['openid'];
                    $datas['msgtype'] = 'text';
                    $datas['text']['content'] = '您的零钱已入账,请注意查收';
				   $weObj->sendCustomMessage($datas);
		}
		$rs=M("balance")->add($data);
		if($rs){
		$this->success($returnMsg,u('User/txjl'));
		}
		}
	}
	//提现验证
	public function yetxorder(){
		$time=time();
	$uid=session('uid');
	//dump($uid);exit;
	$money=I('post.money');
	$pwd=I('post.pwd');
	$user=M("userinfo")->where("uid={$uid}")->find();
	if(empty($money) || empty($pwd)){
	echo"<script>alert('请完善提现信息');window.history.go(-1);</script>";
	exit;
	}
	if(empty($user)){
	echo"<script>alert('未找到该用户信息');window.history.go(-1);</script>";
	exit;
	}else{
	$password=authcode($user['pwd'], 'DECODE');
	if($pwd!=$password){
		echo"<script>alert('您输入的密码有误');window.history.go(-1);</script>";
		exit;
	}
	}
	   $prices=M("accountinfo")->where("uid={$uid}")->find();
		//dump($prices);exit;
		$price=$prices['balance'];
		if($money>$price){
		echo"<script>alert('佣金余额不足');window.history.go(-1);</script>";
		    exit;
		}
        if (file_exists ( './Public/Conf/txinfo.php' )) 
		{
			require './Public/Conf/txinfo.php';
			$txinfo = json_decode ( $txinfo, true );
		}
		$tx=M("balance")->where("bptype='余额提现'and uid={$uid}")->order("bpid desc")->find();
		$jgtime=$txinfo['txjgtime']*3600;
		if(($time-$jgtime)<$tx['bptime']){
		echo'<script>alert("两次提现需间隔'.$txinfo['txjgtime'].'小时");window.history.go(-1);</script>';
		}
		$orderno='TX'.session('uid').randomkeys(10);
		if($money<$txinfo['txmax']){
			echo'<script>alert("提现金额不能小于'.$txinfo.'元");window.history.go(-1);</script>';
		    exit;
		}elseif($money>$txinfo['txonemin']){
		   echo'<script>alert("单次提现金额不能大于'.$txinfo['txonemin'].'元");window.history.go(-1);</script>';
		    exit;
		}elseif($money>=$txinfo['txaccess'] && $money<=$txinfo['txonemin']){
			if($txinfo['txsxf']){
		 $data=array();
		 $data['uid']=$uid;
		$data['bpprice']=$money-$money*($txinfo['txsxf']/100);
		$data['bptype']="余额提现";
		$data['bptime']=$time;
		$data['sxfprice']=$money*($txinfo['txsxf']/100);
		$data['isverified']	= $isverified;
		$data['orderno']=$orderno;
		$data['msg']=$returnMsg;
		}else{
        $data=array();
		$data['uid']=$uid;
		$data['bpprice']=$money;
		$data['bptype']="余额提现";
		$data['bptime']=$time;
		$data['isverified']	=0;
		$data['orderno']=$orderno;
		$data['msg']='您的申请已提交我们将在24小时内通过审核';
		}
		$newyjye=$price-$money;
		M("accountinfo")->where("uid={$uid}")->setField('balance',$newyjye);
		M("balance")->add($data);
            echo"<script>alert('您的申请已提交我们将在24小时内通过审核');window.history.go(-1);</script>";
		    exit;
		}else{
			 import ( 'ComPay', APP_PATH . 'Common/fukuan', '.class.php' );
       if($txinfo['txsxf']){
       $option['mchid']=$txinfo['mchid'];
	   $option['appid']=$txinfo['appid'];
	   $option['apikey']=$txinfo['apikey'];
	   $option['openid']=$user['openid'];
	   $option['amount']=($money-$money*($txinfo['txsxf']/100))*100;
	   $option['desc']="佣金";
	   $option['partnertradeno']=$orderno;
			 }else{
			 $option['mchid']=$txinfo['mchid'];
	         $option['appid']=$txinfo['appid'];
	         $option['apikey']=$txinfo['apikey'];
	         $option['openid']=$user['openid'];
	         $option['amount']=$money*100;
	         $option['desc']="佣金";
	         $option['partnertradeno']=$orderno;
			 }
        $cash = new \ComPay;
		
		$cash->setApiKey($txinfo['key']);
		$msg=$cash->ComPay($option);
		//dump();exit;
		if($msg['result_code']=="SUCCESS"){
			$returnMsg='发放成功';
			$isverified=1;
			$array=array();
			$array['uid']=$uid;
			$array['price']=-$money;
			$array['type']=4;
			$array['addtime']=time();
			$array['orderno']=$orderno;
			$array['remarks']='订单'.$orderno.'余额提现';
			$array['ousername']=$user['nickname'];
			M("caiwu")->add($array);
		}else{
		   $returnMsg=$msg['return_msg'];
		   $isverified=0;
		}
		if($txinfo['txsxf']){
		 $data=array();
		 $data['uid']=$uid;
		$data['bpprice']=$money-$money*($txinfo['txsxf']/100);
		$data['bptype']="余额提现";
		$data['bptime']=$time;
		$data['sxfprice']=$money*($txinfo['txsxf']/100);
		$data['isverified']	= $isverified;
		$data['orderno']=$orderno;
		$data['msg']=$returnMsg;
		}else{
		 $data=array();
		 $data['uid']=$uid;
		$data['bpprice']=$money;
		$data['bptype']="余额提现";
		$data['bptime']=$time;
		$data['isverified']	= $isverified;
		$data['orderno']=$orderno;
		$data['msg']=$returnMsg;
		}
		
		$newyjye=$price-$money;
		M("accountinfo")->where("uid={$uid}")->setField('balance',$newyjye);
		if($isverified==1){
		  $weObj=$this->init();
			  $datas = array();
                    $datas['touser'] = $user['openid'];
                    $datas['msgtype'] = 'text';
                    $datas['text']['content'] = '您的零钱已入账,请注意查收';
				   $weObj->sendCustomMessage($datas);
		}
		$res=M("balance")->add($data);
		if($res){
		$this->success($returnMsg,u('User/txjl'));
		}
		
		}
	}
}