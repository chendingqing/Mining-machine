<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1, minimum-scale=1.0"/>
    <meta content="telephone=no" name="format-detection">
    <title>矿机商城</title>
    <link href="/Public/bang/css/mui.min.css" rel="stylesheet" />
	<link href="/Public/bang/css/kj_resert.css" rel="stylesheet" />
	<link href="/Public/bang/css/kj_public.css" rel="stylesheet" />
	<link href="/Public/bang/css/kj_geren_shouyi-jiaoyi.css" rel="stylesheet" />
    <style>
        header{
            -webkit-box-shadow: 0 0 0 #49bdff !important;
            box-shadow: 0 0 0 #49bdff !important;
        }
        .nav{
            overflow: hidden;
            background: #31b4ff;
            height: 36px;
            line-height: 24px;
        }
        .nav span{
            float: left;
            width: 20%;
            text-align: center;
            color: #ffffff;
            font-size: 14px;
            margin: 0 2.5%;
        }
        .selected{
            border-bottom: 3px solid #0c85ca;
        }
        #tab-content{
            font-size: 12px;
        }
        table{
            width: 100%;
            margin-left:0 !important;
        }
        .mui-table-view-cell:after{
            width: 94%;
            left:  3%!important;
        }
        #tab-content ul{
            display: block;
        }
        td{
            padding: 1%;
        }
        .header-right{
            position: relative;
            right: -90%;
            top: -70%;
        }
        .zyz-button{
            width: 100%;
            height: 36px;
            border:0;
            border-radius: 5px;
            background-color: #ddd;
            display: block;
            color: #000000;
            font-size:14px;
        }
        .layui-layer-rim{
            width: 90% !important;
        }
    </style>
