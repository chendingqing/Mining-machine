<?php
namespace Shop\Controller;
use Think\Controller;
class ProjectController extends CommonController{
	public function addProject(){
		$list = M('shop_leibie')->select();
		$this->assign("ssid",session_id());
		$this->assign('list',$list);		
		$this->display('addProject');
	}
	public function saveProject(){
		// dump($_POST);die();
		 $uploads = new \Think\Upload();// 实例化上传类    
		 $uploads->maxSize   =     3145728 ;// 设置附件上传大小    
		 $uploads->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型    
		 $uploads->savePath  =      '/Pic/'; // 设置附件上传目录    
		 // 上传文件     
		 $info   =   $uploads->uploadOne($_FILES['imagepath']); 
		
		 if(!$info) {// 上传错误提示错误信息    
			$this->error($uploads->getError());
		 }else{// 上传成功 获取上传文件信息    
			
			$_POST['b_imagepath'] = $_POST['imagepath'] = '/Uploads'.$info['savepath'].$info['savename'];
			
		 }
		
		
		$_POST['addtime'] = time();
		$_POST['zt'] = 0;
		$re = $projectOb = D('Project')->saveProject($_POST);
		if($re === 'true'){
			$this->success('商品添加成功');
		}else{
			$this->success($re);
		}
	}
	//产品列表
	public function listProject(){
		$model = D('Project');
		$re = $model->field('jk_shop_project.*,jk_shop_leibie.name as pidname')->join('jk_shop_leibie ON jk_shop_project.pid = jk_shop_leibie.id')->page($_GET['p'],12)->select();
		$count = $model->count();
		$page = new \Think\Page($count,12);
		$show = $page->show();
		//var_dump($show);die;
		$this->assign("page",$show);
		$this->assign('list',$re);
		$this->display('listProject');
	}
	//产品删除
	public function delProject(){
		$data = I('post.');
		$re = D('Project')->delProject($data);
		if($re){
			$this->ajaxReturn(1);
		}else{
			$this->ajaxReturn(0);
		}
	}
	//产品明细
	public function project(){
		$id = I('get.id');
		$list = M('shop_leibie')->select();
		
		$arr = D('Project')->project($id);
		$this->assign('list',$list);	
		$this->assign('ssid',session_id());	
		$this->assign('arr',$arr);
		$this->display('project');

	}
	//产品update
	/* public function updateProject(){
		$id = I('get.id');
		$arr = D('Project')->project($id);
		if(empty($_POST['imagepath'])){
			$_POST['imagepath'] = $_POST['face180'];
		}
		$re = D('Project')->updateProject($id,$_POST);
		if($re === 'true'){
			$this->success('商品修改成功');
		}else{
			$this->success($re);
		}
	} */
	public function updateProject(){

		$id=I('get.id');
		$data['pid']=I('post.pid');
		$data['name']=I('post.name');
		$data['title']=I('post.title');
		$data['old_price']=I('old_price');
        $data['price']=I('price');
        $data['point']=I('point');
		$data['stock']=I('stock');
		$data['fjed']=I('post.fjed');
        $data['imagepath']=I('post.face180');
        $data['b_imagepath']=I('post.face-b-180');
		$data['content']=I('post.content');
		$data['encontent']=I('post.encontent');
		$data['qwsl'] = I('post.qwsl');
		$data['kjsl'] = I('post.kjsl');
		$data['yxzq'] = I('post.yxzq');
		$data['enname'] = I('post.enname');
		$data['ads_condition'] = I('post.ads_condition');
		if($_FILES['face'] && !empty($_FILES['face']['name'])){
            $uploads = new \Think\Upload();// 实例化上传类
            $uploads->maxSize   =     3145728 ;// 设置附件上传大小
            $uploads->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
            $uploads->savePath  =      '/Pic/'; // 设置附件上传目录
            // 上传文件
            $info   =   $uploads->uploadOne($_FILES['face']);
            if(!$info) {// 上传错误提示错误信息
                $this->error($uploads->getError() . "1");
            }else{// 上传成功 获取上传文件信息
                $data['imagepath'] = '/Uploads'.$info['savepath'].$info['savename'];
            }
        }

        if($_FILES['face-b'] && !empty($_FILES['face-b']['name'])){
            $uploads = new \Think\Upload();// 实例化上传类
            $uploads->maxSize   =     3145728 ;// 设置附件上传大小
            $uploads->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
            $uploads->savePath  =      '/Pic/'; // 设置附件上传目录
            // 上传文件
            $info   =   $uploads->uploadOne($_FILES['face-b']);
            if(!$info) {// 上传错误提示错误信息
                $this->error($uploads->getError() . "2");
            }else{// 上传成功 获取上传文件信息
                $data['b_imagepath'] = '/Uploads'.$info['savepath'].$info['savename'];
            }
        }

		// dump($data);die();
		if(M('shop_project')->where(array('id'=>$id))->save($data)){
			$this->success('修改成功!');
		}else{
			$this->success('修改失败！');
		}

	}
    //修改产品状态
    public function ztProject(){
    	$id = I('get.id');
    	$zt = I('get.zt');
		
    	if($zt == 0){
    		D('Project')->ztProject($id,$zt);
    	}elseif($zt == 1){
    		D('Project')->ztProject($id,$zt);
    	}else{
    		alert('提交数据zt状态出错');
    	}
    	$this->redirect('listProject');
    }
	 public function ztProject1(){
    	$id = I('get.id');
    	$zt1 = I('get.zt1');
    	if($zt1 == 0){
    		D('Project')->ztProject1($id,$zt1);
    	}elseif($zt1 == 2){
    		D('Project')->ztProject1($id,$zt1);
    	}else{
    		alert('提交数据zt状态出错');
    	}
    	$this->redirect('listProject');
    }


}