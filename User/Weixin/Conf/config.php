<?php
return array(
	'DB_TYPE'   => 'mysql', // 数据库类型
'DB_HOST'   => 'localhost', // 服务器地址
'DB_NAME'   => 'xnb_gecs', // 数据库名
'DB_USER'   => 'xnb_gecs', // 用户名
'DB_PWD'    => 'xnb_gecs', // 密码
'DB_PORT'   => 3306, // 端口
'DB_PREFIX' => 'jk_', // 数据库表前缀 
'DB_CHARSET'=> 'utf8', // 字符集
'DEFAULT_THEME'    =>    'default',// 设置默认的模板主题
//'SHOW_PAGE_TRACE'=>true,
'TMPL_PARSE_STRING' => array(
        '__UPLOAD__'    => '/Uploads', // 增加新的上传路径替换规则
    ),
'SHOW_ERROR_MSG' =>  false,
'TOKEN_ON'      =>    false,
'DEFAULT_FILTER' => 'strip_tags,htmlspecialchars',
'URL_MODEL'          => '2',
'LANG_SWITCH_ON' => true,
//'LANG_AUTO_DETECT' => true, // 自动侦测语言 开启多语言功能后有效
'DEFAULT_LANG' => 'zh-tw',
//'LANG_LIST'        => 'zh-tw', // 允许切换的语言列表 用逗号分隔
'VAR_LANGUAGE'     => 'l', // 默认语言切换变量
//'LAYOUT_ON'=>false,

// added by skyrim
// purpose: password retrieval
// version: v1.0
// -========= 邮箱配置 =========-
'mail_setting'     => array(
	// SMTP 服务器地址
	'smtp_server' => 'smtp.163.com',
	// SMTP 服务器端口
	'smtp_server_port' => 25,
	// SMTP 用户名
	'smtp_user' => 'gec_system@163.com',
	// SMTP 密码
	'smtp_pass' => 'haohan222
	',
	// 邮件发送人
	'mail_from' => 'gec_system@163.com',
),

    //'配置项'=>'配置值'
   'SHOW_PAGE_TRACE'=>false,
     /* 模板相关配置 */
    'TMPL_PARSE_STRING' => array(
        '__STATIC__' => __ROOT__ . '/Public/static',
        '__ADDONS__' => __ROOT__ . '/Public/ Home/Addons',
        '__IMG__'    => __ROOT__ . '/Public/Home/images',
        '__CSS__'    => __ROOT__ . '/Public/Home/css',
        '__JS__'     => __ROOT__ . '/Public/Home/js',
		'__UPLOAD__' => __ROOT__ . '/Uploads',
    ),
	'DEFAULT_CONTROLLER'    =>  'User', // 默认控制器名称
    'DEFAULT_ACTION'        =>  'index', // 默认操作名称
	'TMPL_ACTION_SUCCESS' => 'Public:dispatch_jump', // 默认错误跳转对应的模板文件
	'TMPL_ACTION_ERROR' => 'Public:dispatch_jump'

);