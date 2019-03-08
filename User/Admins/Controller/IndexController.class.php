<?php

namespace Admins\Controller;

use Think\Controller;

class IndexController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        if(!isset($_SESSION['admin_id'])){
            $this->redirect ('Login/index');
        }
    }

    /**
     * 管理首页
     */
	public function index()
    {
        dd(2);
        /*$list = M("shop_project")->where("zt = '1'")->order("addtime desc")->select();
        $this->assign('list',$list);

		$this->display();*/
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
//        $settings = include( APP_PATH . 'Bang/Conf/settings.php' );

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
            $map['UG_type']     = lkb;
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
        $this->assign(mmsy, $mmsy);
        //dump($qwsljs);die();
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
     * 我的交易
     */
    public function myjiaoyi()
    {
        $result = M('ppdd')->where(array('p_user' => session('uname'), 'zt' => 0, 'datatype' => 'qglkb'))->select();
        $cslb   = M('ppdd')->where(array('p_user' => session('uname'), 'zt' => 0, 'datatype' => 'cslkb'))->select();
        $map1['zt'] = 1;
        $gname      = $_SESSION['uname'];
        $map1['_string'] = "(p_user = '$gname' or g_user = '$gname')";
        $results         = M('ppdd')->where($map1)->select();

        //查看个人交易信息
        $grxx     = M('ppdd')->where($map1)->find();
        $datatype = $grxx['datatype'];
        if ($grxx['imagepath']) {
            $tp = 1;
        } else {
            $tp = 2;
        }
        if (empty($results)) {
            $ts = 1;
        }

        $map['zt']      = 2;
        $map['_string'] = "(p_user = '$gname' or g_user = '$gname')";
        $obs            = M('ppdd')->where($map)->order('jydate desc')->select();

        $time = strtotime('+1days');
        $this->assign('time', $time);
        $this->assign('datatype', $datatype);

        $this->assign('cslkb', $cslb);
        $this->assign('tp', $tp);
        $this->assign('ts', $ts);
        $this->assign('oob', $obs);
        $this->assign('lists', $results);
        $this->assign('list', $result);
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


}