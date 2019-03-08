<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/17
 * Time: 13:39
 */

/**
 * 打印
 * @param $data
 * @param bool $start
 */
function dd($data, $start = true)
{
    dump($data);
    if($start){
        exit;
    }
}