<?php
namespace Shop\Controller;
use Think\Controller;

class ProjectController extends CommonController{
	public function listProject(){
		$model = M('shop_project');
		$count = $model->count();

		$page = new \Think\Page($count,2);
		$show = $page->show();

		$array = $model->page(I('get.p'),2)->select();
		
		$this->assign('show',$show);
		$this->assign('list',$array);
		var_export($show);die;
		$this->display('listProject');

	}
	public function project(){
		$id = I('get.id');
		$arr = M('shop_project')->where(array('id'=>$id))->find();
		$this->assign('arr',$arr);
		$this->display('project');
	}
}