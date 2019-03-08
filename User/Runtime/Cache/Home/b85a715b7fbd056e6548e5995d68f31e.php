<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link type="text/css" rel="stylesheet" href="/Public/web/css/lib.css?2">
	<link rel="stylesheet" href="/Public/web/js/morris.css">
	<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=0" />
	<meta content="telephone=no" name="format-detection">
	<title>交易中心</title>
	<script src="/Public/web/js/jquery-1.8.3.min.js"></script>
	<link rel="stylesheet" href="/Public/web/css/weui.min.css"/>
	<link rel="stylesheet" href="/Public/web/css/jquery-weui.min.css">
	<link href="/Public/web/css/font-awesome.min.css" rel="stylesheet">
	<link href="/Public/web/fonts/iconfont.css" rel="stylesheet">
	<script src="/Public/web/js/layer.js"></script>
	<link rel="stylesheet" href="/Public/web/css/style.css"/>
	<style>
        #chartNav{
		display:none;
            width: 100%;
            height: 30px;
            background: #EFEFF4;
        }
        #chartNav a{
            float: left;
            width: 100%;
            line-height: 30px;
            -ms-text-align-last: center;
            text-align-last: center;
			text-align:center;
            color: #666666;
        }
        #chartNav a:hover,#chartNav a.active{
            background: #02d2f5;
            color: #fff;
            -webkit-transform: all 0.3s;
            -moz-transform: all 0.3s;
            -ms-transform: all 0.3s;
            -o-transform: all 0.3s;
            transform: all 0.3s;
        }
		 #myhend{
            width: 100%;
            height: 40px;
            overflow: hidden;
            border-bottom:1px solid #ddd;
            color: #02d2f5;
        }
        #myhend>div{
            float: left;
            width:calc( 50% - 10px );
            text-align: left;
            height:100%;
            line-height: 40px;
            font-size: 16px;
            font-weight: 600;
			padding-left:0;
			padding-left:10px;
        }
		 #myhend>div:last-child{
		 text-align:center;
		 color:#02d2f5;
		 font-size:24px;
		 }
        #myhend>div>p{
		   float:left;
            width: 50%;
            height: 20px;
            line-height: 20px;
            font-size: 12px;
            font-weight: 500;
        }
		#mynav{
			width:100%;
			height:30px;
			line-height:30px;
			border-bottom:1px solid #ddd;
		}
		#mynav a{
			float:left;
			width:50%;
			text-align:center;
			line-height:30px;
			color:#858585;
		}
		#mynav a:hover{
			transition:all 0.5s;
			background:#02d2f5;
			color:#fff;
		}
		#mynav a.active{
			transition:all 0.5s;
			background:#02d2f5;
			color:#fff;
		}
    </style>
</head>
<body>
	<div style="position: fixed;z-index: -1000;width: 100%;height: 100vh;top:0;left: 0;"><img src="/Public/web/img/body_bg.jpg" style="width:100%;height: 100vh"></div>
	<header class="header">
		<span class="header_l" style="padding-left: 0"><a href="javascript:history.go(-1);"><img src="/Public/web/img/back.png" style="display: inline-block;height: 40px"></a></span>
		<span class="header_c">交易中心</span>
		<span style="position: absolute;right: 40px;top: 0px;text-align:center;width:70px;white-space:nowrap; overflow:hidden; text-overflow:ellipsis;font-size: 12px; "><?php echo ($userData['ue_truename']); ?></span>
		<span class="header_r"><a href="/index.php/Home/Index/index/"><i class="fa fa-user"></i></a></span>
	</header>
	<div class="height40"></div>
	<section class="content">
    <div class="row">
        <div class="col-md-13">
            <div class="box box-info">
                <div class="box-header with-border">
                    <!-- <h3 class="box-title" style="color: #fff;/* background: #02d2f5; */ text-align: center;border-bottom: 1px solid #ddd;border-top: 1px solid #ddd;font-size: 18px;padding: 10px 0;">价格走势图</h3> -->
                </div>
				    <div id="myhend">
                    <div>
                        <p>幅:&nbsp;<?php echo ($fu); ?>%</p>
                        <p>量:&nbsp;<?php echo ($liang); ?></p>
						 <p>最高:&nbsp;<?php echo ($gao); ?></p>
                        <p>最低:&nbsp;<?php echo ($di); ?></p>
                    </div>
					   <div>$:<?php echo ($zuihou); ?></div>
                </div>
                <div id="chartNav"></div>
				<div id="mynav">
				 <a class="active">分时线</a>
				 <a>日线</a>
				</div>
                    <!--<div class="box-body chart-responsive" style="background-image: url('/Public/user2/images/kx.png');">-->
                    <div id="chart" style="width:100%;height:200px;"></div>
            </div>
        </div>
    </div>
