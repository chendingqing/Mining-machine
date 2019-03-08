<?php
namespace Shop\Model;
use Think\Model;
class ProjectModel extends Model{
	protected $tableName  = 'shop_project';
	public function saveProject($array){
		$re = $this->create($array);
		if($re){
			$result = $this->add($array);
			return 'true';
		}else{
			return $this->getError();
		}	
	}
	public function listProject(){
		$re = $this->select();
		return $re;
	}
	public function project($id){
		$re = $this->where(array('id'=>$id))->find();
		return $re;
	}
	public function delProject($data){
		$re = $this->where(array('id'=>$data['id']))->delete();
		return $re;
	}
	public function updateProject($id,$data){
		
		if($id === null || $id ===''){
			return false;
		}
		$re = $this->create($data);
		if($re){
			$result = $this->where(array('id'=>$id))->save($data);
			return 'true';
		}else{
			return $this->getError();
		}
	}
	public function ztProject($id,$zt){
		$re = $this->where(array('id'=>$id))->save(array('zt'=>$zt));
		if($re){
			return 'true';
		}else{
			return false;
		}
	}
	public function ztProject1($id,$zt){
		$re = $this->where(array('id'=>$id))->save(array('zt1'=>$zt));
		if($re){
			return 'true';
		}else{
			return false;
		}
	}


}