<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link type="text/css" rel="stylesheet" href="/Public/web/css/lib.css?2">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<meta content="telephone=no" name="format-detection">
    <title>我的交易</title>
    <meta name="Keywords" content="PAAM" />
    <meta name="Description" content="PAAM" />
    <script src="/Public/web/js/jquery-1.8.3.min.js"></script>
    <link rel="stylesheet" href="/Public/web/css/weui.min.css"/>
    <link rel="stylesheet" href="/Public/web/css/jquery-weui.min.css">
    <script src="/Public/web/js/layer.js"></script>
    <link href="/Public/web/css/font-awesome.min.css" rel="stylesheet">
    <link href="/Public/web/fonts/iconfont.css" rel="stylesheet">
    <link rel="stylesheet" href="/Public/web/css/style.css"/>
	
	<script src="/Public/web/js/ajaxUplod.js"></script>
</head>
<body>
<div style="position: fixed;z-index: -1000;width: 100%;height: 100vh;top:0;left: 0;"><img src="/Public/web/img/body_bg.jpg" style="width:100%;height: 100vh"></div>
<header class="header">
    <span class="header_l" style="padding-left: 0"><a href="javascript:history.go(-1);"><img src="/Public/web/img/back.png" style="display: inline-block;height: 40px"></a></span>
    <span class="header_c">我的交易</span>
	<span style="position: absolute;right: 40px;top: 0px;text-align:center;width:70px;white-space:nowrap; overflow:hidden; text-overflow:ellipsis;font-size: 12px; "><?php echo ($userData['ue_truename']); ?></span>
    <span class="header_r"><a href="/index.php/Home/Index/index"><i class="fa fa-user"></i></a></span>
</header>
<div class="height40"></div>
<!--顶部结束-->
<!--矿车列表-->
<div style="width: 90%;margin-left: 5%;margin-top: 20px;overflow:hidden;border-radius:5px">
    <p id="qiugoubg"onclick='showhidediv("qiugou")'style="float: left;width: 25%;text-align: center;background-color: #fff;height: 30px;line-height: 30px;color: #333">求购列表</p>
    <p id="chushoubg"onclick='showhidediv("chushou")'style="float: left;width: 25%;text-align: center;background-color: #02d2f5;height: 30px;line-height: 30px;color:#fff">出售列表</p>
    <p id="zzjybg" onclick='showhidediv("zzjy")'style="float: left;width: 25%;text-align: center;background-color: #02d2f5;;height: 30px;line-height: 30px;color:#fff">交易列表</p>
    <p id="ywcjybg" onclick='showhidediv("ywcjy")'style="float: left;width: 25%;text-align: center;background-color: #02d2f5;;height: 30px;line-height: 30px;color:#fff">已完成列表</p>
</div>
<div id="qiugou" style="-left: 5%;margin-bottom:80px;margin-top:30px;color: #FFFFFF">
        <ul class="myjy_head"style="font-weight: 700;width:100%;margin-left:0%;margin-top:-5px">
            <li style="width: 18%">昵称</li>
            <li style="width: 24%">个数(GEC)</li>
            <li style="width: 20%">价格($)</li>
            <li style="width: 20%">是否取消</li>
            <li style="width: 18%">状态</li>
        </ul>
    <div>
	<?php if(is_array($list)): foreach($list as $key=>$v): ?><ul class="myjy_body"style="width:100%;margin-left:0%;margin-top:10px;background-color:transparent;">
            <li style=" color: rgb(0, 0, 0);width: 18%;height: 30px;overflow: hidden;display: inline-block;color: #FFFFFF"><?php echo ($v["p_name"]); ?></li>
            <li style=" color: rgb(0, 0, 0);width: 24%;color: #FFFFFF;"><?php echo ($v["lkb"]); ?></li>
            <li style=" color: rgb(0, 0, 0);width: 20%;color: #FFFFFF;" class="money"><?php echo ($v["jb"]); ?></li>
            <li style=" color: rgb(0, 0, 0);width: 20%;">
                <a href="/index.php/Home/Info/delqiugou/?id=<?php echo ($v["id"]); ?>" style="width: 90%;margin-left: 5%;display: block;height: 30px;line-height: 30px;text-align: center;background-color: #02d2f5;border-radius: 5px;color: #FFFFFF">取消</a></li>
            <li style=" color: rgb(0, 0, 0);width: 18%;">
                <?php if($v["zt"] == 0): ?><a href="#" style="width: 90%;margin-left: 5%;display: block;height: 30px;line-height: 30px;text-align: center;background-color: #02d2f5;border-radius: 5px;color: #FFFFFF">未交易</a><?php endif; ?>
                <?php if($v["zt"] == 1): ?><a href="#" style="width: 90%;margin-left: 5%;display: block;height: 30px;line-height: 30px;text-align: center;background-color: #02d2f5;border-radius: 5px;color: #FFFFFF">交易中</a><?php endif; ?>
                <?php if($v["zt"] == 2): ?><a href="#" style="width: 90%;margin-left: 5%;display: block;height: 30px;line-height: 30px;text-align: center;background-color: #02d2f5;border-radius: 5px;color: #FFFFFF">交易完成</a><?php endif; ?>
            </li>
        </ul><?php endforeach; endif; ?>	
    </div>
 </div>
