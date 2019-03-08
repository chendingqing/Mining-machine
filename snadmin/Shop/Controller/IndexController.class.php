<?php
namespace Shop\Controller;
use Think\Controller;
class IndexController extends CommonController {
  
    public function index(){
		$model = M('shop_leibie');
		if(IS_POST){
			$data = I();
			$data['addtime'] = time();
			if($model->where(array("name"=>$data['name']))->find()){
				$this->error("类别已存在");
			}
			$re = $model->add($data);
			$this->show_mes($re);
		}
		$list = $model->page($_GET['p'],12)->select();
		$this->assign("list",$list);
		$count = $model->count();
		$page = new \Think\Page($count,12);
		$show = $page->show();
		$this->assign("page",$show);
    	$this->display();
    }
    function toggleShop(){
    	if(IS_POST){
    		$order = I('post.toggle');
    		if($order == 1){
    			// $re = M('system')->where(['SYS_ID'=>'1'])->setField('toggleshop',1);
    			$re = M('system')->where(array('SYS_ID'=>1))->setField('toggleshop',1);
    		}elseif($order == 0){
    			// $re = M('system')->where(['SYS_ID'=>'1'])->setField('toggleshop',0);
    			$re = M('system')->where(array('SYS_ID'=>'1'))->setField('toggleshop',0);
    		}else{
    			die('非法操作！');
    		}
    		if($re){
    			$this->success('设置成功！');
    		}else{
    			$this->error('设置失败！');
    		}
    	}
    }

	function show_mes($data){
		if($data){
				$this->success("操作成功！");
			}else{
				$this->error("操作失败！");
			}
	}
	
	function ajax_mes($data){
		if($data){
				$this->ajaxReturn("1");
			}else{
				$this->ajaxReturn("0");
			}
	}
	
	function edit(){
		if(IS_POST){
			$model = M("shop_leibie");
			$data['name'] = I("post.name");
			$id = I("post.id");
			$re = $model->where(array("id"=>$id))->save($data);
			$this->ajax_mes($re);
		}
	}
	
	function del(){
		if(IS_POST){
			$id = I("id");
			if(!empty($id)){
				$model = M("shop_leibie");
				$re = $model->where(array("id"=>$id))->delete();
				$this->ajax_mes($data);
			}
		}
	}
	public function listOrderform(){
		$model = M('shop_orderform');
		$re = $model->order('id desc')->page($_GET['p'],12)->select();

		$count = $model->count();
		$page = new \Think\Page($count,12);
		$show = $page->show();
		//var_dump($show);die;
		$this->assign("page",$show);
		$this->assign('list',$re);
		$this->display();
	}
	public function listform(){
		$models = M('zcorder');
		$re = $models->order('id desc')->page($_GET['p'],12)->select();
		$counts = $models->count();
		$page = new \Think\Page($counts,12);
		$show = $page->show();

		$this->assign("page",$show);
		$this->assign('lists',$re);
		$this->display();
	}
	//产品订单
	public function delOrderform(){
		$data = I('post.');
		$re = M('shop_orderform')->where($data)->delete();
		if($re){
			$this->ajaxReturn(1);
		}else{
			$this->ajaxReturn(0);
		}
	}
	//确认发货
	public function delivery(){
		$id = I('post.id');
		$result = M('shop_orderform')->where(array('id'=>$id))->getField('zt');
		
		if($result == '0'){
			$re = M('shop_orderform')->where(array('id'=>$id))->save(array('zt'=>'1'));
		}elseif($result == '1'){
			$re = M('shop_orderform')->where(array('id'=>$id))->save(array('zt'=>'0'));
		}
		if($re){
			$this->ajaxReturn(1);
		}else{
			$this->ajaxReturn(0);
		}
	}
	public function fahuo(){
		$id=I('post.id');
		// alert($id);
		$result=M('zcorder')->where(array('id'=>$id))->getField('zt');

		// dump($result);die();

		if($result=='0'){
			$re = M('zcorder')->where(array('id'=>$id))->save(array('zt'=>'1'));
		 }//elseif($result=='1'){
		// 	$re=M('user')->where(array('id'=>$id))->save(array('zt'=>'0'));
		// }
		if($re){
			$this->ajaxReturn(1);
		}else{
			$this->ajaxReturn(0);
		}
		
	}

