/**
 * Created by PhpStorm.
 * User: Administrator
 * JQ 正则判断
 * Date: 2018/12/20
 * Time: 14:58
 */

/**
 * 正整数
 */
function checkPositiveInteger(s)
{
    var re = /^[1-9][0-9]*$/;
    if(re.test(s)){
        return true;
    }
    return false
}

/**
 * 正常金额判断
 */
function checkMoney(s)
{
    var re = /^(([1-9][0-9]*)|([0]\.[1-9])|([0]\.[0-9][1-9])|([1-9][0-9]*\.[1-9])|([1-9][0-9]*\.[0-9][1-9]))$/;
    if(re.test(s)){
        return true;
    }
    return false
}
