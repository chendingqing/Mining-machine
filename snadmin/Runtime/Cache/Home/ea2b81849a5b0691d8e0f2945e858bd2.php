<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<!--[if lt IE 7 ]>
<html lang="en" class="ie6 ielt8"> <![endif]-->
<!--[if IE 7 ]>
<html lang="en" class="ie7 ielt8"> <![endif]-->
<!--[if IE 8 ]>
<html lang="en" class="ie8"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!-->
<html lang="en"> <!--<![endif]-->
<head lang="en">
    <meta charset="UTF-8">
    <title>欢迎登陆某某后台软件</title>
    <!--meta:vp 手机临时分辨率-->
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0"/>
    <!--meta:compat 调整浏览器内核-->
    <meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1"/>
    <link rel="stylesheet" href="/sncss/wxqf/css/bootstrap.min.css"/>
    <script src="/sncss/wxqf/js/jquery-1.11.3.js"></script>
    <script src="/sncss/wxqf/js/bootstrap.min.js"></script>
    <!--[if lte IE 8]>
    <script src="js/html5shiv.min.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->
    <style>
        #jdt {
            margin-top: 20px;
        }

        #addsj {
            max-height: 500px;
            overflow-y: auto;
            border: 1px solid #ddd;
        }

        #addsj li {
            width: 25%;
            float: left;
            line-height: 30px;
        }

        #jdt .sr-only {
            width: auto;
            height: auto;
            overflow: auto;
            clip:auto;
        }
        #btn {
            margin-top: 10px;
        }

        @media (max-width: 768px) {
            #addsj li {
                width: 33%;
            }
        }

        @media (max-width: 400px) {
            #addsj li {
                width: 50%;
            }
        }
    </style>
</head>
<body>
<div class="container">
    <div class="page-header">
        <h1 class="title">微信群发&nbsp;<small>-zwb</small></h1>
    </div>
    <div class="input-group">
        <span class="input-group-addon">总数</span>
        <input type="text" class="form-control" id="num" placeholder="输入发送总数" autocomplete>
        <span class="input-group-addon">个数</span>
        <input type="text" class="form-control" id="size" placeholder="每次发送的个数" autocomplete>
        <span class="input-group-addon">时间</span>
        <input type="text" class="form-control" id="a" placeholder="每次发送的时间(秒)" autocomplete>
        <span class="input-group-addon">ID</span>
        <input type="text" class="form-control" id="dd" placeholder="开始的ID" autocomplete>
    </div>
    <div class="input-group">
    	<span class="input-group-addon">内容</span>
        <textarea name="str" id="str" cols="15" rows="5" class="form-control"></textarea>
<!--         <input type="text" class="form-control" id="str" placeholder="发送的内容" autocomplete > -->
    </div>
    <div class="input-group">
    	 <span class="input-group-addon">网址</span>
        <input type="text" class="form-control" id="url" placeholder="发送的网址"  value="/admin8899.php/Home/Index/kefu" autocomplete>
    </div>
    <div id="btn">
        <button class="btn btn-danger" id="add">发送</button>
        <button class="btn btn-danger" id="fh">返回</button>
    </div>
    <div class="progress" id="jdt">
        <div id="meta" class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="45"
             aria-valuemin="0" aria-valuemax="0" style="width: 0%">
            <span class="sr-only">0%</span>
        </div>
    </div>
    <h5 class="page-header">发送成功的数据将要显示在这里</h5>
    <ul id="addsj"></ul>

