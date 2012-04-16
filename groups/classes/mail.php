<?php
function sendmail($to,$from,$subject,$message){
	$name=$_POST["name"];
	$head="From: ".$from."\r\n".
		'Reply-To: '.$From."\r\n";
	$her=$head.' < '.$from.' >';
	$ret=mail($to, $subject, $message, $her);
	if($ret==false)
		return "did not send!";
}

function SendPassForGroup($email){
	if (FilterStrict($email,1)==1 or FilterStrict($email,1)==2) return 'پست الکترونیکی خود را تصحیح کنید.';
	$stmt = $dbh->prepare("SELECT * FROM members JOIN groups ON(groupid=groups.ID) WHERE members.email=? AND members.type='header'");
    $stmt->execute(array($email));
	if($db_field = $stmt->fetch()){
		$text='کاربر محترم با نام '.$db_field['membername'].' '.$db_field['memberfamily'];
		$text=$text.'اطلاعات لازم برای ورود شما به صفحه مربوط به اطلاعات گروه شما به شرح زیر است.';
		$text=$text.'نام کاربری :'. $db_field['username'];
		$text=$text.'رمز عبور   :'. $db_field['pass'];
		sendmail('a@a.com',$email,'password reminder',$text);
	}
}