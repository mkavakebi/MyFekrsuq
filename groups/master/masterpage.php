<?php
include_once  '../config.php';
include_once  $MyClasses.'master.php';
$MyMas=new Master($dbh);
ob_start();
?>
<?php include('header.php'); ?>
<?PHP
if ($_SESSION ['usernamemaster'] != ''){
///////////////contents

if ($_GET ['menu'] == 'signout') {
	$MyMas->LogOut();
	header ( "Location:index.php" );
}
ob_flush();
?>
<body>
<left>Hello Master: <?php echo($_SESSION ['usernamemaster']); ?>
<br>
<A href="masterpage.php?menu=signout" >خروج</A><br/>
<A href="sendmessage.php?groupname=all" >فرستادن پیغام عمومی</A><br/>
<A href="problememtiaz.php" >نتایج کنونی سوالات اینترنتی</A><br/>
<A href="katbiemtiaz.php" >نتایج کنونی سوالات کتبی</A><br/>
<A href="eterazlist.php" >اعتراض گروه ها یرای نتایج مرحله اول</A><br/>
<A href="../problems2/master/" >طراحی سوال برای مرحله دوم اینترنتی</A><br/>
<A href="allmembers.php" >مشاهده ی اعضای هر گروه</A><br/>
<A href="groups.php" >مشاهده ی گروه ها</A><br/>
آپلود فایل
<!-- A href="upload.php" >آپلود فایل</A><br/>  -->
</left>
</body>
<?php }else{?>
<center><b>شما قادر به استفاده از این صفحه نیستید</b></center>
<?php }?>
<?php include('../footer.php'); ?>