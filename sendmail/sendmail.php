<?php
	//邮件发送
	require './mailer/class.phpmailer.php';
	require './mailer/class.smtp.php';
	date_default_timezone_set('PRC');
	$mail = new PHPMailer(); 
	$mail->SMTPDebug = 3;
	$mail->isSMTP();
	$mail->SMTPAuth=true;
	$mail->Host = 'smtpdm.aliyun.com';
	$mail->SMTPSecure = 'ssl';
	//设置ssl连接smtp服务器的远程服务器端口号 可选465或587
	$mail->Port = 465;
	$mail->Hostname = 'localhost';
	$mail->CharSet = 'UTF-8';
	$mail->FromName = 'system@gec.green-entrepreneurship.xyz';
	$mail->Username ='system@gec.green-entrepreneurship.xyz';
	$mail->Password = 'ASDjkl147258';
	$mail->From = 'system@gec.green-entrepreneurship.xyz';
	$mail->isHTML(true); 
	$mail->addAddress('51323213@126.com','这个QQ的昵称');
	$mail->Subject = '这是一个PHPMailer发送邮件的示例';
	$mail->Body = "这是一个<b style=\"color:red;\">PHPMailer</b>发送邮件的一个测试用例";
	$mail->addAttachment('./src/20151002.png','test.png');
	$status = $mail->send();
	if($status) 
	{
	 echo '发送邮件成功'.date('Y-m-d H:i:s');;
	}
	else
	{
	 echo '发送邮件失败，错误信息未：'.$mail->ErrorInfo;
	}
	exit;
	
?>

