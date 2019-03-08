<?php if (!defined('THINK_PATH')) exit(); if(C('LAYOUT_ON')) { echo ''; } ?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
	<meta charset="utf-8" />
	<title>Login - THE BEAR STEARNS COS</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
	<meta content="width=device-width, initial-scale=1.0" name="viewport" />
	<meta content="" name="description" />
	<meta content="" name="author" />
	<!-- BEGIN GLOBAL MANDATORY STYLES -->
	<link rel="stylesheet" href="/assets/vendor/fontawesome/css/font-awesome.css" />
    <link rel="stylesheet" href="/assets/vendor/metisMenu/dist/metisMenu.css" />
     <link rel="stylesheet" href="/assets/vendor/animate.css/animate.css" />
     <link rel="stylesheet" href="/assets/vendor/bootstrap/dist/css/bootstrap.css" />

    <!-- App styles -->
     <link rel="stylesheet" href="/assets/fonts/pe-icon-7-stroke/css/pe-icon-7-stroke.css" />
     <link rel="stylesheet" href="/assets/fonts/pe-icon-7-stroke/css/helper.css" />
     <link rel="stylesheet" href="/assets/styles/style.css">
	<!-- END PAGE LEVEL STYLES -->
	<link rel="shortcut icon" href="favicon.ico" />
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body class="login">
	<!-- BEGIN LOGO -->
	<div class="logo" style="width: 100%;">
		<!--<img src="/assets/img/logo-big.png" alt="" />-->
      
	</div>
	<!-- END LOGO -->
	<!-- BEGIN LOGIN -->
	<div class="content">
		<!-- BEGIN LOGIN FORM -->
		<form class="form-vertical login-form"  id="Success" >
			<h3 class="erro" font>登录成功</h3>
		<div class="loading">     <div class="splash"> <div class="color-line"></div><div class="splash-title"><span></span>
		<h3>
		<?php if(isset($message)) {?>
<?php echo($message); ?>
<?php }else{?>
<?php echo($error); ?>
<?php }?></h3><!--<img src="/assets/images/loading-bars.svg" width="64" height="64" />--> </br>  The system will automatically return in <b id="wait"><?php echo($waitSecond); ?></b> seconds,or click <a  id="href" href="<?php echo($jumpUrl); ?>">Here</a> to return</div> 
    </div>
	<script type="text/javascript">
(function(){
//alert('asdfasf');
var wait = document.getElementById('wait'),href = document.getElementById('href').href;
var interval = setInterval(function(){
	var time = --wait.innerHTML;
	if(time <= 0) {
		location.href = href;
		clearInterval(interval);
	};
}, 1000);
})();
</script>

		</form>
		<!-- END LOGIN FORM -->        
		
	</div>
	<!-- END LOGIN -->
	<!-- BEGIN COPYRIGHT -->
	<div class="copyright">
		<!--2014@copyrights. MMMCHINA.com Alright Reserved.-->
	</div>

	<!-- END PAGE LEVEL SCRIPTS --> 

	<!-- END JAVASCRIPTS -->

</body>


<!-- END BODY -->


</html>