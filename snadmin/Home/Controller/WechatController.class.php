<?php
namespace Home \Controller;
use Think\Controller;
use Vendor\Wechat\Wechat;
use Vendor\Wechat\Snoopy;
class WechatController extends Controller {
	public function init() {
		header('Content-type:textml;charset=utf-8'); 
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
	public function index() {
		
		$weObj = $this->init ();
		$weObj->valid ();
		$type = $weObj->getRev ()->getRevType ();
		$openid = $weObj->getRevFrom ();
		session('uid',$openid);
		$users= M ( "user" );
		switch ($type) {
			case Wechat::MSGTYPE_TEXT :
				$weObj->text ( "欢迎关注莱肯币平台" )->reply ();
				break;
			case Wechat::MSGTYPE_EVENT :
				$eventype = $weObj->getRev ()->getRevEvent ();
				if ($eventype ['event'] == "CLICK") {
					if ($eventype ['key'] == 'erweima') {
						$rshy=$users->where(array('openid'=>session('uid')))->find();
						if ($rshy['wxtype']==0) {
							$text = "注册会员后才能生成个人海报";
						}else {
							
							$text = '我的海报<a href="http://' . $_SERVER['SERVER_NAME'] . '/admin8899.php/Shop/Weixin/poster/uid/'.session('uid').'.html">点击生成</a>';
						}
					}
					if ($eventype ['key'] == "rukou") {
						$text = '立即开玩<a href="http://' . $_SERVER['SERVER_NAME'] . '/index.php/Home/Index/index">点击进入</a>';
					}
						$weObj->text ($text)->reply ();
					
				} elseif ($eventype ['event'] == "SCAN") {
					
					$weObj->text ( "欢迎关注莱肯币平台" )->reply ();
					
				} elseif ($eventype ['event'] == "subscribe") {
					unset($data);
					$flg=0;
					if (!empty($eventype ['ticket'])){
						$tjuser=$users->where(array ('ticket'=>$eventype ['ticket']))->find();
						if ($tjuser) {
							$data['managername']=$tjuser['nickname'];
							$data['tpath']=$tjuser['tpath'].','.$tjuser['uid'];
							$flg=1;
						}else {
							$weObj->text ( "扫描二维码关注失败，请取消重新关注" )->reply ();
							exit();
						}
					}else{
						$data['tpath']=0;
						$data['UE_accName']="自己关注";
					}
					
                    $wx_info = $weObj->getUserInfo(session('uid'));
                    $rshy=$users->where(array('openid'=>session('uid')))->find();
                    if (!$rshy) {
						//关注添加数据库
                    	$data['openid']=session('uid');
                    	$data['UE_truename']=$wx_info['nickname'];
                    	$data['adress']=$wx_info['province'].$wx_info['city'];
                    	$data['wx_avatar']=$wx_info['headimgurl'];
						$data['UE_accName'] = $tjuser['ue_account'];
                    	$user_id =M('user')->add ( $data );

                    	if ($user_id) {
                    	$ticket = $weObj->getQRCode($user_id,1);
                    	unset($data);
                    	$data['UE_ID']=$user_id;
                    	$data['ticket']=$ticket['ticket'];
                    	$data['url']=$ticket['url'];
                    	$rs=$users->save($data);
                    	if ($rs) {
                    		if ($flg==1) {
                    			$weObj->text ( "您通过{$tjuser['ue_truename']}关注了本平台,成为本平台的第{$user_id}用户，欢迎您的关注！" )->reply ();
                    			$data = array();
                    			$data['touser'] = $tjuser['openid'];
                    			$data['msgtype'] = 'text';
                    			$data['text']['content'] = '【'.$wx_info[nickname].'】通过名片关注了本公众号，成为您的家族成员！';
                    			$weObj->sendCustomMessage($data);
                    		}else {
                    			$weObj->text ( "欢迎关注莱肯币平台" )->reply ();
                    		}
                    		
                    	}else {
                    		$weObj->text ( "错误" )->reply ();
                    	}
                    }
                  }else {
                  	$weObj->text ( "欢迎回来，亲爱的用户" )->reply ();
                  }
				}
				 else {
					$weObj->text ( "非法操作" )->reply ();
				}
				break;
			default :
				$weObj->text ( "help info" )->reply ();
		}
	}
}