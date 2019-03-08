<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>



<script type="text/javascript" src='/Public/Js/jquery-1.7.2.min.js'></script>
<link rel="stylesheet" href="/Public/Uploadify/uploadify.css"/>
<script type="text/javascript" src='/Public/Uploadify/jquery.uploadify.min.js'></script>
<script type='text/javascript'>
    var PUBLIC = '/Public';
    var uploadUrl = '<?php echo U("Common/uploadFace");?>';
    var ROOT = '';
</script>

<script type="text/javascript">
 //上传插件
$(function() {
    // 弃用
    $('#face').uploadify({
        swf : PUBLIC + '/Uploadify/uploadify.swf',	//引入Uploadify核心Flash文件
        uploader : uploadUrl,	//PHP处理脚本地址
        width : 120,	//上传按钮宽度
        height : 30,	//上传按钮高度
        buttonImage : PUBLIC + '/Uploadify/browse-btn.png',	//上传按钮背景图地址
        fileTypeDesc : 'Image File',	//选择文件提示文字
        fileTypeExts : '*.jpeg; *.jpg; *.png; *.gif',	//允许选择的文件类型
        //		formData : {'session_id' : sid},
        //上传成功后的回调函数
        onUploadSuccess : function (file, data, response) {
            eval('var data = ' + data);
            if (data.status) {
                $('#face-img').attr('src', ROOT + '/Uploads/' + data.path);
                $('input[name=face180]').val('/Uploads/'+data.path);
            } else {
                alert(data.msg);
            }
        }
    });

    $('#face-b').uploadify({
        swf : PUBLIC + '/Uploadify/uploadify.swf',	//引入Uploadify核心Flash文件
        uploader : uploadUrl,	//PHP处理脚本地址
        width : 120,	//上传按钮宽度
        height : 30,	//上传按钮高度
        buttonImage : PUBLIC + '/Uploadify/browse-btn.png',	//上传按钮背景图地址
        fileTypeDesc : 'Image File',	//选择文件提示文字
        fileTypeExts : '*.jpeg; *.jpg; *.png; *.gif',	//允许选择的文件类型
        //		formData : {'session_id' : sid},
        //上传成功后的回调函数
        onUploadSuccess : function (file, data, response) {
            eval('var data = ' + data);
            if (data.status) {
                $('#face-b-img').attr('src', ROOT + '/Uploads/' + data.path);
                $('input[name=face-b-180]').val('/Uploads/'+data.path);
            } else {
                alert(data.msg);
            }
        }
    });
 
 
 });
 </script>

<script type="text/javascript">
<!--

$(document).ready(function(){
  $(".click").click(function(){
  $(".tip").fadeIn(200);
  });
  
  $(".tiptop a").click(function(){
  $(".tip").fadeOut(200);
});

  $(".sure").click(function(){
  $(".tip").fadeOut(100);
});

  $(".cancel").click(function(){
  $(".tip").fadeOut(100);
});

});
//-->
</script>
<script charset="utf-8" src="/Public/kindeditor/kindeditor.js"></script>
<script charset="utf-8" src="/Public/kindeditor/lang/zh_CN.js"></script>

</head>


<body>
<label></label>
<div class="rightinfo">
  <!-- <form action="/admin8899.php/Home/Shop/jbzg_list_xgcl2"  enctype="multipart/form-data" name="xgmm" id="xgmm" method="post"> -->
  <form action="/admin8899.php/Shop/Project/updateProject/id/<?php echo ($arr["id"]); ?>"  enctype="multipart/form-data" name="xgmm" id="xgmm" method="post">
	   <input name="id" type="hidden" value="<?php echo ($caution["if_id"]); ?>">