</section>
	<!--顶部结束-->
	<!--矿车列表-->
	<div style="width: 90%;margin-left: 5%;margin-top: 20px;overflow:hidden;border-radius:5px">
		<p id="qiugou_list"onclick='showhidediv("qiugou")'style="float: left;width: 50%;text-align: center;background-color: #02d2f5;height: 30px;line-height: 30px;color:#fff;border-bottom-left-radius: 5px;border-top-left-radius: 5px">买入GEC</p>
		<p id="chushou_list" onclick='showhidediv("chushou")'style="float: left;width: 50%;text-align: center;background-color: #fff;height: 30px;line-height: 30px;border-top-right-radius: 5px;border-bottom-right-radius: 5px;color: #333">卖出GEC</p>
	</div>
	<div id="qiugou" style="padding-bottom:50px;background-color:transparent;margin-top:0px;width:100%;margin-left:0%">
	<form  id="qiugou" class="mmform" style="margin-top: 25px" action="/index.php/Home/Info/myjiaoyis" method= "POST" onsubmit="return false" >
		<input type="text" name="lkb" id="gmsl" placeholder="请输入要购买数量" onpaste="this.value=this.value.replace(/[^\d]/g,'')" onkeyup="this.value=this.value.replace(/[^\d]/g,'')"
 style="width:60%"/>
		<input type="text" name="price" id="mmp" placeholder="请输入购买单价"style="width:60%" />
		<input type="text" name="code" id="" placeholder="请输入验证码"style="width:60%" />
		
	
		<button type="submit" id="mmm" style="float:right;width:33%;margin-top:-20px;background-color: #02d2f5;height: 30px;line-height: 30px;background-color: #02d2f5;height: 30px;line-height: 30px;border-radius:5px;border:0px;color:#fff">买入</button>
		<button type="button" class="code" id="" style="float:right;width:33%;margin-top:-80px;background-color: #02d2f5;height: 30px;line-height: 30px;background-color: #02d2f5;height: 30px;line-height: 30px;border-radius:5px;border:0px;color:#fff">发送验证码</button>
	</form>
	<table class="jyzx_list" style="margin-top:20px;margin-bottom:80px;border-collapse:collapse;table-layout: fixed">
		<thead>
			<tr style="width:100%;">
				<th style="padding:10px 0">昵称</th>
				<th style="padding:10px 0">等级</th>
				<th style="padding:10px 0;width:20%">GEC</th>
				<th style="padding:10px 0;">总价($)</th>
				<th style="padding:10px 0">状态</th>
			</tr>
		</thead>
		<tbody>
		<?php if(is_array($list)): foreach($list as $key=>$v): ?><tr style="margin-bottom:100px">
				<td class="name" style="padding:10px 0;text-align:center;overflow:hidden;text-overflow:ellipsis;white-space: nowrap;"><?php echo ($v["p_name"]); ?></td>
				<td class="range iconfont" style="padding:10px 0;text-align:center;font-size:12px;text-overflow: ellipsis; overflow: hidden;">
						<?php if($v["p_level"] == 0): ?>未激活<?php endif; ?>
						<?php if($v["p_level"] == 1): ?>GEC矿工<?php endif; ?>
						<?php if($v["p_level"] == 2): ?>工会会长<?php endif; ?>
						<?php if($v["p_level"] == 3): ?>A成长大使<?php endif; ?>
						<?php if($v["p_level"] == 4): ?>S形象大使<?php endif; ?>
						<?php if($v["p_level"] == 5): ?>R全球大使<?php endif; ?>


				</td>
				<td class="lkMoney" style="padding:10px 0;text-align:center;overflow:hidden;text-overflow:ellipsis;white-space: nowrap;"><?php echo ($v["lkb"]); ?></td>
				<td style="padding:10px 0;text-align:center;overflow:hidden;text-overflow:ellipsis;white-space: nowrap;"><span  class="money" ><?php echo ($v["jb"]); ?></span></td>
				<?php if($v["zt"] == 0): ?><td style="padding:5px 0;text-align:center;"><input class="ppid" type="hidden" value="<?php echo ($v["id"]); ?>">
					<button style="background-color:#02d2f5;width: 100%;height: 90% ;border: 0;border-radius: 5px;color: #FFFFFF;cursor: pointer;padding: 4px 5px;" class="btnchushou">等待中</button>
				</td><?php endif; ?>
				<?php if($v["zt"] == 1): ?><td style="padding:5px 0;text-align:center;"><input class="ppid" type="hidden" value="<?php echo ($v["id"]); ?>">
					<button style="background-color:#666;width: 100%;height: 90% ;border: 0px;border-radius: 5px;color: #FFFFFF;cursor: pointer;padding: 4px 5px;" >交易中</button>
				</td><?php endif; ?>
				<?php if($v["zt"] == 2): ?><td style="padding:5px 0;text-align:center;"><input class="ppid" type="hidden" value="<?php echo ($v["id"]); ?>">
					<button style="background-color:#00ff00;width: 100%;height: 90% ;border: 0;border-radius: 5px;color: #FFFFFF;cursor: pointer;padding: 4px 5px;" class="wancheng">交易完成</button>
				</td><?php endif; ?>
			</tr><?php endforeach; endif; ?>
			<!--<tr>
				<td style="padding:10px 0;text-align:center;">三九</td>
				<td style="padding:10px 0;text-align:center;">V3</td>
				<td style="padding:10px 0;text-align:center;">100.0001</td>
				<td style="padding:10px 0;text-align:center;">100.00</td>
				<td style="padding:5px 0;text-align:center;"><input class="ppid" type="hidden" value="2"><button class="btnchushou" style="background-color:#E64340;width: 100%;height: 100% ;border: 0px;border-radius: 5px;;color: #FFFFFF;cursor: pointer;">出售</button></td>
			</tr>-->
		</tbody>
	</table>
	</div>
	<div id="chushou" style="display: none; padding-bottom:50px;background-color:transparent;" >
	<form id="qiugou" class="nnform" style="margin-top: 25px" action="/index.php/Home/Info/cslkb" method= "POST" onsubmit="return false">
		<input type="text" name="lkb" id="mcsl" placeholder="请输入要卖出数量"  onpaste="this.value=this.value.replace(/[^\d]/g,'')" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" style="width:60%"/>
		<input type="text" name="price" id="mcpic" placeholder="请输入卖出单价"style="width:60%"/>
		<input type="text" name="code" id="" placeholder="请输入验证码"style="width:60%"/>
		
		
		
		<button type="submit" id="nnn" style="float:right;width:33%;margin-top:-20px;background-color: #02d2f5;height: 30px;line-height: 30px;background-color: #02d2f5;height: 30px;line-height: 30px;border-radius:5px;border:0px;color:#fff">卖出</button>
		<button type="button" class="code" id="" style="float:right;width:33%;margin-top:-80px;background-color: #02d2f5;height: 30px;line-height: 30px;background-color: #02d2f5;height: 30px;line-height: 30px;border-radius:5px;border:0px;color:#fff">发送验证码</button>
	</form>
		<table class="jyzx_list" style="margin-top:20px;margin-bottom:80px;border-collapse:collapse;table-layout: fixed;background: transparent">
			<thead>
			<tr style="width:100%;">
				<th style="padding:10px 0"><font color="white">昵称</font></th>
				<th style="padding:10px 0"><font color="white">等级</font></th>
				<th style="padding:10px 0;width:20%"><font color="white">GEC</font></th>
				<th style="padding:10px 0;"><font color="white">总价($)</font></th>
				<th style="padding:10px 0"><font color="white">状态</font></th>
			</tr>
			</thead>
			<tbody>
			<?php if(is_array($lists)): foreach($lists as $key=>$v): ?><tr style="margin-bottom:100px">
					<td class="name" style="padding:10px 0;text-align:center;overflow:hidden;text-overflow:ellipsis;white-space: nowrap;"><font color="white"><?php echo ($v["p_name"]); ?></font></td>
					<td class="range iconfont" style="padding:10px 0;text-align:center;font-size:12px">
						<?php if($v["p_level"] == 0): ?><font color="white">未激活</font><?php endif; ?>
						<?php if($v["p_level"] == 1): ?><font color="white">GEC矿工</font><?php endif; ?>
						<?php if($v["p_level"] == 2): ?><font color="white">GEC会长</font><?php endif; ?>
						<?php if($v["p_level"] == 3): ?><font color="white">A成长大使</font><?php endif; ?>
						<?php if($v["p_level"] == 4): ?><font color="white">S形象大使</font><?php endif; ?>
						<?php if($v["p_level"] == 5): ?><font color="white">R全球大使</font><?php endif; ?>
						


					</td>
					<td class="lkMoney" style="padding:10px 0;text-align:center;"><font color="white"><?php echo ($v["lkb"]); ?></font></td>
					<td class="money" style="padding:10px 0;text-align:center;"><?php echo ($v["jb"]); ?></td>
					<?php if($v["zt"] == 0): ?><td style="padding:5px 0;text-align:center;"><input class="ppid" type="hidden" value="<?php echo ($v["id"]); ?>">
							<button style="background-color:#02d2f5;width: 100%;height: 90% ;border: 0;border-radius: 5px;color: #FFFFFF;cursor: pointer;padding: 2px 5px" class="btnsc">等待中</button>
						</td><?php endif; ?>
					<?php if($v["zt"] == 1): ?><td style="padding:5px 0;text-align:center;"><input class="ppid" type="hidden" value="<?php echo ($v["id"]); ?>">
							<button style="background-color:#666;width: 100%;height: 90% ;border: 0px;border-radius: 5px;color: #FFFFFF;cursor: pointer;padding: 2px 5px" >交易中</button>
						</td><?php endif; ?>
					<?php if($v["zt"] == 2): ?><td style="padding:5px 0;text-align:center;"><input class="ppid" type="hidden" value="<?php echo ($v["id"]); ?>">
							<button style="background-color:#02d2f5;width: 100%;height: 90% ;border: 0px;border-radius: 5px;color: #FFFFFF;cursor: pointer;" class="wancheng">交易完成</button>
						</td><?php endif; ?>
				</tr><?php endforeach; endif; ?>
			
			</tbody>
		</table>
	</div> 
