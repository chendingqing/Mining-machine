<?php

namespace Bang\Controller;

use Think\Controller;

class IndexController extends Controller
{
    public $prefix;

    public function __construct()
    {
        parent::__construct();

        if(!isset($_SESSION['uid'])){
            $this->redirect ('Login/index');
        }

        $this->prefix = C("DB_WEIQUAN_PREFIX");
    }





    /**
     * 矿机商城页面
     */
	public function index()
    {
        $list = M("shop_project")->where("zt = '1'")->order("addtime desc")->select();
        $this->assign('list',$list);

        $user = M("user")->where(array('UE_account' => $_SESSION['uname']))->find();
        $this->assign('point',$user['point']);

		$this->display();
	}

    /**
     * 兑换矿机功能
     */
    public function confirmProjecttwo()
    {
        $yCode = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J');
        $orderSn = $yCode[intval(date('Y')) - 2011] . date('d') . substr(time(), -5) . sprintf('%02d', rand(0, 99));

        $id= I('post.id');
        $project=M('shop_project')->where(array('id'=>$id))->find();
        if(empty($project)){
            $this->error("参数错误");
            exit;
        }
        $p_point=$project['point'];

        $result=M('user')->where(array('UE_account'=>$_SESSION['uname']))->find();
        $point=$result['point'];

        if($point<$p_point){
            $this->error('你的矿机点余额不足');
            exit;
        }

        $obs = M('user')->where(array('UE_account' => $_SESSION['uname']))->setDec('point', $p_point);
        if ($obs) {
            $map['user'] = session('uname');
            $map['project'] = $project['name'];
            $map['enproject'] = $project['enname'];
            $map['yxzq'] = $project['yxzq'];
            $map['sumprice'] = $project['price'];
            $map['addtime'] = date('Y-m-d H:i:s');
            $map['username'] = $result['ue_truename'];
            $map['imagepath'] = $project['imagepath'];
            $map['b_imagepath'] = $project['b_imagepath'];
            $map['lixi'] = $project['fjed'];
            $map['qwsl'] = $project['qwsl'];
            $map['kjsl'] = $project['kjsl'];
            $map['kjbh'] = $orderSn;
            M('shop_orderform')->add($map);

            $log = array(
                "user" => session('uname'),
                "type" => 2,
                "remarks" => "花费矿机点[".$p_point."]兑换".$project['name']."一台",
                "addtime" => date('Y-m-d H:i:s'),
            );
            M("point_log")->add($log);

            if($project['ads_condition'] > $result['ads_condition']){
                M('user')->where(array('UE_account' => $_SESSION['uname']))->save(array("ads_condition" => $project['ads_condition']));
                M("user",$this->prefix,"DB_WEIQUAN")->where(array("userid" => $_SESSION['uname']))->save(array("ads_condition" => $project['ads_condition']));
            }
            $this->success("兑换成功");
        } else {
            M('user')->where(array('UE_account' => $_SESSION['uname']))->setInc('point', $p_point);
            $this->error('兑换失败，请重新操作');
        }
    }





    /**
     * 购买矿机页面
     */
    public function jiaoyi()
    {
        $id = $_GET['id'];
        $project=M('shop_project')->where(array('id'=>$id))->find();
        $this->assign('project',$project);

        $this->display();
    }