<table width="90%" border="0" cellpadding="5" cellspacing="1" bgcolor="#CCCCCC" class="tablebg" id="table1">
 <tr>
    <td width="157" bgcolor="#FFFFFF" class="tbkey" >分类：</td>
    <td width="301" bgcolor="#FFFFFF" class="tbval" >
      <select name="pid" id="IF_type">
      <?php if(is_array($list)): foreach($list as $key=>$value): if($arr['pid'] == $value['id']): ?><option value="<?php echo ($value['id']); ?>" selected><?php echo ($value["name"]); ?></option>
        <?php else: ?>
          <option value="<?php echo ($value['id']); ?>"><?php echo ($value["name"]); ?></option><?php endif; endforeach; endif; ?>
      </select></td>
    </tr>
  


  <tr>
    <td bgcolor="#FFFFFF" class="tbkey" >名称</td>
    <td bgcolor="#FFFFFF" class="tbval"><input name="name" type="text" id="IF_theme" size="90" value="<?php echo ($arr["name"]); ?>"/></td>
  </tr>
   <tr>
    <td bgcolor="#FFFFFF" class="tbkey" >英文名称</td>
    <td bgcolor="#FFFFFF" class="tbval"><input name="enname" type="text" id="IF_theme" size="90" value="<?php echo ($arr["enname"]); ?>"/></td>
    </tr>
  
  
  <tr>
    <td bgcolor="#FFFFFF" class="tbkey" >标题</td>
    <td bgcolor="#FFFFFF" class="tbval"><input name="title" type="text" id="IF_theme" size="90" value="<?php echo ($arr["title"]); ?>"/></td>
    </tr>   
  <tr>
    <td bgcolor="#FFFFFF" class="tbkey" >原价</td>
    <td bgcolor="#FFFFFF" class="tbval"><input name="old_price" type="text" id="IF_theme" size="90" value="<?php echo ($arr["old_price"]); ?>" />
    </td>
    </tr>  
  <tr>
    <td bgcolor="#FFFFFF" class="tbkey" >现价</td>
    <td bgcolor="#FFFFFF" class="tbval"><input name="price" type="text" id="IF_theme" size="90" value="<?php echo ($arr["price"]); ?>" />
    </td>
    </tr>
    <tr>
        <td bgcolor="#FFFFFF" class="tbkey" >矿场点激活数</td>
        <td bgcolor="#FFFFFF" class="tbval"><input name="point" type="text" id="IF_theme" size="90" value="<?php echo ($arr["point"]); ?>" />
        </td>
    </tr>

    <tr>
        <td bgcolor="#FFFFFF" class="tbkey" >赠送职称</td>
        <td bgcolor="#FFFFFF" class="tbval">
            <select name="ads_condition" style="width: 10%;">
                <option value="0" <?php if($arr["ads_condition"] == 0): ?>selected<?php endif; ?> >初级矿工</option>
                <option value="1" <?php if($arr["ads_condition"] == 1): ?>selected<?php endif; ?> >中级矿工</option>
                <option value="2" <?php if($arr["ads_condition"] == 2): ?>selected<?php endif; ?> >高级矿工</option>
                <option value="3" <?php if($arr["ads_condition"] == 3): ?>selected<?php endif; ?> >超级矿工</option>
                <option value="4" <?php if($arr["ads_condition"] == 4): ?>selected<?php endif; ?> >专家矿工</option>
            </select>
            <!--<input name="point" type="text" id="IF_theme" size="90" value="<?php echo ($arr["point"]); ?>" />-->
        </td>
    </tr>


    <tr>
    <td bgcolor="#FFFFFF" class="tbkey" >库存</td>
    <td bgcolor="#FFFFFF" class="tbval"><input name="stock" type="text" id="IF_theme" size="90" value="<?php echo ($arr["stock"]); ?>" />
    </td>
  </tr> 


   <tr>
    <td bgcolor="#FFFFFF" class="tbkey" >收益比例</td>
    <td bgcolor="#FFFFFF" class="tbval"><input name="fjed" type="text" id="IF_theme" size="90" placeholder="请正确输入收益点数 如：0.01,0.02" value="<?php echo ($arr["fjed"]); ?>"/>/小时</td>
    </tr>  

     <tr>
    <td bgcolor="#FFFFFF" class="tbkey" >运行周期</td>
    <td bgcolor="#FFFFFF" class="tbval"><input name="yxzq" type="text" id="IF_theme" size="90" value="<?php echo ($arr["yxzq"]); ?>"/>小时</td>
    </tr>    
	
	<tr>
    <td bgcolor="#FFFFFF" class="tbkey" >矿机算力</td>
    <td bgcolor="#FFFFFF" class="tbval"><input name="kjsl" type="text" id="IF_theme" size="90" value="<?php echo ($arr["kjsl"]); ?>"/></td>
    </tr>    
	
	<!-- <tr>
    <td bgcolor="#FFFFFF" class="tbkey" >全网算力</td>
    <td bgcolor="#FFFFFF" class="tbval"><input name="qwsl" type="text" id="IF_theme" size="90" value="<?php echo ($arr["qwsl"]); ?>"/></td>
    </tr>  -->  
  


  <!-- <tr>
    <td bgcolor="#FFFFFF" class="tbkey" >奖励金额</td>
    <td bgcolor="#FFFFFF" class="tbval"><input name="fjed" type="text" id="IF_theme" size="90" value="<?php echo ($arr["fjed"]); ?>" />
    </td>
    </tr>     -->
  <!--會員折扣-->
  <!--基本信息-->
  
  <!-- <tr>
    <td bgcolor="#FFFFFF" class="tbkey" >标题：</td>
    <td bgcolor="#FFFFFF" class="tbval"><input name="IF_theme" type="text" id="IF_theme" value="<?php echo ($caution["if_theme"]); ?>" size="90" /></td>
    </tr>-->
  <tr style="display: none">
    <td bgcolor="#FFFFFF" class="tbkey" >縮略圖(弃用)：</td>
    <td bgcolor="#FFFFFF" class="tbval">
        <div class='edit-face'>
            <img src="<?php echo ($arr["imagepath"]); ?>" width='140' height='140' id='face-img'/>
            <p>
                <input type="file" name='face' id='face'/>
            </p>
            <p>
                <input type="" name='face180' value='<?php echo ($arr["imagepath"]); ?>'/>
			</p>
		</div>
    </td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF" class="tbkey" >縮略圖：</td>
    <td bgcolor="#FFFFFF" class="tbval">
        <div class='edit-face'>
            <img src="<?php echo ($arr["b_imagepath"]); ?>" width='140' height='140' id='face-b-img'/>
            <p>
                <input type="file" name='face-b' id='face-b'/>
            </p>
            <p>
                <input type="hidden" name='face-b-180' value='<?php echo ($arr["b_imagepath"]); ?>'/>
            </p>
        </div>
    </td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF" class="tbkey" >簡介：</td>
    <td bgcolor="#FFFFFF" class="tbval"><!-- 插入编辑器 -->
	
	<script>
    KindEditor.ready(function(K) {
        var editor1 = K.create('textarea[name="content"]', {
            cssPath : '/Public/kindeditor/plugins/code/prettify.css',
            uploadJson : '/Public/kindeditor/php/upload_json.php',
            fileManagerJson : '/Public/kindeditor/php/file_manager_json.php',
            allowFileManager : true,
            afterCreate : function() {
                var self = this;
                K.ctrl(document, 13, function() {
                    self.sync();
                    K('form[name=example]')[0].submit();
                });
                K.ctrl(self.edit.doc, 13, function() {
                    self.sync();
                    K('form[name=example]')[0].submit();
                });
            }
        });
        prettyPrint();
    });
