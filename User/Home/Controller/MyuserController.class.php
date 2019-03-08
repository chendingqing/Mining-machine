<?php

namespace Home\Controller;
use Think\Controller;
class MyuserController extends CommonController {
	// 首頁
	
	public function index(){
		
		
	
		$settings = include( dirname( APP_PATH ) . '/User/Home/Conf/settings.php' );		
		$user=M('user');
		$user_id = $_SESSION['uid'];
		$users = M('user');
		$userinfo = $users->where(array('UE_ID'=>$user_id))->find();
		$map['UE_account'] = array('EQ', $userinfo['ue_account']);
		$rsgs = $users->where($map)->order('UE_ID asc')->limit(1)->find();
		$kzhz=M('user')->where(array('UE_accName'=>$_SESSION['uname']))->count();
		if($kzhz>0){
			$zrs=$user->where("FIND_IN_SET({$user_id},tpath) and UE_status=1")->count();
			//算力
			$rshz=$users->where("FIND_IN_SET({$user_id},tpath) and UE_status=1")->getField('ue_id',true);
			$rshz1=$users->where("FIND_IN_SET({$user_id},tpath) and UE_status=1")->getField('ue_account',true);
			//var_dump($rshz1);die;
			array_unshift($rshz,$user_id);
			//$tpath=implode(',',$rshz);
			$tpath=implode(',',$rshz1);
			//echo $tpath;
			//$rssl=M('shop_orderform')->where(" zt=1 and  uid in({$tpath})")->sum('kjsl');
			$rssl=M('shop_orderform')->where(" zt=1 and  user in({$tpath})")->sum('kjsl');			
			$zkjsl=number_format($rssl,2);
			//dump($zkjsl);die;
		}		
			/* 
				会员升级制度 
			*/
			$level = M('user')->where(array('UE_accName'=>$_SESSION['uname'],'UE_status'=>1 ))->count();//直推人数
			$ree=M('user')->where(array('UE_account'=>$_SESSION['uname']))->find();
			$cskj=M('shop_orderform')->where(array('user'=>$_SESSION['uname'],'zt'=>'1'))->find();
			//判断是否为正式会员
			if($ree['kjzt']==1 && $cskj){
				if($ree['level']<1){
					M('user')->where(array('UE_account'=>$_SESSION['uname']))->data(array('level'=>1))->save();
				}
			}
		//判断直推人数
		if($level>=$settings['ztrs']){
			$user_id = $_SESSION['uid'];
			//$total=M('user')->where("FIND_IN_SET({$user_id},tpath)")->count();
			//判断公会人数
			if($zrs>=$settings['ghrs']){
				if($zkjsl>=$settings['ghkj']){
					if($ree['level']<2){
						M('user')->where(array('UE_account'=>$_SESSION['uname']))->data(array('level'=>2))->save();
						if ($ree['sjzskj_1']==0) {
							M('user')->where(array('UE_account'=>$_SESSION['uname']))->data(array('sjzskj_1'=>1))->save();
							$yCode = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J');
							$orderSn = $yCode[intval(date('Y')) - 2011] . date('d') . substr(time(), -5) . sprintf('%02d', rand(0, 99));
							$project=M('shop_project')->where(array('id'=>216))->find();
							$orderform = M('shop_orderform');
							$map['user'] = $_SESSION['uname'];
							$map['project']=$project['name'];
							$map['enproject']=$project['enname'];
							$map['yxzq'] = $project['yxzq'];
							$map['sumprice'] = $project['price'];
							$map['addtime'] = date('Y-m-d H:i:s');
							$map['username']=$userinfo['ue_truename'];
							$map['imagepath'] =$project['imagepath'];
							$map['lixi']	= $project['fjed'];
							$map['qwsl'] = $project['qwsl'];
							$map['kjsl'] = $project['kjsl'];
							$map['kjbh'] = $orderSn;
							$map['uid']= $_SESSION['uid'];
							$orderform->add($map);
						}
					}
					
				}
			}
		}
		//创业大使判断
		if($ree['level']==2){
			$rshz=$users->where("FIND_IN_SET({$user_id},tpath)")->getField('ue_id',true);
			//dump($rshz);die;
			//array_unshift($rshz,$user_id);
			$tpath=implode(',',$rshz);
			//$cyds=M('user')->where(" level=2 and  UE_ID in({$tpath})")->count();
			$cyds=M('user')->where(array('UE_accName'=>$_SESSION['uname'],'level'=>2))->count();//直推人数
			if($cyds>=$settings['cyhz']){
				if($zkjsl>$settings['cykj']){
					if($ree['level']<3){
						$a=M('user')->where(array('UE_account'=>$_SESSION['uname']))->data(array('level'=>3))->save();
						//dump($a);die;
						if ($ree['sjzskj_2']==0) {
							M('user')->where(array('UE_account'=>$_SESSION['uname']))->data(array('sjzskj_2'=>1))->save();
							$yCode = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J');
							$orderSn = $yCode[intval(date('Y')) - 2011] . date('d') . substr(time(), -5) . sprintf('%02d', rand(0, 99));
							$project=M('shop_project')->where(array('id'=>217))->find();
							$orderform = M('shop_orderform');
							$map['user'] = $_SESSION['uname'];
							$map['project']=$project['name'];
							$map['enproject']=$project['enname'];
							$map['yxzq'] = $project['yxzq'];
							$map['sumprice'] = $project['price'];
							$map['addtime'] = date('Y-m-d H:i:s');
							$map['username']=$userinfo['ue_truename'];
							$map['imagepath'] =$project['imagepath'];
							$map['lixi']	= $project['fjed'];
							$map['qwsl'] = $project['qwsl'];
							$map['kjsl'] = $project['kjsl'];
							$map['kjbh'] = $orderSn;
							$map['uid']= $_SESSION['uid'];
							$orderform->add($map);
						}
					}
							
				}
			}
			
		}
		//环保大使判断
		if($ree['level']==3){
			$rshz=$users->where("FIND_IN_SET({$user_id},tpath)")->getField('ue_id',true);
			//array_unshift($rshz,$user_id);
			$tpath=implode(',',$rshz);
			$hbds=M('user')->where(array('UE_accName'=>$_SESSION['uname'],'level'=>3))->count();//直推人数
			//$hbds=M('user')->where(" level=3 and  UE_ID in({$tpath})")->count();
			if($hbds>=$settings['hbhz']){
				if($zkjsl>$settings['hbkj']){
					if($ree['level']<4){
						M('user')->where(array('UE_account'=>$_SESSION['uname']))->data(array('level'=>4))->save();
						if ($ree['sjzskj_3']==0) {
							M('user')->where(array('UE_account'=>$_SESSION['uname']))->data(array('sjzskj_3'=>1))->save();
							$yCode = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J');
							$orderSn = $yCode[intval(date('Y')) - 2011] . date('d') . substr(time(), -5) . sprintf('%02d', rand(0, 99));
							$project=M('shop_project')->where(array('id'=>218))->find();
							$orderform = M('shop_orderform');
							$map['user'] = $_SESSION['uname'];
							$map['project']=$project['name'];
							$map['enproject']=$project['enname'];
							$map['yxzq'] = $project['yxzq'];
							$map['sumprice'] = $project['price'];
							$map['addtime'] = date('Y-m-d H:i:s');
							$map['username']=$userinfo['ue_truename'];
							$map['imagepath'] =$project['imagepath'];
							$map['lixi']	= $project['fjed'];
							$map['qwsl'] = $project['qwsl'];
							$map['kjsl'] = $project['kjsl'];
							$map['kjbh'] = $orderSn;
							$map['uid']= $_SESSION['uid'];
							$orderform->add($map);
						}
					}
					
				}
			}
		}
		//国际大使
		if($ree['level']==4){
			$rshz=$users->where("FIND_IN_SET({$user_id},tpath)")->getField('ue_id',true);
			//array_unshift($rshz,$user_id);
			$tpath=implode(',',$rshz);
			//$gjds=M('user')->where(" level=4 and  UE_ID in({$tpath})")->count();
			$gjds=M('user')->where(array('UE_accName'=>$_SESSION['uname'],'level'=>4))->count();//直推人数
			if($gjds>=$settings['gjhz']){
				if($zkjsl>$settings['gjkj']){
					if($ree['level']<5){
						M('user')->where(array('UE_account'=>$_SESSION['uname']))->data(array('level'=>5))->save();
							if ($ree['sjzskj_4']==0) {
								M('user')->where(array('UE_account'=>$_SESSION['uname']))->data(array('sjzskj_4'=>1))->save();
								$yCode = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J');
								$orderSn = $yCode[intval(date('Y')) - 2011] . date('d') . substr(time(), -5) . sprintf('%02d', rand(0, 99));
								$project=M('shop_project')->where(array('id'=>219))->find();
								$orderform = M('shop_orderform');
								$map['user'] = $_SESSION['uname'];
								$map['project']=$project['name'];
								$map['enproject']=$project['enname'];
								$map['yxzq'] = $project['yxzq'];
								$map['sumprice'] = $project['price'];
								$map['addtime'] = date('Y-m-d H:i:s');
								$map['username']=$userinfo['ue_truename'];
								$map['imagepath'] =$project['imagepath'];
								$map['lixi']	= $project['fjed'];
								$map['qwsl'] = $project['qwsl'];
								$map['kjsl'] = $project['kjsl'];
								$map['kjbh'] = $orderSn;
								$map['uid']= $_SESSION['uid'];
								$orderform->add($map);
						}
					}
					
				}
			}
		}
		//$level = M('user')->where(array('UE_accName'=>$_SESSION['uname'],'UE_status'=>1 ))->count();//直推人数
		//$ree=M('user')->where(array('UE_account'=>$_SESSION['uname']))->find();//查询这哥们儿
		//$zrs=$user->where("FIND_IN_SET({$user_id},tpath) and UE_status=1")->count();//查询tpath
		//会长降级
		if($ree['level']==2){//判断  这哥们儿的等级状态等于2
			if($level<$settings['ztrs']||$zkjsl<$settings['ghkj']){//判断  这哥们儿的直推人数小于后台设定  这哥们儿的矿机金额小于后台设定
				$hzjj=M('user')->where(array('UE_accName'=>$_SESSION['uname'],'level'=>1,'UE_status'=>1))->count();//直推人数,等级等于4,未冻结的人
					M('user')->where(array('UE_account'=>$_SESSION['uname']))->data(array('level'=>1))->save();//全部满足条件,大功告成,降级了您嘞。
			}
		}
		//创业大师降级
		if($ree['level']==3){
			$cyds=M('user')->where(array('UE_accName'=>$_SESSION['uname'],'level'=>2,'UE_status'=>1))->count();
			if($cyds<$settings['cyhz']||$zkjsl<$settings['cykj']){
				M('user')->where(array('UE_account'=>$_SESSION['uname']))->data(array('level'=>3))->save();
			}
		}
		//环保大使降级
		if($ree['level']==4){
			$hbds=M('user')->where(array('UE_accName'=>$_SESSION['uname'],'level'=>3,'UE_status'=>1))->count();
			if($hbds<$settings['hbhz']||$zkjsl<$settings['hbkj']){
				M('user')->where(array('UE_account'=>$_SESSION['uname']))->data(array('level'=>3))->save();
			}
		}
		//国际大使降级
		if($ree['level']==5){
			$gjds=M('user')->where(array('UE_accName'=>$_SESSION['uname'],'level'=>4,'UE_status'=>1))->count();
			if($gjds<$settings['gjhz']||$zkjsl<$settings['gjkj']){
					M('user')->where(array('UE_account'=>$_SESSION['uname']))->data(array('level'=>4))->save();
			}
		}
			
	
        if ($rsgs) {
					$self=M('shop_orderform')->where(array('user'=>$_SESSION['uname'],zt=>1))->sum('kjsl');
					$num=$self;
			$firsthy = $rsgs['ue_truename'];
			
			
			$this->tjtreestr .= '<div><img src=\'/Public/images/tree.png\'> ' . $firsthy .'  - 人数：' .$zrs.'  - 算力：' .$zkjsl.'</div>';
			$list = $users->where(array('UE_accName' => $rsgs['ue_account']))->select();
			//dump($list);die();
			foreach ($list as $tkey => $tval ) {
				
				$this->tjtreestr .= '<div style=\'margin-left:30px\'>';
				$xjcount = $users->where(array('UE_account' => $tval['ue_accname']))->field('UE_account')->count();
				if (0 < $xjcount) {
					$this->tjtreestr .= '<a href=\'#tree_' . $tval['ue_account'] . '\' onclick="findtree(' . $tval['ue_id'] . ',\'' . u('Index.php/Home/Ajax/getnextree') . '\')">';
					if ($tkey == count($list) - 1) {
						$this->tjtreestr .= '<img id=\'tree_' . $tval['ue_account'] . '\' src=\'/Public/images/tree_plusl.gif\' border=0>';
					}
					else {
						$this->tjtreestr .= '<img id=\'tree_' . $tval['ue_account'] . '\' src=\'/Public/images/tree_plus.gif\' border=0>';
					}
				}
				else if ($tkey == count($list) - 1) {
					$this->tjtreestr .= '<img id=\'tree_' . $tval['ue_account'] . '\' src=\'/Public/images/tree_blankl.gif\' border=0>';
				}
				else {
					$this->tjtreestr .= '<img id=\'tree_' . $tval['ue_account'] . '\' src=\'/Public/images/tree_blank.gif\' border=0>';
				}
				
				
				$this->tjtreestr .= '</a> ' . $tval['ue_truename']/* . '  - 人数：' .$zrss. '  - 算力：' .$zkjsls */;
				$this->tjtreestr .= '<div id="nextree_' . $tval['ue_id'] . '" style="margin-left:30px;display:none"></div>';
				$this->tjtreestr .= '</div>';
			}
		}
		else {
			$this->tjtreestr = '没有会员';
		}
		
		$rshy=$user->where(array('UE_account'=>$_SESSION['uname']))->find();
		$this->assign('tjtreestr', $this->tjtreestr);
		$this->assign('ree', $ree);
		$this->assign('rshy', $rshy);
		$this->display("mytuandui");

	}
	public function enindex(){
		$user=M('user');
		
		$user_id = $_SESSION['uid'];
		$users = M('user');
		$userinfo = $users->where(array('UE_ID'=>$user_id))->find();
		$map['UE_account'] = array('EQ', $userinfo['ue_account']);
		$rsgs = $users->where($map)->order('UE_ID asc')->limit(1)->find();
		$zrs=M('user')->where("FIND_IN_SET({$user_id},tpath and UE_status=1)")->count();
		//dump($rsgs);die();
		$rshz=$users->where("FIND_IN_SET({$user_id},tpath) and UE_status=1")->getField('ue_id',true);
		array_unshift($rshz,$user_id);
		$tpath=implode(',',$rshz);
		$rssl=M('shop_orderform')->where(" zt=1 and  uid in({$tpath})")->sum('kjsl');
		
		$zkjsl=number_format($rssl,2);
        if ($rsgs) {
			
			$firsthy = $rsgs['ue_truename'];
			
			//$this->tjtreestr .= '<div><img src=\'/Public/images/tree.png\'> ' . $firsthy .'  - 人数：' .$zrs.'  - 算力：' .$zkjsl.'</div>';
			$this->tjtreestr .= '<div><img src=\'/Public/images/tree.png\'> ' . $firsthy .'  - Guild number：' .$zrs.' - Guild number：' .$zkjsl.'</div>';
			$list = $users->where(array('UE_accName' => $rsgs['ue_account']))->select();
			
			foreach ($list as $tkey => $tval ) {
				
				$this->tjtreestr .= '<div style=\'margin-left:30px\'>';
				$xjcount = $users->where(array('UE_account' => $tval['ue_accname']))->field('UE_account')->count();
				if (0 < $xjcount) {
					$this->tjtreestr .= '<a href=\'#tree_' . $tval['ue_account'] . '\' onclick="findtree(' . $tval['ue_id'] . ',\'' . u('Index.php/Home/Ajax/engetnextree') . '\')">';
					if ($tkey == count($list) - 1) {
						$this->tjtreestr .= '<img id=\'tree_' . $tval['ue_account'] . '\' src=\'/Public/images/tree_plusl.gif\' border=0>';
					}
					else {
						$this->tjtreestr .= '<img id=\'tree_' . $tval['ue_account'] . '\' src=\'/Public/images/tree_plus.gif\' border=0>';
					}
				}
				else if ($tkey == count($list) - 1) {
					$this->tjtreestr .= '<img id=\'tree_' . $tval['ue_account'] . '\' src=\'/Public/images/tree_blankl.gif\' border=0>';
				}
				else {
					$this->tjtreestr .= '<img id=\'tree_' . $tval['ue_account'] . '\' src=\'/Public/images/tree_blank.gif\' border=0>';
				}
				
				
				
			
				$this->tjtreestr .= '</a> ' . $tval['ue_truename']/* . '  - Guild number：' .$zrss. '  - Guild power：' .$zkjsls */;
				$this->tjtreestr .= '<div id="nextree_' . $tval['ue_id'] . '" style="margin-left:30px;display:none"></div>';
				$this->tjtreestr .= '</div>';
			}
		}
		else {
			$this->tjtreestr = '没有会员';
		}
		
		$this->assign('tjtreestr', $this->tjtreestr);

		$this->display("enmytuandui");

	}
	
	

