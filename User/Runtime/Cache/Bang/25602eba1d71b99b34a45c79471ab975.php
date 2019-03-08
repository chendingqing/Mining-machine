<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1, minimum-scale=1.0"/>
    <meta content="telephone=no" name="format-detection">
    <title>交易大厅</title>
    <link href="/Public/bang/css/mui.min.css" rel="stylesheet"/>
    <link href="/Public/bang/css/kj_resert.css" rel="stylesheet"/>
    <link href="/Public/bang/css/kj_public.css" rel="stylesheet"/>
    <link href="/Public/bang/css/jiaoyizhongxin.css" rel="stylesheet"/>
    <style>
        table tbody tr td{
            font-size: 12px!important;
        }
        .button-d{
            background-color:#02d2f5;
            float: left;
            width: 100%;
            padding: 0;
            height: 30px;
            margin: 5px 0;
        }
    </style>
</head>
<body>
    <header class="mui-navbar-inner mui-bar mui-bar-nav" style="background: #31b4ff;">
        <h1 class="mui-title" style="color:#FFF;">交易中心</h1>
        <a href="<?php echo U('myjiaoyi');?>" class="left-icon">
            <img src="/Public/bang/images/head_back_icon.png"/>
        </a>
    </header>
    <div class="mui-content jyzx">
        <div class="func">
            <div class="nav">
                <span class="kj_flex-item  selected" data-txt="买入" data-number="请输入买入数量" data-money="请输入买入单价" data-url="<?php echo U('addqiugou');?>">买入AD</span>
                <span class="kj_flex-item" data-txt="卖出" data-number="请输入卖出数量" data-money="请输入卖出单价" data-url="<?php echo U('addchushou');?>">卖出AD</span>
            </div>
            <div class="nav-form">
                <form class="mui-input-group" method="post">
                    <div class="mui-input-row">
                        <label>数量</label>
                        <input type="text" name="number" id="form-number" class="mui-input-clear" placeholder="请输入买入数量">
                    </div>
                    <div class="mui-input-row">
                        <label>单价</label>
                        <input type="text" name="money" id="form-money" class="mui-input-password" placeholder="请输入买入单价">
                    </div>
                    <button type="button" class="mui-button-row jiaoyi-button" id="form-on" data-url="<?php echo U('addqiugou');?>">买入</button>
                </form>
            </div>
        </div>
        <div class="content">
            <div class="jyzx_table show">
                <table>
                    <thead>
                        <tr>
                            <td width="40%">昵称</td>
                            <!--<td>等级</td>-->
                            <td width="20%">个数</td>
                            <td width="20%">价格</td>
                            <td width="20%">状态</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(is_array($list)): foreach($list as $key=>$v): ?><tr>
                                <td width="40%"><?php echo ($v["p_name"]); ?></td>
                                <!--<td>
                                    <?php switch($v["p_level"]): case "0": ?>未激活<?php break;?>
                                        <?php case "1": ?>GEC矿工<?php break;?>
                                        <?php case "2": ?>工会会长<?php break;?>
                                        <?php case "3": ?>A成长大使<?php break;?>
                                        <?php case "4": ?>S形象大使<?php break;?>
                                        <?php case "5": ?>R全球大使<?php break; endswitch;?>
                                </td>-->
                                <td width="20%"><?php echo ($v["lkb"]); ?></td>
                                <td width="20%"><?php echo ($v["jb"]); ?></td>
                                <td width="20%">
                                    <?php switch($v["zt"]): case "0": ?><button class="button-d" data-id="<?php echo ($v["id"]); ?>" data-txt="您确定花费<?php echo ($v["jb"]); ?>元购买<?php echo ($v["lkb"]); ?>个AD币吗？">等待中</button><?php break;?>
                                        <?php case "1": ?>交易中<?php break;?>
                                        <?php case "2": ?>交易完成<?php break; endswitch;?>
                                </td>
                            </tr><?php endforeach; endif; ?>
                    </tbody>
                </table>
            </div>

            <div class="jyzx_table">
                <table>
                    <thead>
                        <tr>
                            <td width="40%">昵称</td>
                            <!--<td>等级</td>-->
                            <td width="20%">个数</td>
                            <td width="20%">价格</td>
                            <td width="20%">状态</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(is_array($lists)): foreach($lists as $key=>$v): ?><tr>
                                <td width="40%"><?php echo ($v["p_name"]); ?></td>
                                <!--<td>
                                   <?php switch($v["p_level"]): case "0": ?>未激活<?php break;?>
                                       <?php case "1": ?>GEC矿工<?php break;?>
                                       <?php case "2": ?>工会会长<?php break;?>
                                       <?php case "3": ?>A成长大使<?php break;?>
                                       <?php case "4": ?>S形象大使<?php break;?>
                                       <?php case "5": ?>R全球大使<?php break; endswitch;?>
                               </td>-->
                                <td width="20%"><?php echo ($v["lkb"]); ?></td>
                                <td width="20%"><?php echo ($v["jb"]); ?></td>
                                <td width="20%">
                                    <?php switch($v["zt"]): case "0": ?><button class="button-d" data-id="<?php echo ($v["id"]); ?>" data-txt="您确定花费<?php echo ($v["jb"]); ?>元购买<?php echo ($v["lkb"]); ?>个AD币吗？">等待中</button><?php break;?>
                                        <?php case "1": ?>交易中<?php break;?>
                                        <?php case "2": ?>交易完成<?php break; endswitch;?>
                                </td>
                            </tr><?php endforeach; endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
