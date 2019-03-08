<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1, minimum-scale=1.0"/>
    <meta content="telephone=no" name="format-detection">
    <title>矿机商城</title>
    <link href="/Public/bang/css/mui.min.css" rel="stylesheet"/>
    <link href="/Public/bang/css/kj_resert.css" rel="stylesheet" />
    <link href="/Public/bang/css/kj_public.css" rel="stylesheet" />
    <link href="/Public/bang/css/kuangji.css" rel="stylesheet" />
    <style>
        .progress{
            font-size: 12px;
            color: #8f8f94;
            height: 22px;
            max-height: 22px;
            line-height: 22px;
        }
        .progress span{
            float: left;
        }
        .progress .progress-show{
            float: left;
            width: 80px;
            height: 12px;
            line-height: 12px;
            background: #b6b6b6;
            border-radius: 6px;
            position: absolute;
            margin-top: 6px;
            margin-left: 40px;
            display: flex;
        }
        .progress .progress-show .progress-bg{
            max-height: 12px;
            background: #007aff;
            align-self: center;
        }
        .progress .progress-show .progress1{
            position: absolute;
            top:0;
            left: 0;
            font-size: 10px !important;
            text-align: center;
            color: #FFFFFF;
            width: 100%;
            height: 100%;
            border-radius: 6px;
        }
    </style>
</head>
<body>
    <header class=" mui-navbar-inner mui-bar mui-bar-nav" style="background-image: url(/Public/bang/images/top.png);">
        <h1 class="mui-title" style="color:#FFF;">矿机商城</h1>
        <a href="<?php echo HTTP_URL; ?>" class="left-icon">
            <img src="/Public/bang/images/head_back_icon.png"/>
        </a>
        <a href="<?php echo U('user');?>" class="mui-pull-right header-right"><img src="/Public/bang/images/kaungji_geren-icon.png" width="60%" /></a>
    </header>
    <div class="mui-content">
        <ul class="mui-table-view">
            <?php if(is_array($list)): foreach($list as $k=>$v): ?><li class="mui-table-view-cell">
                    <div class="kj_kuangji_icon" style="padding-bottom: 8px; min-height: 68px;">
                        <img src="<?php echo ($v["b_imagepath"]); ?>" />
                    </div>
                    <div class="kj_kuangji_text">
                        <p><strong><?php echo ($v["name"]); ?></strong><span>价格：</span><span><?php echo ($v["price"]); ?>AD</span></p>
                        <p><span>产量/小时</span><span><?php echo ($v["fjed"]); ?></span></p>
                        <p><span>运行周期</span><span><?php echo ($v["yxzq"]); ?>小时</span></p>
                        <div class="progress">
                            <?php if($v['point'] > 0): ?><span>矿机点&emsp;</span>
                            <div class="progress-show">
                                <?php
 $number = $point/$v['point']*100; if($number >= 100){ echo '<p class="progress1" data-skillbar="100" data-id="jihuo_'.$k.'">100%</p>'; }else{ echo '<p class="progress1" data-skillbar="'.$number.'" data-id="jihuo_'.$k.'">'.round($number, 2).'%</p>'; } ?>
                                <span class="progress-bg"></span>
                            </div><?php endif; ?>
                        </div>
                    </div>
                    <div class="kj_kuangji_btngroup">
                        <div class="kj-kuangji-btn1">
                            <a href="<?php echo U('jiaoyi',array('id' => $v['id']));?>">购买</a>
                        </div>
                        <?php if($v['point'] > 0): ?><div class="kj-kuangji-btn2 jihuo-btn1" id="jihuo_<?php echo ($k); ?>" data-id="<?php echo ($v['id']); ?>" data-pointhtml="您确定花费 <?php echo ($v['point']); ?> 矿场点来兑换<?php echo ($v["name"]); ?>吗？">激活</div><?php endif; ?>
                    </div>
                </li><?php endforeach; endif; ?>
            <li class="mui-table-view-cell"></li>
        </ul>
    </div>
</body>
<script src="/Public/web/js/jquery-1.8.3.min.js"></script>
<script src="/Public/bang/layer-v3.1.1/layer/layer.js"></script>
<script>
    $(".progress1").each(function () {
        var langth_number = $(this).data("skillbar");
        var span = $(this).next("span");
        var id = $(this).data("id");
        span.css(
            {
                "border-radius": "6px",
                "height": langth_number * 2,
            }
        );
        if(langth_number > 0 && langth_number < 100) {
            span.animate(
                {
                    "width": langth_number + "%",
                },
                2000
            );
        }else if(langth_number >= 100){
            span.animate(
                {"width":"100%"},
                2000
            );
            setTimeout(
                function() {
                    $("#"+id).css("background","#30b4ff");
                    $("#"+id).attr("data-start","yes");
                },
                2000
            );
        }
    });

    $(".jihuo-btn1").click(function(){
        var txt = $(this).data("pointhtml");
        var id = $(this).data("id");
        var start = $(this).data("start");
        if(start === "yes"){
            layer.confirm(txt, {
                btn: ['确定','取消'] //按钮
            }, function(){
                layer.closeAll();
                layer.load(1, {
                    shade: [0.1,'#000']
                });
                $.post("<?php echo U('confirmProjecttwo');?>",{id:id},function (data) {
                    layer.closeAll();
                    if(data.status == 1){
                        layer.msg(data.info,{icon:1,time:1000},function () {
                            window.location.href="<?php echo U('mykuangche');?>";
                        });
                    }else{
                        layer.msg(data.info,{icon:2,time: 2000});
                    }
                },"json")

            }, function(){});
        }
    })
</script>
</html>