	public function team() {
		$this->display("team");
	}
	
	public function ghgl() {
		$user=M('user');
		$rshy=$user->where(array('UE_account'=>$_SESSION['uname']))->find();
		/* if ($rshy['level']<=1) {
			$this->error('会长以上级别解锁此功能');
		} */
		$ghgl = d('ghgl');
		$return = $ghgl->where(array('uid' => $rshy['ue_id']))->find();
		$this->assign('return', $return);
		$this->assign('rshy', $rshy);
		$this->display();
	}
	public function ghglto() {
		$user=M('user');
		$rshy=$user->where(array('UE_account'=>$_SESSION['uname']))->find();
		$ghname = i('post.ghname');
		$ghxy = i('post.ghxy');
		$ghqq = i('post.ghqq');
		$hzvx = i('post.hzvx');
		$hzqq = i('post.hzqq');
		$hzphone = i('post.hzphone');
		$ghgl = d('ghgl');
		$return = $ghgl->where(array('uid' => $rshy['ue_id']))->find();
		if ($return['uid']==$rshy['ue_id']) {
			$data['ghname'] = $ghname;
			$data['ghxy'] = $ghxy;
			$data['ghqq'] = $ghqq;
			$data['hzvx'] = $hzvx;
			$data['hzqq'] = $hzqq;
			$data['hzphone'] = $hzphone;
			$data['uid'] = $rshy['ue_id'];
			$resu = $ghgl->where(array('uid' => $rshy['ue_id']))->save($data);
			if($resu !== false){
				$this->success('修改成功');
			}else{
				$this->error('修改失败');
			}
		}else {
			$data['ghname'] = $ghname;
			$data['ghxy'] = $ghxy;
			$data['ghqq'] = $ghqq;
			$data['hzvx'] = $hzvx;
			$data['hzqq'] = $hzqq;
			$data['hzphone'] = $hzphone;
			$data['uid'] = $rshy['ue_id'];
			if ($ghgl->add($data)) {
			
			}else {
				$this->error('添加失败');
			}
			$this->success('添加成功');
		}
	}
	public function kjwl() {
		$user = m('user');
		$rshy=$user->where(array('UE_account'=>$_SESSION['uname']))->find();
		if (!$rshy) {
			$this->error('获取会员失败');
		}
		unset($map);
		$map['UE_accName'] =  $rshy['ue_account'];
		$count =  $user->where($map)->field('UE_ID')->count();
		$page = new \Think\Page ( $count, 5000 );
		//$page->lastSuffix=false;
		$page->setConfig ( 'header', '<li class="rows">共<b>%TOTAL_ROW%</b>条记录    第<b>%NOW_PAGE%</b>页/共<b>%TOTAL_PAGE%</b>页</li>' );
		$page->setConfig ( 'prev', '上一页' );
		$page->setConfig ( 'next', '下一页' );
		$page->setConfig ( 'last', '末页' );
		$page->setConfig ( 'first', '首页' );
		$page->setConfig ( 'theme', '%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%' );		
		$list =  $user->where($map)->order('UE_ID DESC')->limit ( $page->firstRow . ',' . $page->listRows )->select ();
		$this->assign('page', $page->show ());
		$this->assign('list', $list);
		$this->assign('rshy', $rshy);
		
		$this->display();
	}
	public function ssgh() {
		$user=M('user');
		$rshy=$user->where(array('UE_account'=>$_SESSION['uname']))->find();
		$ghgl = d('ghgl');
		$retu = $ghgl->where(array('uid' => $rshy['ue_id']))->find();
		if ($rshy['ssghgl']=="") {
			//print_r($rshy['tpath']);exit;
			unset($find);
			$find['_string']="UE_ID in (".$rshy['tpath'].")";
			$find['ktghgl']=2;
			$find['UE_ID']=array('neq',$rshy['ue_id']);//自己看自己
			$res=$user->where($find)->order('UE_ID desc')->find();
			$user->where(array('UE_account'=>$_SESSION['uname']))->setField('ssghgl',$res['ue_id']);
			$return=$ghgl->where(array('uid'=>$res['ue_id']))->find();
		 }else {
			$return=$ghgl->where(array('uid'=>$rshy['ssghgl']))->find();		
		}
		$this->assign('return', $return);
		$this->assign('rshy', $rshy);
		$this->display();
	}
	
