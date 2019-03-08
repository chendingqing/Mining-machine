<?php
$arr = array(
'DEFAULT_THEME'    =>    'default',
//'SHOW_PAGE_TRACE'=>true,
'TMPL_PARSE_STRING' => array(
        '__UPLOAD__'    => '/Uploads',
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

// -============================-
// added ends
);
$db = include "./config.php";
return array_merge($db,$arr);