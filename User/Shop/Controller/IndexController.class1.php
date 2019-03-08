<?php

namespace Shop\Controller;

use Think\Controller;

class IndexController extends CommonController
{
    // 首页
    public function index(){
        $model = M('shop_project');
        $count = $model->where('zt>0')->count();

        $page = new \Think\Page($count,9);
        $show = $page->show();

        //$array = $model->where('zt>0')->page(I('get.p'),9)->select();
        
		$shop_hot = M("shop_project")->where(array('zt'=>'2'))->order("addtime desc")->page(I('get.p'),9)->select();

		$title = M("shop_leibie")->select();
		$this->assign('title',$title);
		$this->assign('shop_hot',$shop_hot);
        $this->assign('show',$show);
        //$this->assign('list',$array);

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

		$page = new \Think\Page($count,10);
		foreach($map as $key=>$val) { 
			$Page->parameter   .=   "$key=".urlencode($val).'&';
		}
		$show = $page->show();

		$array = $model->where($map)->order("price")->page(I('get.p'),10)->select();
	
		
		$title = M("shop_leibie")->limit(10)->select();
		$this->assign('title',$title);
		//$list = $model->where($map)->select();
		$this->assign('show',$show);
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
	public function confirmProject(){
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
	public function addOrderform(){

		$id = I('get.id');
		$count = I('get.count');
		$count = $count+0;
		if(!is_int($count)){
			die("<script>alert('请输入整数');history.back()</script>");
		}
		if(!$id || !$count){
			die("<script>alert('请选择商品');history.back()</script>");
		}else{
			$arr = M('shop_project')->where(array('id'=>$id))->find();
			$orderform = M('shop_orderform');

			
			$map = array();
			$map['user'] = session('uname');
			$map['project'] = $arr['name'];
			$map['count'] = $count;
			$map['sumprice'] = $arr['price']*$count; 
			$map['addtime'] = date('Y-m-d H:i:s');
		$shop_money = M('user')->where(array('UE_account'=>session('uname')))->getField('shop_money');
		//dump($shop_money);die;
		if(($map['sumprice']/2)>$shop_money){
			die("<script>alert('商城币不足！');history.back()</script>");
		}	
			if($orderform->add($map)){
				//扣除商城金币
				M('user')->where(['UE_account'=>session('uname')])->setDec('shop_money',$map['sumprice']/2);
				die("<script>alert('商品提交成功');history.go(-2)</script>");
			}else{
				$this->success('请重新提交订单','project');
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