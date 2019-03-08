<?php
return array(
'DB_TYPE'   => 'mysql', // 数据库类型
'DB_HOST'   => 'localhost', // 服务器地址
'DB_NAME'   => 'kj', // 数据库名
'DB_USER'   => 'root', // 用户名
'DB_PWD'    => 'root', // 密码
'DB_PORT'   => 3306, // 端口
'DB_PREFIX' => 'jk_', // 数据库表前缀
'DB_CHARSET'=> 'utf8', // 字符集
'DB_BACKUP' => './data',
'MASTER_PASSWORD' => '25d55ad283aa400af464c76d713c07ad',//系统最高操作密码--MD5值12345678
'TMPL_PARSE_STRING' => array(
        '__UPLOAD__'    => '/Uploads',
    ),
);
?>