</head>
<body>
    <header class="mui-navbar-inner mui-bar mui-bar-nav" style="background: #31b4ff;">
        <h1 class="mui-title" style="color:#FFF;">我的交易</h1>
        <a href="<?php echo U('user');?>" class="left-icon">
            <img src="/Public/bang/images/head_back_icon.png"/>
        </a>
        <a href="<?php echo U('jiaoyizhongxin');?>" class="mui-pull-right header-right">
            <img src="/Public/bang/images/jiaoyidating.png" width="11%" />
        </a>
    </header>
    <div class="mui-content">
        <div class="nav">
            <span class="selected">求购列表</span>
            <span>出售列表</span>
            <span>交易列表</span>
            <span>已完成列表</span>
        </div>
        <div id="tab-content">
            <!-- 求购 -->
            <ul class="mui-table-cell">
                <li class="mui-table-view-cell">
                    <table>
                        <tr>
                            <td width="20%">呢称</td>
                            <td width="22%">个数(AD)</td>
                            <td width="17%">价格($)</td>
                            <td width="24%">是否取消</td>
                            <td width="17%">状态</td>
                        </tr>
                    </table>
                </li>
                <?php if(is_array($qiugou)): foreach($qiugou as $key=>$qg): ?><li class="mui-table-view-cell">
                        <table>
                            <tr>
                                <td width="20%"><?php echo ($qg["p_name"]); ?></td>
                                <td width="22%"><?php echo ($qg["lkb"]); ?></td>
                                <td width="17%"><?php echo ($qg["jb"]); ?></td>
                                <td width="24%">
                                    <button type="button" class="mui-btn mui-btn-primary function_click" data-url="<?php echo U('delqiugou');?>" data-id="<?php echo ($qg["id"]); ?>">取&emsp;消</button>
                                </td>
                                <td width="17%"><?php switch($qg["zt"]): case "0": ?>未交易<?php break;?>
                                    <?php case "1": ?>交易中<?php break;?>
                                    <?php case "2": ?>交易完成<?php break; endswitch;?></td>
                            </tr>
                        </table>
                    </li><?php endforeach; endif; ?>
            </ul>

            <!-- 出售 -->
            <ul class="mui-table-cell hide">
                <li class="mui-table-view-cell">
                    <table>
                        <tr>
                            <td width="20%">呢称</td>
                            <td width="22%">个数(AD)</td>
                            <td width="17%">价格($)</td>
                            <td width="24%">是否取消</td>
                            <td width="17%">状态</td>
                        </tr>
                    </table>
                </li>
                <?php if(is_array($chushou)): foreach($chushou as $key=>$cs): ?><li class="mui-table-view-cell">
                        <table>
                            <tr>
                                <td width="20%"><?php echo ($cs["p_name"]); ?></td>
                                <td width="22%"><?php echo ($cs["lkb"]); ?></td>
                                <td width="17%"><?php echo ($cs["jb"]); ?></td>
                                <td width="24%">
                                    <button type="button" class="mui-btn mui-btn-primary function_click" data-url="<?php echo U('delchushou');?>" data-id="<?php echo ($cs["id"]); ?>">取&emsp;消</button>
                                </td>
                                <td width="17%"><?php switch($cs["zt"]): case "0": ?>未交易<?php break;?>
                                    <?php case "1": ?>交易中<?php break;?>
                                    <?php case "2": ?>交易完成<?php break; endswitch;?></td>
                            </tr>
                        </table>
                    </li><?php endforeach; endif; ?>
            </ul>

            <!-- 交易 -->
            <ul class="mui-table-cell hide">
                <li class="mui-table-view-cell">
                    <table>
                        <tr>
                            <td width="20%">操作</td>
                            <td width="40%">呢称</td>
                            <!--<td style="width: 65px;">等级</td>-->
                            <td width="20%">AD</td>
                            <td width="20%">价格($)</td>
                        </tr>
                    </table>
                </li>
                <?php if(is_array($zyz)): foreach($zyz as $key=>$jl): ?><li class="mui-table-view-cell">
                        <table>
                            <tr>
                                <td width="20%">
                                    <input type="radio" name="xz" checked class="xz" value="<?php echo ($v["id"]); ?>"/>
                                </td>
                                <td width="40%"><?php echo ($jl["g_name"]); ?></td>
                                <!--<td class="spang1"><?php switch($jl["p_level"]): case "0": ?>未激活<?php break;?>
                                    <?php case "1": ?>GEC矿工<?php break;?>
                                    <?php case "2": ?>工会会长<?php break;?>
                                    <?php case "3": ?>A成长大使<?php break;?>
                                    <?php case "4": ?>S形象大使<?php break;?>
                                    <?php case "5": ?>R全球大使<?php break; endswitch;?></td>-->
                                <td width="20%"><?php echo ($jl["lkb"]); ?></td>
                                <td width="20%"><?php echo ($jl["jb"]); ?></td>
                            </tr>
                        </table>
                        <table style="margin-top: 20px;">
                            <tr>
                                <!-- 求购交易菜单 -->
                                <?php if($jl["datatype"] == 'qglkb'): if($jl["p_user"] == $uname): ?><td width="25%">
                                            <?php if(empty($jl["imagepath"])): ?><form method="post" enctype="multipart/form-data">
                                                    <button class="zyz-button" style="position: relative;">
                                                        <input type="file" accept="image/*" id="zyz-upload" data-pid="<?php echo ($jl["id"]); ?>" name="zyz_upload_one" style="alpha(opacity=0);-moz-opacity:0;opacity:0; width: 100%; height:100%; z-index: 100; padding: 0; margin: 0; position: absolute; top: 0; left: 0;"/>
                                                        <span style="position: absolute; top:0; left: 0; float: left; width: 100%; height: 100%; line-height: 36px;">上传图片</span>
                                                    </button>
                                                </form>
                                            <?php else: ?>
                                                <button class="zyz-button zyz-imagepath" data-pid="<?php echo ($jl["id"]); ?>">已经上传</button><?php endif; ?>
                                        </td>
                                        <td width="25%"><button class="zyz-button zyz-phone" data-phone="<?php echo ($jl["g_user"]); ?>">联系方式</button></td>
                                        <td width="25%"><button class="zyz-button zyz-tousu" data-pid="<?php echo ($jl["id"]); ?>">投诉</button></td>
                                        <td width="25%"><button class="zyz-button zyz-del" data-pid="<?php echo ($jl["id"]); ?>">取消交易</button></td><?php endif; ?>
                                    <?php if($jl["g_user"] == $uname): ?><td width="25%"><button class="zyz-button zyz-imagepath" data-pid="<?php echo ($jl["id"]); ?>">查看图片</button></td>
                                        <td width="25%"><button class="zyz-button zyz-phone" data-phone="<?php echo ($jl["p_user"]); ?>">联系方式</button></td>
                                        <td width="25%"><button class="zyz-button zyz-tousu" data-pid="<?php echo ($jl["id"]); ?>">投诉</button></td>
                                        <td width="25%"><button class="zyz-button zyz-complete" data-pid="<?php echo ($jl["id"]); ?>">完成交易</button></td><?php endif; endif; ?>

                                <!-- 出售交易菜单 -->
                                <?php if($jl["datatype"] == 'cslkb'): if($jl["g_user"] == $uname): ?><td width="25%">
                                            <?php if(empty($jl["imagepath"])): ?><form method="post" enctype="multipart/form-data">
                                                    <button class="zyz-button" style="position: relative;">
                                                        <input type="file" accept="image/*" id="zyz-upload" data-pid="<?php echo ($jl["id"]); ?>" name="zyz_upload_one" style="alpha(opacity=0);-moz-opacity:0;opacity:0; width: 100%; height:100%; z-index: 100; padding: 0; margin: 0; position: absolute; top: 0; left: 0;"/>
                                                        <span style="position: absolute; top:0; left: 0; float: left; width: 100%; height: 100%; line-height: 36px;">上传图片</span>
                                                    </button>
                                                </form>
                                            <?php else: ?>
                                                <button class="zyz-button zyz-imagepath" data-pid="<?php echo ($jl["id"]); ?>">已经上传</button><?php endif; ?>
                                        </td>
                                        <td width="25%"><button class="zyz-button zyz-phone" data-phone="<?php echo ($jl["p_user"]); ?>">联系方式</button></td>
                                        <td width="25%"><button class="zyz-button zyz-tousu" data-pid="<?php echo ($jl["id"]); ?>">投诉</button></td>
                                        <td width="25%"><button class="zyz-button zyz-del" data-pid="<?php echo ($jl["id"]); ?>">取消交易</button></td><?php endif; ?>
                                    <?php if($jl["p_user"] == $uname): ?><td width="25%"><button class="zyz-button zyz-imagepath" data-pid="<?php echo ($jl["id"]); ?>">查看图片</button></td>
                                        <td width="25%"><button class="zyz-button zyz-phone" data-phone="<?php echo ($jl["g_user"]); ?>">联系方式</button></td>
                                        <td width="25%"><button class="zyz-button zyz-tousu" data-pid="<?php echo ($jl["id"]); ?>">投诉</button></td>
                                        <td width="25%"><button class="zyz-button zyz-complete" data-pid="<?php echo ($jl["id"]); ?>">完成交易</button></td><?php endif; endif; ?>
                            </tr>
                        </table>
                    </li><?php endforeach; endif; ?>
            </ul>

            <!-- 已完成 -->
            <ul class="mui-table-cell hide">
                <li class="mui-table-view-cell">
                    <table>
                        <tr>
                            <td width="40%">呢称</td>
                            <!--<td style="width: 85px;">等级</td>-->
                            <td width="30%">AD</td>
                            <td width="30%">总价($)</td>
                        </tr>
                    </table>
                </li>
                <?php if(is_array($oob)): foreach($oob as $key=>$s): ?><li class="mui-table-view-cell">
                        <table>
                            <tr>
                                <td width="40%"><?php echo ($s["p_name"]); ?></td>
                                <!--<td class="spang1"><?php switch($jl["p_level"]): case "0": ?>未激活<?php break;?>
                                    <?php case "1": ?>GEC矿工<?php break;?>
                                    <?php case "2": ?>工会会长<?php break;?>
                                    <?php case "3": ?>A成长大使<?php break;?>
                                    <?php case "4": ?>S形象大使<?php break;?>
                                    <?php case "5": ?>R全球大使<?php break; endswitch;?></td>-->
                                <td width="30%"><?php echo ($s["lkb"]); ?></td>
                                <td width="30%"><?php echo ($s["jb"]); ?></td>
                            </tr>
                        </table>
                    </li><?php endforeach; endif; ?>
            </ul>
        </div>
    </div>
