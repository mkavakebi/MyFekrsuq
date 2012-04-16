<?php
include_once '../../config.php';
include_once  $MyClasses.'soal.php';
?>
<?PHP
if ($_SESSION ['usernamemaster'] != ''){
//////////////////////////////////////logic operations
$MyGr=new soal($dbh);
$MyGr->InitID($_REQUEST['soalid']);
if(isset($_REQUEST['Added'])){
	$MyGr->SetLevel($_REQUEST['level']);
	$MyGr->SetAnswer($_REQUEST['answer']);
	$MyGr->SetBody($_REQUEST['body']);
	$MyGr->SetTitle($_REQUEST['title']);
	$MyGr->SaveAsNew();
	header("Location:index.php");
}
if(isset($_REQUEST['Eddited'])){
	$MyGr->SetLevel($_REQUEST['level']);
	$MyGr->SetAnswer($_REQUEST['answer']);
	$MyGr->SetBody($_REQUEST['body']);
	$MyGr->SetTitle($_REQUEST['title']);
	$MyGr->SaveEdited();
	header("Location:index.php");
}
//////////////////////////////////////contents///////////////////////////////////
?>
<?php include('../../header.php'); ?><center>
<a href="index.php">بازگشت</a>
<form name="frmPost" method="post">
	<?php for($i=0;$i<count(soal::$Levels);$i++){?>
		<input type="radio" name="level" value="<?php echo $i;?>" <?php if($MyGr->Level()==$i)echo 'checked' ?>><?php echo soal::$Levels[$i];?></input><br/> 
	<?php }?>
	عنوان:<input name="title" type="text" value="<?php echo $MyGr->Title();?>"/><br/>
    <textarea name="body" rows="15" cols="67"><?php echo $MyGr->Body();?></textarea><br/>
    پاسخ:<input name="answer" type="text" value="<?php echo $MyGr->Answer();?>"/><br/>
	<input type="submit" name="<?php echo($MyGr->WrongID?"Added":"Eddited");?>" value="ذخیره" /><br/>
	<input type="hidden" name="soalid" value="<?php echo $MyGr->ID();?>">
</form>

<?php ///////////////////////////////////////////////////////////////////////////////////////////////////////////?>
<?php $dbh=null;?>
</center>
<?php }else{?>
<center><b>شما قادر به استفاده از این صفحه نیستید</b></center>
<?php }?>
<?php include('../../footer.php'); ?>