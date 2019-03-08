<?php
function authcode($string, $operation = 'ENCODE', $key = '', $expiry = 0) {
		$ckey_length = 4;
		$key = md5 ( $key ? $key : 'default_key' );
		$keya = md5 ( substr ( $key, 0, 16 ) );
		$keyb = md5 ( substr ( $key, 16, 16 ) );
		$keyc = ($ckey_length ? ($operation == 'DECODE' ? substr ( $string, 0, $ckey_length ) : substr ( md5 ( microtime () ), - $ckey_length )) : '');
		$cryptkey = $keya . md5 ( $keya . $keyc );
		$key_length = strlen ( $cryptkey );
		$string = ($operation == 'DECODE' ? base64_decode ( substr ( $string, $ckey_length ) ) : sprintf ( '%010d', $expiry ? $expiry + time () : 0 ) . substr ( md5 ( $string . $keyb ), 0, 16 ) . $string);
		$string_length = strlen ( $string );
		$result = '';
		$box = range ( 0, 255 );
		$rndkey = array ();
	
		for($i = 0; $i <= 255; $i ++) {
			$rndkey [$i] = ord ( $cryptkey [$i % $key_length] );
		}
	
		for($j = $i = 0; $i < 256; $i ++) {
			$j = ($j + $box [$i] + $rndkey [$i]) % 256;
			$tmp = $box [$i];
			$box [$i] = $box [$j];
			$box [$j] = $tmp;
		}
	
		for($a = $j = $i = 0; $i < $string_length; $i ++) {
			$a = ($a + 1) % 256;
			$j = ($j + $box [$a]) % 256;
			$tmp = $box [$a];
			$box [$a] = $box [$j];
			$box [$j] = $tmp;
			$result .= chr ( ord ( $string [$i] ) ^ $box [($box [$a] + $box [$j]) % 256] );
		}
		if ($operation == 'DECODE') {
			if (((substr ( $result, 0, 10 ) == 0) || (0 < (substr ( $result, 0, 10 ) - time ()))) && (substr ( $result, 10, 16 ) == substr ( md5 ( substr ( $result, 26 ) . $keyb ), 0, 16 ))) {
				return substr ( $result, 26 );
			} else {
				return '';
			}
		} else {
			return $keyc . str_replace ( '=', '', base64_encode ( $result ) );
		}
	}
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





 function tgzb_jd_jb($i){
		$settings = include( dirname( APP_PATH ) . '/User/Home/Conf/settings.php' );
		//$arr = M('user_jj')->where(array('zt'=>'0'))->select();
		$map['zt'] = ['neq','1'];
		$arr = M('user_jj')->where($map)->select();
		//dump($arr);
		
		$jd_jb = 0;
		foreach($arr as $k=>$v){
			
			$jd_time = $v['date'];
			$aab=strtotime($jd_time);
			
			$NowTime=date('Y-m-d',$aab);
			$NowTime2=date('Y-m-d',time());
		
			$day1 = $NowTime;
			$day2 = $NowTime2;
			
			$diff = diffBetweenTwoDays1($day1, $day2);
			
			//dump($settings['withdraw_day_diff']);
			//dump($diff);die();
			
			if($diff>$settings['withdraw_day_diff']){
				
				$jd_jb += user_jj_lx8($v['id'])+($v['jb']);
				
			}
			
		//	dump($v[ue_account]);
			//echo $i;
			/* $jd_jb = $arr['jb'];
			if($v['ue_account']){
			countSql($v['ue_account'],$i);
			} */
			
		}
		//echo $i;
		
		return $jd_jb;
	}
	//利息金额
	function tgzb_jd_jb1($i){
		$settings = include( dirname( APP_PATH ) . '/User/Home/Conf/settings.php' );
		//$arr = M('user_jj')->where(array('zt'=>'0'))->select();
		//$map['zt'] = ['neq','1'];
		$arr = M('user_jj')->select();
		//dump($arr);
		
		$lx_jb = 0;
		foreach($arr as $k=>$v){
			
			$jd_time = $v['date'];
			$aab=strtotime($jd_time);
			
			$NowTime=date('Y-m-d',$aab);
			$NowTime2=date('Y-m-d',time());
		
			$day1 = $NowTime;
			$day2 = $NowTime2;
			
			$diff = diffBetweenTwoDays1($day1, $day2);
			//dump($diff);
			//dump($settings['withdraw_day_diff']);
			//dump($diff);die();
			//dump(empty($diff));
			if($diff){
				
				$lx_jb += user_jj_lx8($v['id']);
				
			}
			
		//	dump($v[ue_account]);
			//echo $i;
			/* $jd_jb = $arr['jb'];
			if($v['ue_account']){
			countSql($v['ue_account'],$i);
			} */
			
		}
		//echo $i;
		
		return $lx_jb;
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



function user_count($var){
	$count=M('user')->where(array('UE_accName'=>$var))->count();

	// $result=M('user')->where(array('UE_accName'=>$result['ue_account']))->count();

	return "$count";
}
function user_count1($var){
		
		$user=M('user');
		/* 一代 */
		$result=M('user')->where(array('UE_accName'=>$var))->select();//一代
		/* 二代 */
		foreach($result as $v){
			
			 $results=$user->where(array('UE_accName'=>$v['ue_account']))->select();
			
		
		
			 foreach($results as $n){
				$a['ue_account']=$n['ue_account'];
				$a['ue_money'] = $n['ue_money'];
				$a['wx_avatar'] = $n['wx_avatar'];
				$a['ue_truename'] = $n['ue_truename'];
				$b[]=$a;
			 }
			  
		}
		
		$count=count($b);
		return "$count";
}
function user_count2($var){
		/* 一代 */
		$user=M('user');
		$result=M('user')->where(array('UE_accName'=>$var))->select();//一代
		/* 二代 */
		foreach($result as $v){
			
			 $results=$user->where(array('UE_accName'=>$v['ue_account']))->select();
			 foreach($results as $n){
				$a['ue_account']=$n['ue_account'];
				$a['ue_money'] = $n['ue_money'];
				$a['wx_avatar'] = $n['wx_avatar'];
				$a['ue_truename'] = $n['ue_truename'];
				$b[]=$a;
			 }
			  
		}
	/* 三代 */
	foreach($b as $val){
			$res=$user->where(array('UE_accName'=>$val['ue_account']))->select();
			foreach($res as $value){
				$c['ue_account']=$value['ue_account'];
				$c['ue_money'] = $value['ue_money'];
				$c['wx_avatar'] = $value['wx_avatar'];
				$c['ue_truename'] = $value['ue_truename'];
				$d[]=$c;
			}	
		}
		$count=count($d);
		return $count;
}
function user_count3($var){
	$user=M('user');
		/* 一代 */
		
		$result=M('user')->where(array('UE_accName'=>$var))->select();//一代
		/* 二代 */
		foreach($result as $v){
			
			 $results=$user->where(array('UE_accName'=>$v['ue_account']))->select();
			 foreach($results as $n){
				$a['ue_account']=$n['ue_account'];
				$a['ue_money'] = $n['ue_money'];
				$a['wx_avatar'] = $n['wx_avatar'];
				$a['ue_truename'] = $n['ue_truename'];
				$b[]=$a;
			 }
			  
		}
	/* 三代 */
	foreach($b as $val){
			$res=$user->where(array('UE_accName'=>$val['ue_account']))->select();
			foreach($res as $value){
				$c['ue_account']=$value['ue_account'];
				$c['ue_money'] = $value['ue_money'];
				$c['wx_avatar'] = $value['wx_avatar'];
				$c['ue_truename'] = $value['ue_truename'];
				$d[]=$c;
			}	
		}
		/* 四代 */
		foreach($d as $val1){
			$res1=$user->where(array('UE_accName'=>$val1['ue_account']))->select();
			foreach($res1 as $value1){
				$d['ue_account']=$value1['ue_account'];
				$d['ue_money'] = $value1['ue_money'];
				$d['wx_avatar'] = $value1['wx_avatar'];
				$d['ue_truename'] = $value1['ue_truename'];
				$e[]=$d;
			}	
		}
		$count=count($e);
		return $count;
}
function  user_count4($var){
	$user=M('user');
		/* 一代 */
		
		$result=M('user')->where(array('UE_accName'=>$var))->select();//一代
		/* 二代 */
		foreach($result as $v){
			
			 $results=$user->where(array('UE_accName'=>$v['ue_account']))->select();
			 foreach($results as $n){
				$a['ue_account']=$n['ue_account'];
				$a['ue_money'] = $n['ue_money'];
				$a['wx_avatar'] = $n['wx_avatar'];
				$a['ue_truename'] = $n['ue_truename'];
				$b[]=$a;
			 }
			  
		}
	/* 三代 */
	foreach($b as $val){
			$res=$user->where(array('UE_accName'=>$val['ue_account']))->select();
			foreach($res as $value){
				$c['ue_account']=$value['ue_account'];
				$c['ue_money'] = $value['ue_money'];
				$c['wx_avatar'] = $value['wx_avatar'];
				$c['ue_truename'] = $value['ue_truename'];
				$d[]=$c;
			}	
		}
		/* 四代 */
		foreach($d as $val1){
			$res1=$user->where(array('UE_accName'=>$val1['ue_account']))->select();
			foreach($res1 as $value1){
				$d['ue_account']=$value1['ue_account'];
				$d['ue_money'] = $value1['ue_money'];
				$d['wx_avatar'] = $value1['wx_avatar'];
				$d['ue_truename'] = $value1['ue_truename'];
				$e[]=$d;
			}	
		}
		/* 五代 */
		foreach($e as $val2){
			$res2=$user->where(array('UE_accName'=>$val2['ue_account']))->select();
			foreach($res2 as $value2){
				$f['ue_account']=$value2['ue_account'];
				$f['ue_money'] = $value2['ue_money'];
				$f['wx_avatar'] = $value2['wx_avatar'];
				$f['ue_truename'] = $value2['ue_truename'];
				$g[]=$f;
			}	
		}
		$count=count($g);
		return $count;
}
function user_count5($var){
	$user=M('user');
		/* 一代 */
		
		$result=M('user')->where(array('UE_accName'=>$var))->select();//一代
		/* 二代 */
		foreach($result as $v){
			
			 $results=$user->where(array('UE_accName'=>$v['ue_account']))->select();
			 foreach($results as $n){
				$a['ue_account']=$n['ue_account'];
				$a['ue_money'] = $n['ue_money'];
				$a['wx_avatar'] = $n['wx_avatar'];
				$a['ue_truename'] = $n['ue_truename'];
				$b[]=$a;
			 }
			  
		}
	/* 三代 */
	foreach($b as $val){
			$res=$user->where(array('UE_accName'=>$val['ue_account']))->select();
			foreach($res as $value){
				$c['ue_account']=$value['ue_account'];
				$c['ue_money'] = $value['ue_money'];
				$c['wx_avatar'] = $value['wx_avatar'];
				$c['ue_truename'] = $value['ue_truename'];
				$d[]=$c;
			}	
		}
		/* 四代 */
		foreach($d as $val1){
			$res1=$user->where(array('UE_accName'=>$val1['ue_account']))->select();
			foreach($res1 as $value1){
				$d['ue_account']=$value1['ue_account'];
				$d['ue_money'] = $value1['ue_money'];
				$d['wx_avatar'] = $value1['wx_avatar'];
				$d['ue_truename'] = $value1['ue_truename'];
				$e[]=$d;
			}	
		}
		/* 五代 */
		foreach($e as $val2){
			$res2=$user->where(array('UE_accName'=>$val2['ue_account']))->select();
			foreach($res2 as $value2){
				$f['ue_account']=$value2['ue_account'];
				$f['ue_money'] = $value2['ue_money'];
				$f['wx_avatar'] = $value2['wx_avatar'];
				$f['ue_truename'] = $value2['ue_truename'];
				$g[]=$f;
			}	
		}
		/* 六代 */
		foreach($g as $val3){
			$res3=$user->where(array('UE_accName'=>$val3['ue_account']))->select();
			foreach($res3 as $value3){
				$h['ue_account']=$value3['ue_account'];
				$h['ue_money'] = $value3['ue_money'];
				$h['wx_avatar'] = $value3['wx_avatar'];
				$h['ue_truename'] = $value3['ue_truename'];
				$i[]=$h;
			}	
		}
		$count=count($i);
		return $count;
}
function user_count6($var){
	$user=M('user');
		/* 一代 */
		
		$result=M('user')->where(array('UE_accName'=>$var))->select();//一代
		/* 二代 */
		foreach($result as $v){
			
			 $results=$user->where(array('UE_accName'=>$v['ue_account']))->select();
			 foreach($results as $n){
				$a['ue_account']=$n['ue_account'];
				$a['ue_money'] = $n['ue_money'];
				$a['wx_avatar'] = $n['wx_avatar'];
				$a['ue_truename'] = $n['ue_truename'];
				$b[]=$a;
			 }
			  
		}
	/* 三代 */
	foreach($b as $val){
			$res=$user->where(array('UE_accName'=>$val['ue_account']))->select();
			foreach($res as $value){
				$c['ue_account']=$value['ue_account'];
				$c['ue_money'] = $value['ue_money'];
				$c['wx_avatar'] = $value['wx_avatar'];
				$c['ue_truename'] = $value['ue_truename'];
				$d[]=$c;
			}	
		}
		/* 四代 */
		foreach($d as $val1){
			$res1=$user->where(array('UE_accName'=>$val1['ue_account']))->select();
			foreach($res1 as $value1){
				$d['ue_account']=$value1['ue_account'];
				$d['ue_money'] = $value1['ue_money'];
				$d['wx_avatar'] = $value1['wx_avatar'];
				$d['ue_truename'] = $value1['ue_truename'];
				$e[]=$d;
			}	
		}
		/* 五代 */
		foreach($e as $val2){
			$res2=$user->where(array('UE_accName'=>$val2['ue_account']))->select();
			foreach($res2 as $value2){
				$f['ue_account']=$value2['ue_account'];
				$f['ue_money'] = $value2['ue_money'];
				$f['wx_avatar'] = $value2['wx_avatar'];
				$f['ue_truename'] = $value2['ue_truename'];
				$g[]=$f;
			}	
		}
		/* 六代 */
		foreach($g as $val3){
			$res3=$user->where(array('UE_accName'=>$val3['ue_account']))->select();
			foreach($res3 as $value3){
				$h['ue_account']=$value3['ue_account'];
				$h['ue_money'] = $value3['ue_money'];
				$h['wx_avatar'] = $value3['wx_avatar'];
				$h['ue_truename'] = $value3['ue_truename'];
				$i[]=$h;
			}	
		}
		/* 七代 */
		foreach($i as $val5){
			$res5=$user->where(array('UE_accName'=>$val5['ue_account']))->select();
			foreach($res5 as $value5){
				$j['ue_account']=$value5['ue_account'];
				$j['ue_money'] = $value5['ue_money'];
				$j['wx_avatar'] = $value5['wx_avatar'];
				$j['ue_truename'] = $value5['ue_truename'];
				$k[]=$j;
			}	
		}
		$count=count($k);
		return $count;
} 
function user_count7($var){
	$user=M('user');
		/* 一代 */
		
		$result=M('user')->where(array('UE_accName'=>$var))->select();//一代
		/* 二代 */
		foreach($result as $v){
			
			 $results=$user->where(array('UE_accName'=>$v['ue_account']))->select();
			 foreach($results as $n){
				$a['ue_account']=$n['ue_account'];
				$a['ue_money'] = $n['ue_money'];
				$a['wx_avatar'] = $n['wx_avatar'];
				$a['ue_truename'] = $n['ue_truename'];
				$b[]=$a;
			 }
			  
		}
	/* 三代 */
	foreach($b as $val){
			$res=$user->where(array('UE_accName'=>$val['ue_account']))->select();
			foreach($res as $value){
				$c['ue_account']=$value['ue_account'];
				$c['ue_money'] = $value['ue_money'];
				$c['wx_avatar'] = $value['wx_avatar'];
				$c['ue_truename'] = $value['ue_truename'];
				$d[]=$c;
			}	
		}
		/* 四代 */
		foreach($d as $val1){
			$res1=$user->where(array('UE_accName'=>$val1['ue_account']))->select();
			foreach($res1 as $value1){
				$d['ue_account']=$value1['ue_account'];
				$d['ue_money'] = $value1['ue_money'];
				$d['wx_avatar'] = $value1['wx_avatar'];
				$d['ue_truename'] = $value1['ue_truename'];
				$e[]=$d;
			}	
		}
		/* 五代 */
		foreach($e as $val2){
			$res2=$user->where(array('UE_accName'=>$val2['ue_account']))->select();
			foreach($res2 as $value2){
				$f['ue_account']=$value2['ue_account'];
				$f['ue_money'] = $value2['ue_money'];
				$f['wx_avatar'] = $value2['wx_avatar'];
				$f['ue_truename'] = $value2['ue_truename'];
				$g[]=$f;
			}	
		}
		/* 六代 */
		foreach($g as $val3){
			$res3=$user->where(array('UE_accName'=>$val3['ue_account']))->select();
			foreach($res3 as $value3){
				$h['ue_account']=$value3['ue_account'];
				$h['ue_money'] = $value3['ue_money'];
				$h['wx_avatar'] = $value3['wx_avatar'];
				$h['ue_truename'] = $value3['ue_truename'];
				$i[]=$h;
			}	
		}
		/* 七代 */
		foreach($i as $val5){
			$res5=$user->where(array('UE_accName'=>$val3['ue_account']))->select();
			foreach($res5 as $value5){
				$j['ue_account']=$value5['ue_account'];
				$j['ue_money'] = $value5['ue_money'];
				$j['wx_avatar'] = $value5['wx_avatar'];
				$j['ue_truename'] = $value5['ue_truename'];
				$k[]=$j;
			}	
		}
		/* 八代 */
		foreach($k as $val6){
			$res6=$user->where(array('UE_accName'=>$val6['ue_account']))->select();
			foreach($res6 as $value6){
				$l['ue_account']=$value6['ue_account'];
				$l['ue_money'] = $value6['ue_money'];
				$l['wx_avatar'] = $value6['wx_avatar'];
				$l['ue_truename'] = $value6['ue_truename'];
				$m[]=$l;
			}	
		}
		$count=count($m);
		return $count;
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
	function diffBetweenTwoDays($day1, $day2)
	{
		$second1 = $day1;
		$second2 = $day2;
	
		/* $second1 = strtotime($day1);
		 $second2 = strtotime($day2); */
	
		if ($second1 < $second2) {
			$tmp = $second2;
			$second2 = $second1;
			$second1 = $tmp;
		}
		//return ($second1 - $second2) / 5;
		return intval(($second1 - $second2) / 3600);
	}
	function user_jj_lx($var){
		$settings = include( dirname( APP_PATH ) . '/User/Home/Conf/settings.php' );
		$users=M('user');
		$userget=M('userget');
		$shop_orderform = M('shop_orderform');
		$self=$users->where(array('UE_account'=>$_SESSION['uname']))->find();//查询当前会员
		$proall = $userget->where(array('UG_ID'=>$var))->find();//s查矿车收益数据库里UG_ID等于当前会员的
		$NowTime = $proall['ug_gettime'];//结算时间
		$aab=strtotime($NowTime);//把结算时间日期转换成时间戳
		$day1 = $aab;//结算时间戳
		$day2 = time();//当前时间
		$diff = diffBetweenTwoDays($day1, $day2);//计算$day1、$day2两个日期相差的时间
		if($diff>$proall['yxzq']){//判断相差时间大于720小时
			$diff=$proall['yxzq'];//就等于想茶时间等于720小时
		}
		$lixi=$diff*$proall['lixi'];//相差时间乘以矿机收益
		$zqlx=$proall['lixi']*$proall['status'];//矿机收益乘以.......
		$kcxx= $shop_orderform->where(array('id'=>$proall['kcid']))->find();//查询矿车数据库里id等于矿车收益数据库里的kcid
		$user = $users->where(array('UE_account'=>$proall['ug_account']))->find();//查询user数据表里的会员等于矿车收益里的登录账号
		if($diff==$proall['yxzq']){//判断如果相差时间等于720小时
			$oobs= $shop_orderform->where(array('id'=>$proall['kcid']))->data(array('zt'=>2))->save();//查询矿车数据库里的id等于矿车收益数据库里的kcid，更改矿车数据库里的zt字段等于2（2=当前矿车运行完毕）
		}
		//每点击一次矿机收益增加记录
		if($diff>$proall['status']){
			$lixi=$lixi-$zqlx;
			$map['UG_account']=$_SESSION['uname'];
			$map['UG_getTime'] = date('Y-m-d H:i:s',time());
			$map['UG_note'] = $kcxx['project'].'收入';
			//$map['enUG_note'] = $kcxx['enproject'].award;
			$map['UG_money'] = $lixi;
			$map['gmkjh'] = $kcxx['kjbh'];
			//$map['UG_money'] = $zsl;
			$map['UG_dataType'] = 'kjsr';
			$map['nickname'] = $self['ue_truename'];//本人信息
			$map['gzzq'] = $diff;
			$cunru=$userget->add($map);
			$userss = $users->where(array('UE_account'=>$proall['ug_account']))->setInc("UE_money",$lixi);
			//遍历上级 加入奖金
			$settings = include( APP_PATH . 'Home/Conf/settings.php' );
			$ooob=$users->where(array('UE_account'=>$user['ue_accname']))->find();
			if($ooob['level']>=1){
				//$result = $users->where(array('UE_account'=>$_SESSION['uname']))->find();
				$result1 =  $users->where(array('UE_account'=>$self['ue_accname']))->find();
				$order= $shop_orderform->where(array('user'=>$self['ue_account']))->sum('sumprice');
				$order1 = $shop_orderform->where(array('user'=>$result1['ue_account']))->sum('sumprice');
				$money = $lixi;
					
				if($order>$order1){
					$money = $money/2;
				}
				$money=$money*$settings['ztlv'];
				$money=number_format($money,8);
				$tuandui=$users->where(array('UE_account'=>$self['ue_accname']))->setInc('UE_money',$money);
				$resu =	$users->where(array('UE_account'=>$self['ue_accname']))->find();
				$record3 ["UG_account"] = $result1['ue_account']; // 登入轉出賬戶
				$record3 ["UG_type"] = 'lkb';
				$record3 ["UG_allGet"] = $result1['ue_money']; // 金幣
				$record3 ["UG_money"] = '+'.$money; //
				$record3 ["UG_balance"] = $resu['ue_money']; // 當前推薦人的金幣餘額
				$record3 ["UG_dataType"] = 'tdj'; // 金幣轉出
				$record3 ["UG_note"] = "算力收益"; // 推薦獎說明
				$record3 ["enUG_note"]="award";
				$record3["UG_getTime"]		= date ( 'Y-m-d H:i:s', time () ); //操作時間
				$record3["UG_othraccount"] = $self['ue_truename'];
				$record3["nickname"] = $self['ue_truename'];
				$reg4 = $userget->add ( $record3 );
			}
			//内容见上
			$proall= $userget->where(array('UG_ID'=>$var))->data(array('status'=>$diff))->save();
		}
		return $lixi;
	}
}