    /**
     * 购买矿机功能
     */
    public function confirmProject()
    {
        $yCode = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J');
        $orderSn = $yCode[intval(date('Y')) - 2011] . date('d') . substr(time(), -5) . sprintf('%02d', rand(0, 99));

        $id= I('post.id');
        $project=M('shop_project')->where(array('id'=>$id))->find();
        if(empty($project)){
            $this->error("参数错误");
            exit;
        }
        $price=$project['price'];

        $result=M('user')->where(array('UE_account'=>$_SESSION['uname']))->find();
        $money=$result['ue_money'];

        if($money<$price){
            $this->error('你的账户余额不足');
            exit;
        }

        $obs = M('user')->where(array('UE_account' => $_SESSION['uname']))->setDec('UE_money', $price);
//        $zt = M('user')->where(array('UE_account' => $_SESSION['uname']))->data(array('kjzt' => 1))->save();
        if ($obs) {
            $orderform = M('shop_orderform');
            $map['user'] = session('uname');
            $map['project'] = $project['name'];
            $map['enproject'] = $project['enname'];
            $map['yxzq'] = $project['yxzq'];
            $map['sumprice'] = $price;
            $map['addtime'] = date('Y-m-d H:i:s');
            $map['username'] = $result['ue_truename'];
            $map['imagepath'] = $project['imagepath'];
            $map['b_imagepath'] = $project['b_imagepath'];
            $map['lixi'] = $project['fjed'];
            $map['qwsl'] = $project['qwsl'];
            $map['kjsl'] = $project['kjsl'];
            $map['kjbh'] = $orderSn;
            $orderform->add($map);

            if($project['ads_condition'] > $result['ads_condition']){
                M('user')->where(array('UE_account' => $_SESSION['uname']))->save(array("ads_condition" => $project['ads_condition']));
                M("user",$this->prefix,"DB_WEIQUAN")->where(array("userid" => $_SESSION['uname']))->save(array("ads_condition" => $project['ads_condition']));
            }
            $this->success("购买成功");
        } else {
            M('user')->where(array('UE_account' => $_SESSION['uname']))->setInc('UE_money', $price);
            $this->error('购买失败，请重新操作');
        }
    }





	/**
     * 个人中心页面
     */
	public function user()
    {
        $user=M('user')->where(array('UE_account'=>$_SESSION['uname']))->find();
        $this->assign('user',$user);

        $this->display();
    }





    /**
     * 我的矿机页面
     */
    public function mykuangche()
    {
        $result = M('shop_orderform')->where(array("user" => $_SESSION['uname']))->order("zt asc,id desc")->select();
        $this->assign("list", $result);

        $this->display();
    }





    /**
     * 矿机运行 或者 查看矿机
     */
    public function wakuang()
    {
        $id     = $_GET['id'];
        $result = M('shop_orderform')->where(array('id' => $id))->find();
        $user = M('user')->where(array('UE_account' => $_SESSION['uname']))->find();
        if ($result['zt'] == "0") {
            if ($user['level'] == 0) {
                //$jhzt = M('user')->where(array('UE_account' => $_SESSION['uname']))->data(array('level' => 1))->save();
            }
            $re                 = M('shop_orderform')->where(array('id' => $id))->data(array('zt' => 1))->save();
            $he                 = M('user')->where(array('UE_account' => $_SESSION['uname']))->data(array('kjzt' => 1))->save();
            $time               = date('Y-m-d H:i:s');
            $map['UG_account']  = $_SESSION['uname'];
            $map['UG_money']    = 0;
            $map['UG_type']     = 'lkb';
            $map['UG_dataType'] = 'wakuang';
            $map['UG_getTime']  = date('Y-m-d H:i:s');
            $map['UG_balance']  = $user['ue_money'];
            $map['UG_note']     = $result['project'] . '收入';
            $map['yxzq']        = $result['yxzq'];
            $map['kcprice']     = $result['sumprice'];
            $map['lixi']        = $result['lixi'];
            $map['kcid']        = $id;
            $map['kjbh']        = $result['kjbh'];
            $map['kjmc']        = $result['project'];
            M('userget')->add($map);
        }

        //计算预计总收益
        $oob   = M('userget')->where(array('kcid' => $id))->find();
        $dates = $oob['ug_gettime'];
        $time  = strtotime($dates);
        $time1 = time();
        $cha   = $time1 - $time;
        if ($cha / 3600 < 24) {
            $jrsy = $oob['lixi'] / 3600 * $cha;
            $jrsy = number_format($jrsy, 8);
        } else {
            $jrsj    = date('Y-m-d 00:00:00', time());
            $shijian = strtotime($jrsj);
            $nowtime = time();
            $timecha = $nowtime - $shijian;
            $jrsy = $oob['lixi'] / 3600 * $timecha;
            $jrsy = number_format($jrsy, 8);
        }

        $yjzsy  = $oob['lixi'] / 3600 * $cha; //矿车预计总收益
        $zsy    = number_format($yjzsy, 8);
        $kcmc   = $result['project'];
        $status = $result['zt'];
        $mysl   = $result['kjsl'];
        $qwsl   = $result['qwsl'];
        $qwsljs = M('shop_project')->sum('kjsl');
        //每秒受益
        $mmsy = $oob['lixi'] / 3600;
        $mmsy = number_format($mmsy, 8);
        $this->assign("mmsy", $mmsy);
        $ckzqwsl = M('shop_orderform')->where(array('zt' => 1))->sum('kjsl');
        $sl      = M('slkz')->order('id desc')->find();
        $xssl    = $ckzqwsl + $sl['num'];
        $xssl    = number_format($xssl, 2);
        //dump($xssl);die();
        $this->assign('kcmc', $kcmc);
        $this->assign('status', $status);
        $this->assign('yjzsy', $zsy);
        $this->assign('kjsl', $mysl);
        $this->assign('qwsl', $xssl);
        $this->assign('jrsy', $jrsy);

        $this->display();
    }





