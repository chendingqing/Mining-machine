<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link type="text/css" rel="stylesheet" href="/Public/web/css/lib.css?2">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<meta content="telephone=no" name="format-detection">
    <title>运行</title>
    <link href="/Public/bang/css/mui.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="/Public/web/css/weui.min.css"/>
    <link rel="stylesheet" href="/Public/web/css/jquery-weui.min.css">
    <script src="/Public/web/js/jquery-1.8.3.min.js"></script>
    <script src="/Public/web/js/layer.js"></script>
    <style>
        @-webkit-keyframes gogogo {
            0% {
                -webkit-transform: rotate(0deg);
            }
            50% {
                -webkit-transform: rotate(180deg);
            }
            100% {
                -webkit-transform: rotate(360deg);
            }
        }
        .loading{
            -webkit-animation:gogogo 2s infinite linear ;
        }
        .left-icon {
            float: left;
            padding: 10px;
            display: block;
        }
        .left-icon img {
            height: 24px;
        }
        header{
            -webkit-box-shadow: 0 0 0 #49bdff !important;
            box-shadow: 0 0 0 #49bdff !important;
        }
    </style>
</head>
</head>
<body style="background: #49bdff;">
<!--<div style="position: fixed;z-index: -1000;width: 100%;height: 100vh;top:0;left: 0;"><img src="/Public/web/img/body_bg.jpg" style="width:100%;height: 100vh"></div>-->
<header class="mui-navbar-inner mui-bar mui-bar-nav" style="background-image: url(/Public/bang/images/top.png);">
    <h1 class="mui-title" style="color:#FFF;">我的矿机</h1>
    <a href="<?php echo U('mykuangche');?>" class="left-icon">
        <img src="/Public/bang/images/head_back_icon.png"/>
    </a>
</header>

<!--<canvas id="matrix" style="position:absolute;z-index:-1;width: 100%;height: 100%"></canvas>-->

<!--顶部结束-->
<div style="width: 90%;margin-left: 5%;float: left;margin-top: 50px;">
    <p style="height: 20px;line-height: 20px;font-size: 1em;color:#fff;">我的:<?php echo ($kcmc); ?></p>
    <div style="text-align: center;position: relative;width: 100%;height: 100%;height: 100vw;">
        <img class="quan loading" src="/Public/bang/images/1.png" alt="" style="display:block;width:56%;position: absolute;top: 17%;left: 22%;z-index: 100; "/>
        <p class="wakuang" data-id="1" style="z-index:1000;width:100px;height:100px;line-height:100px;position: absolute;top:45%;left:50%;margin-left:-50px;margin-top:-60px;color: #fff;background-color: #f2451a;border-radius: 50%;;">运行中</p>
    </div>
	<div style=" position:fixed; bottom:60px;">
		<p  style="margin-top:-20px;height: 30px;line-height: 30px;font-size:12px; color: #fff;">
            <span id="drGEC" style="font-size:3em;color:#fff"><?php echo ($jrsy); ?></span>
            &nbsp;&nbsp;&nbsp;AD
        </p>
		<p style="height: 30px;line-height: 30px;color:#fff;margin-top:10px;">我的算力：<span><?php echo ($kjsl); ?></span>&nbsp;GH/s</p>
		<p style="height: 30px;line-height: 30px;font-size:12px;/*color:#aaa;*/ color: #fff;">累计获得：
            <span id="ljGEC"><?php echo ($yjzsy); ?></span>
            &nbsp;AD
        </p>
		<p style="height: 30px;line-height: 30px;font-size:10px;/*color:#aaa;*/ color: #fff;">全网算力：<span><?php echo ($qwsl); ?></span>&nbsp;GH/s</p>
	</div>
</div>

<div class="height55"></div>
<script src="/Public/web/js/jquery-weui.min.js"></script>
<script>
    $.ajax({
        url:"",
        type:"get",
        data:"",
        dataType:"json",
        success:function(data){
            if(data.static==1){
                $(".quanb").show();
                $('.wquan').hide();
                $('.quan').addClass('loading').show();
                $(".wakuang").text("挖矿中");
                $(".wakuang").attr("data-id","1");
                var time=setTimeout(function(){
                    $(".quanb").hide();
                },1000);
            }else{
                $(".quanb").show();
                $('.quan').removeClass('loading').hide();
                $('.wquan').show();
                $(".wakuang").text("挖矿");
                $(".wakuang").attr("data-id","0");
            }
        }
    })
</script>
    <script type="text/javascript">
    var matrix=document.getElementById("matrix");
    var context=matrix.getContext("2d");
    matrix.height=window.innerHeight;
    matrix.width=window.innerWidth;
    var drop=[];
    var font_size=16;
    var columns=matrix.width/font_size;
    for(var i=0;i<columns;i++)
        drop[i]=1;

    // 背景颜色
    function drawMatrix(){
        context.fillStyle="rgba(0, 0, 0, 0.1)";
        context.fillRect(0,0,matrix.width,matrix.height);
        context.fillStyle="green";
        context.font=font_size+"px";
        for(var i=0;i<columns;i++){
            context.fillText(Math.floor(Math.random()*2),i*font_size,drop[i]*font_size);/*get 0 and 1*/

            if(drop[i]*font_size>(matrix.height*2/3)&&Math.random()>0.85)/*reset*/
                drop[i]=0;
            drop[i]++;
        }
    }
    setInterval(drawMatrix,40);
</script>
<!--数字递增-->
<script type="text/javascript">
    var i=parseFloat(document.getElementById("drGEC").innerHTML);
    var max=parseFloat(i+(<?php echo ($mmsy); ?>));
    var time1=setInterval(function() {
        var time2=setInterval(function(){
            i=parseFloat((i+0.000222).toFixed(8));
			console.log(i);
            if(i>=max){
                clearInterval(time2);
				i=max;
            }
            $("#drGEC").html(i.toFixed(8));
        },10);
        max=i+(<?php echo ($mmsy); ?>);
        $("#drGEC").html(i);
    }, 5000);
    var s=parseFloat(document.getElementById("ljGEC").innerHTML);
//    console.log(s);
    var time2=setInterval(function() {
        // console.log(s);
        s=parseFloat((s+(<?php echo ($mmsy); ?>)).toFixed(8));
		$("#ljGEC").html(s.toFixed(8));
    }, 5000);
</script>

</body>
</html>