<?php
include_once  '../../config.php';
include_once  $MyClasses.'soal.php';
?>
<?PHP
if ($_SESSION ['usernamemaster'] != ''){
//////////////////////////////////////contents///////////////////////////////////
?>
<?php
if(isset($_REQUEST['soalid'])){
	$MyGr=new soal($dbh);
	$MyGr->DeleteByID($_REQUEST['soalid']);
} 
?>
<?php include('../../header.php'); ?>
<body>
<A href="index.php" >بازگشت به سوالات</A><br/>
<br/><hr/><br/>
<center>
<table border="0" style="FONT-SIZE: 9pt; FONT-FAMILY: Tahoma" dir="rtl" align="center">
<tr>
	<th width="5%">ردیف</th>
	<th width="10%">سطح</th>
	<th width="10%">عنوان</th>
	<th width="10%">جواب</th>
	<th width="5%">حذف</th>
</tr>
<?php
	$stmt = $dbh->prepare("SELECT * FROM problems2 ORDER BY level");
    $stmt->execute();
    $row=1;
    $MyGr=new soal();
	while ( $MyGr->InitRow($stmt->fetch()) ) {
	?>
	<tr bgcolor=<?php if($odd){echo "#CCECCC";}else{echo "#F7F7F7";} $odd=!$odd;  ?> align="center" vAlign="top">
		<td width="5%"><?php echo $row++;?></td>
		<td width="10%"><?php echo $MyGr->GetLevel();?></td>
    	<td width="10%"><?php echo $MyGr->Title();?></td>
		<td width="10%" ><?php echo $MyGr->Answer();?></td>
		<td width="5%"><a href="?soalid=<?php echo $MyGr->ID();?>">حذف</a></td>
	</tr>
	<?php }?>
</table>
<?php ///////////////////////////////////////////////////////////////////////////////////////////////////////////?>
<?php $dbh=null;?>
</center>
</body>
<?php }else{?>
<center><b>شما قادر به استفاده از این صفحه نیستید</b></center>
<?php }?>
<?php include('../../footer.php'); ?>