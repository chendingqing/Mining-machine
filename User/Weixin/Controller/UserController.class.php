<?php
namespace Weixin\Controller;
use Think\Controller;
use Weixin\Controller\CommonController;
class UserController extends CommonController
{  
	public function index(){
		
		$this->display();
	}
	public function check_type(){
	$this->display();
	}
	public function reg()
    {   
    	$uid=I('get.uid');
		$openid=I('get.openid');
		if($uid){
	    $user=M("user")->where("openid='{$openid}'")->find();
		$uid=$user['uid'];
		}
        $this->assign('uid',$uid);
        $this->display();
    }
	function denglu(){
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
		//var_dump($order_info);exit;
		
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
		//var_dump($weObj);exit;
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
			 $this->success('对不起,您的支付金额有误！',U('User/memberinfo'));
		 }
       if ($orderstatus['result_code']!='SUCCESS'|| $orderstatus['return_msg']!='OK' )
	   {
		echo"<script>alert('对不起！您的订单还未支付，请返回重新支付！');</script>";
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
            $this->success('充值成功'); 
			}       
	}
	public function get_wxorderinfo($orderid=0)
	{
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
         
      if (!$orderid ) return false;
               $wxorderinfo = $weObj->get_order_info($orderid);
              
     if (!$wxorderinfo )
     {
     	return false;
     }else{
	    return  $wxorderinfo;
     }
	}//
    
     //账户提现
    public function cash() {
		$balance = D ( 'accountinfo' );
		$uid = session ( 'uid' );
		$openid=session('newopen');
		$user=M('userinfo')->where(array('openid'=>$openid))->find();
		if(!$user){
          $this->redirect('Home/User/check_type');
		}
		$rshy = M ( 'userinfo' )->where ( array ('uid' => $uid ) )->find ();
		if(empty($rshy['username'])||empty($rshy['idcard'])||empty($rshy['bankno'])){
			$this->redirect('Home/User/preinfo');
		}
		$totle = $balance->field ( 'balance' )->where ( 'uid=' . $uid )->find ();
		$rshy ['balance'] = $totle ['balance'];
		$this->assign ( 'rshy', $rshy );
		$this->display ();
	}
    //账户充值
    public function recharge()
    {
        $uid = session('uid');
		$openid=session('newopen');
		$user=M('userinfo')->where(array('openid'=>$openid))->find();
		if(!$user){
          $this->redirect('Home/User/check_type');
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
    //处理支付后的结果，加钱
    public function notify(){
         $orderno=I('get.order_id');
         $balance=M('balance')->where('bpno='.$orderno)->find();
     
         //判断订单是否存在，并且判断是否是同一个人操作
         if ($balance&&$balance['uid']==$_SESSION['uid']) {
            $date['bpno']=$balance['bpno'];
            $date['remarks']='充值成功';
            $style=M('balance')->where('uid='.$balance['uid'])->save($date);
            //修改客户的帐号余额
            if ($style) {
                //查询订单金额
                $prict=M('balance')->where('uid='.$balance['uid'])->find();
                //先取出用户帐号的余额。
                $userprice=M('accountinfo')->where('uid='.$balance['uid'])->find();
                $mydate['balance']=$prict['bpprice']+$userprice['balance'];
                M('accountinfo')->where('uid='.$balance['uid'])->save($mydate);
            }
         }
         $this->redirect('User/memberinfo');   
    }
      //体验卷列表
 

	
    
}