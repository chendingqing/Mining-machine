<?php
namespace Home\Controller;
use Think\Controller;
class DbController extends CommonController {
  
    public function index(){
		$dir = $_SERVER["DOCUMENT_ROOT"]."/db_backup/";
        if(IS_POST){
            
			if(!is_dir($dir)){
				mkdir($dir);
			}
			$mysql_dir = M()->query('select @@basedir as path from dual');
			
			$filename = date("YmdHis",time());
			$cmd = '"'.$mysql_dir[0]['path'].'\bin\mysqldump" -u'.C("DB_USER").' -p'.C("DB_PWD").' '.C("DB_NAME").' > '.$dir.$filename.'.sql';
			
			$res = exec($cmd,$output,$status);
			//$res = passthru($cmd,$status);
			//$res = system($cmd,$output);
			if($status){
				$this->error("备份失败");
			}else{
				$this->success("备份成功");
			}
        }
		$list = glob($dir."*.sql");
		foreach($list as $k=>$v){
			$v1 = explode(".",$v);
			$time = strtotime(str_replace($dir,'',$v1[0]));
			if(strlen($time) != 10){
				continue;
			}
			$list[$k] = date("Y-m-d H:i:s",$time);
		}
		$this->assign("list",$list);
		$this->display("index/data");
    }
	
	function del(){
		$data = I("item");
		if(!empty($data)){
			$dir = $_SERVER["DOCUMENT_ROOT"]."/db_backup/";
			$file = $dir.date("YmdHis",strtotime($data)).".sql";
			
			if(file_exists($file)){
				if(unlink($file)){
					$this->success("删除成功");
				}else{
					$this->success("删除失败");
				}
			}
			
		}
	}
	
	function recovery(){
		$dir = "db_backup/";
		$data = I("item");
		if(!empty($data)){
			$file = $dir.date("YmdHis",strtotime($data)).".sql";
			$cmd = 'mysql.exe -u'.C("DB_USER").' -p'.C("DB_PWD").' '.C("DB_NAME").' < '.$file;
			
			//$res = exec($cmd,$output,$status);
			$res = system($cmd,$output);
			
			//$res = passthru($cmd,$output);
			
			if($output){
				
				$this->error("恢复失败");
			}else{
				
				$this->success("恢复成功");
			}
		}
	}

	public function daoru(){
		$this->display("index/daoru");
	}
	//上传方法
    public function upload()
    {
        header("Content-Type:text/html;charset=utf-8");
        $upload = new \Think\Upload();// 实例化上传类
        $upload->maxSize   =     3145728 ;// 设置附件上传大小
        $upload->exts      =     array('xls', 'xlsx');// 设置附件上传类
        $upload->savePath  =      '/'; // 设置附件上传目录
        // 上传文件
        $info   =   $upload->uploadOne($_FILES['excelData']);
        $filename = './Uploads'.$info['savepath'].$info['savename'];
        $exts = $info['ext'];
        //print_r($info);exit;
        if(!$info) {// 上传错误提示错误信息
              $this->error($upload->getError());
          }else{// 上传成功
                  $this->goods_import($filename, $exts);
        }
    }

    // //导入数据页面
    // public function import()
    // {
    //     $this->display('goods_import');
    // }

    //导入数据方法
    protected function goods_import($filename, $exts='xls')
    {
        //导入PHPExcel类库，因为PHPExcel没有用命名空间，只能inport导入
        import("Org.Util.PHPExcel");
        //创建PHPExcel对象，注意，不能少了\
        $PHPExcel=new \PHPExcel();
        //如果excel文件后缀名为.xls，导入这个类
        if($exts == 'xls'){
            import("Org.Util.PHPExcel.Reader.Excel5");
            $PHPReader=new \PHPExcel_Reader_Excel5();
        }else if($exts == 'xlsx'){
            import("Org.Util.PHPExcel.Reader.Excel2007");
            $PHPReader=new \PHPExcel_Reader_Excel2007();
        }


        //载入文件
        $PHPExcel=$PHPReader->load($filename);
        //获取表中的第一个工作表，如果要获取第二个，把0改为1，依次类推
        $currentSheet=$PHPExcel->getSheet(0);
        //获取总列数
        $allColumn=$currentSheet->getHighestColumn();
        //获取总行数
        $allRow=$currentSheet->getHighestRow();
        //循环获取表中的数据，$currentRow表示当前行，从哪行开始读取数据，索引值从0开始
        for($currentRow=2;$currentRow<=$allRow;$currentRow++){
            //从哪列开始，A表示第一列
            for($currentColumn='B';$currentColumn<=$allColumn;$currentColumn++){
                //数据坐标
                $address=$currentColumn.$currentRow;
                //读取到的数据，保存到数组$arr中
                $data[$currentRow][$currentColumn]=$currentSheet->getCell($address)->getValue();
            }

        }
        $this->save_import($data);
    }

