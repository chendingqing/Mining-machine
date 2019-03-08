<?php

namespace Admin\Controller;
use Think\Controller;
use Vendor\Wechat\Wechat;
use Vendor\Wechat\Snoopy;
class WeixinController extends Controller {
	function _initialize() {
		$useragent = $_SERVER ['HTTP_USER_AGENT'];
		if (strpos($useragent, 'MicroMessenger') === false) {
		echo " 非微信浏览器禁止访问";
		}
	}
	public function init() {
		$config = M ( "Wxconfig" )->where ( array ("id" => "1" ) )->find ();
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
	public function poster() {
			$uid=I('get.uid');
			$rshy = M ("userinfo")->where (array ("openid" => $uid ))->find ();
			
			if ($rshy) {
			    $path="./Poster/".$rshy['openid']."/";
			    $postname="poster_".$rshy['openid'].".jpg";
				$user_pic = $path.$postname;
				if (!file_exists($user_pic)) {
				    if (!is_dir($path)){
				        mkdir($path);
				    }
					$pic = 'https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket='.$rshy['ticket'];
					$data = file_get_contents($pic);
					$filename = "ticket_".$rshy['openid'].".jpg";
					$fp = @fopen($path.$filename,"w");
					@fwrite($fp,$data);
					//fclose($fp);
					$ticket = $path.$filename;
					$tpic=$rshy['wx_avatar'].".jpg";
					$data=file_get_contents($tpic);
					$filename = "logo_".$rshy['openid'].".jpg";
					$fp = @fopen($path.$filename,"w");
					@fwrite($fp,$data);
					fclose($fp);
					$logo = $path.$filename;
					$name=$rshy['nickname']; 
					$img = new \Think\Image();
					$img->open($ticket)->thumb(296, 296)->save($ticket);
					if(!empty($logo)){$img->open($logo)->thumb(62, 62)->save($logo);}
					define('THINKIMAGE_WATER_CENTER', 5);
				    $img->open('./card.jpg')->water($ticket, array(165,525))->water($logo, array(-78,-970))->text($name,'./hei.ttf','20','#d53917', array(-255,-970))->save($user_pic);
				}	
				
			}
			$this->assign('openid',$rshy['openid']);
			$this->assign('imgname',$postname);
			$this->display();
		
	}
	public function userfind(){
		echo "11111111111111111";die();
	}
	
	
}