<div id="chushou" style="-left: 5%;margin-bottom:80px;margin-top:30px;display: none;width: 90%; margin-left: 5%;color: #FFFFFF">
    <ul class="myjy_head"style="font-weight: 700;width:100%;margin-left:0%;margin-top:-5px;">
        <li style="width: 18%">昵称</li>
        <li style="width: 24%">个数(GEC)</li>
        <li style="width: 20%">价格($)</li>
        <li style="width: 20%">是否取消</li>
        <li style="width: 18%">状态</li>
    </ul>
    <div>
        <?php if(is_array($cslkb)): foreach($cslkb as $key=>$v): ?><ul class="myjy_body"style="width:100%;margin-left:0%;margin-top:10px;background-color:transparent;">
                <li style=" color: rgb(0, 0, 0);width: 18%;height: 30px;overflow: hidden;display: inline-block;color: #FFFFFF"><?php echo ($v["p_name"]); ?></li>
                <li style=" color: rgb(0, 0, 0);width: 24%;color: #FFFFFF"><?php echo ($v["lkb"]); ?></li>
                <li style=" color: rgb(0, 0, 0);width: 20%;color: #FFFFFF;" class="money"><?php echo ($v["jb"]); ?></li>
                <li style=" color: rgb(0, 0, 0);width: 20%;color: #FFFFFF"><a href="/index.php/Home/Info/del/?id=<?php echo ($v["id"]); ?>" style="width: 90%;margin-left: 5%;display: block;height: 30px;line-height: 30px;text-align: center;background-color: #02d2f5;border-radius: 5px;color: #FFFFFF">取消</a></li>
                <li style=" color: rgb(0, 0, 0);width: 18%;">
                    <?php if($v["zt"] == 0): ?><a href="#" style="width: 90%;margin-left: 5%;display: block;height: 30px;line-height: 30px;text-align: center;background-color: #02d2f5;border-radius: 5px;color: #FFFFFF">未交易</a><?php endif; ?>
                    <?php if($v["zt"] == 1): ?><a href="#" style="width: 90%;margin-left: 5%;display: block;height: 30px;line-height: 30px;text-align: center;background-color: #02d2f5;border-radius: 5px;color: #FFFFFF">交易中</a><?php endif; ?>
                    <?php if($v["zt"] == 2): ?><a href="#" style="width: 90%;margin-left: 5%;display: block;height: 30px;line-height: 30px;text-align: center;background-color: #02d2f5;border-radius: 5px;color: #FFFFFF">交易完成</a><?php endif; ?>
                </li>
            </ul><?php endforeach; endif; ?>
    </div>
