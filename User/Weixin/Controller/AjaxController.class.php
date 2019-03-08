<?php
namespace Weixin\Controller;
use	 Think\Controller;
class AjaxController extends Controller{
	public function getmobilecode1(){
		
		$mobile=trim(I('post.mobile'));
		
		if(empty($mobile)){
			
			echo json_encode('请输入用户名');exit();
		}
		$mobilepreg='/^1[3|4|5|7|8][0-9]{9}$/';
		if (!preg_match($mobilepreg,$mobile)){
			echo json_encode('用户名不符合规范');exit();
		}
		$users=M('user');
		$rsu=$users->where(array('UE_account'=>$mobile))->find();
		if (!$rsu){
			echo json_encode('会员不存在');exit();
		}
		//echo json_encode('hello world ');die();
		
		$qycode=rand(111111,999999);
		
		$apikey = "5d5c49ab2f78b40037aef522a0b87954 "; //请用自己的apikey代替
		$text="【莱肯社区】您正在找回密码，您的新密码是".$qycode;
		$url="http://yunpian.com/v1/sms/send.json";
		$encoded_text = urlencode("$text");
		$mobile = urlencode("$mobile");
		$post_string="apikey=$apikey&text=$encoded_text&mobile=$mobile";
		
		$info = $this->sock_post($url, $post_string);
		
		$infoary=explode(',',$info);
		if ($infoary[0]!='{"code":0'){
			echo json_encode('发送失败');exit();
		}
		unset($upary);
		$upary['UE_password']=md5($qycode);
	
		if($users->where(array('UE_account'=>$rsu['ue_account']))->setField($upary)===false){
			echo json_encode('更新数据失败');exit();
		}
		echo json_encode('短信发送成功。请注意查收');exit();
	}
	public function sock_post($url, $query) {
		$data = '';
		$info = parse_url ( $url );
		$fp = fsockopen ( $info ['host'], 80, $errno, $errstr, 30 );
		if (! $fp) {
			return $data;
		}
		$head = 'POST ' . $info ['path'] . ' HTTP/1.0' . "\r\n" . '';
		$head .= 'Host: ' . $info ['host'] . "\r\n";
		$head .= 'Referer: http://' . $info ['host'] . $info ['path'] . "\r\n";
		$head .= 'Content-type: application/x-www-form-urlencoded' . "\r\n" . '';
		$head .= 'Content-Length: ' . strlen ( trim ( $query ) ) . "\r\n";
		$head .= "\r\n";
		$head .= trim ( $query );
		$write = fputs ( $fp, $head );
		$header = '';
		while ( $str = trim ( fgets ( $fp, 4096 ))) {
			$header .= $str;
		}
		while ( ! feof ( $fp ) ) {
			$data .= fgets ( $fp, 4096 );
		}
		return $data;
	}
	public function getmobilecode(){
		$mobile=trim(I('post.mobile'));
		if(empty($mobile)){
			echo json_encode('请输入手机');exit();
		}
		$mobilepreg='/^1[3|4|5|7|8][0-9]{9}$/';
		if (!preg_match($mobilepreg,$mobile)){
			echo json_encode('手机不符合规范');exit();
		}
		$users=M('userinfos');
		$rsu=$users->where(array('phone'=>array('eq',$mobile)))->find();
		if ($rsu){
			echo json_encode('手机已经存在');exit();
		}
		//是否发送过验证码了
		$smscode=M('smscode');
		$rsyz=$smscode->where(array('mobile'=>array('eq',$mobile)))->find();
		if ($rsyz){
			if((time()-$rsyz['sendtime'])<60){
				echo json_encode('请在60秒后再获取');exit();
			}
		}	
		//发送手机验证码
		$qycode=rand(111111,999999);
		$apikey = "7aaf8c9e446d8114f657e6efbf65e3a8"; //请用自己的apikey代替
		$text="【玩赚60秒】您的验证码是{$qycode}。如非本人操作，请忽略本短信";
		$url="http://yunpian.com/v1/sms/send.json";
		$encoded_text = urlencode("$text");
		$mobile = urlencode("$mobile");
		$post_string="apikey=$apikey&text=$encoded_text&mobile=$mobile";
		$info = parent::sock_post($url, $post_string);
		$infoary=explode(',',$info);
		if ($infoary[0]!='{"code":0'){
			echo json_encode('发送失败');exit();
		}
		if ($rsyz){
			if(false===$smscode->where(array('id'=>$rsyz['id']))->setField(array('regcode'=>$qycode,'sendtime'=>time(),'state'=>0,'edittime'=>time()+600))){
				echo json_encode('更新数据失败');exit();
			}
		}else{
			unset($data);
			$data['mobile']=$mobile;
			$data['regcode']=$qycode;
			$data['sendtime']=time();
			$data['state']=0;
			$data['edittime']=time()+600;
			if(!$smscode->add($data)){
				echo json_encode('更新数据失败');exit();
			}
		}
		echo json_encode('短信发送成功。请注意查收');exit();
	}
	public function parnum(){
		$news=M('newsinfo');
		$num=I('post.num');
		$nid=I('post.id');
		unset($uparr);
		$uparr['praisenumber']=array('exp','praisenumber+1');
		$rsup=$news->where(array('nid'=>$nid))->setField($uparr);
		if ($rsup) {
			echo json_encode("点赞成功");
		}else{
			echo json_encode("点赞失败");
		}
	}
}
?>