</script>
<textarea name="content" style="width:700px;height:200px;visibility:hidden;"><?php echo ($arr["content"]); ?></textarea></td>
    </tr>
	
	
	
	 <tr>
    <td bgcolor="#FFFFFF" class="tbkey" >英文簡介：</td>
    <td bgcolor="#FFFFFF" class="tbval"><!-- 插入编辑器 -->
	
	<script>
    KindEditor.ready(function(K) {
        var editor1 = K.create('textarea[name="encontent"]', {
            cssPath : '/Public/kindeditor/plugins/code/prettify.css',
            uploadJson : '/Public/kindeditor/php/upload_json.php',
            fileManagerJson : '/Public/kindeditor/php/file_manager_json.php',
            allowFileManager : true,
            afterCreate : function() {
                var self = this;
                K.ctrl(document, 13, function() {
                    self.sync();
                    K('form[name=example]')[0].submit();
                });
                K.ctrl(self.edit.doc, 13, function() {
                    self.sync();
                    K('form[name=example]')[0].submit();
                });
            }
        });
        prettyPrint();
    });
</script>
<textarea name="encontent" style="width:700px;height:200px;visibility:hidden;"><?php echo ($arr["encontent"]); ?></textarea></td>
    </tr>
  <!--微信填寫-->
</table>
<!--基本信息結束-->
              <div id="state_lockcon" ></div>		
                <table class="tablebg" id="table3" style="clear:both">
                    <TR>
                        <td colspan="3" >
                            <input   type="submit" class="button_text"  id="btn" value="確定"> 
                        </TD>
                    </TR>
                </table>		
  </form>
   
   <div class="pages"><br />

                        <div align="right"><?php echo ($page); ?>
                        </div>
   </div>
    
    
</div>
    <script type="text/javascript">
	$('.tablelist tbody tr:odd').addClass('odd');
	</script>

</body>

</html>