<!--底部开始-->
<style>
	.footer ul li{
		width: 25%;
	}
</style>
		<div class="footer">
      <ul>
        <li><a href="/index.php/Shop/Index/" class="block"><i class="iconfont">&#xe620;</i>矿机商城</a></li> <li><a href="/index.php/Home/Info/mykuangche/" class="block"><i class="iconfont">&#xe612;</i>我的矿机</a></li> <li><a href="/index.php/Home/Info/Index/" class="block"><i class="iconfont">&#xe61e;</i>交易中心</a></li>       <li><a href="/index.php/Home/Index/Index/" class="block"><i class="iconfont">&#xe619;</i>个人中心</a></li>
    </ul>
</div>
	
	
	
	
	
	   <script src="/Public/user2/js/jquery.dataTables.min.js"></script>
<script src="/Public/user2/js/dataTables.bootstrap.min.js"></script>
<script src="/Public/user2/js/jQuery-2.1.4.min.js"></script>
<script src="/Public/web/js/echarts.min.js"></script>
<script src="/Public/chart/mychart.js"></script>
<script src="/Public/user2/js/bootstrap.min.js"></script>
<script src="/Public/user2/js/morris.min.js"></script>
<script src="/Public/user2/js/raphael-min.js"></script>
	<!--底部结束-->
	<script src="/Public/web/js/jquery-weui.min.js"></script>
	<script>
		function showhidediv(id) {
			console.log(id);
			var qiugou = document.getElementById("qiugou");
			var zhengzai = document.getElementById("chushou");
			var qiugoubg = document.getElementById("qiugou_list");
			var zhengzaibg = document.getElementById('chushou_list');
			if (id == "qiugou") {
				zhengzai.style.display = 'none';
				qiugou.style.display = 'block';
				qiugoubg.style.backgroundColor = "#02d2f5"
				qiugoubg.style.color = "#fff"
				zhengzaibg.style.backgroundColor = "#fff";
				zhengzaibg.style.color = "#000";
			}else if(id=='chushou'){
				zhengzai.style.display = 'block';
				qiugou.style.display = 'none';
				qiugoubg.style.backgroundColor = "#fff";
				qiugoubg.style.color = "#000";
				zhengzaibg.style.backgroundColor = "#02d2f5";
				zhengzaibg.style.color = "#fff";
			}
		}
	</script>
	
	
	