    /**
     * 矿机收益
     */
    public function kuangcheshouyi()
    {
        $result = M('userget')->where(array('UG_account' => $_SESSION['uname'], 'UG_dataType' => "wakuang"))->order('UG_ID DESC')->select();
        $this->assign('list', $result);

        $this->display();
    }





    /**
     * 我的交易
     */
    public function myjiaoyi()
    {
        $gname  = $_SESSION['uname'];
        $this->assign('uname',$gname);

        // 求购列表
        $result = M('ppdd')->where(array('p_user' => $gname, 'zt' => 0, 'datatype' => 'qglkb'))->select();
        $this->assign('qiugou', $result);

        // 出售列表
        $cslb   = M('ppdd')->where(array('p_user' => $gname, 'zt' => 0, 'datatype' => 'cslkb'))->select();
        $this->assign('chushou', $cslb);

        // 交易列表
        $map1['zt'] = 1;
        $map1['_string'] = "(p_user = '$gname' or g_user = '$gname')";
        $results = M('ppdd')->where($map1)->select();
        $this->assign('zyz', $results);

        //查看个人交易信息
        $grxx     = M('ppdd')->where($map1)->find();
        $datatype = $grxx['datatype'];
        $this->assign('datatype', $datatype);

        if ($grxx['imagepath']) {
            $tp = 1;
        } else {
            $tp = 2;
        }
        $this->assign('tp', $tp);

        if (empty($results)) {
            $ts = 1;
        }
        $this->assign('ts', $ts);

        // 交易完成列表
        $map['zt']      = 2;
        $map['_string'] = "(p_user = '$gname' or g_user = '$gname')";
        $obs = M('ppdd')->where($map)->order('jydate desc')->select();
        $this->assign('oob', $obs);

        $time = strtotime('+1days');
        $this->assign('time', $time);

        $this->display();
    }

    /**
     * 求购交易-个人求购发布取消
     */
    public function delqiugou()
    {
        if(IS_POST){
            $id = I("post.id") ? I("post.id") : "";
            if(empty($id)){
                $this->error("非法操作");
            }
            $order = M('ppdd')->where(array('id' => $id))->find();
            if(empty($order)){
                $this->error("非法操作");
            }
            if($order['zt'] != 0){
                $this->error("本条求购不能取消");
            }
            $result = M('ppdd')->where(array('id' => $id))->delete();
            if($result){
                $this->success("删除成功");
            }
        }
        $this->error("非法操作");
    }

    /**
     * 出售交易-个人出售发布取消
     */
    public function delchushou()
    {
        if(IS_POST){
            $id = I("post.id") ? I("post.id") : "";
            if(empty($id)){
                $this->error("非法操作");
            }
            $order = M('ppdd')->where(array('id' => $id))->find();
            if(empty($order)){
                $this->error("非法操作");
            }
            if($order['zt'] != 0){
                $this->error("本条求购不能取消");
            }
            $oob  = M('ppdd')->where(array('id' => $id))->find();
            $oobs = M('user')->where(array('UE_account' => $oob['p_user']))->find();
            $inc    = M('user')->where(array('UE_account' => $oob['p_user']))->setInc('UE_money', $oobs['djmoney']);
            $dec    = M('user')->where(array('UE_account' => $oob['p_user']))->setDec('djmoney', $oobs['djmoney']);
            $result = M('ppdd')->where(array('id' => $id))->delete();
            if ($result && $inc && $dec) {
                $this->success("删除成功");
            }
        }
        $this->error("非法操作");
    }