</div>
<div id="zzjy" style="display:none;margin-bottom:80px;">
    <div>
	
        <ul class="myjy_head"style="font-weight: 700;">
            <li style=" color:white;width: 10%">操作</li>
            <li style=" color:white;width: 20%">昵称</li>
            <li style=" color: white;width: 15%">等级</li>
            <li style=" color: white;width: 35%">GEC</li>
            <li style=" color: white;width: 20%">价格($)</li>
        </ul>
		
    </div>
    <div class="myjiaoyi_list">
	<?php if(is_array($lists)): foreach($lists as $key=>$v): ?><ul class="myjy_body"style="width:100%;margin-left:0%;margin-top:10px;background-color:transparent;">
            <li style=" color: rgb(0, 0, 0);width: 10%;"><input type="radio" name="xz" checked class="xz" value="<?php echo ($v["id"]); ?>" for="xxx"/></li>
            <li style=" color: rgb(0, 0, 0);width: 20%;height: 30px;text-align:center;overflow:hidden;text-overflow:ellipsis;white-space: nowrap;color: #FFFFFF"><?php echo ($v["g_name"]); ?></li>
            <li class=" iconfont" style=" color: rgb(0, 0, 0);width: 15%; font-size:12px;color: #FFFFFF" >
						<?php if($v["p_level"] == 0): ?>未激活<?php endif; ?>
						<?php if($v["p_level"] == 1): ?>GEC矿工<?php endif; ?>
						<?php if($v["p_level"] == 2): ?>工会会长<?php endif; ?>
						<?php if($v["p_level"] == 3): ?>A成长大使<?php endif; ?>
						<?php if($v["p_level"] == 4): ?>S形象大使<?php endif; ?>
						<?php if($v["p_level"] == 5): ?>R全球大使<?php endif; ?>
				
			</li>
            <li style=" color: rgb(0, 0, 0);width: 35%;color: #FFFFFF"><?php echo ($v["lkb"]); ?></li>
            <li style=" color: rgb(0, 0, 0);width: 20%;color: #FFFFFF" class="money"><?php echo ($v["jb"]); ?></li>
        </ul><?php endforeach; endif; ?>
	
	
	 <!-- <?php if($datatype == 'cslkb'): ?><ul class="myjy_tj";style="margin-bottom:80px">
			<?php if($v["p_user"] == $_SESSION['uname']): ?><li style="position: relative;">
			<div class="pic_show single">
							<if condition = "$tp eq 2">
                            <button type="button" name="IconPath" class="upload_one fl" id="photo_other"style="font-size:14px; width: 95%;height: 30px;border:0px;border-radius: 5px;background-color: #ddd;display: block;line-height: 30px;color: #000000;">上传图片</button><?php endif; ?>
							 <?php if($tp == 1): ?><button type="button" name="IconPath" class="upload_one fl" id="photo_other"style="font-size:14px; width: 95%;height: 30px;border:0px;border-radius: 5px;background-color: #ddd;display: block;line-height: 30px;color: #000000;">已经上传</button><?php endif; ?>
						  <div class="show_box fr single">

                                <ul id="lst_photo_other">

									<li>

									</li>

                                </ul>

                            </div>

                        </div>
				
				</li><?php endif; ?>
		
			<?php if($v["g_user"] == $_SESSION['uname']): ?><li><input type="button" class="ckpicture" value="查看图片" data-pic="请输入图片地址" style="font-size:14px; width: 95%;height: 30px;border:0px;border-radius: 5px;background-color: #ddd;display: block;line-height: 30px;color: #000000;  -webkit-appearance: none;"/></li><?php endif; ?>
            <?php if($v["p_user"] == $_SESSION['uname']): ?><li class="bl2"<a><button class="btnmaijia"style=" width: 95%;height: 30px;border:0px;border-radius: 5px;background-color: #ddd;display: block;line-height: 30px;color: #000000;font-size:14px;">卖家信息</button></a></li><?php endif; ?>
			<?php if($v["g_user"] == $_SESSION['uname']): ?><li class="bl2"><a><button class="btnmai"style=" width: 100%;height: 30px;border:0px;border-radius: 5px;background-color: #ddd;display: block;line-height: 30px;color: #000000;font-size:14px;">买家信息</button></a></li><?php endif; ?>
			<?php if($ts == 0): ?><li class="bl2">
             <button class="btntoushu"style=" width: 95%;height: 30px;border:0px;border-radius: 5px;background-color: #ddd;display: block;line-height: 30px;color: #000000;font-size:14px;">投诉<input class="tsid" type="hidden" value="1"/></button>
			</li><?php endif; ?>
            <?php if($v["p_user"] == $_SESSION['uname']): ?><li class="bl2"style="background-color:#ddd"><a href="#" class="quxiao"style="background-color:#ddd">取消交易</a></li><?php endif; ?>
			<?php if($v["g_user"] == $_SESSION['uname']): ?><li class="bl3" style="background-color:#ddd"><a href="#" class="wancheng" style="background-color:#ddd">完成交易</a></li><?php endif; ?>
			
        </ul>
	</if> -->
		<!-- 求购莱肯币菜单显示 -->
		<?php
 if($datatype=='qglkb'){ ?>
		<ul class="myjy_tj";style="margin-bottom:80px">
			<?php if($v["p_user"] == $_SESSION['uname']): ?><li style="position: relative;">
			<div class="pic_show single">
							<?php if($tp == 2): ?><button type="button" name="IconPath" class="upload_one fl" id="photo_other"style="font-size:14px; width: 95%;height: 30px;border:0px;border-radius: 5px;background-color: #ddd;display: block;line-height: 30px;color: #000000;">上传图片</button><?php endif; ?>
							 <?php if($tp == 1): ?><button type="button" name="IconPath"  id="photo_other"style="font-size:14px; width: 95%;height: 30px;border:0px;border-radius: 5px;background-color: #ddd;display: block;line-height: 30px;color: #000000;">已经上传</button><?php endif; ?>
						  <div class="show_box fr single">

                                <ul id="lst_photo_other">

									<li>

									</li>

                                </ul>

                            </div>

                        </div>
				
				</li><?php endif; ?>
		
			<?php if($v["g_user"] == $_SESSION['uname']): ?><li><input type="button" class="ckpicture" value="查看图片" data-pic="请输入图片地址" style="font-size:14px; width: 95%;height: 30px;border:0px;border-radius: 5px;background-color: #ddd;display: block;line-height: 30px;color: #000000;  -webkit-appearance: none;"/></li><?php endif; ?>
            <?php if($v["p_user"] == $_SESSION['uname']): ?><li class="bl2"<a><button class="btnmaijia"style=" width: 95%;height: 30px;border:0px;border-radius: 5px;background-color: #ddd;display: block;line-height: 30px;color: #000000;font-size:14px;">对方信息</button></a></li><?php endif; ?>
			<?php if($v["g_user"] == $_SESSION['uname']): ?><li class="bl2"><a><button class="btnmai"style=" width: 100%;height: 30px;border:0px;border-radius: 5px;background-color: #ddd;display: block;line-height: 30px;color: #000000;font-size:14px;">对方信息</button></a></li><?php endif; ?>
			<?php if($ts == 0): ?><li class="bl2">
             <button class="btntoushu"style=" width: 95%;height: 30px;border:0px;border-radius: 5px;background-color: #ddd;display: block;line-height: 30px;color: #000000;font-size:14px;">投诉<input class="tsid" type="hidden" value="1"/></button>
			</li><?php endif; ?>
            <?php if($v["p_user"] == $_SESSION['uname']): ?><li class="bl2"style="background-color:#ddd"><a href="#" class="quxiao" style="background-color:#ddd">取消交易</a></li><?php endif; ?>
			<?php if($v["g_user"] == $_SESSION['uname']): ?><li class="bl3" style="background-color:#ddd"><a href="#" class="wancheng" style="background-color:#ddd">完成交易</a></li><?php endif; ?>
			
        </ul>
		<?php }?>
		
		<!-- 出售莱肯币显示菜单 -->
		<?php
 if($datatype=='cslkb'){ ?>
		<ul class="myjy_tj";style="margin-bottom:80px">
		
            <li style="position: relative;">
			<div class="pic_show single">
						<?php if($v["g_user"] == $_SESSION['uname']): if($tp == 2): ?><button type="button" name="IconPath" class="upload_one fl" id="photo_other"style="font-size:14px; width: 95%;height: 30px;border:0px;border-radius: 5px;background-color: #ddd;display: block;line-height: 30px;color: #000000;">上传图片</button><?php endif; ?>
							 <?php if($tp == 1): ?><button type="button" name="IconPath"  id="photo_other"style="font-size:14px; width: 95%;height: 30px;border:0px;border-radius: 5px;background-color: #ddd;display: block;line-height: 30px;color: #000000;">已经上传</button><?php endif; endif; ?>	
						  <div class="show_box fr single">

                                <ul id="lst_photo_other">

									<li>

									</li>

                                </ul>

                            </div>

                        </div>
				
				</li>

		<?php if($v["p_user"] == $_SESSION['uname']): ?><li><input type="button" class="ckpicture" value="查看图片" data-pic="请输入图片地址" style="font-size:14px; width: 95%;height: 30px;border:0px;border-radius: 5px;background-color: #ddd;display: block;line-height: 30px;color: #000000;  -webkit-appearance: none;"/></li><?php endif; ?>   
		
		<?php if($v["g_user"] == $_SESSION['uname']): ?><li class="bl2"<a><button class="btnmai"style=" width: 95%;height: 30px;border:0px;border-radius: 5px;background-color: #ddd;display: block;line-height: 30px;color: #000000;font-size:14px;">对方信息</button></a></li><?php endif; ?> 	
		<?php if($v["p_user"] == $_SESSION['uname']): ?><li class="bl2"><a><button class="btnmaijia"style=" width: 100%;height: 30px;border:0px;border-radius: 5px;background-color: #ddd;display: block;line-height: 30px;color: #000000;font-size:14px;">对方信息</button></a></li><?php endif; ?> 	
			
			<li class="bl2">
             <button class="btntoushu"style=" width: 95%;height: 30px;border:0px;border-radius: 5px;background-color: #ddd;display: block;line-height: 30px;color: #000000;font-size:14px;">投诉<input class="tsid" type="hidden" value="1"/></button>
			</li>
			
         <?php if($v["g_user"] == $_SESSION['uname']): ?><li class="bl2"style="background-color:#ddd"><a href="#" class="csquxiao"style="background-color:#ddd">取消交易</a></li><?php endif; ?>
		<?php if($v["p_user"] == $_SESSION['uname']): ?><li class="bl3" style="background-color:#ddd"><a href="#" class="cswancheng" style="background-color:#ddd">完成交易</a></li><?php endif; ?>
			
        </ul>
		
	<?php }?>
    </div>
	 <div style="width:90%;margin-left:5%;padding-top:30px;font-size:12px">
		<P>交易提示：</P>
		<P>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;为保护您的资金安全，请使用您个人资料内绑定的支付方式向对方绑定的收款账号内付款，付款后请上传付款凭证图片，如使用绑定账户以外的账户交易，系统无法监管，会检测为虚假交易。</P>
	</div>
