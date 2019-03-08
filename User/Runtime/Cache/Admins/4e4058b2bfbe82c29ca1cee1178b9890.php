<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8">
    <title>登录</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=0">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="format-detection" content="telephone=no">
    <meta name="wap-font-scale" content="no">
    <!--<link rel="stylesheet" href="/Public/common/bootstrap-4.0.0/css/bootstrap.min.css">-->
</head>
<body>
<div>
    <form action="" method="post" onsubmit="return false;">
        <div>
            <ul>
                <li>
                    <div>
                        <label for="username"><i></i>&nbsp;</label>
                        <span><input type="text" id="username" name="admin_name"  onkeyup="this.value=this.value.replace(/ /g,'')" maxlength="60" class="input-txt" placeholder="请输入帐号" /></span>
                    </div>
                </li>
                <li>
                    <div>
                        <label for="password"><i></i>&nbsp;</label>
                        <span><input type="password" id="password" name="admin_pass" onkeyup="this.value=this.value.replace(/ /g,'')"  maxlength="26" class="input-txt" placeholder="请输入登录密码" /></span>
                    </div>
                </li>
            </ul>
        </div>
        <div>
            <button onclick="do_submit()">登录</button>
        </div>
    </form>
</div>
</body>
<script src="/Public/web/js/jquery-1.8.3.min.js"></script>
<script src="/Public/bang/layer-v3.1.1/layer/layer.js"></script>
<script>
    function do_submit(){
        layer.load(1, {
            shade: [0.1,'#000']
        });
        $.ajax({
            url:"<?php echo U('login/index');?>",
            type:"post",
            data:$("form").serialize(),
            dataType:"json",
            success:function(data){
                layer.closeAll();
                layer.msg(data.info,{time:1500},function () {
                    if(data.status == 1){
                        location.href="<?php echo U('Index/index');?>";
                    }
                });
            },error:function(){

            },comptele:function(){

            }
        })
    }
</script>

</html>