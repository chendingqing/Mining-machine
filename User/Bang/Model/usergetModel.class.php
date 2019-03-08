<?php

namespace Home\Model;

use Think\Model;




class usergetModel extends Model {
	//protected $insertFields = array('UE_account','UE_accName','nickname','email');
	//protected $updateFields = array('nickname','email');
	
	
	protected $_validate = array(
			
 			array('UJ_addaccount','/^[a-zA-Z0-9]{6,12}$/','账号格式不对！'),
// 			array('UE_account','','用户名已存在！',0,'unique',self::MODEL_BOTH),
// 			array('UE_accName','/^[a-zA-Z0-9]{6,12}$/','推荐人格式不对！'),
// 			array('UE_accName','require','推荐人必填！'),
// 			array('UE_accName','validate','推荐人不存在！',0,'callback',self::MODEL_BOTH),
// 			array('UE_theme','1,10','昵称1-10个字符！',0,'length',self::MODEL_BOTH),
// 			array('UE_password','/^[a-zA-Z0-9]{6,12}$/','密码6-12个字符！'),
// 			array('UE_repwd','/^[a-zA-Z0-9]{6,12}$/','密码6-12个字符！'),
// 			array('UE_secpwd','/^[a-zA-Z0-9]{6,12}$/','二级密码6-12个字符！'),
// 			array('UE_resecpwd','/^[a-zA-Z0-9]{6,12}$/','二级密码6-12个字符！'),
// 			array('UE_password','UE_repwd','两次输入密码不同！',0,'confirm',self::MODEL_BOTH),
// 			array('UE_secpwd','UE_resecpwd','两次输入的二级密码不同！',0,'confirm',self::MODEL_BOTH),
// 			array('UE_trueName','2,5','真实姓名2-5个字符！',0,'length',self::MODEL_BOTH),
// 			array('UE_sfz','/^[0-9]{18}$/','请输入18位身份证！')
	);
// 	protected $_auto = array (
// 			array('UE_password','md5',3,'function') ,
// 			array('UE_secpwd','md5',3,'function')
// 	);
// 	public function validate($data){
// 		if(M('user')->where(array('UE_account'=>$data))->find()){
// 			return TRUE;
// 		}else{
// 			return FALSE;
// 		}
// 	}
			
}