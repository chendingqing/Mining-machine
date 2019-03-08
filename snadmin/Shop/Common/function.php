<?php
function get_menu() {
		$list = M ( 'Wxmenu' )->order ( 'pid asc,menu_id asc' )->select ();
		// 取一级菜单
		foreach ( $list as $k => $vo ) {
			if ($vo ['pid'] != 0)
				continue;
	
			$one_arr [$vo ['menu_id']] = $vo;
			unset ( $list [$k] );
		}
	
		foreach ( $one_arr as $p ) {
			$data [] = $p;
			$two_arr = array ();
			foreach ( $list as $key => $l ) {
				if ($l ['pid'] != $p ['menu_id'])
					continue;
	
				$l ['menu_name'] = '├──' . $l ['menu_name'];
				$two_arr [] = $l;
				unset ( $list [$key] );
			}
	
			$data = array_merge ( $data, $two_arr );
		}
	
		return $data;
	}
	function _deal_data($d)
	{
		$res ['name'] = str_replace ( '├──', '', $d ['menu_name'] );
	
		if ($d ['menu_type'] == 'view') {
				
			$res ['type'] = 'view';
				
			$res ['url'] = trim ( $d ['view_url'] );
		} elseif ($d ['type'] != 'none') {
				
			$res ['type'] = trim ( $d ['menu_type'] );
				
			$res ['key'] = trim ( $d ['event_key'] );
		}
	
		return $res;
	}
	function json_encode_cn($data)
	
	{
		$data = json_encode($data);
	
		return preg_replace("/\\\u([0-9a-f]{4})/ie", "iconv('UCS-2BE', 'UTF-8', pack('H*', '$1'));", $data);
	
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

function cate($var){
		$user = M('user');
		$ztname=$user->where(array('UE_accName'=>$var,'UE_check'=>'1','UE_stop'=>'1'))->getField('ue_account',true);
		$zttj = count($ztname);
		$reg=$ztname;
		$datazs = $zttj;
		if($zttj<=10){
			$s=$zttj;
		}else{
			$s=10;
		}
		if($zttj!=0){

		  for($i=1;$i<$s;$i++){
				if($reg!=''){
					$reg=$user->where(array('UE_accName'=>array('IN',$reg),'UE_check'=>'1','UE_stop'=>'1'))->getField('ue_account',true);
					$datazs +=count($reg);
				}
			}
			
		}
		
	//	$this->ajaxReturn();
		
	return $datazs;
	
	
	
	
}


function sfjhff($r) {
	$a = array("正常用户", "已激活（禁用）","未激活");
	return $a[$r];
}





function tgbz_zd_cl($id){
	
		 
		$tgbzuser=M('tgbz')->where(array('id'=>$id,'zt'=>'0'))->find();

		if($tgbzuser['zffs1']=='1'){$zffs1='1';}else{$zffs1='5';}
		if($tgbzuser['zffs2']=='1'){$zffs2='1';}else{$zffs2='5';}
		if($tgbzuser['zffs3']=='1'){$zffs3='1';}else{$zffs3='5';}
		$User = M ( 'jsbz' ); // 實例化User對象

		$where['zffs1']  = $zffs1;
		$where['zffs2']  = $zffs2;
		$where['zffs3']  = $zffs3;
		$where['_logic'] = 'or';
		$map['_complex'] = $where;
		$map['zt']=0;

		$count = $User->where ( $map )->select(); // 查詢滿足要求的總記錄數
		return $count;



}






function jsbz_jb($id){

		
	$tgbzuser=M('jsbz')->where(array('id'=>$id))->find();

	
	return $tgbzuser['jb'];



}

function tgbz_jb($id){


	$tgbzuser=M('tgbz')->where(array('id'=>$id))->find();


	return $tgbzuser['jb'];



}

                //提供接受帮助
function ppdd_add($p_id,$g_id){

	
	 $g_user1 = M('jsbz')->where(array('id'=>$g_id,'zt'=>'0'))->find();
	 $p_user1=M('tgbz')->where(array('id'=>$p_id))->find();
	 
	 M('user')->where(array('UE_account'=>$p_user1['user']))->save(array('pp_user'=>$g_user1['user']));
	 M('user')->where(array('UE_account'=>$g_user1['user']))->save(array('pp_user'=>$p_user1['user']));
	 
	 // echo $g_user['id'].'<br>';
    		    $data_add['p_id']=$p_user1['id'];
    		    $data_add['g_id']=$g_user1['id'];
    		    $data_add['jb']=$g_user1['jb'];
    		    $data_add['p_user']=$p_user1['user'];
    		    $data_add['g_user']=$g_user1['user'];
    		    $data_add['date']=date ( 'Y-m-d H:i:s', time () );
    		    $data_add['zt']='0';
    		    $data_add['pic']='0';
    		    $data_add['zffs1']=$p_user1['zffs1'];
    		    $data_add['zffs2']=$p_user1['zffs2'];
    		    $data_add['zffs3']=$p_user1['zffs3'];
    		    M('tgbz')->where(array('id'=>$p_id,'zt'=>'0'))->save(array('zt'=>'1'));
    		    M('jsbz')->where(array('id'=>$g_id,'zt'=>'0'))->save(array('zt'=>'1'));
				M('user_jj')->where(array('tgbz_id'=>$p_id))->save(array('zt'=>3));
    		   // echo $p_user1['user'].'<br>';
    		    if(M('ppdd')->add($data_add)){
    		    	//查询接受方用户信息
					$get_user=M('user')->where(array('UE_account'=>$g_user1['user']))->find();
					if($get_user['ue_phone']) sendSMS($get_user['ue_phone'],"您好！您申请帮助的资金：".$g_user1['jb']."元，已匹配成功，请登录网站查看匹配信息！");
    		    	return true;
    		    }else{
    		    	return false;
    		    }


}
function user_sfxt($var){
	if($var[c]==0){
	$zctj=0;
	$zctjuser=M('ppdd')->where(array('p_user'=>$var[a]))->select();
	
	foreach($zctjuser as $value){
		if($value['g_user']==$var['b']){
			$zctj=1;
		}
	}
	
	if($zctj==1){
		return "<span style='color:#FF0000;'>匹配过</span>";
	}else{
		return "否";
	}
	}elseif($var[c]==1){
		$zctj=0;
		$zctjuser=M('ppdd')->where(array('g_user'=>$var[a]))->select();
		
		foreach($zctjuser as $value){
			if($value['p_user']==$var['b']){
				$zctj=1;
			}
		}
		
		if($zctj==1){
			return "<span style='color:#FF0000;'>匹配过</span>";
		}else{
			return "否";
		}
	}

// 	$userxx=M('user')->where(array('UE_account'=>$var[a]))->find();
// //	M('user')->where(array('UE_account'=>$g_user1['user']))->save(array('pp_user'=>$p_user1['user']));
// if($userxx['pp_user']==$var[b]){
// 	return "<span style='color:#FF0000;'>匹配过</span>";
// }else{
// 	return "否";
// }




}

function ppdd_add2($p_id,$g_id){


	$g_user1 = M('jsbz')->where(array('id'=>$g_id))->find();
	$p_user1=M('tgbz')->where(array('id'=>$p_id,'zt'=>'0'))->find();

	// echo $g_user['id'].'<br>';
	$data_add['p_id']=$p_user1['id'];
	$data_add['g_id']=$g_user1['id'];
	$data_add['jb']=$p_user1['jb'];
	$data_add['p_user']=$p_user1['user'];
	$data_add['g_user']=$g_user1['user'];
	$data_add['date']=date ( 'Y-m-d H:i:s', time () );
	$data_add['zt']='0';
	$data_add['pic']='0';
	$data_add['zffs1']=$p_user1['zffs1'];
	$data_add['zffs2']=$p_user1['zffs2'];
	$data_add['zffs3']=$p_user1['zffs3'];
	M('tgbz')->where(array('id'=>$p_id,'zt'=>'0'))->save(array('zt'=>'1'));
	M('jsbz')->where(array('id'=>$g_id,'zt'=>'0'))->save(array('zt'=>'1'));
	M('user_jj')->where(array('tgbz_id'=>$p_id))->save(array('zt'=>3));
	// echo $p_user1['user'].'<br>';
	if(M('ppdd')->add($data_add)){
		//查询支付方用户信息
		$pay_user=M('user')->where(array('UE_account'=>$p_user1['user']))->find();
		if($pay_user['ue_phone']) sendSMS($pay_user['ue_phone'],"您好！您提供帮助的资金：".$p_user1['jb']."元，已匹配成功，请登录网站查看匹配信息，并打款！");
		return true;
	}else{
		return false;
	}


}

function ipjc($auser){

	$tgbz_user_xx=M('user')->where(array('UE_regIP'=>$auser))->count();
	//echo $ppddxx['p_id'];die;


	return $tgbz_user_xx;

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
		return "发送成功!";
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

function listDir($dir){
                $dir .= substr($dir, -1) == '/' ? '' : '/';
                $dirInfo = array();
                foreach (glob($dir.'*') as $v) {
                    $dirInfo[] = $v; 
                    if(is_dir($v)){
                        $dirInfo = array_merge($dirInfo, listDir($v));
                    }
                }
                return $dirInfo;
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
