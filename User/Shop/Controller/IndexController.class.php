<?php

namespace Shop\Controller;

use Think\Controller;

class IndexController extends CommonController
{
    // 首页
    public function index(){

        $model = M('shop_project');
        $count = $model->where('zt>0')->count();

      
        
		$list = M("shop_project")->where("zt = '1'")->order("addtime desc")->select();

		// $title = M("shop_leibie")->select();
		// $this->assign('title',$title);
		$this->assign('list',$list);
        $this->assign('show',$show);
        // dump($list);die();
        $this->display();
    }
	public function enindex(){

        $model = M('shop_project');
        $count = $model->where('zt>0')->count();

      
        
		$list = M("shop_project")->where("zt = '1'")->order("addtime desc")->select();

		// $title = M("shop_leibie")->select();
		// $this->assign('title',$title);
		$this->assign('list',$list);
        $this->assign('show',$show);
        // dump($list);die();
        $this->display();
    }

	public function listProject(){
		$model = M('shop_project');
		$data = I();
		$map = array();
		if($data['pid']){
			$map['pid'] = $data['pid'];
		}else{
			$map['pid'] = '1';
		}
		$map['zt'] = array('in','1,2');
		/*if($data['name']){
			$map['name'] = array("like","%{$data['name']}%");
		}*/
		$count = $model->where($map)->count();

		//$page = new \Think\Page($count,10);
		foreach($map as $key=>$val) { 
			$Page->parameter   .=   "$key=".urlencode($val).'&';
		}
		//$show = $page->show();

		$array = $model->where($map)->order("price")->select();
	
		
		$title = M("shop_leibie")->select();
		$this->assign('title',$title);
		//$list = $model->where($map)->select();
		//$this->assign('show',$show);
		$this->assign('list',$array);
		//var_export($show);die;
		$this->display('listProject');

	}
	public function project(){
		$id = I('get.id');
		$arr = M('shop_project')->where(array('id'=>$id))->find();
		
		$title = M("shop_leibie")->select();
		$this->assign('title',$title);
		
		$this->assign('arr',$arr);
		$this->display('project');
		
		
		
		
	}
	public function jiaoyi(){
		$id =  $_GET['id'];
		$project=M('shop_project')->where(array('id'=>$id))->find();
		$price = $project['price'];
		$content = $project['content'];
		$name = $project['name'];

		// dump($content);die();
		$this->assign('id',$id);
		$this->assign('name',$name);
		$this->assign('price',$price);
		$this->assign('content',$content);
		$this->display();
	}
	public function enjiaoyi(){
		$id =  $_GET['id'];
		$project=M('shop_project')->where(array('id'=>$id))->find();
		
		$price = $project['price'];
		$content = $project['encontent'];
		$name = $project['enname'];
		
		// dump($content);die();
		$this->assign('id',$id);
		$this->assign('name',$name);
		$this->assign('price',$price);
		$this->assign('content',$content);
		$this->display();
	}
	public function confirmProject1(){
		$id = I('get.id');
		$count = I('get.count');
		if($count<1){
			die("<script>alert('请选择正确数量');history.back()</script>");
		}

		$arr = M('shop_project')->where(array('id'=>$id))->find();
		$array = M('shop_project')->where(array('pid'=>$arr['pid']))->select();
		$list = M('shop_project')->where(array('pid'=>$arr['pid'],'zt'=>'2'))->order('id desc')->limit('2')->select();
		
		$sumPrice = $arr['price']*$count;

		$this->assign('list',$list);
		$this->assign('array',$array);

		$map['sumPrice'] = $sumPrice;
		$map['name'] = $arr['name'];
		$map['user'] = session('uname');
		$map['count'] = $count;
		$map['time'] = date('Y-m-d H:i:s'); 
		//dump($arr['price']);
		//dump($count);
		//dump($sumPrice);die;
		$this->assign('sumPrice',$sumPrice);
		$this->assign('arr',$arr); 
		$this->assign('map',$map); 
		$this->display();
	}
	public function confirmProject(){
		$yCode = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J');
		$orderSn = $yCode[intval(date('Y')) - 2011] . date('d') . substr(time(), -5) . sprintf('%02d', rand(0, 99));
		$settings = include( APP_PATH . 'Home/Conf/settings.php' );
		
		$id= I('get.id');
		$project=M('shop_project')->where(array('id'=>$id))->find();
		$price=$project['price'];
	
		$result=M('user')->where(array('UE_account'=>$_SESSION['uname']))->find();
		$money=$result['ue_money'];
		
		if($money<$price){
			$this->error('你的账户余额不足');
			// die("<script>alert('您的账户余额不足');hisback(-1);</script>");
		}else{
			$obs=M('user')->where(array('UE_account'=>$_SESSION['uname']))->setDec('UE_money',$price);
			$zt=M('user')->where(array('UE_account'=>$_SESSION['uname']))->data(array('kjzt'=>1))->save();
			if($obs){
				
				$orderform = M('shop_orderform');
				$map['user'] = session('uname');
				$map['project']=$project['name'];
				$map['enproject']=$project['enname'];
				$map['yxzq'] = $project['yxzq'];
				$map['sumprice'] = $price;
				$map['addtime'] = date('Y-m-d H:i:s');
				$map['username']=$result['ue_truename'];
				$map['imagepath'] =$project['imagepath'];
				$map['lixi']	= $project['fjed'];
				$map['qwsl'] = $project['qwsl'];
				$map['kjsl'] = $project['kjsl'];
				$map['kjbh'] = $orderSn;
				$orderform->add($map);
				
				
				$oob=M('user')->where(array('UE_account'=>$result['ue_accname']))->find();
				//$this_node = $oob['ue_account'];
				$i = $settings['max_user_level'];
				$money = $price;
				$account = $_SESSION['uname'];
				$this_node = $result['ue_account'];
				// while($i--){
				// 	if( $this_node && strlen( $this_node ) ){
				// 				 //判断得了多少奖金，扣税
				// 				 $sjinfo=M('user')->where(['UE_account'=>$this_node])->find();							
				// 				 $this_node = masses_j( $this_node, $money*floatval($settings['masses_share'][$settings['max_user_level']-$i]),'团队奖' . ( floatval($settings['masses_share'][$settings['max_user_level']-$i]) * 100 ) . '%' ,$account);
				// 				 }else{
				// 					if($i>=($settings['max_user_level']-1)){
				// 						$this_node=$_SESSION['uname'];
				// 						$sjinfo=M('user')->where(['UE_account'=>$this_node])->find();						 
				// 						 $this_node = masses_j( $this_node, $money*floatval($settings['masses_share'][$settings['max_user_level']-$i]),'代数奖' . ( floatval($settings['masses_share'][$settings['max_user_level']-$i]) * 100 ) . '%' );
				// 					}
									
				// 						break;
				// 				}
				// }
				// $jlj=$oob['ue_account'];
				// $i=30;
				// while($i--){
				// 	if($jlj && strlen($jlj)){
				// 		 $sjinfo=M('user')->where(['UE_account'=>$jlj])->find();							
				// 		 $jlj = jljj( $jlj, $money*0.001 ,$account );
				// 	}
				// }
					die("<script>alert('购买成功，已加入到我的矿车列表');window.location.href='/index.php/Home/Info/mykuangche/';</script>");
						
			}else{
			
				$this->error('购买失败，请重新操作');
			}
		}

		// dump($result);die();
	}
	public function enconfirmProject(){
		$yCode = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J');
		$orderSn = $yCode[intval(date('Y')) - 2011] . date('d') . substr(time(), -5) . sprintf('%02d', rand(0, 99));
		$settings = include( APP_PATH . 'Home/Conf/settings.php' );
		
		$id= I('get.id');
		$project=M('shop_project')->where(array('id'=>$id))->find();
		$price=$project['price'];
	
		$result=M('user')->where(array('UE_account'=>$_SESSION['uname']))->find();
		$money=$result['ue_money'];
		
		if($money<$price){
			$this->error('Your account balance is not enough.');
			// die("<script>alert('您的账户余额不足');hisback(-1);</script>");
		}else{
			$obs=M('user')->where(array('UE_account'=>$_SESSION['uname']))->setDec('UE_money',$price);
			$zt=M('user')->where(array('UE_account'=>$_SESSION['uname']))->data(array('kjzt'=>1))->save();
			if($obs){
				
				$orderform = M('shop_orderform');
				$map['user'] = session('uname');
				$map['enproject'] = $project['enname'];
				$map['project']=$project['name'];
				$map['yxzq'] = $project['yxzq'];
				$map['sumprice'] = $price;
				$map['addtime'] = date('Y-m-d H:i:s');
				$map['username']=$result['ue_truename'];
				$map['imagepath'] =$project['imagepath'];
				$map['lixi']	= $project['fjed'];
				$map['qwsl'] = $project['qwsl'];
				$map['kjsl'] = $project['kjsl'];
				$map['kjbh'] = $orderSn;
				$orderform->add($map);
				
				
				$oob=M('user')->where(array('UE_account'=>$result['ue_accname']))->find();
				//$this_node = $oob['ue_account'];
				$i = $settings['max_user_level'];
				$money = $price;
				$account = $_SESSION['uname'];
				$this_node = $result['ue_account'];
				// while($i--){
				// 	if( $this_node && strlen( $this_node ) ){
				// 				 //判断得了多少奖金，扣税
				// 				 $sjinfo=M('user')->where(['UE_account'=>$this_node])->find();							
				// 				 $this_node = masses_j( $this_node, $money*floatval($settings['masses_share'][$settings['max_user_level']-$i]),'团队奖' . ( floatval($settings['masses_share'][$settings['max_user_level']-$i]) * 100 ) . '%' ,$account);
				// 				 }else{
				// 					if($i>=($settings['max_user_level']-1)){
				// 						$this_node=$_SESSION['uname'];
				// 						$sjinfo=M('user')->where(['UE_account'=>$this_node])->find();						 
				// 						 $this_node = masses_j( $this_node, $money*floatval($settings['masses_share'][$settings['max_user_level']-$i]),'代数奖' . ( floatval($settings['masses_share'][$settings['max_user_level']-$i]) * 100 ) . '%' );
				// 					}
									
				// 						break;
				// 				}
				// }
				// $jlj=$oob['ue_account'];
				// $i=30;
				// while($i--){
				// 	if($jlj && strlen($jlj)){
				// 		 $sjinfo=M('user')->where(['UE_account'=>$jlj])->find();							
				// 		 $jlj = jljj( $jlj, $money*0.001 ,$account );
				// 	}
				// }
					die("<script>alert('The purchase is successful, has been added to the list of my car');window.location.href='/index.php/Home/Info/enmykuangche/';</script>");
						
			}else{
			
				$this->error('Purchase failed, please restart');
			}
		}

		// dump($result);die();
	}
	public function addOrderform(){
		$settings = include( APP_PATH . 'Home/Conf/settings.php' );
		$UE_money = M('user')->where(array('UE_account'=>session('uname')))->getField('ue_integral');//求积分
		// dump($UE_money);
		//dump($settings['money_spb_bili']);
		$id = I('get.id');
		$count = I('get.count');
		$address=I('get.address');
		// dump($address);die();
		$count = $count+0;

		if(!$address){
			die("<script>alert('请正确填写收货地址');history.back(-1)</script>");
		}
		if(!is_int($count)){
			die("<script>alert('请输入整数');history.back()</script>");
		}
		if(!$id || !$count){
			die("<script>alert('请选择商品');history.back()</script>");
		}else{
			$arr = M('shop_project')->where(array('id'=>$id))->find();
			$var=M('user')->where(array('UE_account'=>session('uname')))->find();
			// dump($var['ue_truename']);die();
			$orderform = M('shop_orderform');
			$map = array();
			$map['user'] = session('uname');
			$map['project'] = $arr['name'];
			$map['count'] = $count;
			$map['sumprice'] = $arr['price']*$count; 
			$map['addtime'] = date('Y-m-d H:i:s');
			$map['address']=$address;
			$map['username']=$var['ue_truename'];
			$map['sid']=$arr['id'];
			// dump($arr['id']);die();
			$UE_money = M('user')->where(array('UE_account'=>session('uname')))->getField('ue_integral');
			//dump($map['sumprice']);
			//dump($settings['money_spb_bili']/100);//die;
			//dump($UE_money);die;
		if($map['sumprice']>$UE_money){
			die("<script>alert('积分余额不足！');history.back()</script>");
		}	
		if($arr['stock']<=0){
			die("<script>alert('库存不足，请先浏览其他商品');history.back()</script>");
		}	
			if($orderform->add($map)){

				//扣除商城金币
				M('user')->where(['UE_account'=>session('uname')])->setDec('UE_integral',$map['sumprice']);
				M('shop_project')->where(array('id'=>$id))->setDec('stock',$map['count']);


				//代数奖分成

				$price=$arr['fjed'];



                $tgbz_user_xx=M('user')->where(array('UE_account'=>session('uname')))->find();//充值人详细
			    //echo $ppddxx['p_id'];die;
			    if($tgbz_user_xx['ue_accname']<>''){
			    	jlsja($tgbz_user_xx['ue_accname']);
			    $money=$price*0.1;//100
			    // dump($money);die();
				$note3 = "推荐奖10%";
				// added by skyrim
				// purpose: custom share
				// version: 6.0
				$settings = include( APP_PATH . 'Home/Conf/settings.php' );
				// dump($settings);die();
				$note3 = "购物分红" . ( floatval($settings['tjr_share']) ) . "%";
				// dump($note3);die();
				$money=$money*10*floatval($settings['tjr_share'])/100;
				// dump($money);die();
			    $accname_zq=M('user')->where(array('UE_account'=>$tgbz_user_xx['ue_accname']))->find();
			    // dump($accname_zq);die();
			    // dump($accname_zq);die();
			    /* NOTED BY SKYRIM: 增加推荐人的统计总和 */
			    M('user')->where(array('UE_account'=>$tgbz_user_xx['ue_accname']))->find();
			    // M('user')->where(array('UE_account'=>$tgbz_user_xx['ue_accname']))->setInc('UE_money',$money);
			    // M('user')->where(array('UE_account'=>$tgbz_user_xx['zcr']))->setInc('UE_money',$money);
			    /* NOTED BY SKYRIM: 推荐人 */
			    $accname_xz=M('user')->where(array('UE_account'=>$tgbz_user_xx['ue_accname']))->find();
			    // dump($accname_xz);die();
			    // dump($accname_xz['ue_money']);die();
				// added ends
			    $record3 ["UG_account"] = $tgbz_user_xx['ue_accname']; // 登入转出账户
			    $record3 ["UG_type"] = 'jb';
			    $record3 ["UG_allGet"] = $accname_zq['ue_money']; // 金币
			    $record3 ["UG_money"] = '+'.$money; //
			    $record3 ["UG_balance"] = $accname_xz['ue_money']; // 当前推荐人的金币馀额
			    $record3 ["UG_dataType"] = 'gwj'; // 金币转出
			    $record3 ["UG_note"] = $note3; // 推荐奖说明
			    $record3["UG_getTime"]		= date ( 'Y-m-d H:i:s', time () ); //操作时间
			    // $reg4 = M ( 'userget' )->add ( $record3 );
			    
			    		//$money_jlj1=;
			    
						// added by skyrim
						// purpose: custom share
						// version: 6.0
						//$this_node = $tgbz_user_xx['zcr'];
						$this_node = $tgbz_user_xx['ue_accname'];
						$i = $settings['max_user_level'];

						$money=$price*$settings['shop_price_bl']*0.1*$count;
						// dump($money);die();

						while( $i -- ){
							if( $this_node && strlen( $this_node ) ){
							$tgbz_user_xx=M('user')->where(array('UE_account'=>$this_node))->find();
							M('user')->where(array('UE_account'=>$tgbz_user_xx['ue_account']))->setInc('UE_money',$money*floatval($settings['masses_share'][$settings['max_user_level']-$i]));

							 $this_node = masses_j( $this_node, $money*floatval($settings['masses_share'][$settings['max_user_level']-$i]),'购物分红奖' . ( floatval($settings['masses_share'][$settings['max_user_level']-$i]) * 100 ) . '%' );
							
							}
						}
					}die("<script>alert('商品提交成功');history.go(-2)</script>");
			}else{
				$this->error('请重新提交订单','project');
			}
		}

	}
	public function historyOrderform(){
		//dump('aaaa');die;
		$list = M('shop_orderform')->where(array('user'=>session('uname')))->select();
		$this->assign('list',$list);
		//dump($list);die;
		$this->display();
	}
	public function saveOrderform(){
		$id = I('post.id');
		$re = M('shop_orderform')->where(array('user'=>session('uname'),'id'=>$id))->save(['zt'=>'2']);
		if($re){
			$this->ajaxReturn(1);
		}else{
			$this->ajaxReturn(0);
		}
	}
	public function delOrderform(){
		$id = I('post.id');
		$re = M('shop_orderform')->where(array('user'=>session('uname'),'id'=>$id))->delete();
		if($re){
			$this->ajaxReturn(1);
		}else{
			$this->ajaxReturn(0);
		}
	}

}