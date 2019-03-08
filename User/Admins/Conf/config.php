<?php
$arr = array(
    'DEFAULT_THEME'    =>    'default',// 设置默认的模板主题
    'SHOW_ERROR_MSG' =>  false,
    'TOKEN_ON'      =>    false,
    'DEFAULT_FILTER' => 'strip_tags,htmlspecialchars',
    'URL_MODEL'          => '2',
    'LANG_SWITCH_ON' => true,
    'DEFAULT_LANG' => 'zh-tw',
    'VAR_LANGUAGE'     => 'l', //  默认语言切换变量
);
$db = include "./config.php";
return array_merge($db,$arr);