<?php if($xgcs == 0): ?><script>
	$.alert("请绑定个人收款资料",function(){
		window.location.href='/index.php/Home/Info/myziliao/';
	});
	
</script><?php endif; ?>
<script>
	$('.code').click(function(){
		$.get("<?php echo U('/index.php/Home/Info/code');?>", {}, function(data){
			alert(data.message);
		}, 'json');
		return false;
	});
</script>
	
	
	
	<script>
	
	
		$(function(){
				var s='<div id="popUpBox" style="position:absolute;top:30%;width:100%;height:100%;display:none;background-color:#DDD">'+
						'<div style="margin:0 auto;width: 90%;height:150px;background-color: #fff;padding:15px 0 10px;border-radius: 10px">'+
						'<div style="text-align:center;font-size:1.2em;margin-top:15px;">是否确认提交？</div><input class="opid" type="hidden" value="" />'+
						'<div style="text-align:center;margin-top:35px;"><button style="font-size:1.2em;padding:5px 10px;background-color:#fff;border-radius: 5px;border: 0px;color:green"  id="confirmBtn">确认</button>&nbsp;&nbsp;<button style="padding:5px 10px;font-size:1.2em;border: 0px;background-color:#fff;border-radius: 5px" id="confirmBtnFalse">取消</button></div>'+
						'</div>'+
				'</div>';
				$("body").append(s);
		})

		$(function(){
		$(".btnchushou").bind("click",function(){


		   var huilv=$(this).parent().parent().find(".money").html();
		   $("#popUpBox").find(".opid").val($(this).parent().find(".ppid").val());
			$.ajax({
				url:"<?php echo U('/index.php/Home/Info/huilv');?>",
				type:"get",
				data:{id:$("#UpBox").find(".opid").val(),huilv:huilv},
				dataType:"json",
				success:function(data){
				console.log(data);
				$.confirm("USD："+huilv+"<br>"+"RMB："+data.rmb+"<br>"+"BTC："+data.btc,"确定提交？",function(){	
					$.ajax({
				url:"<?php echo U('/index.php/Home/Info/chushou');?>",
				type:"get",
				data:{id:$("#popUpBox").find(".opid").val()},
				dataType:"json",
				success:function(data){
				console.log(data);
					if(data.status==1){
					$.alert(data.msg,function(){
					   location.href="/index.php/Home/Info/myjiaoyi";
					});
				    }else{
					$.alert(data.msg);
					}
				},
				error:function(){
					$.alert("网络错误请重试");
				}
			})
		
		})
	
				},
				error:function(){
					$.alert("网络错误请重试");
				}
			})
		
		

		
		
		})



		})
		
		
	</script>
	
	