</div>
<div id="ywcjy"style="display: none;margin-bottom:80px;margin-top:-50px">
    <table  style="margin-top:60px;border-collapse:collapse;width:90%;margin-left:5%">
        <thead>
        <tr style="width:100%;background-color:transparent;">
            <th style="padding:10px 0">昵称</th>
            <th style="padding:10px 0">等级</th>
            <th style="padding:10px 0">GEC</th>
            <th style="padding:10px 0">总价($)</th>
          
        </tr>
        </thead>
        <tbody >
		 <?php if(is_array($oob)): foreach($oob as $key=>$s): ?><tr>
            <td style=" color:white;height:30px;line-height:30px;padding-left:10px;text-align:center;overflow:hidden;text-overflow:ellipsis;white-space: nowrap;"><?php echo ($s["p_name"]); ?></td>
            <td style=" color:white;height:30px;line-height:30px;text-align:center;font-size:12px; "class=" iconfont">
			
						<?php if($s["p_level"] == 0): ?>未激活<?php endif; ?>
						<?php if($s["p_level"] == 1): ?>GEC矿工<?php endif; ?>
						<?php if($s["p_level"] == 2): ?>工会会长<?php endif; ?>
						<?php if($s["p_level"] == 3): ?>A成长大使<?php endif; ?>
						<?php if($s["p_level"] == 4): ?>S形象大使<?php endif; ?>
						<?php if($s["p_level"] == 5): ?>R全球大使<?php endif; ?>
			
			</td>
            <td style=" color: white;height:30px;line-height:30px;text-align:center;"><?php echo ($s["lkb"]); ?></td>
            <td style=" color: white;height:30px;line-height:30px;text-align:center;" ><?php echo ($s["jb"]); ?></td>
            
        </tr><?php endforeach; endif; ?>
       <!--  <tr>
            <td style="padding:10px 0;text-align:center;">三九</td>
            <td style="padding:10px 0;text-align:center;">V3</td>
            <td style="padding:10px 0;text-align:center;">100.0001</td>
            <td style="padding:10px 0;text-align:center;">100.00</td>
            <td style="padding:5px 0;text-align:center;"><a href="#" style="background-color:#E64340;width: 100%;height: 100% ;border: 0px;border-radius: 5px;width: 40px;height: 25px;display: block;line-height: 25px;color: #fff">删除</a></td>
        </tr> -->
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
<script>
    document.getElementById('photo').addEventListener('change',function(e){
        var files = this.files;
        var img = new Image();
        var reader = new FileReader();
        reader.readAsDataURL(files[0]);
        reader.onload = function(e){
            var mb = (e.total/1024)/1024;
            if(mb>= 2){
                alert('文件大小大于2M');
                return;
            }
            img.src = this.result;
            img.style.height="100%";
            document.getElementById('click').innerHTML = '';
            document.getElementById('click').appendChild(img);
            $(".div1").css({"background":"#FFF"});
            $(".div2").html("<span style='float:right;margin-right:5px;color:#e4393c;'>成功</span>")
        }
    });
