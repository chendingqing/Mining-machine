<?php
/*
 *@$info array($id,$row,$count)
 *@$id  自然id
 *@$row  最大行数
 *@$count 最大行人数
 */
 

	class Twotree {

		function make($info){
			$id = $info['numid'];
			$row = $info['row'];
			$cols = $info['count'];
			
			$data = array();
			if($cols == 1<<($row-1)){
				$data['row'] = $row+1;
				$data['cols'] = 1;
				$data['numid'] = $id+1;
			}else{
				$half = 1<<($row-2);
				if($cols<$half){
					$data['cols'] = 2*$cols+1;
					$data['numid'] = $id+2;
				}else{
					$data['cols'] = 2*($cols-$half+1);
					$num1 = $id - 2*($half-1);
					$data['numid'] = $num1+2*($cols-$half)+1;
				}
				$data['row'] = $row;
			}
			$data['stamp'] = ','.$data['row'].'.'.$data['cols'].',';
			return $data;
		}
		
		function get_parents($numid,$row,$col,$deep=1){
			while($deep){
				
				$row = $row-1;
				if($row <= 0){
					$row = 1;
					$col = 1;
					$deep = 1;
					$numid = 1;
					$parent[] = $numid;
					
				}else{
					$numid = ($numid-$col-(1<<($row-1))+ceil($col/2));
					$parent[] = intval($numid);
					
					$col = ceil($col/2);
				}
				$deep--;
			}
			return $parent;
			/* while($deep){
				
				$row = $row-1;
				if($row == 0){
					$row = 1;
					$col = 0;
					$deep = 0;
				}
				$parent[] = ($numid-$col-(1<<($row-1))+ceil($col/2));
				$numid = ($numid-$col-(1<<($row-1))+ceil($col/2));
				$col = ceil($col/2);
				
				$deep--;
			}
			return $parent; */
		}
		
		function get_son($numid,$row,$col,$deep=2,&$return=array()){
			//$col = ($col-1)*2+1;
			$numidl = $numid+(($col-1)*2+1)+(1<<($row-1))-$col;
			$numidr = $numidl+1;
			//$sons[$numid][] = $numidl;
			//$sons[$numid][] = $numidr;
			
			$mynums = array(array('numid'=>$numidl,'row'=>$row+1,'col'=>($col-1)*2+1),array('numid'=>$numidr,'row'=>$row+1,'col'=>($col-1)*2+2));
			$return[] = $numidl;
			$return[] = $numidr;
			
			$deep--;
			
			if(!$deep){
					
					return $return;
				}
			$this->get_ss($mynums,$return,$deep,$sign);
			//return $return;
		}
		function get_ss($myson = array(),&$return,$deep){
			
			foreach($myson as $k=>$v){
				
				$this->get_son($v['numid'],$v['row'],$v['col'],$deep,$return);
			}
			
		}
		
		public function make1(){
			
			$id = array();
			$rows = 1;//(最大行)
			$cols = array();//(当前行的人员)
			//$b = 1;
			//$c += $a;
			foreach($cols as $k=>$v){
				if($v&1){
					$odd[] = $v;
				}else{
					$even[] = $v;
				}
			}
			foreach($id as $k=>$v){
				if($v&1){
					$idr[] = $v;
				}else{
					$idc[] = $v;
				}
			}
			rsort($odd);
			rsort($even);
			rsort($ido);
			rsort($ide);
			
			$data = array();
			$data['newrows'] = $rows;
			$total = 1<<$rows;
			$data['newid'] = $id+1;
			
			if(($odd[0]+2)<$total){
				$data['newcols'] = $odd[0]+2;
				$data['newid'] = $ido[0]+2;
			}else{
				if(($even[0]+2)<=$total){
					$data['newcols'] = $even[0]+2;
					$data['newid'] = $ide[0]+2;
				}else{
					$data['newrows'] = $rows+1;
					$data['newcols'] = 1;
					$data['newid'] = $ide[0]+1;
				}
			}
			return $data;
		}
		
		function position($rows,$cols){
			if(!empty($rows) && !empty($cols)){
				return $cols<=(1<<($rows-1))?'L':'R';
			}
		}
		
		function my_position($cols){
			return $cols&1?'L':'R';
		}
	}