    //保存导入数据
    public function save_import($data)
    {
        //print_r($data);exit;

        $Goods = M('user');
        $add_time = date('Y-m-d H:i:s', time());
        foreach ($data as $k=>$v){
			$date['name'] = $v['B'];
			$date['age'] = $v['C'];
			$result = M('hehe')->add($date);
        }
        if($result){
            $this->success('产品导入成功', 'Index/index');
        }else{
            $this->error('产品导入失败');
        }
        //print_r($info);

    }




     //导出数据方法
    public function goods_export()
    {
		$goods_list = M('user')->select();
        // dump($goods_list);die();
        // print_r($goods_list);exit;
        $data = array();
        foreach ($goods_list as $k=>$goods_info){
// dump($goods_info);die();
			// $data[$k][id] = $goods_info['ue_id'];
            $data[$k][name] = $goods_info['ue_truename'];
            $data[$k][account] = $goods_info['ue_account'];
			 $data[$k][accname] = $goods_info['ue_accname'];
			
           
            $data[$k][money]=$goods_info['ue_money'];
           
            $data[$k][level]=$goods_info['ue_level'];
			 // $data[$k][jf]=$goods_info['ue_integral'];
			 $data[$k][idcard] = $goods_info['idcard'];
			$data[$k][phone] = $goods_info['ue_phone'];
            $data[$k][time] = $goods_info['ue_regtime'];

        }
        //print_r($goods_list);
        //print_r($data);exit;

        foreach ($data as $field=>$v){
           
           

            if($field == 'name'){
                $headArr[]='姓名';
            }
			
			if($field == 'account'){
                $headArr[]='会员编号';
            }

             if($field == 'accname'){
                $headArr[]='推荐人';
            }
           if($field == 'money'){
                $headArr[]='莱肯币';
            } 
           
             if($field == 'level'){
                $headArr[]='会员等级';
            }    
			// if($field == 'jf'){
   //              $headArr[]='积分';
   //          }
			 if($field == 'idcard'){
                $headArr[]='身份证号';
            }
			if($field == 'phone'){
                $headArr[]='电话号';
            }
        }

       
        $filename=date("Y-m-d H:i:s").".".net;

        $this->getExcel("".$filename,$headArr,$data);
    }


    private  function getExcel($fileName,$headArr,$data){

        //导入PHPExcel类库，因为PHPExcel没有用命名空间，只能inport导入
        import("Org.Util.PHPExcel");
        import("Org.Util.PHPExcel.Writer.Excel5");
        import("Org.Util.PHPExcel.IOFactory.php");

        $date = date("Y_m_d",time());
        $fileName .= "_{$date}.xls";

        //创建PHPExcel对象，注意，不能少了\
        $objPHPExcel = new \PHPExcel();
        $objProps = $objPHPExcel->getProperties();

        //设置表头
        $key = ord("A");
        //print_r($headArr);exit;
        foreach($headArr as $v){
            $colum = chr($key);
            $objPHPExcel->setActiveSheetIndex(0) ->setCellValue($colum.'1', $v);
            $objPHPExcel->setActiveSheetIndex(0) ->setCellValue($colum.'1', $v);
            $key += 1;
        }

        $column = 2;
        $objActSheet = $objPHPExcel->getActiveSheet();

        //print_r($data);exit;
        foreach($data as $key => $rows){ //行写入
            $span = ord("A");
            foreach($rows as $keyName=>$value){// 列写入
                $j = chr($span);
                $objActSheet->setCellValue($j. $column, " " . $value);
                $span++;
            }
            $column++;
        }

        $fileName = iconv("utf-8", "gb2312", $fileName);

        //重命名表
        //$objPHPExcel->getActiveSheet()->setTitle('test');
        //设置活动单指数到第一个表,所以Excel打开这是第一个表
        $objPHPExcel->setActiveSheetIndex(0);
        ob_end_clean();
        header('Content-Type: application/vnd.ms-excel;charset=utf8');
        header("Content-Disposition: attachment;filename=\"$fileName\"");
        header('Cache-Control: max-age=0');

        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output'); //文件通过浏览器下载
        exit;
    }



}