    /**
     * 交易列表-投诉
     */
    public function zyz_tousu()
    {
        if(IS_POST){
            $pid = I("post.pid") ? I("post.pid") : "";
            $type = I("post.type") ? I("post.type") : "";
            if(empty($pid) || empty($type)){
                $this->error("非法操作");
            }

            $order = M("ppdd")->where(array("id"=>$pid))->find();
            if(empty($order)){
                $this->error("非法操作");
            }

            $uname = $_SESSION['uname'];
            if($order['p_user'] != $uname && $order['g_user'] != $uname){
                $this->error("非法操作");
            }
            $e_time = strtotime($order['jydate']) + (12*60*60);
            $time = time();
            if($e_time > $time){
                $this->error("本单投诉时间在 ".date("Y-m-d H:i:s",$e_time)." 开放！");
            }

            if($type == 1){
                $this->success("可以投诉");
            }else if($type == 2){
                $text = I("post.text") ? I("post.text") : "";
                if(empty($text)){
                    $this->error("投诉内容不能为空");
                }
                $tousu = M('tousu')->where(array('pid' => $pid, "user" => $uname))->find(); //说明已经有一方投诉过了
                if($tousu){
                    $this->error("请勿重复投诉");
                }

                $map = array();
                if ($order['p_user'] == $uname) {
                    $map['text']  = $text; //投诉内容
                    $map['user']  = $uname; //投诉人；
                    $map['buser'] = $order['g_user']; //被投诉人
                    $map['date']  = date('Y-m-d H:i:s',$time);
                    $map['pid']   = $pid;
                }else if($order['g_user'] == $uname){
                    $map['text']  = $text; //投诉内容
                    $map['user']  = $uname; //投诉人；
                    $map['buser'] = $order['p_user']; //被投诉人
                    $map['date']  = date('Y-m-d H:i:s',$time);
                    $map['pid']   = $pid;
                }
                if(count($map) > 1){
                    $oob = M('tousu')->add($map);
                    if($oob){
                        $this->success("投诉成功，等待管理员处理。。。");
                    }
                }
            }
        }
        $this->error("非法操作");
    }

    /**
     * 交易列表-查看图片
     */
    public function zyz_imagepath()
    {
        if(IS_POST){
            $pid = I("post.pid") ? I("post.pid") : "";
            if(empty($pid) || $pid < 1){
                $this->error("非法操作");
            }
            $order = M("ppdd")->where(array("id"=>$pid))->find();
            if(empty($order)){
                $this->error("非法操作");
            }
            if(!empty($order['imagepath'])){
                $this->success($order['imagepath']);
            }else{
                $this->error("对方还没有上传凭证");
            }
        }
        $this->error("非法操作");
    }

    /**
     * 交易列表-上传图片
     */
    public function zyz_upload()
    {
        if(IS_POST){
            $pid = I("post.pid") ? I("post.pid") : "";
            $file = $_FILES['file'] ? $_FILES['file'] : "";
            if(empty($pid) || empty($file)){
                $this->error("非法操作");
            }
            if($_FILES['file']['error']){
                $this->error("非法操作");
            }

            $uname = $_SESSION['uname'];
            $where = array(
                "id" => $pid,
                'zt' => 1,
                '_string' => "(p_user = '$uname' or g_user = '$uname')",
            );
            $order = M('ppdd')->where($where)->find();
            if(empty($order)){
                $this->error("非法操作");
            }
            if(!empty($order['imagepath'])){
                $this->error("请不要重复上传图片");
            }

            $imgType = explode("/",$file['type']);

            $rootPath = './Uploads/';
            $fileName = $rootPath.date("Y-m-d");
            $fileName = iconv("UTF-8", "GBK", $fileName);
            if(!file_exists($fileName)){
                mkdir($fileName,0777, true);
            }
            $imgName = date("Y-m-d")."/".time().$pid.".".$imgType[1];
            $filePath = $rootPath.$imgName;
            if(!file_exists($filePath)){
                if(move_uploaded_file($file["tmp_name"],$filePath)){
                    $r = M('ppdd')->where(array("id" => $pid))->save(array("imagepath" => $imgName));
                    if($r){
                        $this->success("上传成功");
                    }
                };
            }
            $this->error("上传失败");
        }
        $this->error("非法操作");
    }

