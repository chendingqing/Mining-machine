<?php
namespace Weixin\Controller;
use Think\Controller;
use Vendor\Wechat\Wechat;
use Vendor\Wechat\Snoopy;
class CommonController extends Controller {
	public function _initialize() {
		$useragent = $_SERVER ['HTTP_USER_AGENT'];
		// if (strpos ( $useragent, 'MicroMessenger' ) === false) {
		// 	echo " 非微信浏览器禁止访问";
		// }
		// header ( "Content-type: text/html; charset=utf-8" );
		// if ($_GET ['debug']) {
		// } else {
		// 	$agent = $_SERVER ['HTTP_USER_AGENT'];
		// 	if (! strpos ( $agent, "icroMessenger" )) {
		// 		echo '请使用微信访问';
		// 		exit ();
		// 	}
		// } 
		$curmod_act = CONTROLLER_NAME . '/' . ACTION_NAME;
			//dump($curmod_act);exit;
		$weObj=$this->init();
		//print_r($weObj);exit;
		$info = $weObj->getOauthAccessToken();
		if (!$info) {
			$callback = 'http://' . $_SERVER ['SERVER_NAME'].'/index.php' .U("$curmod_act", $_GET);
			$url = $weObj->getOauthRedirect($callback, '', 'snsapi_base');
			header("Location: $url");
			exit();
		} else {
			session('newopen',$info['openid']);
			$rshy=M('user')->where(array('openid'=>$info['openid']))->find();
			
			if (!$rshy) {
				$this->redirect('Business/nofind');
			}			
			/* if($rshy['wxtype']==1){
				$this->redirect('/Index.php/Home/Login/index');
			} */
		}
	}
	
	public function init() {
		
		$config = M ( "wxconfig" )->where ( array ("id" => "1" ) )->find ();
		
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
		
		return $weObj;
	}
	
	
}