<!--价格走势图开始-->
<script type="text/javascript">
<!-- 买入 -->
$(function(){
	$("#mmm").bind("click",function(){
		var price=$("#mmp").val();
		var sum=/^[0-9]*[1-9][0-9]*$/;
		if(sum.test($("#gmsl").val())){
		}else{
			$.alert("请输入正整数");
			return false;
		}
		console.log(price);
		if(price==""){
			$.alert("请输入价格");
			return false;
		}
		if(!isNaN(price)){
		}else{
			$.alert("请输入数字");
			return false;
		}

		if(price.indexOf(".")==-1){
            $.alert("请输入小数");
			return false;
		}
		price=price.split(".")[1];
		if(price.length>2){
			$.alert("请保留两位小数");
			return false;
		}
<!-- 		$('.mmform').get(0).submit(); -->

			$.showLoading("正在提交");
				console.log(1111);
									$.ajax({
									url:"/index.php/Home/Info/myjiaoyis",
									type:"post",
									 data:$(".mmform").serialize(),
									 dataType:"json",
									 success:function(data){
									    if(data.status==1){
										   $.alert(data.info,function(){
										   location.href="/index.php/Home/Info/index/";
										   })
										}else{
										$.alert(data.info);
									}
									  },error:function(){
									    $.alert("网络错误");
									  },complete:function(){
									  $.hideLoading();
									  }
									})
	})
})
<!-- 卖出 -->
$(function(){
	$("#nnn").bind("click",function(){
		var price=$("#mcpic").val();
		var sum=/^[0-9]*[1-9][0-9]*$/;
		if(sum.test($("#mcsl").val())){
		}else{
			$.alert("请输入正整数");
			return false;
		}
		console.log(price);
		if(price==""){
			$.alert("请输入价格");
			return false;
		}
		if(!isNaN(price)){
		}else{
			$.alert("请输入数字");
			return false;
		}

		if(price.indexOf(".")==-1){
            $.alert("请输入小数");
			return false;
		}
		price=price.split(".")[1];
		if(price.length>2){
			$.alert("请保留两位小数");
			return false;
		}
<!-- 		$('.mmform').get(0).submit(); -->
$.showLoading("正在提交");
				
				console.log(1111);
									$.ajax({
									url:"/index.php/Home/Info/cslkb",
									type:"post",
									 data:$(".nnform").serialize(),
									 dataType:"json",
									 success:function(data){
									    if(data.status==1){
										   $.alert(data.info,function(){
										   location.href="/index.php/Home/Info/index/";
										   })
										}else{
										$.alert(data.info);
									}
									  },error:function(){
									    $.alert("网络错误");
									  },complete:function(){
									  $.hideLoading();
									  }
									})
		 
	})
})