    /**
     * 交易列表-取消正在交易
     */
    public function zyz_del()
    {
        if(IS_POST){
            $pid = I("post.pid") ? I("post.pid") : "";
            if(empty($pid)){
                $this->error("非法操作");
            }

            $order = M("ppdd")->where(array("id" => $pid, "zt" => 1))->find();
            if(empty($order)){
                $this->error("非法操作");
            }
            if(!empty($order['imagepath'])){
                $this->error("您已经上传打款凭证，不能取消订单");
            }

            $uname = $_SESSION['uname'];
            switch ($order['datatype'])
            {
                case "cslkb":       // 出售AD币
                    if($order['g_user'] != $uname){
                        $this->error("非法操作");
                    }
                    $re = M('ppdd')->where(array('g_user' => $uname, 'zt' => 1, "id"=>$pid))->data(array('zt' => 0, 'g_user' => '', 'g_name' => '', 'g_level' => ''))->save();
                    if($re){
                        $this->success("订单已经取消");
                    }
                    break;

                case "qglkb":       // 求购AD币
                    if($order['p_user'] != $uname){
                        $this->error("非法操作");
                    }

                    $g_user = M('user')->where(array('UE_account' => $order['g_user']))->find();
                    if(empty($g_user)){
                        $this->error("非法操作");
                    }

                    $oob = M('user')->where(array('UE_account' => $order['g_user']))->setInc('UE_money', $g_user['djmoney']);
                    if(!$oob){
                        $this->error("取消订单失败");
                    }

                    $obs = M('user')->where(array('UE_account' => $order['g_user']))->setDec('djmoney', $g_user['djmoney']);
                    if(!$obs){
                        M('user')->where(array('UE_account' => $order['g_user']))->setDec('UE_money', $g_user['djmoney']);
                        $this->error("取消订单失败");
                    }

                    $re = M('ppdd')->where(array('zt' => 1, "id"=>$pid))->data(array('zt' => 0, 'g_user' => '', 'g_name' => '', 'g_level' => ''))->save();
                    if(!$re){
                        M('user')->where(array('UE_account' => $order['g_user']))->setDec('UE_money', $g_user['djmoney']);
                        M('user')->where(array('UE_account' => $order['g_user']))->setInc('djmoney', $g_user['djmoney']);
                        $this->error("取消订单失败");
                    }
                    $this->success("已经取消与卖家的联系");
                    break;

                default:
                    $this->error("非法操作");
            }
            $this->error("取消订单失败");
        }
        $this->error("非法操作");
    }

