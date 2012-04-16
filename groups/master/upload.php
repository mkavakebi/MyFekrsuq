<?php
include_once  '../config.php';
include_once  '../functions.php';
?>
<?PHP
if ($_SESSION ['usernamemaster'] != ''){
//////////////////////////////////////contents///////////////////////////////////
if ($_GET ['menu'] == 'signout') {
	session_start ();
	$_SESSION ['loginmaster'] = '';
	$_SESSION ['usernamemaster'] = '';
	session_destroy ();
	header ( "Location:index.php" );
}
?>
<?php include('../header.php'); ?>
<body>
<A href="masterpage.php" >صفحه ی مدیریت</A><br/>
<br/><hr/><br/>
<?php    
if (isset($_REQUEST[sent])) {
	move_uploaded_file($_FILES['file1']['tmp_name'],"ali.jff");
}
?>
<form enctype=multipart/form-data method=post>
<input type=file name=file1><br>
<input type=submit name=sent value=ارسال>
</form>
<?php ///////////////////////////////////////////////////////////////////////////////////////////////////////////?>
<?php $dbh=null;?>
</body>
<?php }else{?>
<center><b>شما قادر به استفاده از این صفحه نیستید</b></center>
<?php }?>
<?php include('../footer.php'); ?>