$.ajax({
        url:'<?php echo U('/index.php/Home/Ajax/getgp');?>',
        type:"post",
        data:null,
        dataType:"json",
        success:function(data){
            chart.oldData=data;
            start(chart);
        },error:function(){
            console.log('没有获取到数据');
        }
    })
    //配置信息
    function start(chart){
        chart.deploy={
            //配置导航信息
            nav:{
                //导航容器的id 默认为chartNav
                navId:"chartNav",
                //设置导航信息
                data:[
                    {
                        title:"分时线",
                        //每条数据额间隔时间 单位为妙
                        interval:"60",
                        //按钮图标
                        icon:"",
                        //按钮class类 需要至少有一个active
                        class:"active",
                        //图标的类型0为折线图,1为kline线图  candlestick
                        type:0,
                        //显示数据的条数 不存在的话为无穷大 0为不显示,-1为无穷大
                        num:1440
                    }
                ]
            }
        };
        chart.start();
    }
	$("#mynav a").bind("click",function(){
	   $("#mynav a").removeClass("active");
	   $(this).addClass("active");
	})
	$("#mynav a").eq(0).bind("click",function(){
	     $.ajax({
			url:'<?php echo U('/index.php/Home/Ajax/getgp');?>',
			type:"post",
			data:null,
			dataType:"json",
			success:function(data){
				chart.oldData=data;
				start(chart);
			},error:function(){
				console.log('没有获取到数据');
			}
		})
	})
	var cht = chart.mychart;
	var option = chart.option;
	$("#mynav a").eq(1).bind("click",function(){
	   $.ajax({
			url:'<?php echo U('/index.php/Home/Ajax/getgps');?>',
			type:"post",
			data:null,
			dataType:"json",
			success:function(data){
			   	option.series.type='candlestick';
	            option.tooltip.formatter=function(data){
                return "时间:"+data[0].name+"<br>"+
                    "开盘"+data[0].data[0]+"<br>"+
                    "收盘"+data[0].data[1]+"<br>"+
                    "最低"+data[0].data[2]+"<br>"+
                    "最高"+data[0].data[3]+"<br>";
             }
			   var time=[];
			   var dt=[];
			   for(var key in data){
			      var tt=new Date(data[key].date*1000);
				  var mm=tt.getMonth()+1;
				  var dd=tt.getDate();
			      time.push(mm+"月"+dd+"日");
				  dt[key]=[];
				  dt[key].push(data[key].jinkai);
				  dt[key].push(data[key].zuoshou);
				  dt[key].push(data[key].jrzd);
				  dt[key].push(data[key].jrzg);
			   }
			  option.xAxis.data=time;
			  option.series.data=dt;
			  cht.setOption(option);
			},error:function(){
				console.log('没有获取到数据');
			}
		})
	})
