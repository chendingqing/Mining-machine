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
  <form action="/admin8899.php/Home/Shop/ly_list_xgcl2"  enctype="multipart/form-data" name="xgmm" id="xgmm" method="post">
	   <input name="id" type="hidden" value="<?php echo ($caution["ma_id"]); ?>">
<table width="90%" border="0" cellpadding="5" cellspacing="1" bgcolor="#CCCCCC" class="tablebg" id="table1">
  
  <!--會員折扣-->
  <!--基本信息-->
  
  <tr>
    <td bgcolor="#FFFFFF" class="tbkey" >问题类型：</td>
    <td bgcolor="#FFFFFF" class="tbval"><?php echo ($caution["ma_otherinfo"]); ?></td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF" class="tbkey" >留言会员：</td>
    <td bgcolor="#FFFFFF" class="tbval"><?php echo ($caution["ma_username"]); ?></td>
  </tr>
  <tr>
    <td width="157" bgcolor="#FFFFFF" class="tbkey" >留言标题：</td>
    <td width="301" bgcolor="#FFFFFF" class="tbval"><?php echo ($caution["ma_theme"]); ?></td>
    </tr>
  <tr>
    <td bgcolor="#FFFFFF" class="tbkey" >留言内容：</td>
    <td bgcolor="#FFFFFF" class="tbval"><?php echo ($caution["ma_note"]); ?></td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF" class="tbkey" >管理员回复：</td>
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
<textarea name="content" style="width:700px;height:200px;visibility:hidden;"><?php echo ($caution["ma_reply"]); ?></textarea></td>
    </tr>
  <!--微信填寫-->
</table>
<!--基本信息結束-->
              <div id="state_lockcon" ></div>		
                <table class="tablebg" id="table3" style="clear:both">
                    <TR>
                        <td colspan="3" >
                            <input   type="submit" class="button_text"  id="btn" value="处理"> 
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