</div>
<script>
    $(function () {
    	    // 初始化定时器
            var timer = null;
        function add(obj) {
        	// 清除警告信息
             if($("#alert_box div")){
             	$("#alert_box").remove();
             }
         	// 插入警告信息
        	$(".page-header").after('<div id="alert_box"><div class="alert alert-info alert-dismissible" role="alert" style="display:none" id="danger"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong>警告!</strong> 您输入总数必须是大于零的自然数 (num>=0[type=int])</div><div class="alert alert-success alert-dismissible" role="alert" style="display:none" id="warn"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong>警告!</strong> 您输入每次执行的次数必须是大于零的自然数 (a>=0[type=int])</div><div class="alert alert-warning alert-dismissible" role="alert" style="display:none" id="tim"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong>警告!</strong>您输入时间必须是大于等于零的自然数或者小数 (time>=0[type=int/float])</div><div id="alert_box"><div class="alert alert-danger alert-dismissible" role="alert" style="display:none" id="idd"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong>警告!</strong> 您输入ID必须是大于等于零的自然数 (id>=0[type=int])</div><div id="alert_box"><div class="alert alert-danger alert-dismissible" role="alert" style="display:none" id="ts"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong>提示!</strong> 您输入的每次执行的次数大于总数,结果只会执行总数的次数！！！</div></div>');
            // 请求数据的总数
            var num = parseInt($("#num").val());
            // console.log(num);
            // 每次请求的次数
            var size = parseInt($("#size").val());
            // console.log(size);
            // 请求的时间间隔
            var a = parseFloat($("#a").val())*1000;
            // console.log(a);
//            发送的内容
            var str = $("#str").val();
            console.log(str);
            // 输入起始id
            var index = parseInt($("#dd").val());
            // console.log(index);
            var urll =  $("#url").val();
//            http://bbb.lj100.cn/index.php?g=Api&m=Api&a=kefu&content=
            // console.log(urll);
            // 控制周期性定时器的结束
            var pp = num + index;
            // 控制进度条的全局变量
             var n=0;
             // 清除定时器
             clearInterval(timer);
             // 初始化发从成功提示
            $("#addsj").html("");
            // 初始化页头
            $(".title").html("微信群发&nbsp;<small>-zwb</small>").css("color", "#000");
            // 控制meta进度的变量
            $("#meta").css("width","0%");
            // 初始化进度条的总长度
            $("#meta").attr("aria-valuemax", num);  
            // console.log("size"+size);  
            // 清空进度条数值
            $(".sr-only").html(0+"%");
            // 判断填写的次数是否大于总数
            if(size>num){
            	$("#ts").show(0.5);
            }
            // 判断是否填写数值
            var pd=true;
            if($("#size").val()<=0||!$("#size").val()){
            	$("#warn").show(0.5);
            	pd=false;
            }
            if($("#num").val()<=0||!$("#num").val()){
            	$("#danger").show(0.5);
            	pd=false;
            }
            if($("#a").val()<0||!$("#a").val()){
            	$("#tim").show(0.5);
            	pd=false;
            }
            if($("#dd").val()<0||!$("#dd").val()){
            	$("#idd").show(0.5);
            	pd=false;
            }
           if(pd==false){
               return false;
           }     
            if(size>=num){
            	  timer = setTimeout(function () {
//           创建for循环请求数据
                for (var i = index; i <(index + size) && i <= pp; i++) {
                    //请求网址
                    // console.log("一次性定时器" + i);
                    // console.log(index+size);
                    $.ajax({
                        url: urll,
                        type: "get",
                        data: {"content":str,"id":i},
                        dataType: "jsonp",
                        complete : function () {
                            return false;
                        }
                    });
                    n++;
                    // console.log(n);
                    $("#addsj").append('<li>第<span>' + i + '</span>数据<i>发送成功</i></li>');
                    $(".sr-only").html(100+"%");
                    $("#meta").css("width",100 + "%");
                }      
                $(".title").html("恭喜您！数据发送完成").css("color", "#e4393c");
                clearTimeout(timer);
                return true;
            }, 0)
            }else if(size<num){
//        创建一次性定时器
            timer = setTimeout(function () {
//           创建for循环请求数据
                for (var i = index; i <(index + size) && i <= pp; i++) {
                    //请求网址
                    // console.log("一次性定时器" + i);
                    // console.log(index+size);
                    $.ajax({
                        url: urll,
                        type: "get",
                        data: {"content":str,"id":i},
                        dataType: "jsonp",
                        complete : function () {
                            return false;
                        }
                    });
                    n++;
                    // console.log(n);
                    $("#addsj").append('<li>第<span>' + i + '</span>数据<i>发送成功</i></li>');
                    $(".sr-only").html(n/num*100+"%");
                    $("#meta").css("width", n / num * 100 + "%");
                }      
                index += size;
            }, 0);
            timer = setInterval(function () {
                // 判断是否到什么时候结束  清楚定时器
                // console.log("判断结束" + index);
                for (var i = index; i <(index + size) && i <= pp; i++) {
                    // console.log("周期性定时器" + i);
                    // 请求网址
                    $.ajax({
                        url: urll,
                        type: "get",
                        data: {"content":str,"id":i},
                        dataType: "jsonp",
                        complete : function (data) {
                             return false;
                        }
                    });
                    n++;
                    // console.log(n);
                    if ( i>= pp) {
                    $(".title").html("恭喜您！数据发送完成&nbsp;<small>-zwb</small>").css("color", "#e4393c");
                    clearInterval(timer);
                    return false;
                    }
                    if(num%size!=0&&pp==i){
                    	break;
                    }
                    $("#addsj").append('<li>第<span>' + i + '</span>数据<i>发送成功</i></li>');
                    if(n>=num){
                     $(".sr-only").html(100+"%");
                     $("#meta").css("width", 100 + "%");
                    }else{
                      $(".sr-only").html(n/num*100+"%");
                      $("#meta").css("width", n / num * 100 + "%");
                    }
                }

                    index += size;
//            console.log(index/num*100+"%");
//            console.log(index);
            }, a);
          }
          return true; 
        }
        $("#add").click(function () {
            add();
        })
        $("#fh").click(function () {
        	clearInterval(timer);
        	$(".sr-only").html(0+"%");
        	$("#ts").hide(0.5);
        	$("#warn").hide(0.5);
        	$("#danger").hide(0.5);
        	$("#tim").hide(0.5);
        	$("#idd").hide(0.5);
            $("#num").val("");
            $("#size").val("");
            $("#a").val("");
            $("#str").val("");
            $("#dd").val("");
//            $("#url").val("");
            $("#meta").css("width","0%");
            $("#addsj").html("");
            $(".title").html("微信群发&nbsp;<small>-zwb</small>").css("color", "#000");
        })
    });
</script>
</body>
<html>