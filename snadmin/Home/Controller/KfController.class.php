<?php
namespace Home\Controller;

use Think\Controller;

class KfController extends Controller
{
    public function fkj()
    {
        if (IS_POST) {
            $username = $_POST['username'];
            $p        = $_POST['p'];
            $num      = (int) $_POST['num'];
            if ($num <= 0) {
                $this->error('数量大于1');
            }
            $user = M('user')->where(array('UE_account' => $username))->find(); //上级用户
            if (!$user) {
                $this->error('用户不存在');
            }
            $yCode   = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J');
            $orderSn = $yCode[intval(date('Y')) - 2011] . date('d') . substr(time(), -5) . sprintf('%02d', rand(0, 99));
            $project = M('shop_project')->where(array('id' => $p))->find();
            if (!$project) {
                $this->error('矿机不存在');
            }
            for ($i = 1; $i <= $num; $i++) {
                $orderform        = M('shop_orderform');
                $map['user']      = $username;
                $map['project']   = $project['name'];
                $map['enproject'] = $project['enname'];
                $map['yxzq']      = $project['yxzq'];
                $map['sumprice']  = $project['price'];
                $map['addtime']   = date('Y-m-d H:i:s');
                $map['username']  = $user['ue_truename'];
                $map['imagepath'] = $project['imagepath'];
                $map['lixi']      = $project['fjed'];
                $map['qwsl']      = $project['qwsl'];
                $map['kjsl']      = $project['kjsl'];
                $map['kjbh']      = $orderSn;
                $map['uid']       = $$user['UE_ID'];
                $orderform->add($map);
            }
            $this->success('发放成功');
        }
        $re = M('shop_project')->field('jk_shop_project.*,jk_shop_leibie.name as pidname')->join('jk_shop_leibie ON jk_shop_project.pid = jk_shop_leibie.id')->page($_GET['p'], 12)->select();
        $this->assign('r', $re);
        return $this->display();
    }

    public function userdelete($user)
    {
        M('user')->where(array('UE_account' => $user))->delete();
        $this->success('删除成功');
    }

}
