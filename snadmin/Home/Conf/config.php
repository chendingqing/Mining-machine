<?php
$arr = array(
'DEFAULT_THEME'    =>    'default',// 设置默认的模板主题
'SHOW_PAGE_TRACE'=>false,
'SHOW_ERROR_MSG' =>  false,
'TOKEN_ON'      =>    true,
'DEFAULT_FILTER' => 'strip_tags,htmlspecialchars',
//'URL_MODEL'          => '2',
'LANG_SWITCH_ON' => false,
//'LANG_AUTO_DETECT' => true, // 自动侦测语言 开启多语言功能后有效
'DEFAULT_LANG' => 'zh-tw',
//'LANG_LIST'        => 'zh-tw', // 允许切换的语言列表 用逗号分隔
'VAR_LANGUAGE'     => 'l', // 默认语言切换变量
//'LAYOUT_ON'=>true,
);
$db = include "./config.php";
return array_merge($db,$arr);