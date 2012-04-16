<?php
include '../config.php';
include_once $MyClasses.'membergroup.php';
?>
<?PHP
if ($_SESSION ['usernamemaster'] != ''){
	$MyGr=new membergroup($dbh);
	echo $MyGr->LoadByField('ID',$_GET['ID']);
	$allmems=$MyGr->Members();
?>
<body>
<?php include('header.php'); ?>
<A href="masterpage.php" >back</A>
<br/><hr/><br/>
	<?php border_start();?>
		<?php include 'allmemlist.php';?>
	<?php border_end();?>
<form>
<input name=ID >
<input type=submit>
</form>
<?php $dbh=null;?>
</body>
<?php } else{?>
<center><b>شما قادر به استفاده از این صفحه نیستید</b></center>
<?php }?>
<?php include('../footer.php'); ?>