	public function wxme() {
		$wxconfig = D ( 'wxconfig' );
		if (IS_POST) {
			if (! $wxconfig->create ()) {
				// 如果创建失败 表示验证没有通过 输出错误提示信息
				$this->error ( $wxconfig->getError () );
			} else {
				// 添加
				if (I ( 'post.id' ) == '') {
					$data = $wxconfig->create ();
					$wxconfig->add ( $data );
				} else {
					// 修改
					$data ['id'] = I ( 'post.id' );
					$data = $wxconfig->create ();
					$wxconfig->save ( $data );
				}
			}
		}
		$wx = $wxconfig->find ();
		$this->assign ( 'wx', $wx );
		$this->display ();
	}
	
  public function wxkjset(){

		if(!empty($_POST)){
		$txinfo = array ();
		$txinfo ['appid'] = $_POST ['appid'];
		$txinfo ['mchid'] = $_POST ['mchid'];
		$txinfo ['key'] = $_POST ['key'];
		$txinfo ['kjmc'] = $_POST ['kjmc'];
		$txinfo ['kjgn'] = $_POST ['kjgn'];
		$txinfo ['kjzq'] = $_POST ['kjzq'];
		// $txinfo ['txjgtime'] = $_POST ['txjgtime'];
		// $txinfo ['txsxf'] = $_POST ['txsxf'];
		//dump($txinfo);exit;
		$txinfo = json_encode ( $txinfo );
	
		$txinfo = '<?php $txinfo = \'' . $txinfo . '\';?>';
		// echo $txinfo;die();
		
		file_put_contents ( "./Public/Conf/txinfo.php", $txinfo );
		$this->success ( "操作成功" );
		}else{
		if (file_exists ( './Public/Conf/txinfo.php' )) 

		{
			
			require './Public/Conf/txinfo.php';
			
			$txinfo = json_decode ( $txinfo, true );
		}
		// dump($txinfo);die();
		$this->assign ( "wxkjset", $txinfo );
		$this->display();
		}
	}
	public function replayedit() {
		
		$mid = I ( 'get.id' );
		$replay = D ( 'replay' );
		if (IS_POST) {
			if (! $replay->create ()) {
				$this->error ( $replay->getError () );
			} else {
				if (I ( 'post.id' ) == '') {
					$data = $replay->create ();
					if ($replay->add ( $data )) {
						$this->success ( "添加成功，请重新生成菜单", U ( 'wxmenu' ) );
					}
				} else {
					$data ['id'] = I ( 'post.id' );
					$data = $replay->create ();
					if ($replay->save ( $data )) {
						$this->success ( "修改成功，请重新生成菜单");
					}
				}
			}
		} else {
			empty($mid)?$mid=1:$mid;
			$rsplay = $replay->where ( array ('id' => $mid) )->find ();
			$this->assign ( 'rsplay', $rsplay );
			$this->display ();
		}
	}
public function medit(){
	$mid = I ( 'get.id' );
		$menu = D ( 'Wxmenu' );
		if (IS_POST) {
			if (! $menu->create ()) {
				$this->error ( $menu->getError () );
			} else {
				if (I ( 'post.menu_id' ) == '') {
					$data = $menu->create ();
					if ($menu->add ( $data )) {
						$this->success ( "添加成功，请重新生成菜单", U ( 'wxmenu' ) );
					}
				} else {
					$data ['menu_id'] = I ( 'post.menu_id' );
					$data = $menu->create ();
					if ($menu->save ( $data )) {
						$this->success ( "修改成功，请重新生成菜单", U ( 'wxmenu' ) );
					}
				}
			}
		} else {
			$rsmenu = $menu->where ( array (
					'menu_id' => $mid 
			) )->find ();
			unset ( $find );
			$find ['menu_type'] = 'none';
			$find ['pid'] = 0;
			$pidmenu = $menu->where ( $find )->select ();
			
			$this->assign ( 'rsmenu', $rsmenu );
			$this->assign ( "pidmenu", $pidmenu );
			$this->display ();
		}
}
public function delmenu() {
		$txtid = I ( 'get.id' );
		$menu = M ( 'wxmenu' );
		$result = $menu->where ( array('menu_id'=>$txtid) )->delete ();
		 if ($result !== FALSE) {
			$this->success ( "成功删除！", U ( "Index/wxmenu" ) );
		} else {
			$this->error ( '删除失败！' );
		}
	}
public function wxmenu() {
		$wxmenu = M ( 'Wxmenu' );
		$menutxt = get_menu ();
		//dump($menutxt);die();
		$this->assign ( "menu", $menutxt );
		$this->display ();
	}
public function creatmenu() {
		$data = get_menu ();
		foreach ($data as $k=>$v){
			$data[$k]['view_url']=html_entity_decode($v['view_url']);
		}
		//dump($data);exit;
		foreach ( $data as $k => $d ) {
			if ($d ['pid'] != 0)
				continue;
			$tree ['button'] [$d ['menu_id']] = _deal_data ( $d );
			unset ( $data [$k] );
		}
		foreach ( $data as $k => $d ) {
			$tree ['button'] [$d ['pid']] ['sub_button'] [] = _deal_data ( $d );
			unset ( $data [$k] );
		}
		$tree2 = array ();
		$tree2 ['button'] = array ();
		foreach ( $tree ['button'] as $k => $d ) {
			$tree2 ['button'] [] = $d;
		}
		$tree = json_encode_cn ( $tree2 );
		$weObj = $this->initwx ();
		
		$res = $weObj->createMenu ( $tree );
		
		if ($res) {
			$this->success ( "重新创建菜单成功!" );
		} else {
			$this->error ( "重新创建菜单失败：" . $weObj->errCode . '-' . $weObj->errMsg );
		}
	}
	public function poster() {
			$uid=I('get.uid');
			$rshy = M ("user")->where (array ("openid" => $uid ))->find ();
			
			if ($rshy) {
			    $path="./Poster/".$rshy['openid']."/";
			    $postname="poster_".$rshy['openid'].".jpg";
				$user_pic = $path.$postname;
				if (!file_exists($user_pic)) {
				    if (!is_dir($path)){
				        mkdir($path);
				    }
					$pic = 'https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket='.$rshy['ticket'];
					$data = file_get_contents($pic);
					$filename = "ticket_".$rshy['openid'].".jpg";
					$fp = @fopen($path.$filename,"w");
					@fwrite($fp,$data);
					//fclose($fp);
					$ticket = $path.$filename;
				;	$tpic=$rshy['wx_avatar'].".jpg";
					$data=file_get_contents($tpic);
					$filename = "logo_".$rshy['openid'].".jpg";
					$fp = @fopen($path.$filename,"w");
					@fwrite($fp,$data);
					fclose($fp);
					$logo = $path.$filename;
					$name=$rshy['nickname']; 
					$img = new \Think\Image();
					$img->open($ticket)->thumb(300, 300)->save($ticket);
					if(!empty($logo)){$img->open($logo)->thumb(62, 62)->save($logo);}
					define('THINKIMAGE_WATER_CENTER', 5);
				    $img->open('./card.jpg')->water($ticket, array(173,527))->water($logo, array(-78,-970))->text($name,'./hei.ttf','20','#d53917', array(-255,-970))->save($user_pic);
				}	
				
			}
			$this->assign('openid',$rshy['openid']);
			$this->assign('imgname',$postname);
			$this->display();
		
	}

}