    /**
     * 交易列表-完成正在交易的订单
     */
    public function zyz_complete()
    {
        if(IS_POST){
            $pid = I("post.pid") ? I("post.pid") : "";
            if(empty($pid)){
                $this->error("非法操作");
            }

            $order = M('ppdd')->where(array('id' => $pid, "zt" => 1))->find();
            if(empty($order)){
                $this->error("非法操作");
            }
            if(empty($order['imagepath'])){
                $this->error("请等待对方把打款凭证图片上传上来");
            }

            $uname = $_SESSION['uname'];
            $user = M("user") -> where(array("UE_account" => $uname))->find();
            if(empty($user)){
                $this->error("非法操作");
            }

            switch ($order['datatype'])
            {
                case "cslkb":    // 出售AD币
                    if ($order['p_user'] != $uname) {
                        $this->error("非法操作");
                    }

                    $obs = M('user')->where(array('UE_account' => $uname))->setDec('djmoney', $user['djmoney']);
                    if(!$obs){
                        $this->error("订单完成操作失败");
                    }

                    $oob = M('user')->where(array('UE_account' => $order['g_user']))->setInc('UE_money', $order['lkb']);
                    if(!$oob){
                        M('user')->where(array('UE_account' => $uname))->setInc('djmoney', $user['djmoney']);
                        $this->error("订单完成操作失败");
                    }

                    $re = M('ppdd')->where(array('id' => $pid, 'zt' => 1))->data(array('zt' => 2))->save();
                    if(!$re){
                        M('user')->where(array('UE_account' => $uname))->setInc('djmoney', $user['djmoney']);
                        M('user')->where(array('UE_account' => $order['g_user']))->setInc('UE_money', $order['lkb']);
                        $this->error("订单完成操作失败");
                    }

                    $maps = array(
                        'date' => time(),
                        'price'=> $order['danjia']
                    );
                    M('date')->add($maps);
                    $this->success("操作成功");
                    break;

                case "qglkb":    // 求购AD币
                    if ($order['g_user'] != $uname) {
                        $this->error("非法操作");
                    }

                    $obs = M('user')->where(array('UE_account' => $uname))->setDec('djmoney', $user['djmoney']);
                    if(!$obs){
                        $this->error("订单完成操作失败");
                    }

                    $oob = M('user')->where(array('UE_account' => $order['p_user']))->setInc('UE_money', $order['lkb']);
                    if(!$oob){
                        M('user')->where(array('UE_account' => $uname))->setInc('djmoney', $user['djmoney']);
                        $this->error("订单完成操作失败");
                    }

                    $re = M('ppdd')->where(array('id' => $pid, "zt" => 1))->data(array('zt' => 2))->save();
                    if(!$re){
                        M('user')->where(array('UE_account' => $uname))->setInc('djmoney', $user['djmoney']);
                        M('user')->where(array('UE_account' => $order['p_user']))->setDec('UE_money', $order['lkb']);
                        $this->error("订单完成操作失败");
                    }

                    $maps = array(
                        'date' => time(),
                        'price'=> $order['danjia']
                    );
                    M('date')->add($maps);
                    $this->success("操作成功");
                    break;

                default:
                    $this->error("非法操作");
            }

            $this->error("订单完成操作失败");
        }
        $this->error("非法操作");
    }





    /**
     * 交易中心
     */
    public function jiaoyizhongxin()
    {
        $uname = $_SESSION['uname'];

        $xgcs = M('user')->where(array('UE_account' => $uname))->find();

        $map['zt']       = array(array('eq', 0), array('eq', 1), 'or');
        $map['datatype'] = 'qglkb';
        $list = M('ppdd')->where($map)->order('zt asc, danjia desc')->select();         // 求购
        $this->assign('list', $list);

        $map1['datatype'] = 'cslkb';
        $map1['zt']       = array(array('eq', 0), array('eq', 1), 'or');
        $lists            = M('ppdd')->where($map1)->order('zt asc, danjia desc')->select();  // 出售
        $this->assign('lists', $lists);

        $this->display();
    }

    /**
     * 发布交易-买入
     */
    public function addqiugou()
    {
        if(IS_POST){
            $number = I("post.number") ? I("post.number") : "";
            $money = I("post.money") ? I("post.money") : "";
            if(empty($number) || empty($money)){
                $this->error("参数错误");
            }
            if ($number < 1 || $money < 0) {
                $this->error("请输入正确的数量与单价");
            }

            $gname = $_SESSION['uname'];
            $user  = M('user')->where(array('UE_account' => $gname))->find();
            if(empty($user)){
                $this->error("非法操作");
            }

            $maps['zt']      = array(array('eq', 1), array('eq', 0), 'or');
            $maps['_string'] = "(p_user = '$gname' or g_user = '$gname')";
            $pd = M('ppdd')->where($maps)->find();
            if($pd){
                $this->error("您还有未完成交易的订单");
            }

            $map = array();
            $map['p_id']     = $user['ue_id'];
            $map['p_user']   = $user['ue_account'];
            $map['jb']       = $number * $money;
            $map['lkb']      = $number;
            $map['date']     = date('Y-m-d H:i:s');
            $map['p_name']   = $user['ue_truename'];
            $map['p_level']  = $user['level'];
            $map['danjia']   = $money;
            $map['datatype'] = 'qglkb';
            $oob = M('ppdd')->add($map);
            if (!$oob) {
                $this->error("发布购买失败");
            }
            $this->success("订单已成功发送至交易中心");
        }
        $this->error("非法操作");
    }