<script src="/Public/web/js/jquery-1.8.3.min.js"></script>
<script src="/Public/bang/layer-v3.1.1/layer/layer.js"></script>
<script>
    $('.nav .kj_flex-item').click(function () {
        var txt = $(this).data("txt");
        var number = $(this).data("number");
        var money = $(this).data("money");
        var url = $(this).data("url");
        $("#form-number").attr("placeholder",number);
        $("#form-money").attr("placeholder",money);
        $("#form-on").text(txt);
        $("#form-on").data("url",url);
        $("#form-number").val("");
        $("#form-money").val("");
        $(this).addClass("selected").siblings().removeClass("selected"); //removeClass就是删除当前其他类；只有当前对象有addClass("selected")；siblings()意思就是当前对象的同级元素，removeClass就是删除；
        $(".content .jyzx_table").hide().eq($('.nav .kj_flex-item').index(this)).show();
    });

    // 买入 卖出 发布
    $("#form-on").click(function () {
        var url = $(this).data("url");
        var number = $("#form-number").val();
        var money = $("#form-money").val();

        var sum=/^[0-9]*[1-9][0-9]*$/;
        if(!sum.test(number)){
            layer.msg("请输入正整数");
            return false;
        }

        var reg = /^(([1-9][0-9]*)|([0]\.[1-9])|([0]\.[0-9][1-9])|([1-9][0-9]*\.[1-9])|([1-9][0-9]*\.[0-9][1-9]))$/;   // 可以带两位小数的正数
        if(!reg.test(money)){
            layer.msg("请输入最小单位为分的金额");
            return false;
        }

        layer.load(1, {
            shade: [0.1,'#000']
        });
        $.post(url,{number:number,money:money},function(data){
            if(data.status == 1){
                layer.msg(data.info,function () {
                    window.location.reload();
                },1000);
            }else{
                layer.closeAll();
                layer.msg(data.info)
            }
        });
    });

    // 确定交易
    $(".button-d").click(function(){
        var id = $(this).data("id");
        var str = $(this).data("txt");
        layer.confirm(
            str,
            {
                btn: ['确定', '取消'],
                title: "提示"
            },
            function (){
                layer.closeAll();
                layer.load(1,{shade: [0.1,'#000']});
                $.post("<?php echo U('transaction');?>",{id:id},function (data) {
                    if(data.status == 1){
                        layer.msg(data.info,function(){
                            window.location.href="<?php echo U('myjiaoyi');?>";
                        });
                    }else{
                        layer.closeAll();
                        layer.msg(data.info);
                    }
                })
            }
        );
    });

</script>
</html>