</script>
<!--底部结束-->
<script src="/Public/web/js/jquery-weui.min.js"></script>



<!-- 汇率转换 -->
	<script>
    $(function(){
		$(".money").bind("click",function(){
			var huilv=$(this).html();
			$("#UpBox").fadeOut();
			$.ajax({
				url:"<?php echo U('/index.php/Home/Info/huilv');?>",
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
<script>
     function showhidediv(id) {
        console.log(id);
        var qiugou = document.getElementById("qiugou");
        var chushou=document.getElementById("chushou");
        var zhengzai = document.getElementById("zzjy");
        var wancheng = document.getElementById('ywcjy');
        var qiugoubg = document.getElementById("qiugoubg");
        var chushoubg=document.getElementById("chushoubg");
        var zhengzaibg = document.getElementById('zzjybg');
        var wancehngbg = document.getElementById('ywcjybg');
        if (id == "zzjy") {
            wancheng.style.display = 'none';
            zhengzai.style.display = 'block';
            qiugou.style.display = 'none';
            chushou.style.display = 'none';
            qiugoubg.style.backgroundColor = "#02d2f5"
			qiugoubg.style.color = "#fff"
            chushoubg.style.backgroundColor = "#02d2f5"
            chushoubg.style.color = "#fff"
            zhengzaibg.style.backgroundColor = "#fff";
			zhengzaibg.style.color = "#000";
            wancehngbg.style.backgroundColor = "#02d2f5";
			wancehngbg.style.color = "#fff";
        }else if (id =='chushou') {
            zhengzai.style.display = 'none';
            wancheng.style.display = 'none';
            qiugou.style.display = 'none';
            chushou.style.display='block';
            chushoubg.style.backgroundColor = "#fff";
            qiugoubg.style.backgroundColor = "#02d2f5";
            zhengzaibg.style.backgroundColor = "#02d2f5";
            wancehngbg.style.backgroundColor = "#02d2f5";
            qiugoubg.style.color= "#fff"
            zhengzaibg.style.color = "#fff";
            wancehngbg.style.color = "#fff";
            chushoubg.style.color = "#000";
        }else if (id =='ywcjy') {
                zhengzai.style.display = 'none';
                wancheng.style.display = 'block';
                qiugou.style.display = 'none';
                chushou.style.display = 'none';
                qiugoubg.style.backgroundColor = "#02d2f5"
                chushoubg.style.backgroundColor = "#02d2f5"
                zhengzaibg.style.backgroundColor = "#02d2f5";
				qiugoubg.style.color= "#fff"
				chushoubg.style.color= "#fff"
                zhengzaibg.style.color = "#fff";
                wancehngbg.style.backgroundColor = "#fff";
				wancehngbg.style.color = "#000";
            }else if(id=='qiugou'){
                chushou.style.display='none';
                zhengzai.style.display = 'none';
                wancheng.style.display = 'none';
                qiugou.style.display = 'block';
                qiugoubg.style.backgroundColor = "#fff";
				qiugoubg.style.color = "#000";
                zhengzaibg.style.backgroundColor = "#02d2f5";
                chushoubg.style.backgroundColor = "#02d2f5";
                wancehngbg.style.backgroundColor = "#02d2f5";
				zhengzaibg.style.color = "#fff";
                wancehngbg.style.color = "#fff";
                chushoubg.style.color = "#fff";
                }
    }
</script>
<!--投诉-->
<script>
    $(".btntoushu").bind("click",function() {
        var oid="";
        $(".xz").map(function(index,item){
            if($(this).is(":checked")){
                oid=$(this).val();
            }
        })
        if(oid==""){
            $.alert("请选择要操作的订单");
        }else {
            $.showLoading();
            $.ajax({
                url:"<?php echo U('/index.php/Home/Info/gettime');?>",
                type:"get",
                data:{id:oid},
                dataType:"json",
                success:function(data){
                    var time=new Date().getTime();
                    var time2=data*1000;
                    if(time>time2){
                       $.prompt("请输入您要投诉的内容", function () {
                                $.ajax({
                                    url: "<?php echo U('/index.php/Home/Info/tousu');?>",
                                    ype: "get",
                                    data: {id: oid, txt: $("#weui-prompt-input").val()},
                                    success: function (data) {
                                        console.log(data);
                                        $.alert(data);
                                    },
                                    error: function () {
                                        alert("网络错误请重试");
                                    }
                                });
                            })

                    }else{
                        var time1=parseInt(time/1000);
                        var dd=parseInt(parseInt(time2)/1000-time1);
                        var h=parseInt(dd/3600);
                        var m=parseInt(dd%3600/60);
                        var s=parseInt(dd%3600%60);
                        console.log(dd,h,m,s);
                        h=h.toString().length==1?"0"+h:h;
                        m=m.toString().length==1?"0"+m:m;
                        s=s.toString().length==1?"0"+s:s;
                        var str=h+":"+m+":"+s;
                        $.alert(str,'现在无法投诉',function(){
                          location.reload();
                        });
                        var djs=setInterval(function(){
                            time1++;
                            dd=parseInt(parseInt(time2)/1000-time1);
                            h=parseInt(dd/3600);
                            m=parseInt(dd%3600/60);
                            s=parseInt(dd%3600%60);
                            h=h.toString().length==1?"0"+h:h;
                            m=m.toString().length==1?"0"+m:m;
                            s=s.toString().length==1?"0"+s:s;
                            str=h+":"+m+":"+s;
                            if(parseInt(h)<=0&&parseInt(m)<=0&&parseInt(s)<=0){
                               $(".weui_dialog_bd").html("可以投诉了,请重新点击");
                               clearInterval(djs);
                            }else{
                               $(".weui_dialog_bd").html(str);
                            }
                        },1000);
                    }

                },error:function(){
                    console.log("网络错误");
                },complete:function(){
                    $.hideLoading();
                }    
            });
        }
    })
</script>
<!--卖家信息-->
<script>
    $(".btnmaijia").bind("click",function() {
        var oid="";
        $(".xz").map(function(index,item){
            if($(this).is(":checked")){
                oid=$(this).val();
            }
        })
        if(oid==""){
            $.alert("请选择要操作的订单");
        }else {
            $.ajax({
                url:"<?php echo U('/index.php/Home/Info/mjxx');?>",
                type: "get",
                data: {id: oid, txt: $("#weui-prompt-input").val()},
                success: function (data) {
				console.log(data);
                    $.modal({
                        title: data.name,
                        text: "<div style='text-align:left'>USD："+data.meiyuan+"<br>"+"RMB："+data.rmb+"<br>"+"BTC："+data.btc+"<br>"+"昵称："+data.ue_truename+"<br>"+"手机号："+data.phone+"<br>"+"BTC钱包："+data.btcaddress+"<br>"+"姓名："+data.zhxm+"<br>"+"银行名称："+data.yhmc+"<br>"+"银行卡号："+data.yhzh+"<br>"+"支付宝："+data.zfb+"<br>"+"微信号："+data.weixin+"</div>",
                        buttons:[
                            { text: "确定", className: "default", onClick: function(){ } },
                        ]
                    })
                },
                error: function () {
                    $.alert("网络错误请重试");
                }
            });
            }
    })
</script>
<!--买家信息-->
<script>
    $(".btnmai").bind("click",function() {
        var oid="";
        $(".xz").map(function(index,item){
            if($(this).is(":checked")){
                oid=$(this).val();
            }
        })
        if(oid==""){
            $.alert("请选择要操作的订单");
        }else {
            $.ajax({
                url:"<?php echo U('/index.php/Home/Info/maijia');?>",
                type: "get",
                data: {id: oid, txt: $("#weui-prompt-input").val()},
                success: function (data) {
				console.log(data);
                    $.modal({
                        title: data.name,
                        text: "<div style='text-align:left'>USD："+data.meiyuan+"<br/>"+"RMB："+data.rmb+"<br>"+"BTC："+data.btc+"<br>"+"昵称："+data.ue_truename+"<br>"+"手机号："+data.phone+"<br>"+"BTC钱包："+data.btcaddress+"<br>"+"姓名："+data.zhxm+"<br>"+"银行名称："+data.yhmc+"<br>"+"银行卡号："+data.yhzh+"<br>"+"支付宝："+data.zfb+"<br>"+"微信号："+data.weixin+"</div>",

                        buttons:[
                            { text: "确定", className: "default", onClick: function(){ } },
                        ]
                    })
                },
                error: function () {
                    $.alert("网络错误请重试");
                }
            });
            }
    })
</script>
<!--图片-->
<script>
    $(".ckpicture").bind("click",function() {
        var oid="";
        $(".xz").map(function(index,item){
            if($(this).is(":checked")){
                oid=$(this).val();
            }
        })
        if(oid==""){
            $.alert("请选择要操作的订单");
        }else {
            $.ajax({
                url:"<?php echo U('/index.php/Home/Info/cktp');?>",
                type: "get",
                data: {id: oid},
                success: function (data) {
				  $.modal({
                        title:"",
                        text: "<img src=\"/Uploads/"+data+"\" width='60%'>",
                        buttons:[
                            { text: "确定", className: "default", onClick: function(){ } },
                        ]
                    })
                },
                error: function () {
                    $.alert("网络错误请重试");
                }
            });
        }
    })
    $(".quxiao").bind("click",function() {
        var oid="";
        $(".xz").map(function(index,item){
            if($(this).is(":checked")){
                oid=$(this).val();
            }
        })
        if(oid==""){
            $.alert("请选择要操作的订单");
        }else {
            $.confirm("您确定要取消订单吗？",function(){
                $.ajax({
                    url:"<?php echo U('/index.php/Home/Info/qxdd');?>",
                    type: "get",
                    data: {id: oid},
                    success: function (data) {
						console.log(data);
                        $.alert(data);
						location.href ="/index.php/Home/Info/myjiaoyi/";
                    },
                    error: function () {
                        $.alert("网络错误请重试");
                    }
                });
            })
        }
    })
	//出售取消
	 $(".csquxiao").bind("click",function() {
        var oid="";
        $(".xz").map(function(index,item){
            if($(this).is(":checked")){
                oid=$(this).val();
            }
        })
        if(oid==""){
            $.alert("请选择要操作的订单");
        }else {
            $.confirm("您确定要取消订单吗？",function(){
                $.ajax({
                    url:"<?php echo U('/index.php/Home/Info/csqx');?>",
                    type: "get",
                    data: {id: oid},
                    success: function (data) {
						console.log(data);
                        $.alert(data);
						location.href ="/index.php/Home/Info/myjiaoyi/";
                    },
                    error: function () {
                        $.alert("网络错误请重试");
                    }
                });
            })
        }
    })
	
	
    $(".wancheng").bind("click",function() {
        var oid="";
        $(".xz").map(function(index,item){
            if($(this).is(":checked")){
                oid=$(this).val();
            }
        })
        if(oid==""){
            $.alert("请选择要操作的订单");
        }else if(<?php echo ($tp); ?>==2){
			$.alert("请等待对方付款完成！");
		}else{
            $.confirm("您确定要完成订单吗？",function(){
                $.ajax({
                    url:"<?php echo U('/index.php/Home/Info/wancheng');?>",
                    type: "get",
                    data: {id: oid},
                    success: function (data) {
					dataType:"json",
					console.log(data.msg);
                        if (data.status == 1) {
                            $.alert(data.msg, function () {
                                location.href ="/index.php/Home/Info/myjiaoyi/";
                            });
                        } else {

                        $.alert(data);
                    }
                    },
                    error: function() {
                        $.alert("网络错误请重试");
                    }
                });
            })
        }
    })
	
	
	//出售订单完成
	$(".cswancheng").bind("click",function() {
        var oid="";
        $(".xz").map(function(index,item){
            if($(this).is(":checked")){
                oid=$(this).val();
            }
        })
        if(oid==""){
            $.alert("请选择要操作的订单");
        }else if(<?php echo ($tp); ?>==2){
			$.alert("请等待对方付款完成！");
		}else{
            $.confirm("您确定要完成订单吗？",function(){
                $.ajax({
                    url:"<?php echo U('/index.php/Home/Info/cswancheng');?>",
                    type: "get",
                    data: {id: oid},
                    success: function (data) {
					dataType:"json",
					console.log(data.msg);
                        if (data.status == 1) {
                            $.alert(data.msg, function () {
                                location.href ="/index.php/Home/Info/myjiaoyi/";
                            });
                        } else {

                        $.alert(data);
                    }
                    },
                    error: function() {
                        $.alert("网络错误请重试");
                    }
                });
            })
        }
    })
</script>

<!--取消交易-->

</body>
</html>