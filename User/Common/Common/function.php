<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/17
 * Time: 10:08
 */


/**
 * 打印
 * @param $data
 * @param bool $start
 */
function dd($data, $start = true)
{
    echo "<pre>";
    var_dump($data);
    if($start === true){
        exit;
    }
}