</body>
<script src="/Public/web/js/jquery-1.8.3.min.js"></script>
<script src="/Public/bang/layer-v3.1.1/layer/layer.js"></script>
<script>
    $('.nav span').click(function(){
        $(this).addClass("selected").siblings().removeClass("selected");//removeClass就是删除当前其他类；只有当前对象有addClass("selected")；siblings()意思就是当前对象的同级元素，removeClass就是删除；
        $("#tab-content > ul").hide().eq($('.nav span').index(this)).show();
    });

    $(".function_click").click(function () {
        var url = $(this).data("url");
        var id = $(this).data("id");
        if(typeof(url) === "undefined" || typeof(id) === "undefined"){
            return false;
        }
        layer.load(1,{
            shade: [0.1,'#000']
        });
        $.post(url,{id:id},function (data) {
            if(data.status == 1){
                layer.msg(data.info,function () {
                    window.location.reload();
                },1000);
            }else{
                layer.closeAll();
                layer.msg(data.info);
            }
        })
    });

    /**
     * 联系方式
     */
    $(".zyz-phone").click(function(){
        layer.alert("联系电话："+$(this).data("phone"));
    });

    /**
     * 投诉
     */
    $(".zyz-tousu").click(function(){
        var pid = $(this).data("pid");
        layer.load(1,{
            shade: [0.1,'#000']
        });
        $.post("<?php echo U('zyz_tousu');?>",{pid:pid,type:1},function (data) {
            layer.closeAll();
            if(data.status == 1){
                layer.open({
                    id:1,
                    type: 1,
                    title:'修改密码',
                    skin:'layui-layer-rim',
                    area:['450px', 'auto'],
                    content: ' <div class="row">'
                        +'<div class="col-sm-12">'
                        +'<div class="input-group">'
                        +'<textarea id="text" name="text" class="form-control" rows="4" style="width: 95%; margin:20px 2.5% 0; padding: 5px;" placeholder="请输入投诉内容"></textarea>'
                        +'</div>'
                        +'</div>'
                        +'</div>'
                    ,
                    btn:['保存','取消'],
                    btn1: function (index,layero) {
                        var text = $("#text").val();
                        layer.load(1,{
                            shade: [0.1,'#000']
                        });
                        $.post("<?php echo U('zyz_tousu');?>",{pid:pid,type:2,text:text},function (datas) {
                            layer.closeAll();
                            if(datas.status == 1){
                                layer.load(1,{
                                    shade: [0.1,'#000']
                                });
                                layer.msg(datas.info,function () {
                                    window.location.reload();
                                },2000);
                            }else{
                                layer.msg(datas.info);
                            }
                        });
                    }
                });
            }else{
                layer.msg(data.info);
            }
        })
    });

    /**
     * 查看图片
     */
    $(".zyz-imagepath").click(function () {
        var pid = $(this).data("pid");
        layer.load(1,{
            shade: [0.1,'#000']
        });
        $.post("<?php echo U('zyz_imagepath');?>",{pid:pid},function (data) {
            layer.closeAll();
            if(data.status == 1){
                layer.open({
                    id:1,
                    type: 1,
                    title:'转账凭证图片',
                    skin:'layui-layer-rim',
                    content:'<img src="/Uploads/'+data.info+'" alt="" style="width: 70%; margin-left: 15%; padding: 20px 0;">',
                    btn:['确定'],
                    btn1: function (index,layero) {
                        layer.closeAll();
                    }
                });
            }else{
                layer.msg(data.info);
            }
        })
    });

    /**
     * 上传图片
     */
    $("#zyz-upload").change(function (e) {
        var pid = $(this).data("pid");
        var files = this.files;
        var reader = new FileReader();
        reader.readAsDataURL(files[0]);
        reader.onload = function(e){
            var mb = e.total/1024;
            if(mb > 500){
                layer.msg('文件大小大于500KB');
                return false;
            }
            layer.load(1,{
                shade: [0.1,'#000']
            });
            var formDatas = new FormData();
            formDatas.append("file",files[0]);
            formDatas.append("pid",pid);
            $.ajax({
                url:"<?php echo U('zyz_upload');?>",
                type:"POST",
                data:formDatas,
                processData:false,
                contentType:false,
                success:function (data) {
                    if(data.status == 1){
                        layer.msg(data.info,function () {
                            window.location.reload();
                        })
                    }else{
                        layer.closeAll();
                        layer.msg(data.info);
                    }
                },
                error:function(){
                    layer.msg("操作失败");
                },
            });
        }
    });

    /**
     * 交易取消
     */
    $(".zyz-del").click(function(){
        var pid = $(this).data("pid");
        layer.load(1,{shade:[0.1,'#000']});
        $.post("<?php echo U('zyz_del');?>",{pid:pid},function (data) {
            if(data.status == 1){
                layer.msg(data.info,function(){
                    window.location.reload();
                })
            }else{
                layer.closeAll();
                layer.msg(data.info);
            }
        })
    });

    /**
     * 交易完成
     */
    $(".zyz-complete").click(function(){
        var pid = $(this).data("pid");
        layer.load(1,{shade:[0.1,'#000']});
        $.post("<?php echo U('zyz_complete');?>",{pid:pid},function (data) {
            if(data.status == 1){
                layer.msg(data.info,function(){
                    window.location.reload();
                })
            }else{
                layer.closeAll();
                layer.msg(data.info);
            }
        })
    })

</script>
</html>