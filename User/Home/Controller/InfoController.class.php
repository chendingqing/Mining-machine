<?php

namespace Home\Controller;

use Think\Controller;

class InfoController extends CommonController
{
    // 首頁
    public function index()
    {
        $settings = include dirname(APP_PATH) . '/User/Home/Conf/settings.php';
        if ($settings['is_op'] != 1) {
            die("<script>alert('市场暂时关闭');window.location.href='/index.php/Home/Info/myziliao/';</script>");
        }
        $xgcs = M('user')->where(array('UE_account' => $_SESSION['uname']))->find();
        /* if($xgcs['xgcs']==0){
        die("<script>alert('请绑定个人收款资料');window.location.href='/index.php/Home/Info/myziliao/';</script>");
        } */
        $cs = $xgcs['xgcs'];
        $this->assign('xgcs', $cs);

        $a               = '0';
        $b               = '1';
        $map['zt']       = array(array('eq', $a), array('eq', $b), 'or');
        $map['datatype'] = 'qglkb';

        $list = M('ppdd')->where($map)->order('zt asc, danjia desc')->select();

        $c                = '0';
        $d                = '1';
        $map1['datatype'] = 'cslkb';
        $map1['zt']       = array(array('eq', $c), array('eq', $d), 'or');
        $lists            = M('ppdd')->where($map1)->order('zt asc, danjia desc')->select();

        $gao    = $settings['max_danjia'];
        $di     = $settings['min_danjia'];
        $zuihou = M('date')->order('id desc')->find();
        //dump($zuihou);die();
        $zuihou = $zuihou['price'];

        $fu = ($gao / $di) - 1;
        $fu = $fu * 100;
        $fu = number_format($fu, 2);

        $time  = date('Y-m-d 00:00:00', time());
        $time1 = date('Y-m-d 23:59:59', time());

        $maps['jydate'] = array(array('gt', $time), array('lt', $time1));
        //dump($map);
        $liang = M('ppdd')->where($maps)->sum('lkb');
        $zjjy  = M('jyl')->order('id desc')->find();
        $liang = $liang + $zjjy['num'];
        /* dump($time);echo "<br />";
        dump($time1); */
        //今开
        $yestoday = strtotime("-1days");
        $yest     = date('Y-m-d 00:00:00', $yestoday);
        $yests    = date('Y-m-d 23:59:59', $yestoday);
        $ztime    = strtotime($yest);
        $ztimes   = strtotime($yests);
        /* echo $ztime; echo "<br />";
        echo $ztimes; */

        $maap['date'] = array(array('gt', $ztime), array('lt', $ztimes));
        $zuoshou      = M('date')->where($maap)->order('id desc')->find();
        $zuoshou      = $zuoshou['price'];
        //echo $zuoshou;

        //作收
        //今开
        $jtime         = strtotime($time);
        $jtime1        = strtotime($time1);
        $maaps['date'] = array(array('egt', $jtime), array('lt', $jtime1));
        $jinkai        = M('date')->where($maaps)->order('id asc')->find();
        //dump($jinkai);
        $jinkai = $jinkai['price'];
        //今天最高
        $jrsj = strtotime(date('Y-m-d', TIME()));
        //ECHO $jrsj;
        $jrzg  = M('date')->where($maaps)->max('price');
        $jrzd  = M('date')->where($maaps)->min('price');
        $rxpan = M(ridate)->where(array('date' => $jrsj))->find();
        if (!$rxpan) {
            $data['jinkai']  = $jinkai;
            $data['zuoshou'] = $zuoshou;
            $data['jrzg']    = $jrzg;
            $data['jrzd']    = $jrzd;
            $data['date']    = $jrsj;
            M('ridate')->add($data);
        }
        if ($rxpan['jrzg'] < $jrzg) {
            M('ridate')->where(array('date' => $jrsj))->save(array('jrzg' => "$jrzg"));
        }
        if ($rxpan['jrzd'] > $jrzd) {
            M('ridate')->where(array('date' => $jrsj))->save(array('jrzd' => "$jrzd"));
        }

        $level  = M('user')->where(array('UE_account' => $_SESSION['uname']))->find();
        $levels = $level['level'];
        $this->assign('level', $levels);
        $this->assign('gao', $gao);
        $this->assign('di', $di);
        $this->assign('zuihou', $zuihou);
        $this->assign('liang', $liang);
        $this->assign('fu', $fu);
        $this->assign('lists', $lists);
        $this->assign('list', $list);
        $this->assign('zuoshou', $zuoshou);
        $this->assign('jinkai', $jinkai);
        $this->assign('jrzg', $jrzg);
        $this->assign('jrzd', $jrzd);
        $wk_start_time = M('config')->find(1);
        $wk_end_time   = M('config')->find(2);
        $opening       = M('config')->find(5);
        $is_Prompt     = $this->get_curr_time_section($wk_start_time['config_value'], $wk_end_time['config_value']);
        $this->assign('is_Prompt', $is_Prompt);
        $this->assign('opening', $opening['config_value']);

        $this->display("info/index");
    }

    public function get_curr_time_section($wk_start_time, $wk_end_time)
    {
        $checkDayStr = date('Y-m-d ', time());
        $timeBegin1  = strtotime($checkDayStr . $wk_start_time);
        $timeEnd1    = strtotime($checkDayStr . $wk_end_time);
        $curr_time   = time();
        if ($curr_time >= $timeBegin1 && $curr_time <= $timeEnd1) {
            return 1;
        }
        return -1;
    }

    public function enindex()
    {
        $settings = include dirname(APP_PATH) . '/User/Home/Conf/settings.php';
        //die("<script>alert('Yet open');history.back(-1);</script>");
        $a               = '0';
        $b               = '1';
        $map['zt']       = array(array('eq', $a), array('eq', $b), 'or');
        $map['datatype'] = 'qglkb';

        $list = M('ppdd')->where($map)->order('zt asc, danjia desc')->select();

        $c                = '0';
        $d                = '1';
        $map1['datatype'] = 'cslkb';
        $map1['zt']       = array(array('eq', $c), array('eq', $d), 'or');
        $lists            = M('ppdd')->where($map1)->order('zt asc, danjia desc')->select();

        $gao    = $settings['max_danjia'];
        $di     = $settings['min_danjia'];
        $zuihou = M('date')->order('id desc')->find();
        $zuihou = $zuihou['price'];
        $fu     = ($gao / $di) - 1;
        $fu     = $fu * 100;
        $fu     = number_format($fu, 2);

        $time  = date('Y-m-d 00:00:00', time());
        $time1 = date('Y-m-d 23:59:59', time());

        $maps['jydate'] = array(array('gt', $time), array('lt', $time1));
        //dump($map);
        $liang  = M('ppdd')->where($maps)->sum('lkb');
        $zjjy   = M('jyl')->order('id desc')->find();
        $liang  = $liang + $zjjy['num'];
        $level  = M('user')->where(array('UE_account' => $_SESSION['uname']))->find();
        $levels = $level['level'];
        $this->assign('level', $levels);
        $this->assign('gao', $gao);
        $this->assign('di', $di);
        $this->assign('zuihou', $zuihou);
        $this->assign('liang', $liang);
        $this->assign('fu', $fu);
        $this->assign('lists', $lists);
        $this->assign('list', $list);

        $this->display();
    }

    public function code()
    {
        $user = M("user")->where(array("UE_account" => $_SESSION['uname']))->find();
        $mobile  = $user['phone'];
        $code    = mt_rand(1000, 9999);
        $content = "您的验证码是{$code}【HBC】";
        $url     = "http://utf8.sms.webchinese.cn/?Uid=bc&Key=c2586066d2fdef&smsMob=$mobile&smsText=$content";
        $res     = file_get_contents($url);
        session('xx_code', $code);
        echo json_encode(['code' => 0, 'message' => '发送成功']);
        exit;
    }

