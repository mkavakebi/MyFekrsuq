<?php
include_once  '../../config.php';
include_once  $MyClasses.'soal.php';
?>
<?PHP
if ($_SESSION ['usernamemaster'] != ''){
//////////////////////////////////////contents///////////////////////////////////
if ($_GET ['menu'] == 'signout') {
	session_start ();
	$_SESSION ['loginmaster'] = '';
	$_SESSION ['usernamemaster'] = '';
	session_destroy ();
	header ( "Location:../../master/index.php" );
}
?>
<?php include($MyRoot.'header.php'); ?>
<body>
<A href="../../master/masterpage.php" >صفحه ی مدیریت</A><br/>
<A href="soals.php" >اضافه کردن سوال</A><br/>
<A href="deletesoal.php" >حذف کردن</A><br/>
<br/><hr/><br/>
<center>
<table border="0" style="FONT-SIZE: 9pt; FONT-FAMILY: Tahoma" dir="rtl" align="center">
<tr>
	<th width="5%">ردیف</th>
	<th width="10%">سطح</th>
	<th width="10%">عنوان</th>
	<th width="55%">شرح</th>
	<th width="10%">جواب</th>
	<th width="5%">مشاهده</th>
	<th width="5%">تغییر</th>
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
		<td width="55%"><?php echo $MyGr->Body();?></td>
		<td width="10%" ><?php echo $MyGr->Answer();?></td>
		<td width="5%"><a href="showsoal.php?soalid=<?php echo $MyGr->ID();?>">مشاهده</a></td>
		<td width="5%"><a href="soals.php?soalid=<?php echo $MyGr->ID();?>">تغییر</a></td>
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
<?php include($MyRoot.'footer.php'); ?>