    /**
     * 发布交易-出售
     */
    public function addchushou()
    {
        if(IS_POST){
            $number = I("post.number") ? I("post.number") : "";
            $money = I("post.money") ? I("post.money") : "";
            if(empty($number) || empty($money)){
                $this->error("参数错误");
            }
            if ($number < 1 || $money < 0) {
                $this->error("请输入正确的数量与单价");
            }

            $gname = $_SESSION['uname'];
            $user  = M('user')->where(array('UE_account' => $gname))->find();
            if(empty($user)){
                $this->error("非法操作");
            }
            if($user['ue_money'] < $number){
                $this->error("您的账号余额不足");
            }

            $maps['zt']      = array(array('eq', 1), array('eq', 0), 'or');
            $maps['_string'] = "(p_user = '$gname' or g_user = '$gname')";
            $pd = M('ppdd')->where($maps)->find();
            if($pd){
                $this->error("您还有未完成交易的订单");
            }

            $totalprice = $number * $money;
            $map = array();
            $map['p_id']     = $user['ue_id'];
            $map['p_user']   = $user['ue_account'];
            $map['jb']       = $totalprice;
            $map['lkb']      = $number;
            $map['date']     = date('Y-m-d H:i:s');
            $map['p_name']   = $user['ue_truename'];
            $map['p_level']  = $user['level'];
            $map['danjia']   = $money;
            $map['datatype'] = 'cslkb';
            $chushou = M('user')->where(array('UE_account' => $gname))->setDec('UE_money', $number);
            if(!$chushou){
                $this->error("发布出售失败");
            }
            $csdec   = M('user')->where(array('UE_account' => $gname))->setInc('djmoney', $number);
            if(!$csdec){
                M('user')->where(array('UE_account' => $gname))->setInc('UE_money', $number);
                $this->error("发布出售失败");
            }
            $oob = M('ppdd')->add($map);
            if (!$oob) {
                M('user')->where(array('UE_account' => $gname))->setInc('UE_money', $number);
                M('user')->where(array('UE_account' => $gname))->setDec('djmoney', $number);
                $this->error("发布出售失败");
            }
            $this->success("订单已成功发送至交易中心");
        }
        $this->error("非法操作");
    }

    /**
     * 确定交易联系
     */
    public function transaction()
    {
        if(IS_POST){
            $id = I("post.id") ? I("post.id") : "";
            if(empty($id) || $id < 1){
                $this->error("非法操作");
            }

            $order = M("ppdd")->where(array("id" => $id, 'zt' => 0))->find();
            if(empty($order)){
                $this->error("订单不存在");
            }

            $uname = $_SESSION['uname'];
            $user = M("user")->where(array("UE_account" => $uname))->find();
            if(empty($user)){
                $this->error("非法操作");
            }

            if($order['p_user'] == $uname){
                $this->error("您不能与自己发布的单子确定交易联系！");
            }

            $maps['zt']      = array(array('eq', 1), array('eq', 0), 'or');
            $maps['_string'] = "(p_user = '$uname' or g_user = '$uname')";
            $pd = M('ppdd')->where($maps)->find();
            if($pd){
                $this->error("您还有未完成交易的订单");
            }

            $time = date('Y-m-d H:i:s');
            switch ($order['datatype'])
            {
                case "qglkb":           // 求购单
                    if($user['ue_money'] < $order['lkb']){
                        $this->error("你的账户余额不足");
                    }

                    $oob = M('user')->where(array('UE_account' => $uname))->setDec('UE_money', $order['lkb']);
                    if(!$oob){
                        $this->error("操作失败");
                    }

                    $obs = M('user')->where(array('UE_account' => $uname))->setInc('djmoney', $order['lkb']);
                    if(!$obs){
                        M('user')->where(array('UE_account' => $uname))->setInc('UE_money', $order['lkb']);
                        $this->error("操作失败");
                    }

                    $re_array = array(
                        'g_id' => $user['ue_id'],
                        'g_user' => $user['ue_account'],
                        'zt' => 1,
                        'g_name' => $user['ue_truename'],
                        'jydate' => $time,
                        'g_level' => $user['level'],
                    );
                    $re   = M('ppdd')->where(array('id' => $id))->save($re_array);
                    if(!$re){
                        M('user')->where(array('UE_account' => $uname))->setInc('UE_money', $order['lkb']);
                        M('user')->where(array('UE_account' => $uname))->setDec('djmoney', $order['lkb']);
                        $this->error("操作失败");
                    }
                    $this->success("匹配成功，请到 我的交易中的交易列表 查看详情");
                    break;

                case "cslkb":           // 出售单
                    $re_array = array(
                        'g_id' => $user['ue_id'],
                        'g_user' => $user['ue_account'],
                        'zt' => 1,
                        'g_name' => $user['ue_truename'],
                        'jydate' => $time,
                        'g_level' => $user['level'],
                    );
                    $re   = M('ppdd')->where(array('id' => $id))->save($re_array);
                    if(!$re){
                        $this->error("操作失败");
                    }
                    $this->success("匹配成功，请到 我的交易中的交易列表 查看详情");
                    break;

                default:
                    $this->error("非法操作");
            }
        }
        $this->error("非法操作");
    }





