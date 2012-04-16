<?php
include_once  '../config.php';
include_once  $MyClasses.'test2group.php';
ob_start();
?>
<?php include $MyRoot.'header.php';?>
<br/>
<?php
if ($_SESSION ['username'] != ''){
    $MyGr=new Test2Group($dbh,$_SESSION ['username']);
	if (($MyGr->State() =='enabled')){
//////page contents////////////////////////////////////////////////////////?>
<?php 	///only first time people can see welcome page
	if(!$MyGr->NotSuchGroup) header ( "Location:index.php" );
	if(isset($_REQUEST['submit']))
	{
		$MyGr->MakeDBRow();
		header ( "Location:info.php" );
	}
?>
سلام بر گروه <?php echo $MyGr->Name();?><br/>
موجودی شما0 میباشد<br/>
پس از خواندن این صفحه بازدن کلید ادامه موجودی اولیه ای به مقدار <?php echo Test2Group::StartingMoney; ?>
به حساب شما افزوده می شود و توضیحات کامل تر را در صفحه ی توضیحات خواهید یافت  
<?php
echo $MyGr->GetFullSchool();  
?>
<center><br/>
توضیحات<br/>
و خوش آمد گویی

<form method="post">
<input type="submit" name="submit" value="دریافت موجودی اولیه و ادامه">
</form>
</center>
<?php ////////////////////////////////////////////////////////////////////////
ob_flush(); ?>
  <?php  }else{?>
  <center>
    <b>گروه شما هنوز فعال نشده</b>
  </center>
  <?php  }?>
<?php  }else{?>
<center>
  <b>شما قادر به استفاده از این صفحه نیستید</b>
  <br/>
  <a href="../index.php?return=problems2/welcome.php">login</a>
</center>
<?php }?>

<?php include $MyRoot.'footer.php';?>
<?php $dbh=null;?>