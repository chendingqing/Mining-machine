<?php
namespace Weixin\Controller;
use Think\Controller;
use Vendor\Wechat\Wechat;
use Vendor\Wechat\Snoopy;
class IndexController extends Controller
   { 
	    public function init($type = 'index')
        {
          $agent = $_SERVER['HTTP_USER_AGENT'];
            $config = M("Wxconfig")->where(array(
                "id" => "1"
            ))->find();
            $options = array(
                'token' => $config ["token"], 
                'encodingaeskey' => $config ["encodingaeskey"],
                'appid' => $config ["appid"], 
                'appsecret' => $config ["appsecret"],
                'partnerid' => $config ["partnerid"], 
                'partnerkey' => $config ["partnerkey"], 
                'paysignkey' => $config ["paysignkey"] 
            );
            $weObj = new Wechat ($options);
            $info = $weObj->getOauthAccessToken();
            if (!$info) {
                $callback = 'http://' . $_SERVER ['SERVER_NAME'] . U("Index/$type", $_GET);
                $url = $weObj->getOauthRedirect($callback, '', 'snsapi_base');
                header("Location: $url");
                exit();
            } else {
                session('newopen',$info['openid']);
            }     
    }
	public function app(){
		$useragent = $_SERVER ['HTTP_USER_AGENT'];
		if(!strpos ($useragent, 'MicroMessenger' )){
			$link=1;
		}else{
		$link=2;
		}
		$this->assign("link",$link);
	$this->display();
	}
	public function check_type(){
	$this->display();
	}
	//账户充值
    public function recharge()
    {
		$this->init("recharge");
		$openid=session('newopen');
		$user=M('userinfo')->where(array('openid'=>$openid))->find();
		if(!$user){
          $this->redirect('User/index');
		}else{
		 session('uid',$user['uid']);
		}
        $rshy=M('userinfo')->where(array('uid'=>$uid))->find();
        $result = M('accountinfo')->where('uid='. $uid)->find();
       	$rshy['balance']=$result['balance'];
        $this->assign('result', $result);
        $this->assign('rshy', $rshy);
        if (IS_POST) {
        	$params = json_decode(file_get_contents('php://input'),true);
             $date['bpprice']=$params["DepositAmount"];
            $date['bpno']=$this->build_order_no();
             $date['uid']=$uid;
             $date['bptype']='充值';
             $date['bptime']=date(time());
             $date['remarks']='开始充值';
             $balanceid=M('balance')->add($date);
             if ($balanceid) {
                $balc=M('balance')->where('bpid='.$balanceid)->find();
                $this->assign('balc',$balc);
             }
             $s['id'] = $balanceid;
             $s['success']=1;
             $s['errors'] = 0;
             $this->ajaxReturn($s);
        }
        $this->display();
    }
	public function addorder(){
	$uid=session('uid');
	$result=M("account")->where("uid={$uid}")->find();
	$price=I('get.price');
   if($price<=0){
   echo"<script>alert('请正确输入充值金额');window.history.go(-1);</script>";
   }
	$time=time();
	$orderno= 'CZ'.session('uid').randomkeys(10);
	     $data=array();
	    $data['uid']=$uid;
		$data['bpprice']=$price;
		$data['bptype']="充值";
		$data['bptime']=$time;
		$data['isverified']	=0;
		$data['orderno']=$orderno;
		M("balance")->add($data);
		$arr=array();
		$arr['err']=false;
		$arr['msg']="订单提交成功";
	 $arr['orderid']=$orderno;
	 $this->ajaxReturn($arr);
       //$payurl = 'http://' . $_SERVER ['SERVER_NAME'] . U('Home/User/pay', array('totalprice' => $price, 'cart_name' => $data['bptype'], 'uid' => $uid, 'orderid' => $orderno));
      //$this->success('提交成功，转向支付页面', $payurl);
	}
	public function pay()
    { 
	   $uid=session('uid');
	   $user=M("userinfo")->where("uid={$uid}")->find();
	   $openid=$user['openid'];
		$orderid = $_GET['orderid'];
		$order_info = M('balance')->where(array('orderno'=>$orderid))->find();
		 $this->assign('uid',$openid);
		 if(empty($order_info))
		{
			exit('订单信息错误');
		}
		$yunpay = M('Yunpay')->find();
		if($yunpay['zt']==1) {
			//$url = 'http://' . $_SERVER ['SERVER_NAME'].'/api/passpay3/shanpay.php?WIDout_trade_no=' . $orderid . '&WIDsubject=' . $orderid . '&WIDtotal_fee=' . $order_info['bpprice'];	
			header("Location: $url");
			exit();	
			
		}
		$config = M ( "wxconfig" )->where ( array (
				"id" => "1" 
		) )->find ();
		$options = array (
				'token' => $config ["token"], // 填写你设定的key
				'encodingaeskey' => $config ["encodingaeskey"], // 填写加密用的EncodingAESKey
				'appid' => $config ["appid"], // 填写高级调用功能的app id
				'appsecret' => $config ["appsecret"], // 填写高级调用功能的密钥
				'partnerid' => $config ["partnerid"], // 财付通商户身份标识
				'partnerkey' => $config ["partnerkey"], // 财付通商户权限密钥Key
				'paysignkey' => $config ["paysignkey"]  // 商户签名密钥Key
				);
		$weObj = new Wechat ( $options );

		$cart_name = $order_info['bptype'];
		$cart_num = 1;
		$cart_price = $order_info['bpprice'];
		$userdata = M ("userinfo")->where( array ("uid" => $uid) )->find ();
		if(empty($userdata))
		{
			exit('用户信息错误');
		}
		$username = $userdata['username'];
		$phone = $userdata['phone'];
		$address = $userdata['address'];
		$this->assign ( "username", $username );
		$this->assign ( "phone", $phone );
		$this->assign ( "address", $address );
		$this->assign ( "cart_name", $cart_name );
		$this->assign ( "cart_num", $cart_num );
		$this->assign ( "cart_price", $order_info['bpprice']);
		$appid = $options['appid'];
		$mch_id = $options['partnerid'];
		$out_trade_no = $orderid;
		$body = $order_info['bptype'];
		$total_fee = $order_info['bpprice']*100;
		if($openid==$this->test_uid){
			$total_fee = 1;
		}
		$notify_url = 'http://' . $_SERVER ['SERVER_NAME'] . __ROOT__ . '/api/wxpay/notify_url.php';
            
		$spbill_create_ip = $_SERVER["REMOTE_ADDR"];
		
		$nonce_str = $weObj->generateNonceStr();
		
		//
		$pay_xml = $weObj->createPackageXml($appid,$mch_id,$nonce_str,$body,$out_trade_no,$total_fee,$spbill_create_ip,$notify_url,$openid);
		
		
		$pay_xml =  $weObj->get_pay_id($pay_xml);
		
		if($pay_xml['return_code']=='FAIL'){
			echo $pay_xml['return_msg'];
			echo json_encode($options);
			exit();
		}
		
		if($pay_xml['err_code']=="ORDERPAID")
		{
			$this->redirect('Weixin/User/payover',array('out_trade_no'=>$out_trade_no,'uid'=>$openid)); 
			eixt();
		}
		$prepay_id = $pay_xml['prepay_id'];
		
		$jsApiObj["appId"] = $appid;
		$timeStamp = time();
	    $jsApiObj["timeStamp"] ="$timeStamp";
	    $jsApiObj["nonceStr"] = $nonce_str;
		$jsApiObj["package"] = "prepay_id=$prepay_id";
	    $jsApiObj["signType"] = "MD5";
	    $jsApiObj["paySign"] = $weObj->getPaySignature($jsApiObj);
		$url = json_encode($jsApiObj);
		//var_dump($jsApiObj["package"]);exit;
		$returnUrl = 'http://' . $_SERVER ['SERVER_NAME']. U('Weixin/User/payover',array('orderid'=>$out_trade_no,'uid'=>$uid));
		$this->assign ( "price", $order_info['bpprice']);
		$this->assign ( "url", $url );
		$this->assign ( "returnUrl", $returnUrl );
		$this->display ();
	}
	public function payover(){ 
        $uid=session('uid');
		$user=M("userinfo")->where("uid={$uid}")->find();
		$out_trade_no =I('get.orderid');

		$order_info = M("balance")->where(array('orderno' => $out_trade_no))->find();
	if (empty($order_info)) {			
			echo"<script>alert('未找到该订单信息');</script>";
			return false;	
		}	
        $orderstatus=$this->get_wxorderinfo($out_trade_no); 
		 if($orderstatus['total_fee']!=($order_info['bpprice']*100)){
		$this->success('对不起,您的支付金额有误！',U('Index/app'));
			 exit;
		 }
       if ($orderstatus['result_code']!='SUCCESS'|| $orderstatus['return_msg']!='OK' )
	   {
		 $this->success('对不起！您的订单还未支付，请返回重新支付！',U('Index/app'));
		   exit;
	    }
		M("balance")->where(array('orderno' => $out_trade_no))->setField('isverified',1);
		$bpprice=$order_info['bpprice'];
		$user_price=M("accountinfo")->where("uid={$uid}")->find();
		$newprice=$bpprice+$user_price['balance'];
	   M("accountinfo")->where("uid={$uid}")->setField('balance',$newprice);
		    $array=array();
			$array['uid']=$uid;
			$array['price']=+$order_info['bpprice'];
			$array['addtime']=time();
			$array['orderno']=$order_info['orderno'];
			$array['remarks']='订单'.$order_info['orderno'].'充值';
			$array['type']=3;
			$array['ousername']=$user['nickname'];
			M("caiwu")->add($array);
			$data=array();
            $data['uid']=$uid;
			$data['nickname']=$user['nickname'];
			$data['phone']=$user['phone'];
			$data['ctype']=1;
			$data['price']=$order_info['bpprice'];
			$data['addtime']=time();
			$data['memo']='订单'.$order_info['orderno'].'充值';
			$add=M("recharge")->add($data);
			if($add){
            $this->success('充值成功',U('Index/app')); 
			}       
	}
	  //账户提现
        public function cash() {
		$this->init("cash");
		$balance = D ( 'accountinfo' );
		$uid = session ( 'uid' );
		$openid=session('newopen');
		$user=M('userinfo')->where(array('openid'=>$openid))->find();
		if(!$user){
          $this->redirect('User/index');
		}else{
		session("uid",$user['uid']);
		}
		$rshy = M ( 'userinfo' )->where ( array ('openid' => $openid ) )->find();
		if(empty($rshy['username'])||empty($rshy['idcard'])||empty($rshy['bankno'])){
			$this->redirect('Index/preinfo');
		}
		$totle = $balance->field ( 'balance,yjye' )->where ( 'uid=' . $uid )->find ();
		$rshy ['balance'] = $totle ['balance'];
		$rshy ['yjye'] = $totle ['yjye'];
		if($rshy ['balance']<=0){
			$rshy ['balance']=0.00;
		}
		$this->assign ( 'rshy', $rshy );
		$this->display ();
	}
	//提现验证
	public function yetxorder(){
	$time=time();
	$uid=session('uid');
	$money=I('post.money');
	$pwd=I('post.pwd');
	$wallet=I('post.wallet');
	$user=M("userinfo")->where("uid={$uid}")->find();
	if(empty($money) || empty($pwd)){
		$this->error('请完善提现信息');
	exit;
	}
	if(empty($user)){
		$this->error('未找到该用户信息');
	exit;
	}else{
	$password=authcode($user['pwd'], 'DECODE');
	if($pwd!=$password){
		$this->error('您输入的密码有误');
		exit;
	}
	}
	   $prices=M("accountinfo")->where("uid={$uid}")->find();
		if($wallet==1){
			if($money>$prices['balance']){
				$this->error('余额不足');
			}
			$ms='余额提现';
		}elseif($wallet==2){
			if($money>$prices['yjye']){
				$this->error('佣金余额不足');
			}
			$ms='佣金提现';
		}else{
			$this->error('提现信息不正确');
		}
        if (file_exists ( './Public/Conf/txinfo.php' )) 
		{
			require './Public/Conf/txinfo.php';
			$txinfo = json_decode ( $txinfo, true );
		}
		$tx=M("balance")->where("bptype={$ms} and uid={$uid}")->order("bpid desc")->find();
		$jgtime=$txinfo['txjgtime']*3600;
		if(($time-$jgtime)<$tx['bptime']){
			$this->error('两次提现需间隔'.$txinfo['txjgtime'].'小时');
		    exit;
		}
		$orderno='TX'.session('uid').randomkeys(10);
		if($money<$txinfo['txmax']){
			$this->error('提现金额不能小于'.$txinfo['txmax'].'元');
		    exit;
		}elseif($money>$txinfo['txonemin']){
			$this->error('单次提现金额不能大于'.$txinfo['txonemin'].'元');
		    exit;
		}elseif($money>=$txinfo['txaccess'] && $money<=$txinfo['txonemin']){
			if($txinfo['txsxf']){
		 $data=array();
		$data['uid']=$uid;
		$data['bpprice']=$money-$money*($txinfo['txsxf']/100);
		$data['bptype']=$ms;
		$data['bptime']=$time;
		$data['sxfprice']=$money*($txinfo['txsxf']/100);
		$data['isverified']	= $isverified;
		$data['orderno']=$orderno;
		$data['msg']=$returnMsg;
		}else{
        $data=array();
		$data['uid']=$uid;
		$data['bpprice']=$money;
		$data['bptype']=$ms;
		$data['bptime']=$time;
		$data['isverified']	=0;
		$data['orderno']=$orderno;
		$data['msg']='您的申请已提交我们将在24小时内通过审核';
		}	
		unset($carr);
		if($wallet==1){
			$carr['balance']=array('exp','balance-'.$money);
		}else{
			$carr['yjye']=array('exp','yjye-'.$money);
		}
		M("accountinfo")->where("uid={$uid}")->setField($carr);
		M("balance")->add($data);
		$this->success('您的申请已提交我们将在24小时内通过审核');
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
		if($msg['result_code']=="SUCCESS"){
			$returnMsg='发放成功';
			$isverified=1;
			$array=array();
			$array['uid']=$uid;
			$array['price']=-$money;
			$array['type']=4;
			$array['addtime']=time();
			$array['orderno']=$orderno;
			$array['remarks']='订单'.$orderno.$ms;
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
		$data['bptype']=$ms;
		$data['bptime']=$time;
		$data['sxfprice']=$money*($txinfo['txsxf']/100);
		$data['isverified']	= $isverified;
		$data['orderno']=$orderno;
		$data['msg']=$returnMsg;
		}else{
		 $data=array();
		 $data['uid']=$uid;
		$data['bpprice']=$money;
		$data['bptype']=$ms;
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
		$this->success($returnMsg,u('Index/app'));
		}
		}
	}
	public function preinfo(){
		$this->init('preinfo');
		$users=M('userinfo');
		
			$rshy = $users->where ( array ('openid' => session('newopen') ) )->find ();
			if (!$rshy) {
				 $this->error("未找到指定的用户");
			}
			$this->assign ( 'rshy', $rshy );
			$this->display ();
				
	}
	public function do_preinfo(){
			$uid=I('post.uid');
			$username=I('post.username');
			$idcard=I('post.idcard');
			$bankno=I('post.bankno');
			unset($uparr);
			$uparr['username']=$username;
			$uparr['idcard']=$idcard;
			$uparr['bankno']=$bankno;
			$rse=M("userinfo")->where(array('uid'=>$uid))->setField($uparr);
			if ($rse) {
				$this->success('完善成功',u('Index/cash'));
			}
		
	}
}