    public function mykuangche()
    {

        $map['user'] = session('uname');
        $result      = M('shop_orderform')->where($map)->order("zt asc,id desc")->select();

        $this->assign("list", $result);
        $this->display();
    }
    public function enmykuangche()
    {
        $map['user'] = session('uname');
        $result      = M('shop_orderform')->where($map)->order("zt asc,id desc")->select();

        $this->assign("list", $result);
        $this->display('enmykuangche');
    }

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
    public function enwakuang()
    {

        $id     = $_GET['id'];
        $result = M('shop_orderform')->where(array('id' => $id))->find();

        $user = M('user')->where(array('UE_account' => $_SESSION['uname']))->find();

        if ($result['zt'] == "0") {
            if ($user['level'] == 0) {
                $jhzt = M('user')->where(array('UE_account' => $_SESSION['uname']))->data(array('level' => 1))->save();
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
        $kcmc   = $result['enproject'];
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

    public function myziliao()
    {
        $user  = M('user')->where(array('UE_account' => $_SESSION['uname']))->select();
        $users = M('user')->where(array('UE_account' => $_SESSION['uname']))->find();
        if ($users['phone'] == "") {
            $yzm = 1;
        } else {
            $yzm = 2;
        }
        $xgcs = $users['xgcs'];

        //$result = M('user')->where(array())->find();
        $this->assign('xgcs', $xgcs);
        $this->assign('yzm', $yzm);
        $this->assign('list', $user);
        $this->display();
    }

    /* wk 币转编码转换 */
    public function exchange()
    {
        $oob     = M('user')->where(array('UE_account' => $_SESSION['uname']))->find();
        $kymoney = $oob['ue_money'];
        $kymoney = number_format($kymoney, 8);
        $this->assign('kymoney', $kymoney);

        $list = M('changelist')->where(array('bid' => $oob['ue_id']))->order('addtime desc ')->select();
        $this->assign('list', $list);
        $this->display();
    }
    /* wk 处理兑换 */
    public function edit_exchange()
    {
        $oob  = M('user')->where(array('UE_account' => $_SESSION['uname']))->find();
        $data = I('post.');
        $lkb  = trim($data['lkb']);

        $find = M('changelist')->where(array('bs' => $lkb))->find();
        if (empty($find)) {
            $url = 'http://' . $_SERVER['HTTP_HOST'] . u('index.php/Home/info/change');

            die("<script>alert('该串码无效');history.back(-2);window.location.href='" . $url . "';</script>");
        }

        if ($find['bid'] > 0) {
            $url = 'http://' . $_SERVER['HTTP_HOST'] . u('index.php/Home/info/change');
            die("<script>alert('该串码已被使用');history.back(-2);window.location.href='" . $url . "';</script>");

        }

        M('user')->where(array('UE_account' => $_SESSION['uname']))->setInc('UE_money', $find['money']);

        M('changelist')->where(array('id' => $find['id']))->data(array('bid' => $oob['ue_id']))->save();

        $url = 'http://' . $_SERVER['HTTP_HOST'] . u('index.php/Home/info/change');
        die("<script>alert('使用成功');history.back(-2);window.location.href='" . $url . "';</script>");

    }

    /* wk 币转编码 */
    public function change()
    {
        $oob     = M('user')->where(array('UE_account' => $_SESSION['uname']))->find();
        $kymoney = $oob['ue_money'];
        $kymoney = number_format($kymoney, 8);
        $this->assign('kymoney', $kymoney);

        $list = M('changelist')->where(array('uid' => $oob['ue_id']))->order('bid asc , addtime desc')->select();
        $this->assign('list', $list);

        $oob   = M('user')->where(array('UE_account' => $_SESSION['uname']))->find();
        $list2 = M('changelist')->where(array('bid' => $oob['ue_id']))->order('addtime desc ')->select();
        $this->assign('list2', $list2);

        $this->display();
    }
    /* wk  处理币转编码
    操作数据库
    CREATE TABLE IF NOT EXISTS `jk_changelist` (
    `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
    `uid` int(8) unsigned NOT NULL COMMENT 'id',
    `bid` int(8) unsigned NOT NULL COMMENT '使用者id',
    `service` decimal(12,8) NOT NULL DEFAULT '0.00000000' COMMENT '手续费',
    `money` decimal(12,8) NOT NULL DEFAULT '0.00000000' COMMENT '价值',
    `kymoney` decimal(12,8) NOT NULL DEFAULT '0.00000000' COMMENT '需要扣除的 初始金额',
    `addtime` varchar(16) NOT NULL COMMENT '添加时间',
    `bs` varchar(64) NOT NULL COMMENT '标示',
    PRIMARY KEY (`id`),
    UNIQUE KEY `id` (`id`),
    KEY `id_2` (`id`),
    KEY `id_3` (`id`)
    ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;
     */
    public function edit_change()
    {
        $settings = include dirname(APP_PATH) . '/User/Home/Conf/settings.php';

        if ($settings['wallet_open'] != 1) {
            $url = 'http://' . $_SERVER['HTTP_HOST'] . u('index.php/Home/info/change');
            die("<script>alert('当前功能已关闭');history.back(-2);window.location.href='" . $url . "';</script>");

        }
        $oob     = M('user')->where(array('UE_account' => $_SESSION['uname']))->find();
        $kymoney = $oob['ue_money'];
        $kymoney = intval($kymoney);

        $data = I('post.');
        $lkb  = intval($data['lkb']);
        // $lkb = trim($data['lkb']);
        /* 验证金额  */
        if ($lkb <= 0) {
            $url = 'http://' . $_SERVER['HTTP_HOST'] . u('index.php/Home/info/change');
            die("<script>alert('提交金额有误');history.back(-2);window.location.href='" . $url . "';</script>");

        }
        // elseif($lkb > $kymoney){
        elseif ($lkb > 1000) {
            $url = 'http://' . $_SERVER['HTTP_HOST'] . u('index.php/Home/info/change');
            // die("<script>alert('您没有那么多的币');history.back(-2);window.location.href='". $url ."';</script>");
            die("<script>alert('每次仅能转换1枚币');history.back(-2);window.location.href='" . $url . "';</script>");

        }
        //mp($kymoney);die;
        if ($lkb > $kymoney) {
            $url = 'http://' . $_SERVER['HTTP_HOST'] . u('index.php/Home/info/change');
            die("<script>alert('您没有那么多的币');history.back(-2);window.location.href='" . $url . "';</script>");

        }
        /* 如果有比例 就计算比例后的 */
        $wallet_service = 0;
        if ($settings['wallet_service'] > 0) {
            $wallet_service = $lkb * ($settings['wallet_service'] / 100);
        }

        /* 验证金额  */
        $datas = array();

        $datas['service'] = $wallet_service; /* 手续费 */
        $datas['uid']     = $oob['ue_id']; /* 用户ID */
        if ($kymoney > ($wallet_service + $lkb)) {
            $datas['money']   = $lkb; /* 价值             */
            $datas['kymoney'] = $wallet_service + $lkb; /* 需要扣除的 初始金额 */
        } else {
            $datas['money']   = $kymoney - $wallet_service; /* 价值 */
            $datas['kymoney'] = $lkb; /* 需要扣除的 初始金额 */
        }
        $datas['addtime'] = time(); /* 添加时间 */

        $datas['bs'] = md5($oob['ue_id'] . time()); /* 标示 */
        M('changelist')->add($datas);
        M('user')->where(array('UE_account' => $_SESSION['uname']))->setDec('UE_money', $datas['kymoney']);
        // $csdec =M('user')->where(array('UE_account'=>$_SESSION['uname']))->setInc('djmoney',$totalprice);

        $url = 'http://' . $_SERVER['HTTP_HOST'] . u('index.php/Home/info/change');
        die("<script>alert('操作成功');history.back(-2);window.location.href='" . $url . "';</script>");
    }

    public function enmyziliao()
    {
        $user  = M('user')->where(array('UE_account' => $_SESSION['uname']))->select();
        $users = M('user')->where(array('UE_account' => $_SESSION['uname']))->find();
        if ($users['phone'] == "") {
            $yzm = 1;
        } else {
            $yzm = 2;
        }
        //$result = M('user')->where(array())->find();
        $this->assign('yzm', $yzm);
        //$result = M('user')->where(array())->find();
        $this->assign('list', $user);
        $this->display();
    }

    public function mmgl()
    {
        //dump($_POST);die();
        $result = M('user')->where(array('UE_account' => $_SESSION['uname']))->find();
        $pass   = md5($_POST['password']);
        $pass1  = md5($_POST['password1']);
        $pass2  = md5($_POST['password2']);
        if ($pass1 != $pass2) {
            die("<script>alert('两次密码输入不一致');history.back(-1);</script>");
        }
        if ($pass != $result['ue_password']) {
            die("<script>alert('原密码输入有误');history.back(-1);</script>");
        } else {
            $results = M('user')->where(array('UE_account' => $_SESSION['uname']))->data(array('UE_password' => $pass1))->save();

        }
        if ($results) {
            die("<script>alert('密码修改成功');history.back(-1);</script>");
        }

    }

    public function enmmgl()
    {
        //dump($_POST);die();
        $result = M('user')->where(array('UE_account' => $_SESSION['uname']))->find();
        $pass   = md5($_POST['password']);
        $pass1  = md5($_POST['password1']);
        $pass2  = md5($_POST['password2']);
        if ($pass1 != $pass2) {
            die("<script>alert('Two password input inconsistent ');history.back(-1);</script>");
        }
        if ($pass != $result['ue_password']) {
            die("<script>alert('The original security password input error ');history.back(-1);</script>");
        } else {
            $results = M('user')->where(array('UE_account' => $_SESSION['uname']))->data(array('UE_password' => $pass1))->save();

        }
        if ($results) {
            die("<script>alert('Password modification success ');history.back(-1);</script>");
        }

    }

    public function mmgl1()
    {
        //dump($_POST);die();
        $result = M('user')->where(array('UE_account' => $_SESSION['uname']))->find();
        $pass   = md5($_POST['password']);
        $pass1  = md5($_POST['password1']);
        $pass2  = md5($_POST['password2']);
        if ($pass1 != $pass2) {
            die("<script>alert('两次密码输入不一致');history.back(-1);</script>");
        }
        if ($pass != $result['ue_secpwd']) {
            die("<script>alert('原安全密码输入有误');history.back(-1);</script>");
        } else {
            $results = M('user')->where(array('UE_account' => $_SESSION['uname']))->data(array('UE_secpwd' => $pass1))->save();

        }
        if ($results) {
            die("<script>alert('安全密码修改成功');history.back(-1);</script>");
        }

    }
    public function enmmgl1()
    {
        //dump($_POST);die();
        $result = M('user')->where(array('UE_account' => $_SESSION['uname']))->find();
        $pass   = md5($_POST['password']);
        $pass1  = md5($_POST['password1']);
        $pass2  = md5($_POST['password2']);
        if ($pass1 != $pass2) {
            die("<script>alert('Two password input inconsistent');history.back(-1);</script>");
        }
        if ($pass != $result['ue_secpwd']) {
            die("<script>alert('The original security password input error ');history.back(-1);</script>");
        } else {
            $results = M('user')->where(array('UE_account' => $_SESSION['uname']))->data(array('UE_secpwd' => $pass1))->save();

        }
        if ($results) {
            die("<script>alert('Password modification success');history.back(-1);</script>");
        }

    }
    public function myziliao1()
    {

        $src                = '';
        $upload             = new \Think\Upload(); // 实例化上传类
        $upload->maxSize    = 8388608; // 设置附件上传大小
        $upload->exts       = array('jpg', 'gif', 'png', 'jpeg'); // 设置附件上传类型
        $upload->rootPath   = './Uploads/'; // 设置附件上传根目录
        $upload->savePath   = ''; // 设置附件上传（子）目录或者date
        $upload->dateFormat = 'Ym'; //子目录方式为date的时候指定日期格式
        //完整的头像路径
        $path             = './avatar/';
        $upload->savePath = $path;

        // 上传文件
        $info = $upload->upload();
        $src  = 'http://' . $_SERVER['HTTP_HOST'] . '/' . substr_replace($info['0']['savepath'], 'Uploads/', 0, 2) . $info['0']['savename'];

        echo $src;
    }
    public function zlxg()
    {
        //dump($_POST);die();
        $sj = M('user')->where(array('UE_account' => $_SESSION['uname']))->find();
        //$this->success($sj['zfb']);
        $time = time();

        $phone   = I('post.phone');
        $code    = I('post.code');
        $zfb     = I('post.zfbb');
        $weixin  = I('post.weixin');
        $zhxm    = I('post.zhxm');
        $yhmc    = I('post.yhmc');
        $banknum = $_POST['banknum'];

        $re = M('smscode')->where(array('mobile' => $phone, 'regcode' => $code))->find();
        //if($sj['phone']==""){
        //dump($re);die();
        /*if ($re['edittime'] > time()) {
        if ($re['regcode']!=I ( 'post.code' )) {

        //die("<script>alert('手机验证码不正确');history.back(-1);</script>");
        $this->success('手机验证码不正确');

        }
        }else {
        $this->success('手机验证码已过期');
        //die("<script>alert('手机验证码已过期');history.back(-1);</script>");
        }*/
        //}

        $zfbpd = M('user')->where(array('zfb' => $zfb))->count();

        $wxpd   = M('user')->where(array('weixin' => $weixin))->count();
        $bankpd = M('user')->where(array('yhzh' => $banknum))->count();

        $mopd = M('user')->where(array('phone' => $phone))->count();
        //$this->success($wxpd);
        if ($sj['zfb'] == "") {
            //$this->success('11111111');
            if ($zfbpd > 0) {
                $this->success('该支付宝帐户已经存在');
            }
        } else {
            if ($zfbpd > 1) {
                $this->success('该支付宝帐户已经存在');
            }
        }
        if ($sj['weixin'] == "") {
            if ($wxpd > 0) {
                $this->success('该微信号已经存在');
            }
        } else {
            if ($wxpd > 1) {
                $this->success('该微信号已经存在');
            }
        }
        if ($sj['yhzh'] == "") {
            if ($bankpd > 0) {
                $this->success('该银行帐户已经存在');
            }
        } else {
            if ($bankpd > 1) {
                $this->success('该银行帐户已经存在');
            }
        }
        /* if($zfbpd>0){
        $this->success('该支付宝帐户已经存在');
        } */
        /* if($wxpd>0){
        $this->success('该微信号已经存在');
        }
        if($bankpd>0){
        $this->success('该银行帐户已经存在');
        } */
        if ($sj['phone'] == "") {
            if ($mopd > 0) {
                $this->success('该手机号已经存在');
            }
        }

        /* if($zfbpd){
        $zfb = M('user')->where(array(''=>$_POST['zfbb']))->find();
        if($zfb){
        $this->success('该支付宝帐户已经存在');
        //die("<script>alert('该支付宝帐户已经存在');history.back(-1);</script>");
        }
        }
        if($pdtj['weixin']==""){
        $weixin = M('user')->where(array('weixin'=>$_POST['weixin']))->find();
        if($weixin){
        $this->success('该微信号已经存在');
        //die("<script>alert('该微信号已经存在');history.back(-1);</script>");
        }
        } */
        /* if($pdtj['btcaddress']==""){
        $btcaddress = M('user')->where(array('btcaddress'=>$_POST['btc']))->find();
        if($btcaddress){
        die("<script>alert('该比特币地址已经存在');history.back(-1);</script>");
        }
        } */

        //dump($_POST);die();
        $resul = M('country')->where(array('abbr' => $_POST['guoji']))->find();

        $map['UE_truename'] = $_POST['nickname'];

        if ($_POST['phone'] != "") {
            $map['phone'] = $_POST['phone'];
        }

        $map['idcard'] = $_POST['idcard'];
        //dump($_POST);die();
        if ($_POST['yhmc'] != "" && $_POST['zfbb'] != "" && $_POST['weixin'] != "" && $_POST['banknum'] != "" && $_POST['zhxm'] != "") {

            $map['zfb']    = $_POST['zfbb'];
            $map['weixin'] = $_POST['weixin'];
            $map['yhmc']   = $_POST['yhmc'];
            $map['yhzh']   = $_POST['banknum'];
            $map['zhxm']   = $_POST['zhxm'];
        }

        $map['UE_truename'] = $_POST['nickname'];
        if ($resul) {
            $map['area'] = $resul['cninfo'];
        }

        $map['btcaddress'] = $_POST['btc'];
        $map['mxtime']     = time();
        $map['xgcs']       = 1;
        // $map['jh'] = 2;

        /*  wk
        ALTER TABLE `jk_user` ADD `tx_img` VARCHAR( 2560 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'touxiang'
        ALTER TABLE `jk_user` ADD `jh` INT( 2 ) UNSIGNED NOT NULL DEFAULT '1'
        ALTER TABLE `jk_user` CHANGE `tx_img` `tx_img` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'touxiang'
        ALTER TABLE `jk_user` CHANGE `UE_sfz` `UE_sfz` LONGTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '生分证'
         */
        $tx_img = I('post.tx_img');
        if ($tx_img) {
            $map['UE_sfz'] = $tx_img;

        }

        if (
            empty($map['UE_truename']) ||
            empty($map['area']) ||

            empty($map['zhxm']) ||
            empty($map['idcard']) ||
            empty($map['yhmc']) ||
            empty($map['yhzh']) ||
            empty($map['zfb']) ||
            empty($map['weixin']) ||
            empty($map['UE_sfz'])

        ) {
            $this->success('请填写完所有的信息在进行提交');
        }

        /* wk */

        $result = M('user')->where(array('UE_account' => $_SESSION['uname']))->save($map);
        if ($result) {

            /* wk 增加矿机 ID 210 */
            /*$id = 210;
            $project=M('shop_project')->where(array('id'=>$id))->find();
            $price=$project['price'];
            $orderform = M('shop_orderform');
            $map['user'] = session('uname');
            $map['project']=$project['name'];
            $map['enproject']=$project['enname'];
            $map['yxzq'] = $project['yxzq'];
            $map['sumprice'] = $price;
            $map['addtime'] = date('Y-m-d H:i:s');
            $map['username']=$result['ue_truename'];
            $map['imagepath'] =$project['imagepath'];
            $map['lixi']    = $project['fjed'];
            $map['qwsl'] = $project['qwsl'];
            $map['kjsl'] = $project['kjsl'];
            $map['kjbh'] = $orderSn;
            $orderform->add($map);
            M('user')->where(array('UE_account'=>$_SESSION['uname']))->data(array('mfkj'=>2))->save();*/
            /* wk 增加矿机 ID 210 */

            $this->success('已提交成功,等待审核');
        }
    }

    public function enzlxg()
    {
        $sj   = M('user')->where(array('UE_account' => $_SESSION['uname']))->find();
        $time = time();
        if (($time - $sj['mxtime']) / 3600 < 24) {
            die("<script>alert('Only once in 24 hours');history.back(-1);</script>");
        }
        $phone = I('post.phone');
        $code  = I('post.code');
        $re    = M('smscode')->where(array('mobile' => $phone, 'regcode' => $code))->find();
        /* if ($re['edittime'] > time()) {
        if (!$re['regcode']==I ( 'post.code' )) {

        die("<script>alert('手机验证码不正确');history.back(-1);</script>");

        }
        }else {
        die("<script>alert('手机验证码已过期');history.back(-1);</script>");
        } */
        //dump($_POST);die();
        $resul = M('country')->where(array('abbr' => $_POST['guoji']))->find();

        $map['UE_truename'] = $_POST['nickname'];
        $map['yhmc']        = $_POST['yhmc'];
        $map['yhzh']        = $_POST['banknum'];
        $map['zhxm']        = $_POST['zhxm'];
        $map['phone']       = $_POST['phone'];
        $map['idcard']      = $_POST['idcard'];
        $map['zfb']         = $_POST['zfbb'];
        $map['weixin']      = $_POST['weixin'];
        $map['UE_truename'] = $_POST['nickname'];
        $map['area']        = $resul['cninfo'];
        $map['btcaddress']  = $_POST['btc'];
        $map['mxtime']      = time();
        $result             = M('user')->where(array('UE_account' => $_SESSION['uname']))->save($map);
        if ($result) {
            die("<script>alert('Successful modification');window.location.href='/index.php/Home/Index/enindex/';</script>");
        }
    }

    public function tgsy()
    {
        $result             = M('userget');
        $a                  = 'tdj';
        $b                  = 'jlj';
        $map['UG_dataType'] = array(array('eq', $a), array('eq', $b), 'or');
        $map['UG_account']  = session('uname');
        $oob                = $result->where($map)->order("UG_ID DESC")->select();
        $this->assign('list', $oob);
        $this->display();
    }
    public function entgsy()
    {
        $result             = M('userget');
        $a                  = 'tdj';
        $b                  = 'jlj';
        $map['UG_dataType'] = array(array('eq', $a), array('eq', $b), 'or');
        $map['UG_account']  = session('uname');
        $oob                = $result->where($map)->order("UG_ID DESC")->select();
        $this->assign('list', $oob);
        $this->display();
    }
    public function gettime()
    {

        $gname           = $_SESSION['uname'];
        $map1['_string'] = "(p_user = '$gname' or g_user = '$gname')";
        $map1['zt']      = 1;
        $grxx            = M('ppdd')->where($map1)->find();
        $time            = strtotime($grxx['jydate']);
        $time            = 12 * 60 * 60 + $time;
        $this->ajaxReturn($time);
    }
    public function myjiaoyi()
    {
        $result = M('ppdd')->where(array('p_user' => session('uname'), 'zt' => 0, 'datatype' => 'qglkb'))->select();
        $cslb   = M('ppdd')->where(array('p_user' => session('uname'), 'zt' => 0, 'datatype' => 'cslkb'))->select();
        //$map1['uname'] =$_SESSION['name'];
        $map1['zt'] = 1;
        $gname      = $_SESSION['uname'];
        //dump($gname);die();
        $map1['_string'] = "(p_user = '$gname' or g_user = '$gname')";
        $results         = M('ppdd')->where($map1)->select();
        //dump($results);die();
        //dump($results);die();
        //查看个人交易信息
        $grxx     = M('ppdd')->where($map1)->find();
        $datatype = $grxx['datatype'];
        //$imagpath=M('ppdd')->where(array('p_user'=>'$gname'))->order('id desc')->find();
        //dump($imagpath);die();
        if ($grxx['imagepath']) {
            $tp = 1;
        } else {
            $tp = 2;
        }
        if (empty($results)) {
            $ts = 1;
        }
        //$map['uname']=$_SESSION['uname'];
        $map['zt']      = 2;
        $map['_string'] = "(p_user = '$gname' or g_user = '$gname')";
        $obs            = M('ppdd')->where($map)->order('jydate desc')->select();

        // dump($obs);die();
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
    public function enmyjiaoyi()
    {

        $result = M('ppdd')->where(array('p_user' => session('uname'), 'zt' => 0, 'datatype' => 'qglkb'))->select();

        $cslb = M('ppdd')->where(array('p_user' => session('uname'), 'zt' => 0, 'datatype' => 'cslkb'))->select();

        //$map1['uname'] =$_SESSION['name'];
        $map1['zt'] = 1;
        $gname      = $_SESSION['uname'];

        //dump($gname);die();

        $map1['_string'] = "(p_user = '$gname' or g_user = '$gname')";

        $results = M('ppdd')->where($map1)->select();
        //dump($results);die();
        //dump($results);die();

        //查看个人交易信息
        $grxx     = M('ppdd')->where($map1)->find();
        $datatype = $grxx['datatype'];

        $imagpath = M('ppdd')->where(array('p_user' => '$gname'))->order('id desc')->find();
        //dump($imagpath);die();
        if ($imagpath['imagepath']) {
            $tp = 1;
        } else {
            $tp = 2;
        }
        if (empty($results)) {
            $ts = 1;
        }

        //$map['uname']=$_SESSION['uname'];
        $map['zt']      = 2;
        $map['_string'] = "(p_user = '$gname' or g_user = '$gname')";
        $obs            = M('ppdd')->where($map)->order('jydate desc')->select();

        // dump($obs);die();
        $this->assign('datatype', $datatype);

        $this->assign('cslkb', $cslb);
        $this->assign('tp', $tp);
        $this->assign('ts', $ts);
        $this->assign('oob', $obs);
        $this->assign('lists', $results);
        $this->assign('list', $result);
        $this->display();
    }
    public function enmyjiaoyi1()
    {

        $result          = M('ppdd')->where(array('p_user' => session('uname'), 'zt' => 0, 'datatype' => 'qglkb'))->select();
        $cslb            = M('ppdd')->where(array('p_user' => session('uname'), 'zt' => 0, 'datatype' => 'cslkb'))->select();
        $map1['uname']   = $_SESSION['name'];
        $map1['zt']      = 1;
        $map1['_string'] = "(p_user = {$_SESSION['uname']} or g_user = {$_SESSION['uname']})";
        $results         = M('ppdd')->where($map1)->select();
        //dump($results);die();

        //查看个人交易信息
        $grxx     = M('ppdd')->where($map1)->find();
        $datatype = $grxx['datatype'];

        $imagpath = M('ppdd')->where(array('p_user' => $_SESSION['uname']))->order('id desc')->find();
        //dump($imagpath);die();
        if ($imagpath['imagepath']) {
            $tp = 1;
        } else {
            $tp = 2;
        }
        if (empty($results)) {
            $ts = 1;
        }

        $map['uname']   = $_SESSION['uname'];
        $map['zt']      = 2;
        $map['_string'] = "(p_user = {$_SESSION['uname']} or g_user = {$_SESSION['uname']})";
        $obs            = M('ppdd')->where($map)->order('jydate desc')->select();

        // dump($obs);die();
        $this->assign('datatype', $datatype);

        $this->assign('cslkb', $cslb);
        $this->assign('tp', $tp);
        $this->assign('ts', $ts);
        $this->assign('oob', $obs);
        $this->assign('lists', $results);
        $this->assign('list', $result);
        $this->display();
    }

    public function qrcode()
    {
        header("Content-type: text/html; charset=utf-8");
        $url = 'http://' . $_SERVER['HTTP_HOST'] . u('index.php/Home/User/reg', array('uid' => session('uid')));

        Vendor('phpqrcode.phpqrcode');
        //生成二维码图片
        $object               = new \QRcode();
        $url                  = '$url'; //网址或者是文本内容
        $level                = 3;
        $size                 = 10;
        $errorCorrectionLevel = intval($level); //容错级别
        $matrixPointSize      = intval($size); //生成图片大小

        QRcode::png($data, false, $level, $size);
        //$object->png($url, false, $errorCorrectionLevel, $matrixPointSize, 2);

    }
    public function tuiguangma()
    {
        header("Content-type: text/html; charset=utf-8");
        $url = 'http://' . $_SERVER['HTTP_HOST'] . u('index.php/Home/User/reg', array('uid' => session('uid')));
        Vendor('phpqrcode.phpqrcode');
        //生成二维码图片
        $object               = new \QRcode();
        $url                  = $url; //网址或者是文本内容
        $level                = 3;
        $size                 = 7;
        $errorCorrectionLevel = intval($level); //容错级别
        $matrixPointSize      = intval($size); //生成图片大小

        $path = "images/";
        // 生成的文件名
        $fileName = $path . $_SESSION['uname'] . '.png';

        $object->png($url, $fileName, $errorCorrectionLevel, $matrixPointSize, 2);

        /* $img = new \Think\Image();
        define('THINKIMAGE_WATER_CENTER', 5);
        $img->open('./card.jpg')->water($fileName, array(150,538))->text($name,'./hei.ttf','20','#d53917', array(-255,-970))->save($fileName);

         */

        $this->assign('url', $url);

        $this->display();

    }
    public function entuiguangma()
    {
        header("Content-type: text/html; charset=utf-8");
        $url = 'http://' . $_SERVER['HTTP_HOST'] . u('index.php/Home/User/enreg', array('uid' => session('uid')));
        Vendor('phpqrcode.phpqrcode');
        //生成二维码图片
        $object               = new \QRcode();
        $url                  = $url; //网址或者是文本内容
        $level                = 3;
        $size                 = 6;
        $errorCorrectionLevel = intval($level); //容错级别
        $matrixPointSize      = intval($size); //生成图片大小

        $path = "images/";
        // 生成的文件名
        $fileName = $path . $_SESSION['uname'] . '.png';

        $object->png($url, $fileName, $errorCorrectionLevel, $matrixPointSize, 2);

        $img = new \Think\Image();
        define('THINKIMAGE_WATER_CENTER', 5);
        $img->open('./encard.jpg')->water($fileName, array(150, 538))->text($name, './hei.ttf', '20', '#d53917', array(-255, -970))->save($fileName);

        $this->assign('url', $url);

        $this->display();

    }
    public function encslkb()
    {
        $settings         = include dirname(APP_PATH) . '/User/Home/Conf/settings.php';
        $price            = $_POST['price'];
        $lkb              = $_POST['lkb'];
        $zdjy             = $_POST['zdjy'];
        $a                = strlen($price);
        $zd               = M('user')->where(array('UE_account' => $zdjy))->find();
        $zdname           = $zdjy;
        $c                = 1;
        $d                = 0;
        $map1s['zt']      = array(array('eq', $c), array('eq', $d), 'or');
        $map1s['_string'] = "(p_user = '$zdname' or g_user = '$zdname')";
        $zdzt             = M('ppdd')->where($map1s)->find();
        $zdtj             = M('user')->where(array('UE_account' => $_SESSION['uname']))->find();
        if ($zdtj['level'] > 1) {
            if ($zdjy != "") {
                if (!$zd) {
                    die("<script>alert('Designated trader does not exist');history.back(-1);</script>");
                }
                if ($zdzt) {
                    die("<script>alert('Designated trader has an order not yet completed');history.back(-1);</script>");
                }
            }

        }
        if ($a > 4) {
            die("<script>alert('Please enter the correct price');history.back(-1);</script>");
        }
        if ($lkb < 1) {
            die("<script>alert('Please enter the correct number of transactions');history.back(-1);</script>");
        }
        if ($price < $settings['min_danjia'] || $price > $settings['max_danjia']) {
            die("<script>alert('Lowest transaction price：" . $settings['min_danjia'] . "USD，Highest：" . $settings['max_danjia'] . "USD');history.back(-1);</script>");
        }
        $totalprice = $lkb + $lkb * $settings['jiaoyi_shouxu'];
        $info       = M('user')->where(array('UE_account' => $_SESSION['uname']))->find();
        if ($totalprice > $info['ue_money']) {
            die("<script>alert('Your balance is not enough.');history.back(-1);</script>");
        }
        $user  = M('user')->where(array('UE_account' => $_SESSION['uname']))->find();
        $gname = $_SESSION['uname'];

        //dump($gname);die();

        //$map1['_string']="(p_user = '$gname' or g_user = '$gname')";
        $a               = 1;
        $b               = 0;
        $maps['zt']      = array(array('eq', $a), array('eq', $b), 'or');
        $maps['_string'] = "(p_user = '$gname' or g_user = '$gname')";
        $pd              = M('ppdd')->where($maps)->find();
        if ($pd) {
            die("<script>alert('You still have an order for the completed transaction');history.back(-1);</script>");
        }

        if ($user['idcard'] == "" || $user['weixin'] == "") {
            die("<script>alert('Prior to the transaction, please go to personal data to improve personal information');window.location.href='/index.php/Home/info/enmyziliao/';</script>");
        }
        if ($user['ue_money'] < $lkb) {
            die("<script>alert('The sale of GEC cannot be greater than your balance');history.back(-1);</script>");
        }
        if ($lkb == '' || $lkb <= 0) {
            die("<script>alert('Please enter the correct number of GEC');history.back(-1);</script>");
        }
        if ($price == '' || $price <= 0) {
            die("<script>alert('Please enter the correct transaction price');history.back(-1);</script>");
        }
        $dajia           = $price / $lkb;
        $map['p_id']     = $user['ue_id'];
        $map['p_user']   = $user['ue_account'];
        $map['jb']       = $price * $lkb;
        $map['lkb']      = $lkb;
        $map['date']     = date('Y-m-d H:i:s');
        $map['p_name']   = $user['ue_truename'];
        $map['p_level']  = $user['level'];
        $map['danjia']   = $price;
        $map['datatype'] = 'cslkb';
        $sail            = M('ppdd')->where(array('p_user' => $_SESSION['uname']))->data(array('p_level' => $user['level']))->save();
        $result          = M('ppdd');
        $chushou         = M('user')->where(array('UE_account' => $_SESSION['uname']))->setDec('UE_money', $totalprice);
        $csdec           = M('user')->where(array('UE_account' => $_SESSION['uname']))->setInc('djmoney', $totalprice);
        $oob             = $result->add($map);
        if ($csdec) {
            if ($zdname != "") {
                $zdxx = M('user')->where(array('UE_account' => $zdname))->find();
                $re   = M('ppdd')->where(array('id' => $oob))->data(array('zt' => 1, 'jydate' => date('Y-m-d H:i:s', time()), 'g_name' => $zdxx['ue_truename'], 'g_user' => $zdxx['ue_account'], 'g_level' => $user['level'], 'g_id' => $user['ue_id']))->save();
            }
            die("<script>alert('Order has been successfully sent to the trading hall');window.location.href='/index.php/Home/Info/enindex/';</script>");
        }

    }
    public function lianxius()
    {

        if (IS_POST) {
            $data_P = I('post.');
            //dump($data_P);die;
            //$this->ajaxReturn($data_P['ymm']);die;
            //$user = M ( 'user' )->where ( array (
            //        UE_account => $_SESSION ['uname']
            //) )->find ();

            $user1 = M();
            //! $this->check_verify ( I ( 'post.yzm' ) )
            //! $user1->autoCheckToken ( $_POST )
            if (strlen($data_P['lynr']) < 1) {
                die("<script>alert('留言內容不能为空！');history.back(-1);</script>");

            } else {

                $record['MA_type']      = 'message';
                $record['MA_userName']  = $_SESSION['uname'];
                $record['pic']          = $data_P['face180'];
                $record['MA_otherInfo'] = $data_P['otlylx'];
                $record['MA_theme']     = $data_P['lybt'];
                $record['MA_note']      = $data_P['lynr'];
                $record['MA_time']      = date('Y-m-d H:i:s', time());

                $reg = M('message')->add($record);

                if ($reg) {
                    die("<script>alert('留言成功！');history.back(-1);</script>");

                } else {
                    die("<script>alert('留言失败！');history.back(-1);</script>");

                }

            }
        }
        $User = M('message'); // 實例化User對象
        //$suser = I ( 'post.user', '', '/^[a-zA-Z0-9]{6,12}$/' );

        $map['MA_userName'] = $_SESSION['uname'];

        $count = $User->where($map)->count(); // 查詢滿足要求的總記錄數
        //dump($var)
        $page = new \Think\Page($count, 12); // 實例化分頁類 傳入總記錄數和每頁顯示的記錄數(25)

        // $page->lastSuffix=false;
        $page->setConfig('header', '<li class="rows">共<b>%TOTAL_ROW%</b>條記錄    第<b>%NOW_PAGE%</b>頁/共<b>%TOTAL_PAGE%</b>頁</li>');
        $page->setConfig('prev', '上一頁');
        $page->setConfig('next', '下一頁');
        $page->setConfig('last', '末頁');
        $page->setConfig('first', '首頁');
        $page->setConfig('theme', '%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');

        $show = $page->show(); // 分頁顯示輸出
        // 進行分頁數據查詢 注意limit方法的參數要使用Page類的屬性
        $list = $User->where($map)->order('MA_ID DESC')->limit($page->firstRow . ',' . $page->listRows)->select();
        //dump($list);die;
        $this->assign('list', $list); // 賦值數據集
        $this->display();
    }
    public function enlianxius()
    {

        if (IS_POST) {
            $data_P = I('post.');
            //dump($data_P);die;
            //$this->ajaxReturn($data_P['ymm']);die;
            //$user = M ( 'user' )->where ( array (
            //        UE_account => $_SESSION ['uname']
            //) )->find ();

            $user1 = M();
            //! $this->check_verify ( I ( 'post.yzm' ) )
            //! $user1->autoCheckToken ( $_POST )
            if (strlen($data_P['lynr']) < 1) {
                die("<script>alert('Message content can not be empty ！');history.back(-1);</script>");

            } else {

                $record['MA_type']      = 'message';
                $record['MA_userName']  = $_SESSION['uname'];
                $record['pic']          = $data_P['face180'];
                $record['MA_otherInfo'] = $data_P['otlylx'];
                $record['MA_theme']     = $data_P['lybt'];
                $record['MA_note']      = $data_P['lynr'];
                $record['MA_time']      = date('Y-m-d H:i:s', time());

                $reg = M('message')->add($record);

                if ($reg) {
                    die("<script>alert('Message success ！');history.back(-1);</script>");

                } else {
                    die("<script>alert('Message failure ！');history.back(-1);</script>");

                }

            }
        }
        $User = M('message'); // 實例化User對象
        //$suser = I ( 'post.user', '', '/^[a-zA-Z0-9]{6,12}$/' );

        $map['MA_userName'] = $_SESSION['uname'];

        $count = $User->where($map)->count(); // 查詢滿足要求的總記錄數
        //dump($var)
        $page = new \Think\Page($count, 12); // 實例化分頁類 傳入總記錄數和每頁顯示的記錄數(25)

        // $page->lastSuffix=false;
        $page->setConfig('header', '<li class="rows">共<b>%TOTAL_ROW%</b>條記錄    第<b>%NOW_PAGE%</b>頁/共<b>%TOTAL_PAGE%</b>頁</li>');
        $page->setConfig('prev', '上一頁');
        $page->setConfig('next', '下一頁');
        $page->setConfig('last', '末頁');
        $page->setConfig('first', '首頁');
        $page->setConfig('theme', '%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');

        $show = $page->show(); // 分頁顯示輸出
        // 進行分頁數據查詢 注意limit方法的參數要使用Page類的屬性
        $list = $User->where($map)->order('MA_ID DESC')->limit($page->firstRow . ',' . $page->listRows)->select();
        //dump($list);die;
        $this->assign('list', $list); // 賦值數據集
        $this->display();
    }
    public function cslkb()
    {
        $settings = include dirname(APP_PATH) . '/User/Home/Conf/settings.php';
        $price    = $_POST['price'];
        $lkb      = $_POST['lkb'];
        $zdjy     = $_POST['zdjy'];
        $a        = strlen($price);
        /*$code     = $_POST['code'];
        if ($code != session('xx_code')) {
            $this->ajaxReturn(['message' => '验证码错误']);
        }*/

        /* $res['status']=2;
        $res['info']="$price";
        $this->ajaxReturn($res); */
        $zd = M('user')->where(array('UE_account' => $zdjy))->find();
        //dump($zd);die();
        $zdname           = $zdjy;
        $c                = 1;
        $d                = 0;
        $map1s['zt']      = array(array('eq', $c), array('eq', $d), 'or');
        $map1s['_string'] = "(p_user = '$zdname' or g_user = '$zdname')";
        $zdzt             = M('ppdd')->where($map1s)->find();
        $zdtj             = M('user')->where(array('UE_account' => $_SESSION['uname']))->find();
        if ($zdtj['level'] > 1) {
            if ($zdjy != "") {
                if (!$zd) {
                    $respond['status'] = 2;
                    $respond['info']   = "指定交易人不存在";
                    $this->ajaxReturn($respond);
                    //die("<script>alert('指定交易人不存在');history.back(-1);</script>");
                }
                if ($zdzt) {
                    $wwc['status'] = 2;
                    $wwc['info']   = "指定交易人有尚未完成的订单";
                    $this->ajaxReturn($wwc);
                    //die("<script>alert('指定交易人有尚未完成的订单');history.back(-1);</script>");
                }
            }

        }

        if ($a > 4) {
            $price['status'] = 2;
            $price['info']   = "请输入正确的价格";
            $this->ajaxReturn($price);
            //die("<script>alert('请输入正确的价格');history.back(-1);</script>");
        }
        $jiao = M('config')->find(4);
        if ($lkb < 1 || $lkb < $jiao['config_value']) {
            $jysl['status'] = 2;
            $jysl['info']   = "请输入正确的交易数量";
            $this->ajaxReturn($jysl);
            //die("<script>alert('请输入正确的交易数量');history.back(-1);</script>");
        }
        $totalprice = $lkb + $lkb * $settings['jiaoyi_shouxu'];
        //dump($totalprice);die;
        $info = M('user')->where(array('UE_account' => $_SESSION['uname']))->find();
        if ($totalprice > $info['ue_money']) {
            $ye['status'] = 2;
            $ye['info']   = "您的余额不足";
            $this->ajaxReturn($ye);
            //die("<script>alert('您的余额不足');history.back(-1);</script>");
        }
        if ($price < $settings['min_danjia'] || $price > $settings['max_danjia']) {
            die("<script>alert('交易单价最低：" . $settings['min_danjia'] . "美元，最高：" . $settings['max_danjia'] . "美元');history.back(-1);</script>");
        }
        $user = M('user')->where(array('UE_account' => $_SESSION['uname']))->find();

        $gname = $_SESSION['uname'];

        //dump($gname);die();

        //$map1['_string']="(p_user = '$gname' or g_user = '$gname')";

        $a               = 1;
        $b               = 0;
        $maps['zt']      = array(array('eq', $a), array('eq', $b), 'or');
        $maps['_string'] = "(p_user = '$gname' or g_user = '$gname')";
        $pd              = M('ppdd')->where($maps)->find();
        if ($pd) {
            $jydd['status'] = 2;
            $jydd['info']   = "您还有未完成交易的订单";
            $this->ajaxReturn($jydd);
            //die("<script>alert('您还有未完成交易的订单');history.back(-1);</script>");
        }

        /*if ($user['yhmc'] == "" || $user['weixin'] == "" || $user['phone'] == "") {
            $grxx['status'] = 2;
            $grxx['info']   = "交易前请先到个人资料完善个人信息";
            $this->ajaxReturn($grxx);
            //die("<script>alert('交易前请先到个人资料完善个人信息');window.location.href='/index.php/Home/info/myziliao/';</script>");
        }*/
        if ($user['ue_money'] < $totalprice) {
            $res['status'] = 2;
            $res['info']   = "出售的GEC不能大于您的余额";
            $this->ajaxReturn($res);
            //die("<script>alert('出售的GEC不能大于您的余额');history.back(-1);</script>");
        }
        if ($lkb == '' || $lkb <= 0) {
            $ree['status'] = 2;
            $ree['info']   = "请输入正确的GEC数量";
            $this->ajaxReturn($ree);
            //die("<script>alert('请输入正确的GEC数量');history.back(-1);</script>");
        }
        if ($price == '' || $price <= 0) {
            $rs['status'] = 2;
            $rs['info']   = "请输入正确的交易价格";
            $this->ajaxReturn($rs);
            //die("<script>alert('请输入正确的交易价格');history.back(-1);</script>");
        }

        $dajia           = $price / $lkb;
        $map['p_id']     = $user['ue_id'];
        $map['p_user']   = $user['ue_account'];
        $map['jb']       = $price * $lkb;
        $map['lkb']      = $lkb;
        $map['date']     = date('Y-m-d H:i:s');
        $map['p_name']   = $user['ue_truename'];
        $map['p_level']  = $user['level'];
        $map['danjia']   = $price;
        $map['datatype'] = 'cslkb';
        $map['zdjyr']    = $zdjy;
        $sail            = M('ppdd')->where(array('p_user' => $_SESSION['uname']))->data(array('p_level' => $user['ue_level']))->save();
        $result          = M('ppdd');
        $chushou         = M('user')->where(array('UE_account' => $_SESSION['uname']))->setDec('UE_money', $totalprice);
        $csdec           = M('user')->where(array('UE_account' => $_SESSION['uname']))->setInc('djmoney', $totalprice);
        $oob             = $result->add($map);
        if ($csdec) {
            if ($zdname != "") {
                $zdxx = M('user')->where(array('UE_account' => $zdname))->find();
                $re   = M('ppdd')->where(array('id' => $oob))->data(array('zt' => 1, 'jydate' => date('Y-m-d H:i:s', time()), 'g_name' => $zdxx['ue_truename'], 'g_user' => $zdxx['ue_account'], 'g_level' => $user['level'], 'g_id' => $user['ue_id']))->save();
            }
            $responds['status'] = 1;
            $responds['info']   = "订单已成功发送至交易大厅";
            $this->ajaxReturn($responds);
            ///die("<script>alert('订单已成功发送至交易大厅');window.location.href='/index.php/Home/Info/index/';</script>");
        }

    }
    public function enmyjiaoyis()
    {
        $settings = include dirname(APP_PATH) . '/User/Home/Conf/settings.php';
        $price    = $_POST['price'];
        $lkb      = $_POST['lkb'];
        $zdjy     = $_POST['zdjy'];
        $a        = strlen($price);

        if ($a > 4) {
            die("<script>alert('Please enter the correct price');history.back(-1);</script>");
        }
        if ($lkb < 1) {
            die("<script>alert('Please enter the correct number of transactions');history.back(-1);</script>");
        }
        if ($price < $settings['min_danjia'] || $price > $settings['max_danjia']) {
            die("<script>alert('Lowest transaction price：" . $settings['min_danjia'] . "USD，Highest：" . $settings['max_danjia'] . "USD');history.back(-1);</script>");
        }
        $user = M('user')->where(array('UE_account' => $_SESSION['uname']))->find();

        $gname = $_SESSION['uname'];

        //dump($gname);die();

        //$map1['_string']="(p_user = '$gname' or g_user = '$gname')";

        $a               = 1;
        $b               = 0;
        $maps['zt']      = array(array('eq', $a), array('eq', $b), 'or');
        $maps['_string'] = "(p_user = '$gname' or g_user = '$gname')";
        $pd              = M('ppdd')->where($maps)->find();
        if ($pd) {
            die("<script>alert('You still have an order for the completed transaction');history.back(-1);</script>");
        }

        if ($user['yhmc'] == "") {
            die("<script>alert('Prior to the transaction, please go to personal data to improve personal information');window.location.href='/index.php/Home/info/enmyziliao/';</script>");
        }
        if ($lkb == '' || $lkb <= 0) {
            die("<script>alert('Please enter the correct number of GEC');history.back(-1);</script>");
        }
        if ($price == '' || $price <= 0) {
            die("<script>alert('Please enter the correct transaction price');history.back(-1);</script>");
        }
        $danjia          = $price;
        $map['p_id']     = $user['ue_id'];
        $map['p_user']   = $user['ue_account'];
        $map['jb']       = $price * $lkb;
        $map['lkb']      = $lkb;
        $map['date']     = date('Y-m-d H:i:s');
        $map['p_name']   = $user['ue_truename'];
        $map['p_level']  = $user['level'];
        $map['danjia']   = $danjia;
        $map['datatype'] = 'qglkb';
        $sail            = M('ppdd')->where(array('p_user' => $_SESSION['uname']))->data(array('p_level' => $user['level']))->save();
        $result          = M('ppdd');
        $oob             = $result->add($map);
        if ($oob) {
            die("<script>alert('Order has been successfully sent to the trading hall');window.location.href='/index.php/Home/Info/enindex/';</script>");
        }
    }
    public function myjiaoyis()
    {
        $settings = include dirname(APP_PATH) . '/User/Home/Conf/settings.php';
        $price    = $_POST['price'];
        $lkb      = $_POST['lkb'];
        $zdjy     = $_POST['zdjy'];
        $a        = strlen($price);
        $jiao     = M('config')->find(4);

        /*$code = $_POST['code'];
        if ($code != session('xx_code')) {
            $this->success('请输入正确的验证码');
        }*/

        if ($a > 4) {

            $this->success('请输入正确的价格');
            //die("<script>alert('请输入正确的价格');history.back(-1);</script>");
        }
        if ($lkb < 1) {
            die("<script>alert('请输入正确的交易数量');history.back(-1);</script>");
        }
        if ($price < $settings['min_danjia'] || $price > $settings['max_danjia']) {
            /* $respond['status']=2;
            $respond['info']="交易单价最低："."$settings['min_danjia']"."美元"，"最高："."$settings['max_danjia']"."美元";
            $this->ajaxReturn($respond); */
            die("<script>alert('交易单价最低：" . $settings['min_danjia'] . "美元，最高：" . $settings['max_danjia'] . "美元');history.back(-1);</script>");

        }

        $user  = M('user')->where(array('UE_account' => $_SESSION['uname']))->find();
        $gname = $_SESSION['uname'];

        //dump($gname);die();

        //$map1['_string']="(p_user = '$gname' or g_user = '$gname')";
        $a               = 1;
        $b               = 0;
        $maps['zt']      = array(array('eq', $a), array('eq', $b), 'or');
        $maps['_string'] = "(p_user = '$gname' or g_user = '$gname')";
        $pd              = M('ppdd')->where($maps)->find();
        if ($pd) {
            $res['status'] = 2;
            $res['info']   = "您还有未完成交易的订单";
            $this->ajaxReturn($res);
            //die("<script>alert('您还有未完成交易的订单');history.back(-1);</script>");
        }
        if ($user['yhmc'] == "" || $user['phone'] == "") {
            $ree['status'] = 2;
            $ree['info']   = "交易前请先到个人资料完善个人信息";
            $this->ajaxReturn($ree);
            //die("<script>alert('交易前请先到个人资料完善个人信息');window.location.href='/index.php/Home/info/myziliao/';</script>");
        }

        if ($lkb == '' || $lkb <= 0) {
            $ge['status'] = 2;
            $ge['info']   = "请输入正确的GEC数量";
            $this->ajaxReturn($ge);
            //die("<script>alert('请输入正确的GEC数量');history.back(-1);</script>");
        }
        if ($price == '' || $price <= 0) {
            $jyjg['status'] = 2;
            $jyjg['info']   = "请输入正确的交易价格";
            //die("<script>alert('请输入正确的交易价格');history.back(-1);</script>");
            $this->ajaxReturn($jyjg);
        }
        $danjia          = $price;
        $map['p_id']     = $user['ue_id'];
        $map['p_user']   = $user['ue_account'];
        $map['jb']       = $price * $lkb;
        $map['lkb']      = $lkb;
        $map['date']     = date('Y-m-d H:i:s');
        $map['p_name']   = $user['ue_truename'];
        $map['p_level']  = $user['level'];
        $map['danjia']   = $danjia;
        $map['datatype'] = 'qglkb';
        $map['zdjyr']    = $zdjy;
        $sail            = M('ppdd')->where(array('p_user' => $_SESSION['uname']))->data(array('p_level' => $user['level']))->save();
        $result          = M('ppdd');
        $oob             = $result->add($map);
        if ($oob) {
            $responds['status'] = 1;
            $responds['info']   = '订单已成功发送至交易大厅。';
            //$this->success('订单已成功发送至交易大厅');
            //die("<script>alert('订单已成功发送至交易大厅');window.location.href='/index.php/Home/Info/index/';</script>");
            $this->ajaxReturn($responds);
        }
    }
    public function kuangcheshouyi()
    {
        $result = M('userget')->where(array('UG_account' => $_SESSION['uname'], 'UG_dataType' => wakuang))->order('UG_ID DESC')->select();
        $this->assign('list', $result);
        $this->display();

    }
    public function enkuangcheshouyi()
    {
        $result = M('userget')->where(array('UG_account' => $_SESSION['uname'], 'UG_dataType' => wakuang))->order('UG_ID DESC')->select();
        $this->assign('list', $result);
        $this->display();

    }
    public function entousu()
    {
        $data_P = $_GET['id'];
        $text   = $_GET['txt'];

        $result = M('ppdd')->where(array('id' => $data_P))->find();

        $tousu = M('tousu')->where(array('pid' => $data_P))->find(); //说明已经有一方投诉过了
        if ($tousu) {
            if ($tousu['user'] = $_SESSION['uname']) {
                $this->ajaxReturn('Do not repeat the complaint');
            }
        }

        if ($text == "") {
            $this->ajaxReturn('Complaints can not be empty');
        }
        if ($result['p_user'] == $_SESSION['uname']) {

            $map['text']  = $text; //投诉内容
            $map['user']  = $_SESSION['uname']; //投诉人；
            $map['buser'] = $result['g_user']; //被投诉人
            $map['date']  = date('Y-m-d H:i:s');
            $map['pid']   = $data_P;
            $oob          = M('tousu')->add($map);
            if ($oob) {
                $this->ajaxReturn('Complaints successful, waiting for the administrator to deal with');
            }
        }

        if ($result['g_user'] == $_SESSION['uname']) {

            $map1['text']  = $text; //投诉内容
            $map1['user']  = $_SESSION['uname']; //投诉人；
            $map1['buser'] = $result['p_user']; //被投诉人
            $map1['date']  = date('Y-m-d H:i:s');
            $map1['pid']   = $data_P;
            $oobs          = M('tousu')->add($map1);
            if ($oobs) {
                $this->ajaxReturn('Complaints successful, waiting for the administrator to deal with');
            }

        }
    }
    public function tousu()
    {
        $data_P = $_GET['id'];
        $text   = $_GET['txt'];

        $result = M('ppdd')->where(array('id' => $data_P))->find();

        $tousu = M('tousu')->where(array('pid' => $data_P))->find(); //说明已经有一方投诉过了
        if ($tousu) {
            if ($tousu['user'] = $_SESSION['uname']) {
                $this->ajaxReturn('请勿重复投诉');
            }
        }

        if ($text == "") {
            $this->ajaxReturn('投诉内容不能为空');
        }
        if ($result['p_user'] == $_SESSION['uname']) {

            $map['text']  = $text; //投诉内容
            $map['user']  = $_SESSION['uname']; //投诉人；
            $map['buser'] = $result['g_user']; //被投诉人
            $map['date']  = date('Y-m-d H:i:s');
            $map['pid']   = $data_P;
            $oob          = M('tousu')->add($map);
            if ($oob) {
                $this->ajaxReturn('投诉成功，等待管理员处理。。。');
            }
        }

        if ($result['g_user'] == $_SESSION['uname']) {

            $map1['text']  = $text; //投诉内容
            $map1['user']  = $_SESSION['uname']; //投诉人；
            $map1['buser'] = $result['p_user']; //被投诉人
            $map1['date']  = date('Y-m-d H:i:s');
            $map1['pid']   = $data_P;
            $oobs          = M('tousu')->add($map1);
            if ($oobs) {
                $this->ajaxReturn('投诉成功，等待管理员处理。。。');
            }

        }
    }
    public function mjxx()
    {
        $settings = include dirname(APP_PATH) . '/User/Home/Conf/settings.php';
        $data_P   = $_GET['id'];

        $result  = M('ppdd')->where(array('id' => $data_P))->find();
        $rmb     = $result['jb'] * $settings['rmb_hl'];
        $btc     = $result['jb'] * $settings['btc_hl'];
        $meiyuan = $result['jb'];

        $user            = M('user')->where(array('UE_account' => $result['g_user']))->find();
        $user['rmb']     = $rmb;
        $user['btc']     = $btc;
        $user['meiyuan'] = $meiyuan;
        $this->ajaxReturn($user);

    }
    //SELECT UE_accName FROM jk_user WHERE UE_accName IS NULL;
    public function maijia()
    {
        $settings = include dirname(APP_PATH) . '/User/Home/Conf/settings.php';
        $data_P   = $_GET['id'];

        $result = M('ppdd')->where(array('id' => $data_P))->find();

        $rmb     = $result['jb'] * $settings['rmb_hl'];
        $btc     = $result['jb'] * $settings['btc_hl'];
        $meiyuan = $result['jb'];

        $user            = M('user')->where(array('UE_account' => $result['p_user']))->find();
        $user['rmb']     = $rmb;
        $user['btc']     = $btc;
        $user['meiyuan'] = $meiyuan;

        $this->ajaxReturn($user);
    }
    public function huilv()
    {
        $settings       = include dirname(APP_PATH) . '/User/Home/Conf/settings.php';
        $data_P         = $_GET['huilv'];
        $rmb            = $data_P * $settings['rmb_hl'];
        $btc            = $data_P * $settings['btc_hl'];
        $respond['rmb'] = $rmb;
        $respond['btc'] = $btc;

        $this->ajaxReturn($respond);
    }
    public function tpsc()
    {
        echo "111111111";die();
    }
    // 上传图片
    public function sctp()
    {

        $upload           = new \Think\Upload(); // 实例化上传类
        $upload->maxSize  = 3145728; // 设置附件上传大小
        $upload->exts     = array('jpg', 'gif', 'png', 'jpeg'); // 设置附件上传类型
        $upload->rootPath = './Uploads/'; // 设置附件上传根目录
        $upload->savePath = ''; // 设置附件上传（子）目录
        // 上传文件
        $info = $upload->upload();

        if (!$info) {
// 上传错误提示错误信息
            $returnData['status'] = 'failed';
            $returnData['reason'] = $upload->getError();
        } else {
// 上传成功 获取上传文件信息
            $returnData['status'] = 'success';
            //$returnData['data']['path'] = $info['savepath'].$info['savename'];
            $returnData['data']['path'] = $info["pic"]['savepath'] . $info["pic"]['savename'];
            /* $map['_string']="(p_user = {$_SESSION['uname']} or g_user = {$_SESSION['uname']})";
            $map['zt']=1; */
            $pdtj  = M('ppdd')->where(array('p_user' => $_SESSION['uname'], 'zt' => 1, 'datatype' => 'qglkb'))->find();
            $pdtj1 = M('ppdd')->where(array('g_user' => $_SESSION['uname'], 'zt' => 1, 'datatype' => 'cslkb'))->find();
            if ($pdtj) {
                $result = M('ppdd')->where(array('p_user' => $_SESSION['uname'], 'zt' => 1))->data(array('imagepath' => $returnData['data']['path']))->save();
            }
            if ($pdtj1) {
                $result = M('ppdd')->where(array('g_user' => $_SESSION['uname'], 'zt' => 1))->data(array('imagepath' => $returnData['data']['path']))->save();
            }

        }
        if ($result) {

            /* $user= M('ppdd')->where(array('p_user'=>$_SESSION['uname'],'zt'=>1))->find();
            $phone=$user['g_user'];

            $apikey = '';//
            $mobile =$phone;
            $text = '【莱肯社区】提醒您，对方已打款成功，请及时登录平台进行操作';//
            $url = 'http://yunpian.com/v1/sms/send.json';
            $encoded_text = urlencode ( $text );
            $mobile = urlencode ( $mobile );
            $post_string = 'apikey=' . $apikey . '&text=' . $encoded_text . '&mobile=' . $mobile;
            $this->sock_post ( $url, $post_string ); */

            return $this->ajaxReturn($returnData);
        }
        //return $this->ajaxReturn($returnData);
    }

    public function cktp()
    {
        $id     = $_GET['id'];
        $result = M('ppdd')->where(array('id' => $id))->find();
        $photo  = $result['imagepath'];
        $this->ajaxReturn($photo);
    }
    public function encsqx()
    {
        $data_P    = $_GET['id'];
        $map['id'] = $data_P;
        $map['zt'] = 1;
        $gname     = $_SESSION['uname'];
        //$map['_string']="(p_user = {$_SESSION['uname']} or g_user = {$_SESSION['uname']})";
        $map['_string'] = "(p_user = '$gname' or g_user = '$gname')";
        $result         = M('ppdd')->where($map)->find(); //出售人信息

        if (!$result) {
            $this->ajaxReturn('You are trading in no order');

        }

        $re = M('ppdd')->where(array('g_user' => $_SESSION['uname'], 'zt' => 1))->data(array('zt' => 0, 'g_user' => '', 'g_name' => '', 'g_level' => ''))->save();

        if ($re) {
            $this->ajaxReturn('Order has been cancelled');
        }

    }
    // 出售取消
    public function csqx()
    {
        $data_P    = $_GET['id'];
        $map['id'] = $data_P;
        $map['zt'] = 1;
        $gname     = $_SESSION['uname'];
        //$map['_string']="(p_user = {$_SESSION['uname']} or g_user = {$_SESSION['uname']})";
        $map['_string'] = "(p_user = '$gname' or g_user = '$gname')";
        $result         = M('ppdd')->where($map)->find(); //出售人信息

        if (!$result) {
            $this->ajaxReturn('你暂无正在交易中的订单');

        }

        $re = M('ppdd')->where(array('g_user' => $_SESSION['uname'], 'zt' => 1))->data(array('zt' => 0, 'g_user' => '', 'g_name' => '', 'g_level' => ''))->save();

        if ($re) {
            $this->ajaxReturn('订单已经取消');
        }

    }
    public function enqxdd()
    {
        //$this->ajaxReturn("11111111");
        $data_P         = $_GET['id'];
        $map['id']      = $data_P;
        $map['zt']      = 1;
        $gname          = $_SESSION['uname'];
        $map['_string'] = "(p_user = '$gname' or g_user = '$gname')";
        $result         = M('ppdd')->where($map)->find(); //出售人信息

        if (!$result) {
            $this->ajaxReturn('You are trading in no order');

        }
        $user    = M('user')->where(array('UE_account' => $_SESSION['uname']))->find();
        $djmoney = M('user')->where(array('UE_account' => $result['g_user']))->find();
        $oob     = M('user')->where(array('UE_account' => $result['g_user']))->setInc('UE_money', $djmoney['djmoney']); //购币人信息

        $obs = M('user')->where(array('UE_account' => $result['g_user']))->setDec('djmoney', $djmoney['djmoney']);

        if ($oob && $obs) {
            $re = M('ppdd')->where(array('id' => $data_P))->delete();
            if ($re) {
                $this->ajaxReturn("Order has been cancelled");
            }

        }

    }
    public function qxdd()
    {

        //$this->ajaxReturn("11111113424111");
        $gname          = $_SESSION['uname'];
        $data_P         = $_GET['id'];
        $map['id']      = $data_P;
        $map['zt']      = 1;
        $map['_string'] = "(p_user = '$gname' or g_user = '$gname')";
        $result         = M('ppdd')->where($map)->find(); //出售人信息

        if (!$result) {
            $this->ajaxReturn('你暂无正在交易中的订单');

        }
        $user    = M('user')->where(array('UE_account' => $_SESSION['uname']))->find();
        $djmoney = M('user')->where(array('UE_account' => $result['g_user']))->find();
        $oob     = M('user')->where(array('UE_account' => $result['g_user']))->setInc('UE_money', $djmoney['djmoney']); //购币人信息
        $obs = M('user')->where(array('UE_account' => $result['g_user']))->setDec('djmoney', $djmoney['djmoney']);

        if ($oob && $obs) {
            $re = M('ppdd')->where(array('id' => $data_P))->delete();
            if ($re) {
                $this->ajaxReturn("订单已经取消");
            }

        }

    }
    public function lksc()
    {
        $data_P = I('GET.');

        if (IS_AJAX) {
            $data_P = I('GET.');
            if (false) {
                $this->ajaxReturn(array('data' => '网络错误!', 'sf' => 0));
            } else {
                $user   = M('user')->where(array('UE_account' => $_SESSION['uname']))->find(); //登录账户本人信息
                $result = M('ppdd')->where(array('id' => $data_P['id']))->find(); //订单信息
                $gname  = $_SESSION['uname'];

                $map['zt']      = 1;
                $map['_string'] = "(p_user = '$gname' or g_user = '$gname')";

                $oob             = M('ppdd')->where($map)->find();
                $maps['zt']      = 0;
                $maps['_string'] = "(p_user = '$gname' or g_user = '$gname')";

                $oob1 = M('ppdd')->where($maps)->find();
                //$this->ajaxReturn($oob1);
                if ($user['yhmc'] == "" || $user['phone'] == "") {
                    $res['status'] = 2;
                    $res['msg']    = '交易前请先到个人资料完善个人信息';
                    $this->ajaxReturn($res);
                }
                if ($result['zdjyr'] != "") {
                    if ($_SESSION['uname'] != $result['zdjyr']) {
                        $zd['msg'] = '该订单已有指定交易人';
                        $this->ajaxReturn($zd);
                    }
                }
                if ($oob || $oob1) {
                    $jj['msg'] = "你还有未完成交易的订单。";
                    $this->ajaxReturn($jj);
                } elseif ($result['p_user'] == $_SESSION['uname']) {
                    $self['msg'] = "您不能购买自己出售的GEC";
                    $this->ajaxReturn($self);
                } elseif ($result['zt'] == 1) {
                    $dfz['msg'] = "对方正在交易中。";
                    $this->ajaxReturn($dfz);
                } elseif ($result['zt'] == 2) {
                    $jywc['msg'] = "对方交易已完成。";
                    $this->ajaxReturn($jywc);
                } else {
                    // $re=M('duihuanjf')->where(array('id'=>$id))->data(array('status'=>2,'pass_time'=>$time))->save();
                    $time = date('Y-m-d H:i:s');
                    $re   = M('ppdd')->where(array('id' => $data_P['id']))->data(array('zt' => 1, 'jydate' => $time, 'g_name' => $user['ue_truename'], 'g_user' => $user['ue_account'], 'g_level' => $user['level'], 'g_id' => $user['ue_id']))->save();

                    /* $results=M('user')->where(array('UE_account'=>$result['p_user']))->setDec('UE_money',$result['lkb']);

                    $obs=M('user')->where(array('UE_account'=>$result['p_user']))->setInc('djmoney',$result['lkb']); */
                    if ($re) {
                        unset($respond);
                        $respond['status'] = 1;
                        $respond['msg']    = '匹成功，请到我的交易中查看详情';
                        $maijia            = $result['g_user']; //购买方
                        $mj                = $result['p_user']; //出售方

                        /* $apikey = '';//
                        $mobile =$mj;
                        $text = '【莱肯社区】提醒您，您的出售订单已经匹配成功，请及时登录平台进行操作';//
                        $url = 'http://yunpian.com/v1/sms/send.json';
                        $encoded_text = urlencode ( $text );
                        $mobile = urlencode ( $mobile );
                        $post_string = 'apikey=' . $apikey . '&text=' . $encoded_text . '&mobile=' . $mobile;
                        $this->sock_post ( $url, $post_string ) */;

                        $this->ajaxReturn($respond);
                    }
                }

            }

        }

    }

    public function enlksc()
    {
        $data_P = I('GET.');

        if (IS_AJAX) {
            $data_P = I('GET.');
            if (false) {
                $this->ajaxReturn(array('data' => 'network error!', 'sf' => 0));
            } else {
                $user   = M('user')->where(array('UE_account' => $_SESSION['uname']))->find(); //登录账户本人信息
                $result = M('ppdd')->where(array('id' => $data_P['id']))->find(); //订单信息
                $gname  = $_SESSION['uname'];

                $map['zt']      = 1;
                $map['_string'] = "(p_user = '$gname' or g_user = '$gname')";

                $oob             = M('ppdd')->where($map)->find();
                $maps['zt']      = 0;
                $maps['_string'] = "(p_user = '$gname' or g_user = '$gname')";

                $oob1 = M('ppdd')->where($maps)->find();
                if ($user['yhmc'] == "") {
                    $res['status'] = 2;
                    $res['msg']    = 'Prior to the transaction, please go to personal center to improve personal information';
                    $this->ajaxReturn($res);
                }
                if ($result['zdjyr'] != "") {
                    if ($_SESSION['uname'] != $result['zdjyr']) {
                        $zd['msg'] = 'The order has been designated by the trader';
                        $this->ajaxReturn($zd);
                    }
                }

                if ($oob || $oob1) {
                    $jj['msg'] = "You still have orders for an unfinished transaction.";
                    $this->ajaxReturn($jj);
                } elseif ($result['p_user'] == $_SESSION['uname']) {
                    $self['msg'] = "You can't buy your own GEC";
                    $this->ajaxReturn($self);
                } elseif ($result['zt'] == 1) {
                    $dfz['msg'] = "The other party is in the transaction。";
                    $this->ajaxReturn($dfz);
                } elseif ($result['zt'] == 2) {
                    $jywc['msg'] = "对方交易已完成。";
                    $this->ajaxReturn($jywc);
                } else {
                    // $re=M('duihuanjf')->where(array('id'=>$id))->data(array('status'=>2,'pass_time'=>$time))->save();
                    $time = date('Y-m-d H:i:s');
                    $re   = M('ppdd')->where(array('id' => $data_P['id']))->data(array('zt' => 1, 'jydate' => $time, 'g_name' => $user['ue_truename'], 'g_user' => $user['ue_account'], 'g_level' => $user['level'], 'g_id' => $user['ue_id']))->save();

                    /* $results=M('user')->where(array('UE_account'=>$result['p_user']))->setDec('UE_money',$result['lkb']);

                    $obs=M('user')->where(array('UE_account'=>$result['p_user']))->setInc('djmoney',$result['lkb']); */
                    if ($re) {
                        unset($respond);
                        $respond['status'] = 1;
                        $respond['msg']    = 'Successful, please go to my transaction to see details';
                        $maijia            = $result['g_user']; //购买方
                        $mj                = $result['p_user']; //出售方

                        $apikey       = ''; //
                        $mobile       = $mj;
                        $text         = '【莱肯社区】提醒您，您的出售订单已经匹配成功，请及时登录平台进行操作'; //
                        $url          = 'http://yunpian.com/v1/sms/send.json';
                        $encoded_text = urlencode($text);
                        $mobile       = urlencode($mobile);
                        $post_string  = 'apikey=' . $apikey . '&text=' . $encoded_text . '&mobile=' . $mobile;
                        $this->sock_post($url, $post_string);

                        $this->ajaxReturn($respond);
                    }
                }

            }

        }

    }

    public function erjimima()
    {
        $data_P = I('GET.pwd');
        $pwd    = md5($data_P);
        $result = M('user')->where(array('UE_account' => $_SESSION['uname']))->find();
        if ($pwd == $result['ue_secpwd']) {
            $res['status'] = 1;
            $res['msg']    = "密码正确！";
            //session('subPwd',$sql['ue_secpwd']);
            session('secpwd', $result['ue_secpwd']);
            $this->ajaxReturn($res);
        } else {
            $res['status'] = 2;
            $res['msg']    = "密码错误！";
            $this->ajaxReturn($res);
        }
    }
    public function enerjimima()
    {
        $data_P = I('GET.pwd');
        $pwd    = md5($data_P);
        $result = M('user')->where(array('UE_account' => $_SESSION['uname']))->find();
        if ($pwd == $result['ue_secpwd']) {
            $res['status'] = 1;
            $res['msg']    = "Password correct！";
            //session('subPwd',$sql['ue_secpwd']);
            session('secpwd', $result['ue_secpwd']);
            $this->ajaxReturn($res);
        } else {
            $res['status'] = 2;
            $res['msg']    = "Password error！";
            $this->ajaxReturn($res);
        }
    }
    public function chushou()
    {
        $settings = include dirname(APP_PATH) . '/User/Home/Conf/settings.php';
        if (IS_AJAX) {
            $data_P = I('GET.');
            if (false) {
                $this->ajaxReturn(array('data' => '网络错误!', 'sf' => 0));
            } else {
                $user   = M('user')->where(array('UE_account' => $_SESSION['uname']))->find();
                $result = M('ppdd')->where(array('id' => $data_P['id']))->find();
                $gname  = $_SESSION['uname'];

                $map['zt']      = 1;
                $map['_string'] = "(p_user = '$gname' or g_user = '$gname')";

                $oob             = M('ppdd')->where($map)->find();
                $maps['zt']      = 0;
                $maps['_string'] = "(p_user = '$gname' or g_user = '$gname')";

                $oob1 = M('ppdd')->where($maps)->find();

                if ($user['yhmc'] == "" || $user['phone'] == "") {
                    $res['status'] = 2;
                    $res['msg']    = '交易前请先到个人资料完善个人信息';
                    $this->ajaxReturn($res);
                }
                $totalprice = $result['lkb'] + $result['lkb'] * $settings['jiaoyi_shouxu'];
                if ($user['ue_money'] < $totalprice) {
                    $os['msg'] = '你的账户余额不足';
                    $this->ajaxReturn($os);
                } elseif ($oob || $oob1) {
                    $jj['msg'] = "你还有未完成交易的订单。";
                    $this->ajaxReturn($jj);
                } elseif ($result['p_user'] == $_SESSION['uname']) {
                    $self['msg'] = "您不能出售GEC到自己的账户";
                    $this->ajaxReturn($self);
                } elseif ($result['zt'] == 1) {
                    $dfz['msg'] = "对方正在交易中。";
                    $this->ajaxReturn($dfz);
                } elseif ($result['zt'] == 2) {
                    $jywc['msg'] = "对方交易已完成。";
                    $this->ajaxReturn($jywc);
                } else {
                    // $re=M('duihuanjf')->where(array('id'=>$id))->data(array('status'=>2,'pass_time'=>$time))->save();
                    $time = date('Y-m-d H:i:s');
                    $re   = M('ppdd')->where(array('id' => $data_P['id']))->data(array('zt' => 1, 'jydate' => $time, 'g_name' => $user['ue_truename'], 'g_user' => $user['ue_account'], 'g_level' => $user['level'], 'g_id' => $user['ue_id']))->save();

                    $results = M('user')->where(array('UE_account' => $_SESSION['uname']))->setDec('UE_money', $totalprice);

                    $obs = M('user')->where(array('UE_account' => $_SESSION['uname']))->setInc('djmoney', $totalprice);
                    if ($results && $obs) {
                        unset($respond);
                        $respond['status'] = 1;
                        $respond['msg']    = '匹配成功，请到我的交易中查看详情';
                        $maijia            = $result['g_user']; //卖家
                        $mj                = $result['p_user']; //买家

                        $apikey       = ''; //
                        $mobile       = $mj;
                        $text         = '【莱肯社区】提醒您，您的求购订单已经匹配成功，请及时登录平台进行操作'; //
                        $url          = 'http://yunpian.com/v1/sms/send.json';
                        $encoded_text = urlencode($text);
                        $mobile       = urlencode($mobile);
                        $post_string  = 'apikey=' . $apikey . '&text=' . $encoded_text . '&mobile=' . $mobile;
                        $this->sock_post($url, $post_string);

                        $this->ajaxReturn($respond);
                    }
                }

            }

        }
    }
    public function enchushou()
    {
        $settings = include dirname(APP_PATH) . '/User/Home/Conf/settings.php';
        if (IS_AJAX) {
            $data_P = I('GET.');
            if (false) {
                $this->ajaxReturn(array('data' => 'network error!', 'sf' => 0));
            } else {
                $user   = M('user')->where(array('UE_account' => $_SESSION['uname']))->find();
                $result = M('ppdd')->where(array('id' => $data_P['id']))->find();
                $gname  = $_SESSION['uname'];

                $map['zt']      = 1;
                $map['_string'] = "(p_user = '$gname' or g_user = '$gname')";

                $oob             = M('ppdd')->where($map)->find();
                $maps['zt']      = 0;
                $maps['_string'] = "(p_user = '$gname' or g_user = '$gname')";

                $oob1 = M('ppdd')->where($maps)->find();
                if ($user['yhmc'] == "") {
                    $res['status'] = 2;
                    $res['msg']    = 'Prior to the transaction, please go to personal center to improve personal information';
                    $this->ajaxReturn($res);
                }

                $totalprice = $result['lkb'] + $result['lkb'] * $settings['jiaoyi_shouxu'];
                if ($user['ue_money'] < $totalprice) {
                    $os['msg'] = 'your balance not enough';
                    $this->ajaxReturn($os);
                } elseif ($oob || $oob1) {
                    $jj['msg'] = "You still have orders for an unfinished transaction。";
                    $this->ajaxReturn($jj);
                } elseif ($result['p_user'] == $_SESSION['uname']) {
                    $self['msg'] = "You cannot sell GEC coins to your account";
                    $this->ajaxReturn($self);
                } elseif ($result['zt'] == 1) {
                    $dfz['msg'] = "The other party is in the transaction。";
                    $this->ajaxReturn($dfz);
                } elseif ($result['zt'] == 2) {
                    $jywc['msg'] = "The other party transaction has been completed。";
                    $this->ajaxReturn($jywc);
                } else {
                    // $re=M('duihuanjf')->where(array('id'=>$id))->data(array('status'=>2,'pass_time'=>$time))->save();
                    $time = date('Y-m-d H:i:s');
                    $re   = M('ppdd')->where(array('id' => $data_P['id']))->data(array('zt' => 1, 'jydate' => $time, 'g_name' => $user['ue_truename'], 'g_user' => $user['ue_account'], 'g_level' => $user['level'], 'g_id' => $user['ue_id']))->save();

                    $results = M('user')->where(array('UE_account' => $_SESSION['uname']))->setDec('UE_money', $totalprice);

                    $obs = M('user')->where(array('UE_account' => $_SESSION['uname']))->setInc('djmoney', $totalprice);
                    if ($results && $obs) {
                        unset($respond);
                        $respond['status'] = 1;
                        $respond['msg']    = 'Matching success, please see the details in my transaction';
                        $maijia            = $result['g_user']; //卖家
                        $mj                = $result['p_user']; //买家

                        $apikey       = ''; //
                        $mobile       = $mj;
                        $text         = '【莱肯社区】提醒您，您的求购订单已经匹配成功，请及时登录平台进行操作'; //
                        $url          = 'http://yunpian.com/v1/sms/send.json';
                        $encoded_text = urlencode($text);
                        $mobile       = urlencode($mobile);
                        $post_string  = 'apikey=' . $apikey . '&text=' . $encoded_text . '&mobile=' . $mobile;
                        $this->sock_post($url, $post_string);

                        $this->ajaxReturn($respond);
                    }
                }

            }

        }
    }
    public function sock_post($url, $query)
    {
        $data = '';
        $info = parse_url($url);
        $fp   = fsockopen($info['host'], 80, $errno, $errstr, 30);

        if (!$fp) {
            return $data;
        }

        $head = 'POST ' . $info['path'] . ' HTTP/1.0' . "\r\n" . '';
        $head .= 'Host: ' . $info['host'] . "\r\n";
        $head .= 'Referer: http://' . $info['host'] . $info['path'] . "\r\n";
        $head .= 'Content-type: application/x-www-form-urlencoded' . "\r\n" . '';
        $head .= 'Content-Length: ' . strlen(trim($query)) . "\r\n";
        $head .= "\r\n";
        $head .= trim($query);
        $write  = fputs($fp, $head);
        $header = '';

        while ($str = trim(fgets($fp, 4096))) {
            $header .= $str;
        }

        while (!feof($fp)) {
            $data .= fgets($fp, 4096);
        }

        return $data;
    }
    public function enwancheng()
    {
        $settings = include dirname(APP_PATH) . '/User/Home/Conf/settings.php';
        $data_P   = $_GET['id'];
        $result   = M('ppdd')->where(array('id' => $data_P))->find();
        if ($result['p_user'] == $_SESSION['uname']) {
            $this->ajaxReturn('Please wait for the seller to determine the transaction');
        }
        if ($result['g_user'] == $_SESSION['uname']) {
            $djmoney = M('user')->where(array('UE_account' => $result['g_user']))->find();
            $zz      = M('ppdd')->where(array('g_user' => $result['g_user'], 'zt' => 1))->find();
            if ($zz) {
                $obs = M('user')->where(array('UE_account' => $result['g_user']))->setDec('djmoney', $djmoney['djmoney']);
                $oob = M('user')->where(array('UE_account' => $result['p_user']))->setInc('UE_money', $result['lkb']);
            }
            $re = M('ppdd')->where(array('g_user' => $result['g_user'], 'zt' => 1))->data(array('zt' => 2))->save();
            if ($oob && $obs && $re) {
                $respond['status'] = 1;
                $respond['msg']    = 'Order completed';
                //分红金额
                $fenhong = $djmoney['djmoney'] - $result['lkb'];
                $count   = M('user')->where(array('level' => 2))->count();
                $fh      = $fenhong / $count;
                $fh      = $fh * $settings['hzlv'];
                $level   = M('user')->where(array('level' => 2))->select(); //一代

                foreach ($level as $v) {
                    $result1                = M('user')->where(array('UE_account' => $v['ue_account']))->find();
                    $sj                     = M('user')->where(array('UE_account' => $v['ue_account']))->setInc('UE_money', $fh);
                    $resu                   = M('user')->where(array('UE_account' => $v['ue_account']))->find();
                    $record3["UG_account"]  = $v['ue_account']; // 登入轉出賬戶
                    $record3["UG_type"]     = 'lkb';
                    $record3["UG_allGet"]   = $result1['ue_money']; // 金幣
                    $record3["UG_money"]    = '+' . $fh; //
                    $record3["UG_balance"]  = $resu['ue_money']; // 當前推薦人的金幣餘額
                    $record3["UG_dataType"] = 'tdj'; // 金幣轉出
                    $record3["UG_note"]     = "会长收益"; // 推薦獎說明
                    $record3["enUG_note"]   = "President earnings";
                    $record3["UG_getTime"]  = date('Y-m-d H:i:s', time()); //操作時間
                    //$record3["UG_othraccount"] = $result['ue_truename'];
                    $record3["nickname"] = $djmoney['ue_truename'];
                    $reg4                = M('userget')->add($record3);

                }
                //创业大使
                $count1 = M('user')->where(array('level' => 3))->count();
                $fh     = $fenhong / $count1;
                $fh     = $fh * $settings['cylv'];
                $level  = M('user')->where(array('level' => 3))->select(); //一代

                foreach ($level as $v) {
                    $result1                = M('user')->where(array('UE_account' => $v['ue_account']))->find();
                    $sj                     = M('user')->where(array('UE_account' => $v['ue_account']))->setInc('UE_money', $fh);
                    $resu                   = M('user')->where(array('UE_account' => $v['ue_account']))->find();
                    $record5["UG_account"]  = $v['ue_account']; // 登入轉出賬戶
                    $record5["UG_type"]     = 'lkb';
                    $record5["UG_allGet"]   = $result1['ue_money']; // 金幣
                    $record5["UG_money"]    = '+' . $fh; //
                    $record5["UG_balance"]  = $resu['ue_money']; // 當前推薦人的金幣餘額
                    $record5["UG_dataType"] = 'tdj'; // 金幣轉出
                    $record5["UG_note"]     = "创业大使收益"; // 推薦獎說明
                    $record5["enUG_note"]   = "Entrepreneurial income";
                    $record5["UG_getTime"]  = date('Y-m-d H:i:s', time()); //操作時間
                    //$record3["UG_othraccount"] = $result['ue_truename'];
                    $record5["nickname"] = $djmoney['ue_truename'];
                    $reg4                = M('userget')->add($record5);

                }
                //环保大使
                $count2 = M('user')->where(array('level' => 4))->count();
                $fh     = $fenhong / $count2;
                $fh     = $fh * $settings['hblv'];
                $level  = M('user')->where(array('level' => 4))->select(); //一代

                foreach ($level as $v) {
                    $result1                = M('user')->where(array('UE_account' => $v['ue_account']))->find();
                    $sj                     = M('user')->where(array('UE_account' => $v['ue_account']))->setInc('UE_money', $fh);
                    $resu                   = M('user')->where(array('UE_account' => $v['ue_account']))->find();
                    $record6["UG_account"]  = $v['ue_account']; // 登入轉出賬戶
                    $record6["UG_type"]     = 'lkb';
                    $record6["UG_allGet"]   = $result1['ue_money']; // 金幣
                    $record6["UG_money"]    = '+' . $fh; //
                    $record6["UG_balance"]  = $resu['ue_money']; // 當前推薦人的金幣餘額
                    $record6["UG_dataType"] = 'tdj'; // 金幣轉出
                    $record6["UG_note"]     = "环保收益"; // 推薦獎說明
                    $record6["enUG_note"]   = "Environmental income";
                    $record6["UG_getTime"]  = date('Y-m-d H:i:s', time()); //操作時間
                    //$record3["UG_othraccount"] = $result['ue_truename'];
                    $record6["nickname"] = $djmoney['ue_truename'];
                    $reg4                = M('userget')->add($record6);

                }
                //国际大使
                $count3 = M('user')->where(array('level' => 5))->count();
                $fh     = $fenhong / $count3;
                $fh     = $fh * $settings['gjlv'];
                $level  = M('user')->where(array('level' => 5))->select(); //一代

                foreach ($level as $v) {
                    $result1                = M('user')->where(array('UE_account' => $v['ue_account']))->find();
                    $sj                     = M('user')->where(array('UE_account' => $v['ue_account']))->setInc('UE_money', $fh);
                    $resu                   = M('user')->where(array('UE_account' => $v['ue_account']))->find();
                    $record7["UG_account"]  = $v['ue_account']; // 登入轉出賬戶
                    $record7["UG_type"]     = 'lkb';
                    $record7["UG_allGet"]   = $result1['ue_money']; // 金幣
                    $record7["UG_money"]    = '+' . $fh; //
                    $record7["UG_balance"]  = $resu['ue_money']; // 當前推薦人的金幣餘額
                    $record7["UG_dataType"] = 'tdj'; // 金幣轉出
                    $record7["UG_note"]     = "国籍大使收益"; // 推薦獎說明
                    $record7["enUG_note"]   = "Income of ambassador";
                    $record7["UG_getTime"]  = date('Y-m-d H:i:s', time()); //操作時間
                    //$record3["UG_othraccount"] = $result['ue_truename'];
                    $record7["nickname"] = $djmoney['ue_truename'];
                    $reg4                = M('userget')->add($record7);

                }
                $jydate = M('ppdd')->order('jydate desc')->find();

                $maps['date']  = time();
                $maps['price'] = $jydate['danjia'];
                M('date')->add($maps);
                $this->ajaxReturn($respond);
            }

        }
    }

    public function wancheng()
    {
        $settings = include dirname(APP_PATH) . '/User/Home/Conf/settings.php';
        $data_P   = $_GET['id'];
        $result   = M('ppdd')->where(array('id' => $data_P))->find();

        if ($result['p_user'] == $_SESSION['uname']) {
            $this->ajaxReturn('请等待卖家确定交易。');
        }
        if ($result['g_user'] == $_SESSION['uname']) {
            $djmoney = M('user')->where(array('UE_account' => $result['g_user']))->find();
            $zz      = M('ppdd')->where(array('g_user' => $result['g_user'], 'zt' => 1))->find();
            if ($zz) {
                $obs = M('user')->where(array('UE_account' => $result['g_user']))->setDec('djmoney', $djmoney['djmoney']);
                $oob = M('user')->where(array('UE_account' => $result['p_user']))->setInc('UE_money', $result['lkb']);
            }
            $re = M('ppdd')->where(array('g_user' => $result['g_user'], 'zt' => 1))->data(array('zt' => 2))->save();
            if ($oob && $obs && $re) {

                $respond['status'] = 1;
                $respond['msg']    = '订单已完成。';
                //分红金额
                $fenhong = $djmoney['djmoney'] - $result['lkb'];
                $count   = M('user')->where(array('level' => 2))->count();
                $fh      = $fenhong / $count;
                $fh      = $fh * $settings['hzlv'];
                $level   = M('user')->where(array('level' => 2))->select(); //一代

                foreach ($level as $v) {
                    $result1                = M('user')->where(array('UE_account' => $v['ue_account']))->find();
                    $sj                     = M('user')->where(array('UE_account' => $v['ue_account']))->setInc('UE_money', $fh);
                    $resu                   = M('user')->where(array('UE_account' => $v['ue_account']))->find();
                    $record3["UG_account"]  = $v['ue_account']; // 登入轉出賬戶
                    $record3["UG_type"]     = 'lkb';
                    $record3["UG_allGet"]   = $result1['ue_money']; // 金幣
                    $record3["UG_money"]    = '+' . $fh; //
                    $record3["UG_balance"]  = $resu['ue_money']; // 當前推薦人的金幣餘額
                    $record3["UG_dataType"] = 'tdj'; // 金幣轉出
                    $record3["UG_note"]     = "会长收益"; // 推薦獎說明
                    $record3["enUG_note"]   = "President earnings";
                    $record3["UG_getTime"]  = date('Y-m-d H:i:s', time()); //操作時間
                    //$record3["UG_othraccount"] = $result['ue_truename'];
                    $record3["nickname"] = $djmoney['ue_truename'];
                    $reg4                = M('userget')->add($record3);

                }
                //创业大使
                $count1 = M('user')->where(array('level' => 3))->count();
                $fh     = $fenhong / $count1;
                $fh     = $fh * $settings['cylv'];
                $level  = M('user')->where(array('level' => 3))->select(); //一代

                foreach ($level as $v) {
                    $result1                = M('user')->where(array('UE_account' => $v['ue_account']))->find();
                    $sj                     = M('user')->where(array('UE_account' => $v['ue_account']))->setInc('UE_money', $fh);
                    $resu                   = M('user')->where(array('UE_account' => $v['ue_account']))->find();
                    $record5["UG_account"]  = $v['ue_account']; // 登入轉出賬戶
                    $record5["UG_type"]     = 'lkb';
                    $record5["UG_allGet"]   = $result1['ue_money']; // 金幣
                    $record5["UG_money"]    = '+' . $fh; //
                    $record5["UG_balance"]  = $resu['ue_money']; // 當前推薦人的金幣餘額
                    $record5["UG_dataType"] = 'tdj'; // 金幣轉出
                    $record5["UG_note"]     = "创业大使收益"; // 推薦獎說明
                    $record5["enUG_note"]   = "Entrepreneurial income";
                    $record5["UG_getTime"]  = date('Y-m-d H:i:s', time()); //操作時間
                    //$record3["UG_othraccount"] = $result['ue_truename'];
                    $record5["nickname"] = $djmoney['ue_truename'];
                    $reg4                = M('userget')->add($record5);

                }
                //环保大使
                $count2 = M('user')->where(array('level' => 4))->count();
                $fh     = $fenhong / $count2;
                $fh     = $fh * $settings['hblv'];
                $level  = M('user')->where(array('level' => 4))->select(); //一代

                foreach ($level as $v) {
                    $result1                = M('user')->where(array('UE_account' => $v['ue_account']))->find();
                    $sj                     = M('user')->where(array('UE_account' => $v['ue_account']))->setInc('UE_money', $fh);
                    $resu                   = M('user')->where(array('UE_account' => $v['ue_account']))->find();
                    $record6["UG_account"]  = $v['ue_account']; // 登入轉出賬戶
                    $record6["UG_type"]     = 'lkb';
                    $record6["UG_allGet"]   = $result1['ue_money']; // 金幣
                    $record6["UG_money"]    = '+' . $fh; //
                    $record6["UG_balance"]  = $resu['ue_money']; // 當前推薦人的金幣餘額
                    $record6["UG_dataType"] = 'tdj'; // 金幣轉出
                    $record6["UG_note"]     = "环保收益"; // 推薦獎說明
                    $record6["enUG_note"]   = "Environmental income";
                    $record6["UG_getTime"]  = date('Y-m-d H:i:s', time()); //操作時間
                    //$record3["UG_othraccount"] = $result['ue_truename'];
                    $record6["nickname"] = $djmoney['ue_truename'];
                    $reg4                = M('userget')->add($record6);

                }
                //国际大使
                $count3 = M('user')->where(array('level' => 5))->count();
                $fh     = $fenhong / $count3;
                $fh     = $fh * $settings['gjlv'];
                $level  = M('user')->where(array('level' => 5))->select(); //一代

                foreach ($level as $v) {
                    $result1                = M('user')->where(array('UE_account' => $v['ue_account']))->find();
                    $sj                     = M('user')->where(array('UE_account' => $v['ue_account']))->setInc('UE_money', $fh);
                    $resu                   = M('user')->where(array('UE_account' => $v['ue_account']))->find();
                    $record7["UG_account"]  = $v['ue_account']; // 登入轉出賬戶
                    $record7["UG_type"]     = 'lkb';
                    $record7["UG_allGet"]   = $result1['ue_money']; // 金幣
                    $record7["UG_money"]    = '+' . $fh; //
                    $record7["UG_balance"]  = $resu['ue_money']; // 當前推薦人的金幣餘額
                    $record7["UG_dataType"] = 'tdj'; // 金幣轉出
                    $record7["UG_note"]     = "国籍大使收益"; // 推薦獎說明
                    $record7["enUG_note"]   = "Income of ambassador";
                    $record7["UG_getTime"]  = date('Y-m-d H:i:s', time()); //操作時間
                    //$record3["UG_othraccount"] = $result['ue_truename'];
                    $record7["nickname"] = $djmoney['ue_truename'];
                    $reg4                = M('userget')->add($record7);

                }
                $jydate = M('ppdd')->order('jydate desc')->find();

                $maps['date']  = time();
                $maps['price'] = $jydate['danjia'];
                M('date')->add($maps);
                $this->ajaxReturn($respond);
            }

        }
    }
    public function cswancheng()
    {
        $settings = include dirname(APP_PATH) . '/User/Home/Conf/settings.php';
        $data_P   = $_GET['id'];
        $result   = M('ppdd')->where(array('id' => $data_P))->find();

        $price = $result['lkb'] + $result['lkb'];
        if ($result['p_user'] == $_SESSION['uname']) {
            $djmoney = M('user')->where(array('UE_account' => $result['p_user']))->find();
            $zz      = M('ppdd')->where(array('g_user' => $result['g_user'], 'zt' => 1))->find();
            if ($zz) {
                $obs = M('user')->where(array('UE_account' => $result['p_user']))->setDec('djmoney', $djmoney['djmoney']);
                $oob = M('user')->where(array('UE_account' => $result['g_user']))->setInc('UE_money', $result['lkb']);
            }

            $re = M('ppdd')->where(array('g_user' => $result['g_user'], 'zt' => 1))->data(array('zt' => 2))->save();
            if ($oob && $obs && $re) {
                //分红金额
                $fenhong = $djmoney['djmoney'] - $result['lkb'];
                $count   = M('user')->where(array('level' => 2))->count();
                $fh      = $fenhong / $count;
                $fh      = $fh * $settings['hzlv'];
                $level   = M('user')->where(array('level' => 2))->select(); //一代

                foreach ($level as $v) {
                    $result1                = M('user')->where(array('UE_account' => $v['ue_account']))->find();
                    $sj                     = M('user')->where(array('UE_account' => $v['ue_account']))->setInc('UE_money', $fh);
                    $resu                   = M('user')->where(array('UE_account' => $v['ue_account']))->find();
                    $record3["UG_account"]  = $v['ue_account']; // 登入轉出賬戶
                    $record3["UG_type"]     = 'lkb';
                    $record3["UG_allGet"]   = $result1['ue_money']; // 金幣
                    $record3["UG_money"]    = '+' . $fh; //
                    $record3["UG_balance"]  = $resu['ue_money']; // 當前推薦人的金幣餘額
                    $record3["UG_dataType"] = 'tdj'; // 金幣轉出
                    $record3["UG_note"]     = "会长收益"; // 推薦獎說明
                    $record3["enUG_note"]   = "President earnings";
                    $record3["UG_getTime"]  = date('Y-m-d H:i:s', time()); //操作時間
                    //$record3["UG_othraccount"] = $result['ue_truename'];
                    $record3["nickname"] = $djmoney['ue_truename'];
                    $reg4                = M('userget')->add($record3);

                }
                //创业大使
                $count1 = M('user')->where(array('level' => 3))->count();
                $fh     = $fenhong / $count1;
                $fh     = $fh * $settings['cylv'];
                $level  = M('user')->where(array('level' => 3))->select(); //一代

                foreach ($level as $v) {
                    $result1                = M('user')->where(array('UE_account' => $v['ue_account']))->find();
                    $sj                     = M('user')->where(array('UE_account' => $v['ue_account']))->setInc('UE_money', $fh);
                    $resu                   = M('user')->where(array('UE_account' => $v['ue_account']))->find();
                    $record5["UG_account"]  = $v['ue_account']; // 登入轉出賬戶
                    $record5["UG_type"]     = 'lkb';
                    $record5["UG_allGet"]   = $result1['ue_money']; // 金幣
                    $record5["UG_money"]    = '+' . $fh; //
                    $record5["UG_balance"]  = $resu['ue_money']; // 當前推薦人的金幣餘額
                    $record5["UG_dataType"] = 'tdj'; // 金幣轉出
                    $record5["UG_note"]     = "创业大使收益"; // 推薦獎說明
                    $record5["enUG_note"]   = "Entrepreneurial income";
                    $record5["UG_getTime"]  = date('Y-m-d H:i:s', time()); //操作時間
                    //$record3["UG_othraccount"] = $result['ue_truename'];
                    $record5["nickname"] = $djmoney['ue_truename'];
                    $reg4                = M('userget')->add($record5);

                }
                //环保大使
                $count2 = M('user')->where(array('level' => 4))->count();
                $fh     = $fenhong / $count2;
                $fh     = $fh * $settings['hblv'];
                $level  = M('user')->where(array('level' => 4))->select(); //一代

                foreach ($level as $v) {
                    $result1                = M('user')->where(array('UE_account' => $v['ue_account']))->find();
                    $sj                     = M('user')->where(array('UE_account' => $v['ue_account']))->setInc('UE_money', $fh);
                    $resu                   = M('user')->where(array('UE_account' => $v['ue_account']))->find();
                    $record6["UG_account"]  = $v['ue_account']; // 登入轉出賬戶
                    $record6["UG_type"]     = 'lkb';
                    $record6["UG_allGet"]   = $result1['ue_money']; // 金幣
                    $record6["UG_money"]    = '+' . $fh; //
                    $record6["UG_balance"]  = $resu['ue_money']; // 當前推薦人的金幣餘額
                    $record6["UG_dataType"] = 'tdj'; // 金幣轉出
                    $record6["UG_note"]     = "环保收益"; // 推薦獎說明
                    $record6["enUG_note"]   = "Environmental income";
                    $record6["UG_getTime"]  = date('Y-m-d H:i:s', time()); //操作時間
                    //$record3["UG_othraccount"] = $result['ue_truename'];
                    $record6["nickname"] = $djmoney['ue_truename'];
                    $reg4                = M('userget')->add($record6);

                }
                //国际大使
                $count3 = M('user')->where(array('level' => 5))->count();
                $fh     = $fenhong / $count3;
                $fh     = $fh * $settings['gjlv'];
                $level  = M('user')->where(array('level' => 5))->select(); //一代

                foreach ($level as $v) {
                    $result1                = M('user')->where(array('UE_account' => $v['ue_account']))->find();
                    $sj                     = M('user')->where(array('UE_account' => $v['ue_account']))->setInc('UE_money', $fh);
                    $resu                   = M('user')->where(array('UE_account' => $v['ue_account']))->find();
                    $record8["UG_account"]  = $v['ue_account']; // 登入轉出賬戶
                    $record8["UG_type"]     = 'lkb';
                    $record8["UG_allGet"]   = $result1['ue_money']; // 金幣
                    $record8["UG_money"]    = '+' . $fh; //
                    $record8["UG_balance"]  = $resu['ue_money']; // 當前推薦人的金幣餘額
                    $record8["UG_dataType"] = 'tdj'; // 金幣轉出
                    $record8["UG_note"]     = "国籍大使收益"; // 推薦獎說明
                    $record8["enUG_note"]   = "Income of ambassador";
                    $record8["UG_getTime"]  = date('Y-m-d H:i:s', time()); //操作時間
                    //$record3["UG_othraccount"] = $result['ue_truename'];
                    $record8["nickname"] = $djmoney['ue_truename'];
                    $reg4                = M('userget')->add($record8);

                }

                $respond['status'] = 1;
                $respond['msg']    = '订单已完成。';
                $jydate            = M('ppdd')->order('jydate desc')->find();

                $maps['date']  = time();
                $maps['price'] = $jydate['danjia'];
                M('date')->add($maps);
                $this->ajaxReturn($respond);
            }

        }

    }
    public function encswancheng()
    {
        $data_P = $_GET['id'];
        $result = M('ppdd')->where(array('id' => $data_P))->find();

        if ($result['p_user'] == $_SESSION['uname']) {
            $djmoney = M('user')->where(array('UE_account' => $result['p_user']))->find();
            $zz      = M('ppdd')->where(array('g_user' => $result['g_user'], 'zt' => 1))->find();
            if ($zz) {
                $obs = M('user')->where(array('UE_account' => $result['p_user']))->setDec('djmoney', $djmoney['djmoney']);
                $oob = M('user')->where(array('UE_account' => $result['g_user']))->setInc('UE_money', $result['lkb']);
            }
            $re = M('ppdd')->where(array('g_user' => $result['g_user'], 'zt' => 1))->data(array('zt' => 2))->save();
            if ($oob && $obs && $re) {
                $respond['status'] = 1;
                $respond['msg']    = 'Order completed';
                //分红金额
                $fenhong = $djmoney['djmoney'] - $result['lkb'];
                $count   = M('user')->where(array('level' => 2))->count();
                $fh      = $fenhong / $count;
                $fh      = $fh * $settings['hzlv'];
                $level   = M('user')->where(array('level' => 2))->select(); //一代

                foreach ($level as $v) {
                    $result1                = M('user')->where(array('UE_account' => $v['ue_account']))->find();
                    $sj                     = M('user')->where(array('UE_account' => $v['ue_account']))->setInc('UE_money', $fh);
                    $resu                   = M('user')->where(array('UE_account' => $v['ue_account']))->find();
                    $record3["UG_account"]  = $v['ue_account']; // 登入轉出賬戶
                    $record3["UG_type"]     = 'lkb';
                    $record3["UG_allGet"]   = $result1['ue_money']; // 金幣
                    $record3["UG_money"]    = '+' . $fh; //
                    $record3["UG_balance"]  = $resu['ue_money']; // 當前推薦人的金幣餘額
                    $record3["UG_dataType"] = 'tdj'; // 金幣轉出
                    $record3["UG_note"]     = "会长收益"; // 推薦獎說明
                    $record3["enUG_note"]   = "President earnings";
                    $record3["UG_getTime"]  = date('Y-m-d H:i:s', time()); //操作時間
                    //$record3["UG_othraccount"] = $result['ue_truename'];
                    $record3["nickname"] = $djmoney['ue_truename'];
                    $reg4                = M('userget')->add($record3);

                }
                //创业大使
                $count1 = M('user')->where(array('level' => 3))->count();
                $fh     = $fenhong / $count1;
                $fh     = $fh * $settings['cylv'];
                $level  = M('user')->where(array('level' => 3))->select(); //一代

                foreach ($level as $v) {
                    $result1                = M('user')->where(array('UE_account' => $v['ue_account']))->find();
                    $sj                     = M('user')->where(array('UE_account' => $v['ue_account']))->setInc('UE_money', $fh);
                    $resu                   = M('user')->where(array('UE_account' => $v['ue_account']))->find();
                    $record5["UG_account"]  = $v['ue_account']; // 登入轉出賬戶
                    $record5["UG_type"]     = 'lkb';
                    $record5["UG_allGet"]   = $result1['ue_money']; // 金幣
                    $record5["UG_money"]    = '+' . $fh; //
                    $record5["UG_balance"]  = $resu['ue_money']; // 當前推薦人的金幣餘額
                    $record5["UG_dataType"] = 'tdj'; // 金幣轉出
                    $record5["UG_note"]     = "创业大使收益"; // 推薦獎說明
                    $record5["enUG_note"]   = "Entrepreneurial income";
                    $record5["UG_getTime"]  = date('Y-m-d H:i:s', time()); //操作時間
                    //$record3["UG_othraccount"] = $result['ue_truename'];
                    $record5["nickname"] = $djmoney['ue_truename'];
                    $reg4                = M('userget')->add($record5);

                }
                //环保大使
                $count2 = M('user')->where(array('level' => 4))->count();
                $fh     = $fenhong / $count2;
                $fh     = $fh * $settings['hblv'];
                $level  = M('user')->where(array('level' => 4))->select(); //一代

                foreach ($level as $v) {
                    $result1                = M('user')->where(array('UE_account' => $v['ue_account']))->find();
                    $sj                     = M('user')->where(array('UE_account' => $v['ue_account']))->setInc('UE_money', $fh);
                    $resu                   = M('user')->where(array('UE_account' => $v['ue_account']))->find();
                    $record6["UG_account"]  = $v['ue_account']; // 登入轉出賬戶
                    $record6["UG_type"]     = 'lkb';
                    $record6["UG_allGet"]   = $result1['ue_money']; // 金幣
                    $record6["UG_money"]    = '+' . $fh; //
                    $record6["UG_balance"]  = $resu['ue_money']; // 當前推薦人的金幣餘額
                    $record6["UG_dataType"] = 'tdj'; // 金幣轉出
                    $record6["UG_note"]     = "环保收益"; // 推薦獎說明
                    $record6["enUG_note"]   = "Environmental income";
                    $record6["UG_getTime"]  = date('Y-m-d H:i:s', time()); //操作時間
                    //$record3["UG_othraccount"] = $result['ue_truename'];
                    $record6["nickname"] = $djmoney['ue_truename'];
                    $reg4                = M('userget')->add($record6);

                }
                //国际大使
                $count3 = M('user')->where(array('level' => 5))->count();
                $fh     = $fenhong / $count3;
                $fh     = $fh * $settings['gjlv'];
                $level  = M('user')->where(array('level' => 5))->select(); //一代

                foreach ($level as $v) {
                    $result1                = M('user')->where(array('UE_account' => $v['ue_account']))->find();
                    $sj                     = M('user')->where(array('UE_account' => $v['ue_account']))->setInc('UE_money', $fh);
                    $resu                   = M('user')->where(array('UE_account' => $v['ue_account']))->find();
                    $record8["UG_account"]  = $v['ue_account']; // 登入轉出賬戶
                    $record8["UG_type"]     = 'lkb';
                    $record8["UG_allGet"]   = $result1['ue_money']; // 金幣
                    $record8["UG_money"]    = '+' . $fh; //
                    $record8["UG_balance"]  = $resu['ue_money']; // 當前推薦人的金幣餘額
                    $record8["UG_dataType"] = 'tdj'; // 金幣轉出
                    $record8["UG_note"]     = "国籍大使收益"; // 推薦獎說明
                    $record8["enUG_note"]   = "Income of ambassador";
                    $record8["UG_getTime"]  = date('Y-m-d H:i:s', time()); //操作時間
                    //$record3["UG_othraccount"] = $result['ue_truename'];
                    $record8["nickname"] = $djmoney['ue_truename'];
                    $reg4                = M('userget')->add($record8);

                }
                $jydate = M('ppdd')->order('jydate desc')->find();

                $maps['date']  = time();
                $maps['price'] = $jydate['danjia'];
                M('date')->add($maps);
                $this->ajaxReturn($respond);
            }

        }

    }
    public function wcjy()
    {

        $result = M('ppdd')->where(array('g_user' => $_SESSION['uname'], 'zt' => 1))->find(); //出售人信息
        if (!$result) {
            die("<script>alert('你暂无正在交易中的订单');history.back(-1);</script>");
        }
        $user = M('user')->where(array('UE_account' => $_SESSION['uname']))->find();
        $oob  = M('user')->where(array('UE_account' => $result['p_user']))->setInc('UE_money', $result['lkb']); //购币人信息
        $obs  = M('user')->where(array('UE_account' => $result['g_user']))->setDec('djmoney', $result['lkb']);
        $re   = M('ppdd')->where(array('g_user' => $_SESSION['uname'], 'zt' => 1))->data(array('zt' => 2))->save();
        if ($oob && $obs && $re) {
            die("<script>alert('交易已完成。。。');history.back(-1);</script>");
        }

    }
    public function quxiao()
    {
        $result = M('ppdd')->where(array('g_user' => $_SESSION['uname'], 'zt' => 1))->find(); //出售人信息
        if (!$result) {
            die("<script>alert('你暂无正在交易中的订单');history.back(-1);</script>");

        }
        $user = M('user')->where(array('UE_account' => $_SESSION['uname']))->find();
        $oob  = M('user')->where(array('UE_account' => $result['g_user']))->setInc('UE_money', $result['lkb']); //购币人信息
        $obs  = M('user')->where(array('UE_account' => $result['g_user']))->setDec('djmoney', $result['lkb']);
        $re   = M('ppdd')->where(array('g_user' => $_SESSION['uname'], 'zt' => 1))->data(array('zt' => 0, 'g_user' => '', 'g_name' => '', 'g_level' => ''))->save();
        if ($oob && $obs && $re) {
            die("<script>alert('交易已经取消。。。');history.back(-1);</script>");
        }
    }
    public function qiugouLKC()
    {
        $this->display();

    }
    public function enqiugoulkb()
    {

        $this->display();
    }

    public function shouchu()
    {
        $this->display();
    }
    public function enshouchu()
    {
        $this->display();
    }
    public function del()
    {
        $id = $_GET['id'];

        $oob  = M('ppdd')->where(array('id' => $id))->find();
        $oobs = M('user')->where(array('UE_account' => $oob['p_user']))->find();
        //dump($oobs);die();
        $inc    = M('user')->where(array('UE_account' => $oob['p_user']))->setInc('UE_money', $oobs['djmoney']);
        $dec    = M('user')->where(array('UE_account' => $oob['p_user']))->setDec('djmoney', $oobs['djmoney']);
        $result = M('ppdd')->where(array('id' => $id))->delete();
        if ($result && $inc && $dec) {
            $this->success("删除成功");
        }
    }
    public function endel()
    {
        $id = $_GET['id'];
        //echo "1111111";die();
        $oob  = M('ppdd')->where(array('id' => $id))->find();
        $oobs = M('user')->where(array('UE_account' => $oob['p_user']))->find();
        //dump($oobs);die();
        $inc    = M('user')->where(array('UE_account' => $oob['p_user']))->setInc('UE_money', $oobs['djmoney']);
        $dec    = M('user')->where(array('UE_account' => $oob['p_user']))->setDec('djmoney', $oobs['djmoney']);
        $result = M('ppdd')->where(array('id' => $id))->delete();
        if ($result && $inc && $dec) {
            $this->success("Delete success");
        }
    }
    public function delqiugou()
    {
        //echo "1111111";die();
        $id     = $_GET['id'];
        $result = M('ppdd')->where(array('id' => $id))->delete();
        if ($result) {
            $this->success("删除成功");
        }
    }
    public function endelqiugou()
    {
        //echo "1111111";die();
        $id     = $_GET['id'];
        $result = M('ppdd')->where(array('id' => $id))->delete();
        if ($result) {
            $this->success("删除成功");
        }
    }
    public function delete()
    {
        $id     = $_GET['id'];
        $result = M('ppdd')->where(array('id' => $id))->delete();
        if ($result) {
            $this->success("删除成功");
        }
    }
    public function yanzheng()
    {
        $name = I('post.uname');
        //dump($name);die();
        if (IS_AJAX) {
            $user1 = M();
            //! $this->check_verify ( I ( 'post.yzm' ) )
            //! $user1->autoCheckToken ( $_POST )
            if (false) {

                $this->ajaxReturn(array('nr' => '验证码错误!', 'sf' => 0));
            } else {
                $addaccount = M('user')->where(array(UE_account => $name))->find();

                if (!$addaccount) {
                    $this->ajaxReturn(array('nr' => '用戶名不存在!', 'sf' => 0));
                } elseif ($addaccount['ue_truename'] == '') {
                    $this->ajaxReturn(array('nr' => '對方未設置名稱!', 'sf' => 0));
                } else {

                    $this->ajaxReturn($addaccount['ue_truename']);
                }
            }
        }
    }
    public function duihuan()
    {
        $data = $_POST['duihuan'];
        $ob   = M('user')->where(array('UE_ID' => $_SESSION['uid']))->find();
        $obb  = M('duihuanjf')->where(array('UE_ID' => $_SESSION['uid']))->order('id desc')->find();
        if ($data > $ob['ue_integral']) {
            die("<script>alert('申请兑换的额度不能大于积分总额！');history.back(-1);</script>");
        } elseif ($data <= 0) {
            die("<script>alert('申请兑换的额度必须大于0！');history.back(-1);</script>");
        } elseif (strstr($data, '.')) {
            die("<script>alert('申请兑换的额度必须为整数！');history.back(-1);</script>");
        } elseif ($obb['status'] == 1) {
            die("<script>alert('有尚未审核的申请，请检查！');history.back(-1);</script>");
        }
        $time  = date("Y-m-d H:i:s", time());
        $array = array('status' => 1,
            'UE_integral'           => $ob['ue_integral'] - $data,
            'UE_ID'                 => $ob['ue_id'],
            'duihuan_jf'            => $data,
            'duihuan_time'          => $time,
            'qq'                    => $ob['qq'],
            'weixin'                => $ob['weixin'],
            'zfb'                   => $ob['zfb'],
            'UE_account'            => $ob['ue_account'],
            'UE_theme'              => $ob['ue_theme'],
        );
        $ree = M('user')->where(array('UE_ID' => $_SESSION['uid']))->data(array('UE_integral' => $ob['ue_integral'] - $data))->save();
        $re  = M('duihuanjf')->where(array('UE_ID' => $_SESSION['uid']))->data($array)->add();
        if ($re && $ree) {
            $this->success('积分兑换成功，等待审核。', 'cwmx');
        } else {
            die("<script>alert('积分兑换失败，请检查！');history.back(-1);</script>");
        }

    }
    public function tixian()
    {
        $this->display();
    }
    public function tixians()
    {

        $settings = include dirname(APP_PATH) . '/User/Home/Conf/settings.php';
        $data     = $_POST['price'];
        $ob       = M('user')->where(array('UE_account' => $_SESSION['uname']))->find();
        $obb      = M('tixian')->where(array('UE_account' => $_SESSION['uname']))->order('id desc')->find();

        //die("<script>alert('帮助金额".$settings['supply_money_lower_limit']."-".$settings['supply_money_upper_limit'].",并且是100的倍数！');history.back(-1);</script>");

        if ($data > $ob['ue_money']) {
            die("<script>alert('申请提现的额度不能大于钱包总额！');history.back(-1);</script>");
        } elseif ($data < $settings['min_tixian_money']) {
            die("<script>alert('申请提现的额度必须大于" . $settings['min_tixian_money'] . "且为" . $settings['min_tixian_money'] . "的倍数！');history.back(-1);</script>");
        } elseif ($data % $settings['min_tixian_money'] > 0) {
            die("<script>alert('申请提现的额度必须大于" . $settings['min_tixian_money'] . "且为" . $settings['min_tixian_money'] . "的倍数！');history.back(-1);</script>");
        } elseif ($obb['status'] == 1) {
            die("<script>alert('有尚未审核的申请，请检查！');history.back(-1);</script>");
        }

        $time  = date("Y-m-d H:i:s", time());
        $array = array('status' => 1,
            'UE_money'              => $ob['ue_money'] - $data, //现金余额
            'UE_ID'                 => $ob['ue_id'],
            'duihuan_money'         => $data, //体现金额
            'duihuan_time'          => $time, //体现时间
            // 'qq'=>$ob['qq'],
            'weixin'                => $ob['weixin'],
            'zfb'                   => $ob['zfb'],
            'UE_account'            => $ob['ue_account'],
            //'UE_theme'=>$ob['ue_phone'],
            //'yhzh'=>$ob['yhzh'],
            //'yhmc'=>$ob['yhmc'],
            'truename'              => $ob['ue_truename'],
            //'charge'=>$data*0.03,
            //'chongxiao'=>$data*0.05,
            //'true'=>$data*0.92,
        );
        $ree = M('user')->where(array('UE_account' => $_SESSION['uname']))->data(array('UE_money' => $ob['ue_money'] - $data))->save();
        $re  = M('tixian')->where(array('UE_account' => $_SESSION['uname']))->data($array)->add();
        if ($ree && $re) {
            die("<script>alert('体现成功，请等待管理员审核');history.back(-1);</script>");
        } else {
            die("<script>alert('体现失败，请稍后再试');history.back(-1);</script>");
        }

    }

    public function duihuanmoney()
    {
        $data = $_POST['duihuan1'];
        $oob  = M('user')->where(array('UE_accName' => $_SESSION['uname']))->count();
        // dump($oob);die();
        $ob  = M('user')->where(array('UE_ID' => $_SESSION['uid']))->find();
        $obb = M('tixian')->where(array('UE_ID' => $_SESSION['uid']))->order('id desc')->find();
        //dump($obb);
        //die();
        if ($data > $ob['ue_money']) {
            die("<script>alert('申请提现的额度不能大于钱包总额！');history.back(-1);</script>");
        } elseif ($data < 100) {
            die("<script>alert('申请提现的额度必须大于100且为100的倍数！');history.back(-1);</script>");
        } elseif ($data % 100 > 0) {
            die("<script>alert('申请提现的额度必须大于100且为100的倍数！');history.back(-1);</script>");
        } elseif ($obb['status'] == 1) {
            die("<script>alert('有尚未审核的申请，请检查！');history.back(-1);</script>");
        } elseif ($oob < 5) {
            die("<script>alert('首层不够五人不能提现！');history.back(-1);</script>");

        }
        $money3 = $data * 0.1;
        $money5 = $data * 0.9;
        $time   = date("Y-m-d H:i:s", time());
        $array  = array('status' => 1,
            'UE_money'               => $ob['ue_money'] - $data,
            'UE_ID'                  => $ob['ue_id'],
            'duihuan_money'          => $data,
            'duihuan_time'           => $time,
            'qq'                     => $ob['qq'],
            'weixin'                 => $ob['weixin'],
            'zfb'                    => $ob['zfb'],
            'UE_account'             => $ob['ue_account'],
            'UE_theme'               => $ob['ue_phone'],
            'yhzh'                   => $ob['yhzh'],
            'yhmc'                   => $ob['yhmc'],
            'truename'               => $ob['ue_truename'],
            'tip'                    => $money3,
            'total'                  => $money5,
        );
        $ree     = M('user')->where(array('UE_ID' => $_SESSION['uid']))->data(array('UE_money' => $ob['ue_money'] - $data))->save();
        $re      = M('tixian')->where(array('UE_ID' => $_SESSION['uid']))->data($array)->add();
        $user_xz = M('user')->where(array('UE_ID' => $_SESSION['uid']))->find();

        /* $note3 = "奖金提现";
        $record3["UG_account"]=$_SESSION['uname'];//登入提现账户
        $record3["UG_type"] = 'jb';
        $record3["UG_allGet"]= $ob['ue_money'];//金币
        $record3["UG_money"]= $data;
        $record3["UG_balance"]=$user_xz['ue_money'];//当前推荐人的金币余额
        $record3["UG_dataType"]='jjtx';
        $record3["UG_note"]=$note3;//奖金提现说明
        $record3['status']=1;
        $record3['tid']=$re;
        $record3["UG_getTime"]=date('Y-m-d H:i:s',time());//操作时间
        $reg4=M('usergett')->add($record3); */
        $note3                  = "奖金提现";
        $record3["UG_account"]  = $_SESSION['uname']; //登入提现账户
        $record3["UG_type"]     = 'jb';
        $record3["UG_allGet"]   = $money3; //金币
        $record3["UG_money"]    = $data;
        $record3["UG_balance"]  = $money5; //当前推荐人的金币余额
        $record3["UG_dataType"] = 'jjtx';
        $record3["UG_note"]     = $note3; //奖金提现说明
        $record3['status']      = 1;
        $record3['tid']         = $re;
        $record3["UG_getTime"]  = date('Y-m-d H:i:s', time()); //操作时间
        $reg4                   = M('usergett')->add($record3);

        if ($re && $ree) {
            $this->success('申请提现成功，等待审核。', 'cwmx');
        } else {
            die("<script>alert('申请提现失败，请检查！');history.back(-1);</script>");
        }

    }
    public function gwjzs()
    {
        if (IS_POST) {
            $num   = I('post.recive_num');
            $users = I('post.recive_name');
            $user  = M('user')->where(array('UE_account' => $users))->find();
            $self  = M('user')->where(array('UE_account' => $_SESSION['uname']))->find();
            $self1 = M('user')->where(array('UE_account' => $users))->find();
            $num   = ($num > $self['ggf']) ? 0 : $num;
            if ($num && $user) {

                $ree                       = M('user')->where(array('UE_ID' => $_SESSION['uid']))->setDec('ggf', $num);
                $re                        = M('user')->where(array('UE_account' => $user['ue_account']))->setInc('ggf', $num);
                $ree2                      = M('user')->where(array('UE_ID' => $_SESSION['uid']))->find();
                $note3                     = "购物券转送";
                $record3["UG_account"]     = $_SESSION['uname'];
                $record3["UG_othraccount"] = $users;
                $record3["UG_type"]        = 'gwj';
                $record3["UG_allGet"]      = $self['ggf']; //购物券
                $record3["UG_money"]       = '-' . $num;
                $record3["UG_balance"]     = $ree2['ggf']; //当前推荐人的购物卷余额
                $record3["UG_dataType"]    = 'gwjzs';
                $record3["UG_note"]        = $note3; //奖金提现说明
                $record3["UG_getTime"]     = date('Y-m-d H:i:s', time()); //操作时间
                $reg4                      = M('usergett')->add($record3);

                $ree3                      = M('user')->where(array('UE_account' => $users))->find();
                $note4                     = "购物券转送";
                $record4["UG_account"]     = $users;
                $record4["UG_othraccount"] = $_SESSION['uname'];
                $record4["UG_type"]        = 'gwj';
                $record4["UG_allGet"]      = $self1['ggf']; //购物券
                $record4["UG_money"]       = '+' . $num;
                $record4["UG_balance"]     = $ree3['ggf']; //当前推荐人的购物卷余额
                $record4["UG_dataType"]    = 'gwjzs';
                $record4["UG_note"]        = $note4; //奖金提现说明
                $record4["UG_getTime"]     = date('Y-m-d H:i:s', time()); //操作时间
                $reg5                      = M('usergett')->add($record4);

                $this->success('转送成功！');
            } else {
                $this->error('转送失败！请确认账号信息及余额！');
            }
        }
    }
    public function jjzb()
    {
        // dump($_POST);die();
        $data    = $_POST['PickupCount'];
        $type    = $_POST['zhflag'];
        $ob      = M('user')->where(array('UE_ID' => $_SESSION['uid']))->find();
        $user_zq = M('user')->where(array('UE_ID' => $_SESSION['uid']))->find();

        if ($type == 0) {
            if ($data > $ob['ue_money']) {
                die("<script>alert('申请转换的额度不能大于奖金总额！');history.back(-1);</script>");
            }
            $re   = M('user')->where(array('UE_ID' => $_SESSION['uid']))->setInc('ggf', $data);
            $ree  = M('user')->where(array('UE_ID' => $_SESSION['uid']))->setDec('UE_money', $data);
            $ree1 = M('user')->where(array('UE_ID' => $_SESSION['uid']))->find();

            $note3                  = "奖金转购物券";
            $record3["UG_account"]  = $_SESSION['uname']; //登入转换账户
            $record3["UG_type"]     = 'jb';
            $record3["UG_allGet"]   = $user_zq['ue_money']; //金币
            $record3["UG_money"]    = '-' . $data;
            $record3["UG_balance"]  = $ree1['ue_money']; //当前推荐人的金币余额
            $record3["UG_dataType"] = 'jjzh';
            $record3["UG_note"]     = $note3; //奖金提现说明
            $record3["UG_getTime"]  = date('Y-m-d H:i:s', time()); //操作时间
            $reg4                   = M('usergett')->add($record3);

            if ($re && $ree) {
                $this->success('奖金转换成功.', 'cwmx');
            } else {
                die("<script>alert('奖金转换失败，请检查！');history.back(-1);</script>");
            }
        }
        if ($type == 1) {
            if ($data > $ob['ue_money']) {
                die("<script>alert('申请转换的额度不能大于奖金总额！');history.back(-1);</script>");
            }
            $re   = M('user')->where(array('UE_ID' => $_SESSION['uid']))->setInc('UE_integral', $data);
            $ree  = M('user')->where(array('UE_ID' => $_SESSION['uid']))->setDec('UE_money', $data);
            $ree1 = M('user')->where(array('UE_ID' => $_SESSION['uid']))->find();

            $note3                  = "奖金转购物积分";
            $record3["UG_account"]  = $_SESSION['uname']; //登入转换账户
            $record3["UG_type"]     = 'jb';
            $record3["UG_allGet"]   = $user_zq['ue_money']; //金币
            $record3["UG_money"]    = '-' . $data;
            $record3["UG_balance"]  = $ree1['ue_money']; //当前推荐人的金币余额
            $record3["UG_dataType"] = 'jjzhjf';
            $record3["UG_note"]     = $note3; //奖金提现说明
            $record3["UG_getTime"]  = date('Y-m-d H:i:s', time()); //操作时间
            $reg4                   = M('usergett')->add($record3);
            if ($re && $ree) {
                $this->success('奖金转换成功.', 'cwmx');
            } else {
                die("<script>alert('奖金转换失败，请检查！');history.back(-1);</script>");
            }
        }
        if ($type == 2) {
            $resul = M('user')->where(array('UE_ID' => $_SESSION['uid']))->find();

            if ($resul['ggf'] < $data) {
                die("<script>alert('购物券余额不足');history.back(-1);</script>");
            }
            $result  = M('user')->where(array('UE_ID' => $_SESSION['uid']))->setInc('UE_integral', $data);
            $result1 = M('user')->where(array('UE_ID' => $_SESSION['uid']))->setDec('ggf', $data);
            $result2 = M('user')->where(array('UE_ID' => $_SESSION['uid']))->find();
            // if($resul['ggf']<$data){
            //     die("<script>alert('购物券余额不足');history.back(-1);</script>");
            // }
            $note3                  = "购物券转积分";
            $record3["UG_account"]  = $_SESSION['uname']; //登入转换账户
            $record3["UG_type"]     = 'jb';
            $record3["UG_allGet"]   = $resul['ggf']; //金币
            $record3["UG_money"]    = '-' . $data;
            $record3["UG_balance"]  = $result2['ggf']; //当前推荐人的金币余额
            $record3["UG_dataType"] = 'gwqzhjf';
            $record3["UG_note"]     = $note3; //奖金提现说明
            $record3["UG_getTime"]  = date('Y-m-d H:i:s', time()); //操作时间
            $reg4                   = M('usergett')->add($record3);

            if ($result && $result1) {
                $this->success('购物券转积分成功', 'cwmx');
                // die("<script>alert('购物券转积分成功');history.back(-1);</script>");
            } else {
                die("<script>alert('购物券转积分失败');history.back(-1);</script>");
            }
        }
    }
    public function xgmm()
    {
        $userData = M('user')->where(array(
            'UE_ID' => $_SESSION['uid'],
        ))->find();
        $this->userData = $userData;
        $this->display('xgmm');
    }
    public function xgmme()
    {
        $userData = M('user')->where(array(
            'UE_ID' => $_SESSION['uid'],
        ))->find();
        $this->userData = $userData;
        $this->display('xgmme');
    }
    public function bdmb()
    {
        $userData = M('user')->where(array(
            'UE_ID' => $_SESSION['uid'],
        ))->find();
        $this->userData = $userData;
        if ($userData['ue_question'] == '') {
            $this->display('bdmb');
        } else {
            $this->display('xgmb');
        }
    }
    public function xgmb()
    {
        $userData = M('user')->where(array(
            'UE_ID' => $_SESSION['uid'],
        ))->find();
        $this->userData = $userData;
        $this->display('xgmb');
    }
    public function addskzh()
    {
        $userData = M('user')->where(array(
            'UE_ID' => $_SESSION['uid'],
        ))->find();
        $this->userData = $userData;
        $this->display('addskzh');
    }
    public function skzh()
    {
        $userData = M('user')->where(array(
            'UE_ID' => $_SESSION['uid'],
        ))->find();
        $caution = M('userinfo')->where(array(
            'UI_userID' => $_SESSION['uid'],
        ))->order('UI_ID DESC')->select();
        $this->caution = $caution;
        //dump($caution);die;
        $this->userData = $userData;
        $this->display('skzh');
    }

    public function skzhdl()
    {
        if (!preg_match('/^[0-9]{1,10}$/', I('get.id'))) {
            $this->success('非法操作,將凍結賬號!');
        } else {
            $userinfo = M('userinfo')->where(array('UI_ID' => I('get.id')))->find();
            if ($userinfo['ui_userid'] != $_SESSION['uid']) {
                $this->success('非法操作,將凍結賬號!');
            } else {
                $reg = M('userinfo')->where(array('UI_ID' => I('get.id')))->delete();
                if ($reg) {
                    $this->success('刪除成功!');
                } else {
                    $this->success('刪除失敗!');
                }
            }
        }
    }

    public function ejmm()
    {
        $this->display('ejmm');
    }
    public function ejmmcl()
    {
        //echo $_SESSION['url'];die;
        if (IS_POST) {
            $data_P     = I('post.');
            $addaccount = M('user')->where(array(UE_account => $_SESSION['uname']))->find();
            //dump($addaccount['ue_secpwd']);
            //dump(md5($data_P['ejmmqr']));
            //die;
            if ($addaccount['ue_secpwd'] != md5($data_P['ejmmqr'])) {
                $this->error('二級密碼不正確!');
            } else {
                $_SESSION['ejmmyz'] = $addaccount['ue_secpwd'];
                //    echo ;die;
                $this->success('驗證成功', $_SESSION['url']);
            }
        }

    }
    public function xgzlcl()
    {
        if (IS_POST) {
            $data_P = I('post.');

            $userxx = M('user')->where(array('UE_account' => $_SESSION['uname']))->find();
            if ($userxx['ue_secpwd'] != md5($data_P['trade_pwd2'])) {
                die("<script>alert('二级密码输入有误！');history.back(-1);</script>");
            } else {

                $data_up['adress'] = $data_P['adress'];
                $data_up['yhmc']   = $data_P['bank_name'];
                //$data_up['zhxm'] = $data_P['bank_user'];
                $data_up['yhzh']        = $data_P['bank_number'];
                $data_up['UE_truename'] = $data_P['truename'];
                //$data_up['khzh'] = $data_P['khzh'];
                $data_up['UE_phone'] = $data_P['alipay'];
                $reg                 = M('user')->where(array('UE_account' => $_SESSION['uname']))->save($data_up);

                if ($reg) {
                    die("<script>alert('修改成功！');history.back(-1);</script>");
                } else {
                    die("<script>alert('修改失败！');history.back(-1);</script>");
                }
            }
        }
    }

    public function xgyjmmcl()
    {

        if (IS_AJAX) {
            $data_P = I('post.');
            //dump($data_P);die;
            //$this->ajaxReturn($data_P['ymm']);die;
            //$user = M ( 'user' )->where ( array (
            //        UE_account => $_SESSION ['uname']
            //) )->find ();

            $user1 = M();
            //! $this->check_verify ( I ( 'post.yzm' ) )
            //! $user1->autoCheckToken ( $_POST )
            if (!preg_match('/^[a-zA-Z0-9]{1,15}$/', $data_P['xmm'])) {
                $this->ajaxReturn(array('nr' => '新密碼6-12個字元,大小寫英文+數字,請勿用特殊詞符！', 'sf' => 0));
            } elseif ($data_P['xmm'] != $data_P['xmmqr']) {
                $this->ajaxReturn(array('nr' => '新密碼兩次輸入不一致!', 'sf' => 0));
            } elseif ($data_P['ymm'] == $data_P['xmm']) {
                $this->ajaxReturn(array('nr' => '原密碼和新密碼不能相同!', 'sf' => 0));
            } else {
                $addaccount = M('user')->where(array(UE_account => $_SESSION['uname']))->find();

                if ($addaccount['ue_password'] != md5($data_P['ymm'])) {
                    $this->ajaxReturn(array('nr' => '原密碼不正確!', 'sf' => 0));
                } else {

                    $reg = M('user')->where(array(
                        'UE_ID' => $_SESSION['uid'],
                    ))->save(array('UE_password' => md5($data_P['xmm'])));

                    if ($reg) {
                        $this->ajaxReturn(array('nr' => '修改成功!', 'sf' => 0));
                    } else {
                        $this->ajaxReturn(array('nr' => '修改失敗!', 'sf' => 0));
                    }
                }
            }
        }
    }

    public function addskzhcl()
    {

        if (IS_AJAX) {
            $data_P = I('post.');
            //dump($data_P);
            //$this->ajaxReturn($data_P['ymm']);die;
            //$user = M ( 'user' )->where ( array (
            //        UE_account => $_SESSION ['uname']
            //) )->find ();

            $user1 = M();
            //! $this->check_verify ( I ( 'post.yzm' ) )
            //! $user1->autoCheckToken ( $_POST )
            if (!$this->check_verify(I('post.yzm'))) {

                $this->ajaxReturn(array('nr' => '驗證碼錯誤!', 'sf' => 0));
            } elseif (strlen($data_P['skfs']) > 13 || strlen($data_P['skfs']) < 6) {
                $this->ajaxReturn(array('nr' => '請選擇收款方式!', 'sf' => 0));
            } elseif (!preg_match('/^[0-9]{6,30}$/', $data_P['skzh'])) {
                $this->ajaxReturn(array('nr' => '收款賬號為數字6-30位！', 'sf' => 0));
            } elseif (strlen($data_P['khh']) > 60 || strlen($data_P['khh']) < 6) {
                $this->ajaxReturn(array('nr' => '開戶支行中文字數2-20字!', 'sf' => 0));
            } else {

                //    if ($addaccount['ue_password']<>md5($data_P['ymm'])) {
                //    $this->ajaxReturn ( array ('nr' => '原密碼不正確!','sf' => 0 ) );
                if (!$user1->autoCheckToken($_POST)) {
                    $this->ajaxReturn(array('nr' => '新勿重複提交,請刷新頁面!', 'sf' => 0));
                } else {
                    $addaccount = M('user')->where(array(UE_account => $_SESSION['uname']))->find();

                    $data_up['UI_userID']     = $_SESSION['uid'];
                    $data_up['UI_time']       = date('Y-m-d H:i:s', time());
                    $data_up['UI_realName']   = $addaccount['ue_truename'];
                    $data_up['UI_payaccount'] = $data_P['skzh'];
                    $data_up['UI_payStyle']   = $data_P['skfs'];
                    $data_up['UI_isindex']    = I('post.sfqy', 0, '/^[1]{1}$/');
                    $data_up['UI_opendress']  = $data_P['khh'];
                    $reg                      = M('userinfo')->add($data_up);
                    //    $reg = M ( 'user' )->where ( array (
                    //            'UE_ID' => $_SESSION ['uid']
                    //    ) )->save (array('UE_password'=>md5($data_P['xmm'])));

                    //dump($data_up);

                    if ($reg) {
                        $this->ajaxReturn('添加成功!');
                    } else {
                        $this->ajaxReturn('添加失敗!');
                    }
                }
            }
        }
    }

    public function xgejmmcl()
    {

        if (IS_POST) {
            $data_P = I('post.');
            //dump($data_P);die;
            //$this->ajaxReturn($data_P['ymm']);die;
            //$user = M ( 'user' )->where ( array (
            //        UE_account => $_SESSION ['uname']
            //) )->find ();

            $user1 = M();
            //! $this->check_verify ( I ( 'post.yzm' ) )
            //! $user1->autoCheckToken ( $_POST )
            if (!preg_match('/^[a-zA-Z0-9]{1,15}$/', $data_P['xejmm'])) {
                //$this->ajaxReturn ( array ('nr' => '新二级密碼6-12個字元,大小寫英文+數字,請勿用特殊詞符！','sf' => 0 ) );
                die("<script>alert('新二级密碼6-12個字元,大小寫英文+數字,請勿用特殊詞符！');history.back(-1);</script>");
            } elseif ($data_P['xejmm'] != $data_P['xejmmqr']) {
                //$this->ajaxReturn ( array ('nr' => '新二级密碼兩次輸入不一致!','sf' => 0 ) );
                die("<script>alert('新二级密碼兩次輸入不一致！');history.back(-1);</script>");
            } elseif ($data_P['yejmm'] == $data_P['xejmm']) {
                //$this->ajaxReturn ( array ('nr' => '原二级密碼和新密碼不能相同!','sf' => 0 ) );
                die("<script>alert('原二级密碼和新密碼不能相同！');history.back(-1);</script>");
            } else {
                $addaccount = M('user')->where(array(UE_account => $_SESSION['uname']))->find();

                if ($addaccount['ue_secpwd'] != md5($data_P['yejmm'])) {
                    //$this->ajaxReturn ( array ('nr' => '原二级密碼不正確!','sf' => 0 ) );
                    die("<script>alert('原二级密碼不正確！');history.back(-1);</script>");
                } else {

                    $reg = M('user')->where(array(
                        'UE_ID' => $_SESSION['uid'],
                    ))->save(array('UE_secpwd' => md5($data_P['xejmm'])));

                    if ($reg) {
                        //$this->ajaxReturn ( array ('nr' => '修改成功!','sf' => 0 ));
                        die("<script>alert('修改成功!');history.back(-1);</script>");
                    } else {
                        //$this->ajaxReturn ( array ('nr' => '修改失敗!','sf' => 0 ) );
                        die("<script>alert('修改失敗！');history.back(-1);</script>");
                    }
                }
            }
        }
    }

    public function bdmbadd()
    {

        if (IS_AJAX) {
            $data_P = I('post.');
            //dump($data_P);die;
            //$this->ajaxReturn($data_P['ymm']);die;
            //$user = M ( 'user' )->where ( array (
            //        UE_account => $_SESSION ['uname']
            //) )->find ();

            $user1 = M();
            //! $this->check_verify ( I ( 'post.yzm' ) )
            //! $user1->autoCheckToken ( $_POST )
            if (!$this->check_verify(I('post.yzm'))) {

                $this->ajaxReturn(array('nr' => '驗證碼錯誤!', 'sf' => 0));
            } elseif ($data_P['wt1'] == '0' || $data_P['wt2'] == '0' || $data_P['wt3'] == '0') {
                $this->ajaxReturn(array('nr' => '請選擇問題!', 'sf' => 0));
            } elseif ($data_P['wt1'] == $data_P['wt2'] || $data_P['wt1'] == $data_P['wt3'] || $data_P['wt2'] == $data_P['wt3']) {
                $this->ajaxReturn(array('nr' => '密保問題不能相同!', 'sf' => 0));
            } elseif (strlen($data_P['wt1']) > 60 || strlen($data_P['wt2']) > 60 || strlen($data_P['wt3']) > 60) {
                $this->ajaxReturn(array('nr' => '問題格式不對!', 'sf' => 0));
            } elseif (strlen($data_P['da1']) > 20 || strlen($data_P['da2']) > 20 || strlen($data_P['da3']) > 20) {
                $this->ajaxReturn(array('nr' => '答案1-10個字！', 'sf' => 0));
            } elseif (strlen($data_P['da1']) < 1 || strlen($data_P['da2']) < 1 || strlen($data_P['da3']) < 1) {
                $this->ajaxReturn(array('nr' => '答案1-10個字！', 'sf' => 0));
            } elseif (!$user1->autoCheckToken($_POST)) {
                $this->ajaxReturn(array('nr' => '新勿重複提交,請刷新頁面!', 'sf' => 0));
            } else {
                $addaccount = M('user')->where(array(UE_account => $_SESSION['uname']))->find();

                if ($addaccount['ue_question'] != '') {
                    $this->ajaxReturn(array('nr' => '您已經設置過密保!', 'sf' => 0));
                    //}elseif(false){
                    //    $this->ajaxReturn ( array ('nr' => '新勿重複提交,請刷新頁面!','sf' => 0 ) );
                } else {

                    $data_up['UE_question']  = $data_P['wt1'];
                    $data_up['UE_question2'] = $data_P['wt2'];
                    $data_up['UE_question3'] = $data_P['wt3'];
                    $data_up['UE_answer']    = $data_P['da1'];
                    $data_up['UE_answer2']   = $data_P['da2'];
                    $data_up['UE_answer3']   = $data_P['da3'];

                    $reg = M('user')->where(array(
                        'UE_ID' => $_SESSION['uid'],
                    ))->save($data_up);

                    if ($reg) {
                        $this->ajaxReturn(array('nr' => '綁定成功!', 'sf' => 0));
                    } else {
                        $this->ajaxReturn(array('nr' => '綁定失敗!', 'sf' => 0));
                    }
                }
            }
        }
    }

    public function xgmbadd()
    {

        if (IS_AJAX) {
            $data_P = I('post.');
            //dump($data_P);die;
            //$this->ajaxReturn($data_P['ymm']);die;
            //$user = M ( 'user' )->where ( array (
            //        UE_account => $_SESSION ['uname']
            //) )->find ();

            $user1 = M();
            //! $this->check_verify ( I ( 'post.yzm' ) )
            //! $user1->autoCheckToken ( $_POST )
            $addaccount = M('user')->where(array(UE_account => $_SESSION['uname']))->find();
            if (!$this->check_verify(I('post.yzm'))) {
                $this->ajaxReturn(array('nr' => '驗證碼錯誤!', 'sf' => 0));
            } elseif ($addaccount['ue_question'] == '') {
                $this->ajaxReturn(array('nr' => '您從未綁定過密保,請先綁定保密!', 'sf' => 0));
            } elseif ($addaccount['ue_answer'] != $data_P['yda1'] || $addaccount['ue_answer2'] != $data_P['yda2'] || $addaccount['ue_answer3'] != $data_P['yda3']) {
                $this->ajaxReturn(array('nr' => '原密保答案不正確!', 'sf' => 0));
            } elseif ($data_P['wt1'] == '0' || $data_P['wt2'] == '0' || $data_P['wt3'] == '0') {
                $this->ajaxReturn(array('nr' => '請選擇新保密問題!', 'sf' => 0));
            } elseif ($data_P['wt1'] == $data_P['wt2'] || $data_P['wt1'] == $data_P['wt3'] || $data_P['wt2'] == $data_P['wt3']) {
                $this->ajaxReturn(array('nr' => '新保密問題不能相同!', 'sf' => 0));
            } elseif (strlen($data_P['wt1']) > 60 || strlen($data_P['wt2']) > 60 || strlen($data_P['wt3']) > 60) {
                $this->ajaxReturn(array('nr' => '新保密問題格式不對!', 'sf' => 0));
            } elseif (strlen($data_P['da1']) > 20 || strlen($data_P['da2']) > 20 || strlen($data_P['da3']) > 20) {
                $this->ajaxReturn(array('nr' => '新保密答案1-10個字！', 'sf' => 0));
            } elseif (strlen($data_P['da1']) < 1 || strlen($data_P['da2']) < 1 || strlen($data_P['da3']) < 1) {
                $this->ajaxReturn(array('nr' => '新保密答案1-10個字！', 'sf' => 0));
            } elseif (false) {
                $this->ajaxReturn(array('nr' => '新勿重複提交,請刷新頁面!', 'sf' => 0));
            } else {

                //if ($addaccount['ue_question']<>'') {
                //    $this->ajaxReturn ( array ('nr' => '您已經設置過密保!','sf' => 0 ) );
                //}elseif(false){
                //    $this->ajaxReturn ( array ('nr' => '新勿重複提交,請刷新頁面!','sf' => 0 ) );
                //} else {

                $data_up['UE_question']  = $data_P['wt1'];
                $data_up['UE_question2'] = $data_P['wt2'];
                $data_up['UE_question3'] = $data_P['wt3'];
                $data_up['UE_answer']    = $data_P['da1'];
                $data_up['UE_answer2']   = $data_P['da2'];
                $data_up['UE_answer3']   = $data_P['da3'];

                $reg = M('user')->where(array(
                    'UE_ID' => $_SESSION['uid'],
                ))->save($data_up);

                if ($reg) {
                    $this->ajaxReturn(array('nr' => '修改成功!', 'sf' => 0));
                } else {
                    $this->ajaxReturn(array('nr' => '修改失敗!', 'sf' => 0));
                }
                //}
            }
        }
    }

    public function cwmxx()
    {
        //奖金提现记录
        $user = M(usergett); //实例化user对象
        // dump($user);die();
        $map['UG_dataType'] = jjtx;
        $map['UG_account']  = session('uname');
        $count              = $user->where($map)->count();
        $p1                 = getpage($count, 10);
        $list1              = $user->where($map)->order('UG_ID DESC')->limit($p1->firstRow, $p1->listRows)->select();
        $this->assign('list1', $list1); //赋值数据集
        $this->assign('page1', $p1->show()); //赋值分页输出

        //奖金转换记录
        $a                   = 'jjzh';
        $b                   = 'jjzhjf';
        $c                   = 'gwqzhjf';
        $map1['UG_dataType'] = array(array('eq', $a), array('eq', $b), array('eq', $c), 'or');
        //$map1['UG_dataType']=jjzh;
        //$map2['UG_dataType']=jjzhjf;
        $map1['UG_account'] = session('uname');
        $count1             = $user->where(array('UG_dataType' => $map1['UG_dataType']))->count();
        //dump($count1);die();
        $p2    = getpage($count1, 10);
        $list2 = $user->where($map1)->order('UG_ID DESC')->limit($p2->firstRow, $p2->listRows)->select();
        $this->assign('list2', $list2); //赋值数据集
        $this->assign('page2', $p2->show()); //赋值分页输出

        //购物券赠送记录
        $map2['UG_dataType'] = gwjzs;
        $map2['UG_account']  = session('uname');
        $count2              = $user->where($map2)->count();
        // dump($count2);die;
        $p3    = getpage($count2, 10);
        $list3 = $user->where($map2)->order('UG_ID DESC')->limit($p3->firstRow, $p3->listRows)->select();
        $this->assign('list3', $list3); //赋值数据集
        $this->assign('page3', $p3->show()); //赋值分页输出
        // $this->display('cwmxx');

        //物流信息
        $model = M('shop_orderform');
        // dump($model);die();
        $map3['user'] = session('uname');
        $count3       = $model->where($map3)->count();
        $p4           = getpage($count3, 10);
        $list4        = $model->where($map3)->order('id DESC')->limit($p4->firstRow, $p4->listRows)->select();
        $this->assign('list4', $list4); //赋值数据集
        $this->assign('page4', $p4->show()); //赋值分页输出

        $this->display('cwmxx');

    }

    public function cwmx()
    {

        //////////////////----------
        if (!session('subPwd')) {
            $this->redirect('erjimima');
            return;
        }
        $User = M('user_jj'); // 實例化User對象

        $map1['user'] = $_SESSION['uname'];
        //$map1['zt']=3;
        $count1 = $User->where($map1)->count(); // 查詢滿足要求的總記錄數
        //$count2 = $User->where ($map1)->select();
        //dump($count2);
        //$page = new \Think\Page ( $count, 3 ); // 實例化分頁類 傳入總記錄數和每頁顯示的記錄數(25)

        $p1 = getpage($count1, 10);

        $list1 = $User->where($map1)->order('id DESC')->limit($p1->firstRow, $p1->listRows)->select();
        $this->assign('list1', $list1); // 賦值數據集
        $this->assign('page1', $p1->show()); // 賦值分頁輸出
        /////////////////----------------
        //dump($list1);die;
        //////////////////----------
        $User = M('user_jl'); // 實例化User對象

        $map2['user'] = $_SESSION['uname'];
        $map2['jb']   = 0;
        //$map2['jifen']=20;
        //$map2['jifen']!==0;
        $count2 = $User->where($map2)->count(); // 查詢滿足要求的總記錄數
        //$page = new \Think\Page ( $count, 3 ); // 實例化分頁類 傳入總記錄數和每頁顯示的記錄數(25)

        $p2 = getpage($count2, 10);
        $a1 = $User->where($map2)->select();
        //foreach ($a1 as $key => $v) {
        //
        //if($v['jifen']>0){
        //dump($v['jifen']);
        //$list2 = $User->where ( $map2 )->order ( 'id DESC' )->limit ( $p2->firstRow, $p2->listRows )->select ();
        $list2 = $User->where($map2)->order('id DESC')->limit($p2->firstRow, $p2->listRows)->select();
        //dump($list2);
        //}
        //}
        //if(!$a1['jifen']){
        //$list2 = $User->where ( $map2 )->order ( 'id DESC' )->limit ( $p2->firstRow, $p2->listRows )->select ();}
        $this->assign('list2', $list2); // 賦值數據集
        $this->assign('page2', $p2->show()); // 賦值分頁輸出
        /////////////////----------------

        //////////////////----------
        $User = M('userget'); // 實例化User對象

        $map['UG_account'] = $_SESSION['uname'];
        // $map['UG_type']=jb;
        $count = $User->where($map)->count(); // 查詢滿足要求的總記錄數
        //$page = new \Think\Page ( $count, 3 ); // 實例化分頁類 傳入總記錄數和每頁顯示的記錄數(25)

        $p = getpage($count, 10);

        $list = $User->where($map)->order('UG_ID DESC')->limit($p->firstRow, $p->listRows)->select();
        // dump($list);die();
        $this->assign('list', $list); // 賦值數據集
        $this->assign('page', $p->show()); // 賦值分頁輸出
        /////////////////----------------

        $userdata = M('user')->where(array(
            UE_account => $_SESSION['uname'],
        ))->find();
        $this->userdata = $userdata;

        $fenhong1 = M('userget')->where(array('UG_account' => $_SESSION['uname'], 'UG_dataType' => 'tjj'))->sum('UG_money');

        if ($fenhong1 == '') {$fenhong1 = '0';}
        //$fenhong2='600';
        $this->fenhong1 = $fenhong1;

        $fenhong2 = M('userget')->where(array('UG_account' => $_SESSION['uname'], 'UG_dataType' => 'jlj'))->sum('UG_money');

        if ($fenhong2 == '') {$fenhong2 = '0';}
        //$fenhong2='600';
        $this->fenhong2 = $fenhong2;

        $tree_model        = M('tree_record');
        $tree_limit['uid'] = $_SESSION['uid']; //用户ID
        $count             = $tree_model->where($tree_limit)->count(); // 查詢滿足要求的總記錄數
        //$page = new \Think\Page ( $count, 3 ); // 實例化分頁類 傳入總記錄數和每頁顯示的記錄數(25)
        C('VAR_PAGE', 'p4');
        $p4 = getpage($count, 10);

        $list4 = $tree_model->where($tree_limit)->order('addtime desc')->limit($p4->firstRow, $p4->listRows)->select();
        $this->assign('list4', $list4); // 賦值數據集
        $this->assign('page4', $p4->show()); // 賦值分頁輸出

        $this->display('cwmx');
    }
    public function subPass()
    {
        if (IS_POST) {
            $data['UE_ID']     = session('uid');
            $data['UE_secpwd'] = md5(I('post.subPass'));
            $sql               = M('User')->where($data)->find();
            if ($sql) {
                session('subPwd', $sql['ue_secpwd']);
                $this->redirect('cwmx');
            } else {
                $this->error('密码错误！');}
        }
    }

    public function tgbz_tx_cl()
    {

        if (I('get.id') != '') {
            $varid  = I('get.id');
            $proall = M('user_jj')->where(array('id' => $varid))->find();
            if (zt($varid) == '0' || $proall['zt'] == '1') {
                die("<script>alert('转出失败,时间没有大于15天或交易未完成！');history.back(-1);</script>");
            } else {

                $lx_he = user_jj_lx($varid) + $proall['jb'];

                $user_zq = M('user')->where(array('UE_ID' => $_SESSION['uid']))->find();
                M('user')->where(array('UE_ID' => $_SESSION['uid']))->setInc('UE_money', $lx_he);
                $user_xz = M('user')->where(array('UE_ID' => $_SESSION['uid']))->find();
                M('user_jj')->where(array('id' => $varid))->save(array('zt' => '1'));

                $note3                  = "提供帮助本金加利息";
                $record3["UG_account"]  = $_SESSION['uname']; // 登入轉出賬戶
                $record3["UG_type"]     = 'jb';
                $record3["UG_allGet"]   = $user_zq['ue_money']; // 金幣
                $record3["UG_money"]    = '+' . $lx_he; //
                $record3["UG_balance"]  = $user_xz['ue_money']; // 當前推薦人的金幣餘額
                $record3["UG_dataType"] = 'tgbz'; // 金幣轉出
                $record3["UG_note"]     = $note3; // 推薦獎說明
                $record3["UG_getTime"]  = date('Y-m-d H:i:s', time()); //操作時間
                $reg4                   = M('userget')->add($record3);

                die("<script>alert('提现转出成功.请刷新查看你的账户余额！');history.back(-1);</script>");
                //echo $lx_he;
            }

        }

    }

    public function pin()
    {

        //////////////////----------
        $User = M('pin'); // 實例化User對象

        $map1['user'] = $_SESSION['uname'];
        $count1       = $User->where($map1)->count(); // 查詢滿足要求的總記錄數
        //$page = new \Think\Page ( $count, 3 ); // 實例化分頁類 傳入總記錄數和每頁顯示的記錄數(25)

        $p1 = getpage($count1, 10);

        $list1 = $User->where($map1)->order('id DESC')->limit($p1->firstRow, $p1->listRows)->select();
        $this->assign('list1', $list1); // 賦值數據集
        $this->assign('page1', $p1->show()); // 賦值分頁輸出
        /////////////////----------------

        $this->pin_zs = M('pin')->where(array('user' => $_SESSION['uname'], 'zt' => 0))->count() + 0;

        $this->display('pin');
    }

    public function aab()
    {

        $arr = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10);
        $p   = 0;
        $tj  = count($arr);

        //$tj1=$tj;
        //$bba=array_slice($arr,0,1);
        //dump($bba);
        //die;
        //0,4

        for ($m = 0; $m < $tj; $m++) {

            for ($p = 2; $p + $m < $tj; $p++) {
                if ($tj - $m < $p) {break;} //1,4  5
                $bba = array_slice($arr, $m, 2);

                //echo $arr[$p].'</br>';
                $bba[] = $arr[$p + $m];

                foreach ($bba as $var) {
                    echo $var . '+';
                }

                //dump($bba);
                echo '=' . array_sum($bba) . '<br/>';
                //$bba=array();
            }
            //$tj1--;
            //$a=
            //$tj2=$tj1-1;
            //echo '------------<br>';

        }

        //die;

        for ($m = 0; $m < $tj; $m++) {

            for ($p = 2; $p <= $tj; $p++) {
                if ($tj - $m < $p) {break;} //1,4  5
                $bba = array_slice($arr, $m, $p);
                // dump($bba);
                foreach ($bba as $var) {
                    echo $var . '+';
                }

                echo '=' . array_sum($bba) . '<br/>';
                //$bba=array();
            }
            //$tj1--;
            //$a=
            //$tj2=$tj1-1;
            //echo '------------<br>';

        }

        die;

        sort($arr); //保证初始数组是有序的
        $last  = count($arr) - 1; //$arr尾部元素下标
        $x     = $last;
        $count = 1; //组合个数统计
        echo implode(',', $arr), "\n"; //输出第一种组合
        echo "<br/>";
        while (true) {
            $y = $x--; //相邻的两个元素
            if ($arr[$x] < $arr[$y]) {
                //如果前一个元素的值小于后一个元素的值
                $z = $last;
                while ($arr[$x] > $arr[$z]) {
                    //从尾部开始，找到第一个大于 $x 元素的值
                    $z--;
                }
                /* 交换 $x 和 $z 元素的值 */
                list($arr[$x], $arr[$z]) = array($arr[$z], $arr[$x]);
                /* 将 $y 之后的元素全部逆向排列 */
                for ($i = $last; $i > $y; $i--, $y++) {
                    list($arr[$i], $arr[$y]) = array($arr[$y], $arr[$i]);
                }
                echo implode(',', $arr), "\n"; //输出组合
                echo "<br/>";
                $x = $last;
                $count++;
            }
            if ($x == 0) {
                //全部组合完毕
                break;
            }
        }
        echo '组合个数： ', $count, "\n";
        //输出结果为：3628800个

        die;

        $xypipeije = 16;
        $data      = array(1, 2, 3, 4, 5, 6, 7, 8);
        $tj        = count($data);
        $sf_tcpp   = '0';

        for ($m = 0; $m < $tj; $m++) {

            for ($p = 0; $p < $tj - $m; $p++) {
                $data1[$m][$p] = $data[$m];

            }
        }
        $adsfdsaf = $data1[0];
        dump($adsfdsaf);die;

        for ($v = 0; $v < $tj; $v++) {

            for ($c = 0; $c < $tj; $c++) {
                echo $data[$v] + $data[$c + 1] . '<br>';

            }
        }

        die;

        for ($b = 0; $b < $tj; $b++) {

            if ($sf_tcpp == '1') {break;}
            $tj_j = $tj - 1;
            echo '===========<br>';
            for ($i = 0; $i < $tj; $i++) {
                if ($b < $i) {
                    $pipeihe = $data[$b] + $data[$tj_j];
                    if ($pipeihe == $xypipeije) {
                        echo $data[$b] . '+' . $data[$tj_j] . '<br>';
                        $sf_tcpp = '1';
                        break;
                    }

                    $tj_j--;
                }
            }
        }

    }

}