</script>
<!--价格走势图结束-->

	
	
	
	<script>
	$(function(){
				var s='<div id="UpBox" style="position:absolute;top:30%;width:100%;height:100%;display:none;background-color:#DDD">'+
						'<div style="margin:0 auto;width: 90%;height:150px;background-color: #fff;padding:15px 0 10px;border-radius: 10px">'+
						'<div style="text-align:center;font-size:1.2em;margin-top:15px;">是否确认提交？</div><input class="opid" type="hidden" value="" />'+
						'<div style="text-align:center;margin-top:35px;"><button style="font-size:1.2em;padding:5px 10px;background-color:#fff;border-radius: 5px;border: 0px;color:green"  id="firmBtn">确认</button>&nbsp;&nbsp;<button style="padding:5px 10px;font-size:1.2em;border: 0px;background-color:#fff;border-radius: 5px" id="confirmBtnFalse">取消</button></div>'+
						'</div>'+
				'</div>';
				$("body").append(s);
		})
	$(function(){



		$(".btnsc").bind("click",function(){



		   var huilv=$(this).parent().parent().find(".money").html();
		   $("#popUpBox").find(".opid").val($(this).parent().find(".ppid").val());
			$.ajax({
				url:"<?php echo U('/index.php/Home/Info/huilv');?>",
				type:"get",
				data:{id:$("#UpBox").find(".opid").val(),huilv:huilv},
				dataType:"json",
				success:function(data){
				console.log(data);
				$.confirm("USD："+huilv+"<br>"+"RMB："+data.rmb+"<br>"+"BTC："+data.btc,"确定提交？",function(){	
					$.ajax({
				url:"<?php echo U('/index.php/Home/Info/lksc');?>",
				type:"get",
				data:{id:$("#popUpBox").find(".opid").val()},
				dataType:"json",
				success:function(data){
				console.log(data);
					if(data.status==1){
					$.alert(data.msg,function(){
					   location.href="/index.php/Home/Info/myjiaoyi";
					});
				    }else{
					$.alert(data.msg);
					}
				},
				error:function(){
					$.alert("网络错误请重试");
				}
			})
		
		})
	
				},
				error:function(){
					$.alert("网络错误请重试");
				}
			})
		
		

		
		
		})




		})
	</script>
	<!-- 汇率转换 -->
	<script>
    $(function(){
		$(".money").bind("click",function(){
			var huilv=$(this).html();
			$.ajax({
				url:"<?php echo U('/Index.php/Home/Info/huilv');?>",
				type:"get",
				data:{id:$("#UpBox").find(".opid").val(),huilv:huilv},
				dataType:"json",
				success:function(data){
				console.log(data);
					$.modal({
                        title: data.name,
                        text: "美元："+huilv+"<br>"+"人民币："+data.rmb+"<br>"+"比特币："+data.btc,
                        buttons:[
                            { text: "确定", className: "default", onClick: function(){ } },
                        ]
                    })
				},
				error:function(){
					$.alert("网络错误请重试");
				}
			})
		})
		$("#firmBtnFalse").bind("click",function(){
			$("#UpBox").fadeOut();
		})
		})
</script>
<?php if($_SESSION['secpwd'] == ''): ?><script>
$(function(){
$.prompt("请输入安全密码","",function(){
   $.ajax({
   url:"<?php echo U('/Index.php/Home/Info/erjimima');?>",
   type:"get",
   data:{pwd:$("#weui-prompt-input").val()},
   dataType:"json",
   success:function(data){
   if(data.status==1){
   $.alert(data.msg);
   }else{
   $.alert(data.msg,function(){
   location.href=location.href;
   });
   }
   },error:function(){
   $.alert("网络错误",function(){
   history.back(-1);
   });
   }
   })
},function(){
history.back(-1);
},1)
})
</script><?php endif; ?>
</body>
</html>