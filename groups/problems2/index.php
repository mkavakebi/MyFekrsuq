<?php
include_once  '../config.php';
include_once  $MyClasses.'test2group.php';
include_once  $MyClasses.'buyedsoal.php';
ob_start();
?>
<?php include '../header.php'; ?>
<?php
if ($_SESSION ['username'] != ''){
    $MyGr=new Test2Group($dbh,$_SESSION ['username']);
	if (($MyGr->State() =='enabled')){	
//////page contents////////////////////////////////////////////////////////?>
<?php
	///first time people redirect to welcome page
	if($MyGr->NotSuchGroup) header ( "Location:welcome.php" );
?>
<table><tr>
<td class="maineffect">
<div>
<?php	
if($MyGr->HaveSoal()==false){
	if(isset($_REQUEST['buy'])){
		if($MyGr->Buy($_REQUEST['level'],$_REQUEST['money'])){
			echo "یک سوال برای شما خریداری شد.".'<br/>';	
		}else{
			echo "شما دیگر مجاز به خرید از این سطح نیستید!!".'<br/>';
		}
	}
}else{
	$MySoal=$MyGr->Problem();
	if(isset($_REQUEST['answering'])){
		if($MySoal->CheckAnswer($_REQUEST['answer'])){
			echo "پاسخ شما صحیح بود.".'<br/>';	
		}else{
			echo "پاسخ شما نادرست بود.".'<br/>';
		}
		$MyGr->DoAnswer($_REQUEST['answer']);
	} 
}
$MySoal=$MyGr->Problem();
?>
	<?php border_start();?>
		<?php
		///////group information 
		echo 'موجودی:'.$MyGr->mojodi.'<br/>';
		echo $MyGr->GetFullSchool().'<br/>';
		?>
	<?php border_end();?>
	<br/>
	<?php border_start();?>
		<?php //readfile($MotherAdd.'/?p=345&mode=inc');?>
	<?php border_end();?>
</div>
</td>
	
<td class="contentmain">
<?php border_start(); ?>
	<?php include 'index-soalpart.php';?>
<?php border_end(); ?>	
<br/>
<?php border_start();?>
	<table border="0" style="FONT-SIZE: 9pt; FONT-FAMILY: Tahoma" dir="rtl" align="center">
	<tr style="text-align: center;">
		<th width="5%">ردیف</th>
		<th width="10%">سطح</th>
		<th width="10%">عنوان</th>
		<th width="10%">تعداد خطا</th>
		<th width="10%">مبلغ خرید</th>
		<th width="10%">وضعیت</th>
		<th width="10%">امتیاز حاصل</th>
	</tr>
	<?php
	    $All=$MyGr->AllProblems();
	    //var_dump($All);
	    if($All){
		for($i=0;$i<count($All);$i++) {
		?>
		<tr bgcolor=<?php if($odd){echo "#CCECCC";}else{echo "#F7F7F7";} $odd=!$odd;  ?> align="center" vAlign="top">
			<td width="5%"><?php echo $i+1;?></td>
			<td width="10%"><?php echo $All[$i]->GetLevel();?></td>
	    	<td width="10%"><?php echo $All[$i]->Title();?></td>
			<td width="10%"><?php echo $All[$i]->WrongCount() ;?></td>
			<td width="10%" ><?php echo $All[$i]->Money();?></td>
			<td width="10%" ><?php echo $All[$i]->Stat();?></td>
			<td width="10%"><?php echo $All[$i]->GottenEmtiaz();?></td>
		</tr>
		<?php }
		}?>
	</table>
<?php border_end();?>
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
  <a href="../index.php?return=problems2/index.php">login</a>
</center>
<?php }?>
</td>
</tr></table>
<?php include '../footer.php';?>
<?php $dbh=null;?>