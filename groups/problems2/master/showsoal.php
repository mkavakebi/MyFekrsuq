<?php
include_once  '../../config.php';
include_once  $MyClasses.'soal.php';
?>
<?PHP
if ($_SESSION ['usernamemaster'] != ''){
//////////////////////////////////////logic operations
$MyGr=new soal($dbh);
$MyGr->InitID($_REQUEST['soalid']);
if($MyGr->WrongID)header("Location:index.php");
//////////////////////////////////////contents///////////////////////////////////
?>
<?php include('../../header.php'); ?><center>
<a href="index.php">بازگشت</a><br/>
<a href="soals.php?soalid=<?php echo $MyGr->ID();?>">تغییر</a>
<?php border_start(); ?>
	<right><B>
		سطح:<?php echo $Levels[$MyGr->Level()];?>
	</B></right>
	<center><h1>
		عنوان:<?php echo $MyGr->Title();?><br/>
	</h1></center>	 
	<br/><hr/>
	<Center>
		شرح:<br/>
		<?php echo $MyGr->Body();?>
		<br/><hr/><br/>
	    پاسخ:<?php echo $MyGr->Answer();?>
	</Center>
<?php border_end(); ?>
<?php ///////////////////////////////////////////////////////////////////////////////////////////////////////////?>
<?php $dbh=null;?>
</center>
<?php }else{?>
<center><b>شما قادر به استفاده از این صفحه نیستید</b></center>
<?php }?>
<?php include('../../footer.php'); ?>