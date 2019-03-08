<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <title>微圈传媒</title>
    <link href="/Public/bang/css/mui.min.css" rel="stylesheet"/>
    <link href="/Public/bang/css/kj_resert.css" rel="stylesheet" />
    <link href="/Public/bang/css/kj_public.css" rel="stylesheet" />
    <link href="/Public/bang/css/kj_geren.css" rel="stylesheet" />
    <link href="/Public/bang/css/kjd_zhuanchu.css" rel="stylesheet" />
	<style>
		.kjd_jilu{
			padding:5px;
		}
		.kjd_time{
			display: block;
			padding-right: 8px;
		}
	</style>
</head>
<body>
<header class=" mui-navbar-inner mui-bar mui-bar-nav" style="background-image: url(/Public/bang/images/top.png);">
	<h1 class="mui-title" style="color:#FFF;">我的矿点</h1>
	<a href="<?php echo U('user');?>" class="left-icon">
		<img src="/Public/bang/images/head_back_icon.png"/>
	</a>
    <a href="javascript:void(0)" id="opentanchu" class="right-icon"><span>转出</span></a>
</header>
<div class="mui-content">
    <div class="geren_card">
        <div class="geren_card_bg">
            <p class="geren_card_name">
                <span>职称：</span>
                <span>
                    <?php switch($user["ads_condition"]): case "0": ?>初级矿工<?php break;?>
                         <?php case "1": ?>中级矿工<?php break;?>
                         <?php case "2": ?>高级矿工<?php break;?>
                         <?php case "3": ?>超级矿工<?php break;?>
                         <?php case "4": ?>专家矿工<?php break; endswitch;?>
                </span>
            </p>
            <span class="geren_card_GEC">可用矿机点</span>
            <div class="geren_card_GEC_num"><?php echo ($user["point"]); ?></div>
        </div>
    </div>

    <!-- 转出功能 -->
    <div class="div-form">
        <form action="" class="mui-input-group">
            <div class="mui-input-row">
                <label>转出:</label>
                <input type="text" name="point" placeholder="请输入数量">
            </div>
        </form>
        <div style="width: 100%;">
            <div class="mui-btn kjd-btn" id="div-form-no">取消</div>
            <div class="mui-btn kjd-btn" id="div-from-yes">提交</div>
        </div>
    </div>

    <ul class="mui-table-view geren_table_view" id="content-ul">
        <?php if(is_array($log)): foreach($log as $key=>$list): ?><li class="mui-table-view-cell">
                <div class="kjd_jilu">
                    <span class="kjd_time"><?php echo ($list["addtime"]); ?></span>
                    <p style="text-indent: 1em;"><?php echo ($list["remarks"]); ?></p>
                </div>
            </li><?php endforeach; endif; ?>
    </ul>
</div>
</body>
<script src="/Public/web/js/jquery-1.8.3.min.js"></script>
<script src="/Public/bang/layer-v3.1.1/layer/layer.js"></script>
<script>
    var mo=function(e){e.preventDefault();};

    //禁止页面滑动
    function stop(){
        document.body.style.overflow='hidden';
        document.addEventListener("touchmove",mo,false);
    }

    //开启页面滑动
    function move(){
        document.body.style.overflow='';
        document.removeEventListener("touchmove",mo,false);
    }

    var number = 1;
    $(window).scroll(function(){
        var scrollTop = $(this).scrollTop();    //滚动条距离顶部的高度
        var scrollHeight = $(document).height();   //当前页面的总高度
        var clientHeight = $(this).height();    //当前可视的页面高度
        if(scrollTop + clientHeight >= scrollHeight){   //距离顶部+当前高度 >=文档总高度 即代表滑动到底部
            if(number > 0){
                stop();
                layer.load(0);
                $.post("<?php echo U('point_post');?>",{number:number},function(data){
                    layer.closeAll();
                    layer.msg(data.info.msg);
                    if(data.status == 1){
                        number = data.info.number;
                        $("#content-ul").append(data.info.html);
                    }
                    move();
                });
            }
            return false;
        }
    });

    $("#opentanchu").click(function(){
        $("input[name='point']").val("");
        $(".div-form").toggle();
    });
    $("#div-form-no").click(function(){
        $(".div-form").hide();
    });

    //正整数验证
    function isPInt(str) {
        var g = /^[1-9]*[1-9][0-9]*$/;
        return g.test(str);
    }

    $("#div-from-yes").click(function () {
        var point = $("input[name='point']").val();
        if(isPInt(point)){
            layer.load(1, {
                shade: [0.1,'#000']
            });
            $.post("<?php echo U('point_turn_out');?>",{point:point},function(data){
                layer.closeAll();
                if(data.status == 1){
                    layer.load(1, {
                        shade: [0.1,'#000']
                    });
                    layer.msg(data.info,function () {
                        window.location.reload();
                    },2000);
                }else{
                    layer.msg(data.info)
                }
            });
        }else{
            layer.msg("请输入大于0的正整数");
        }
    })
</script>
</html>