    /**
     * 我的矿点
     */
    public function point()
    {
        $uname = $_SESSION['uname'];

        $user=M('user')->where(array('UE_account'=>$uname))->find();
        $this->assign('user',$user);

        $log = M("point_log")->where(array("user" => $uname))->limit(10)->order("id desc")->select();
        $this->assign('log',$log);

        $this->display();
    }

    /**
     * 获取矿点日志
     */
    public function point_post()
    {
        if(IS_POST){
            $uname = $_SESSION['uname'] ? $_SESSION['uname'] : "";
            $number = I("post.number") ? I("post.number") : "";
            if(empty($uname) || empty($number)){
                $this->error("非法操作");
            }
            $log = M("point_log")->where(array("user" => $uname))->limit($number*10,10)->order("id desc")->select();
            $data = array(
                'number' => 0,
                "html" => "",
                'msg' => "暂无数据"
            );
            if(!empty($log)){
                if(count($log) < 10){
                    $data['msg'] = "已获取全部数据";
                }else{
                    $data['number'] = $number+1;
                    $data['msg'] = "获取成功";
                }
                foreach ($log as $v){
                    $data['html'] .= '<li class="mui-table-view-cell"><div class="kjd_jilu"><span class="kjd_time">'.$v['addtime'].'</span><p style="text-indent: 2em;">'.$v['remarks'].'</p></div></li>';
                }
            }
            $this->success($data);
        }
        $this->error("非法操作");
    }

    /**
     * 转出矿点功能
     */
    public function point_turn_out()
    {
        if(IS_POST){
            $uname = $_SESSION['uname'] ? $_SESSION['uname'] : "";
            $point = I("point") ? I("point") : "";
            if(empty($uname) || empty($point)){
                $this->error("非法操作");
            }

            $user = M("user")->where(array("UE_account" => $uname))->find();
            if(empty($user)){
                $this->error("非法操作");
            }
            $point = (int)$point;
            if($user['point'] < $point){
                $this->error("矿机点余额不足");
            }

            $z_user = M("user",$this->prefix,"DB_WEIQUAN")->where(array("userid"=>$uname))->find();
            if(empty($z_user)){
                $this->error("非法账号");
            }

            $time = time();
            $log_data = array(
                'user' => $uname,
                'type' => 3,
                'remarks' => '矿机网站转出['.$point.']矿机点',
                'addtime' => date("Y-m-d H:i:s",$time),
            );
            $r_log = M("point_log")->add($log_data);
            $r_user = M('user')->where(array('UE_account' => $uname))->setDec('point', $point);
            if($r_log && $r_user){
                $acount_log_data = array(
                    'user_id' => $z_user['id'],
                    'username' => $z_user['userid'],
                    'shouruad' => $point,
                    'addtime' => $time,
                    'leixing' => "从矿机网站转过来[".$point."]矿机点",
                );
                M("acount_log",$this->prefix,"DB_WEIQUAN")->add($acount_log_data);
                M("user",$this->prefix,"DB_WEIQUAN")->where(array("userid"=>$uname))->setInc("ue_money",$point);
                $this->success("操作成功");
            }
            $this->error($point);
        }
        $this->error("非法操作");
    }





}