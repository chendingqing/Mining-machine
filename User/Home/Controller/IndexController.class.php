<?php

namespace Home\Controller;

use Think\Controller;

class IndexController extends Controller {
	// 首页
	public function index() {
		I('post.help', '', I('get.i'));
		if(! isset ( $_SESSION ['uid'] )){
			$this->redirect ( '/Index.php/Home/Login/index' );
		}

		$result= M('userget')->where(array('UG_account'=>$_SESSION['uname'],'UG_dataType'=>wakuang))->order('UG_ID DESC')->select();
		
		$this->assign('list',$result);
		//dump($result);die();
		$oob=M('user')->where(array('UE_account'=>$_SESSION['uname']))->find();
		$kymoney= $oob['ue_money'];
		$djmoney = $oob['djmoney'];
		$kymoney = number_format($kymoney,8);
		$nickname=$oob['ue_truename'];
		$this->assign('nickname',$nickname);
		$this->assign('djmoney',$djmoney);
		$this->assign('kymoney',$kymoney);
		//$this->assign('openid',$openid);
		
		$this->display();
	}
	public function enindex() {
		if(! isset ( $_SESSION ['uid'] )){
			$this->redirect ( '/Index.php/Home/Login/index' );
		}

		$result= M('userget')->where(array('UG_account'=>$_SESSION['uname'],'UG_dataType'=>wakuang))->order('UG_ID DESC')->select();
		
		$this->assign('list',$result);
		//dump($result);die();
		$oob=M('user')->where(array('UE_account'=>$_SESSION['uname']))->find();
		$kymoney= $oob['ue_money'];
		$djmoney = $oob['djmoney'];
		$nickname=$oob['ue_truename'];
		$this->assign('nickname',$nickname);
		//$djmoney = number_format($djmoney,8);
		$kymoney = number_format($kymoney,8);
		$this->assign('djmoney',$djmoney);
		$this->assign('kymoney',$kymoney);
		//$this->assign('openid',$openid);
		$this->display('enindex');
	}

	public function help(){
		$info=M('info')->where(array('IF_type'=>'help'))->order('IF_ID DESC')->select();
		
		$this->assign('info',$info);
		

		$this->display();
	}
	
	public function help1(){
		$info=M('info')->where(array('IF_type'=>'gonggao'))->order('IF_ID DESC')->select();
		
		$this->assign('info',$info);
		

		$this->display();
	}
	
	
	
	public function enhelp(){
		$info=M('info')->order('IF_ID DESC')->select();
		
		$this->assign('info',$info);
		

		$this->display('enhelp');
	}
	/* public function erweima(){
		$user= M('user')->where(array('UE_account'=>$_SESSION['uname']))->find();
			$useragent = $_SERVER ['HTTP_USER_AGENT'];
		if (strpos ( $useragent, 'MicroMessenger' ) === false) {
			die("<script>alert('请到微信端查看');history.back(-1);</script>");
				
		}
		header ( "Content-type: text/html; charset=utf-8" );
		if ($_GET ['debug']) {
		} else {
			$agent = $_SERVER ['HTTP_USER_AGENT'];
			if (! strpos ( $agent, "icroMessenger" )) {
				die("<script>alert('请到微信端查看');history.back(-1);</script>");
			}
		}
		
		
		
		$openid= $user['openid'];
		$this->assign('openid',$openid);
		$this->display();
	} */
  public function uploadify()
    {
        if (!empty($_FILES)) {
            //图片上传设置
            $config = array(   
                'maxSize'    =>    3145728, 
                'savePath'   =>    '',  
                'saveName'   =>    array('uniqid',''), 
                'exts'       =>    array('jpg', 'gif', 'png', 'jpeg'),  
                'autoSub'    =>    true,   
                'subName'    =>    array('date','Ymd'),
            );
            $upload = new \Think\Upload($config);// 实例化上传类
            $images = $upload->upload();
            //判断是否有图
            if($images){
                $info=$images['file']['savepath'].$images['file']['savename'];
                //返回文件地址和名给JS作回调用
                echo $info;
            }
            else{
                //$this->error($upload->getError());//获取失败信息
            }
        }
    }
	
	
	
	
	

}