	public function zskj() {
		$user= M ('user');
		$rshy= $user ->where(array('UE_account'=>$_SESSION['uname']))->find();
		$ghname = i('post.nickname');
		$rs = $user->where(array('UE_account' => $ghname))->find();
		//dump($rs);die;
		if (!$rs) {
				$this->error('没有此会员！');
			}
		//dump($rshy);die;
		//$level = $user ->where(array('UE_accName'=>$_SESSION['uname']))->count();//直推人数
		//dump($level);die;
		//dump($ree);die;
		$cskj=M('shop_orderform')->where(array('user'=>$ghname,'zt'=>'1'))->find();
		//dump($cskj);die;
		if ($rs['mfkj']==2) {
		 $this->error('该会员已经领取过免费矿机');
		}
		//判断是否为正式会员
		if($rs['kjzt']==1 && $cskj){
			if($rs['level']<=1){
				M('user')->where(array('UE_account'=>$ghname))->data(array('level'=>1))->save();
			}
				
		}
		if($rs){
			//注册赠送矿机
				$yCode = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J');
				$orderSn = $yCode[intval(date('Y')) - 2011] . date('d') . substr(time(), -5) . sprintf('%02d', rand(0, 99));
				$project=M('shop_project')->where(array('id'=>210))->find();
				$orderform = M('shop_orderform');
				$map['user'] = $ghname;
				$map['project']=$project['name'];
				$map['enproject']=$project['enname'];
				$map['yxzq'] = $project['yxzq'];
				$map['sumprice'] = $project['price'];
				$map['addtime'] = date('Y-m-d H:i:s');
				$map['username']=$rs['ue_truename'];
				$map['imagepath'] =$project['imagepath'];
				$map['lixi']	= $project['fjed'];
				$map['qwsl'] = $project['qwsl'];
				$map['kjsl'] = $project['kjsl'];
				$map['kjbh'] = $orderSn;
				$map['uid'] = $rs['ue_id'];
				$map['status_zs'] = 1;
				$orderform->add($map);
				M('user')->where(array('UE_account'=>$ghname))->data(array('mfkj'=>2))->save();
				$this->success('矿机赠送成功','/index.php/Home/Myuser/ghgl/');
			//die("<script>alert('矿机赠送成功');window.location.href='/index.php/Home/Myuser/ghgl/';</script>");
		}	
	}
	
}