<?php
include '../config.php';
include '../functions.php';
?>
<?PHP
if ($_SESSION ['usernamemaster'] != ''){
// header ( "Location:master.php" );
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<body>
<A href="masterpage.php" >back</A>
<br/><hr/><br/>
<table border="0" style="FONT-SIZE: 9pt; FONT-FAMILY: Tahoma" dir="rtl" align="center">
<tr>
	<th width="20">ردیف</th>
	<th width="60">تاریخ</th>
	<th width="60">نام گروه</th>
	<th width="70">شهر</th>
	<th width="70">دبیرستان</th>
	<th width="30">جنسیت</th>
	<th width="20">ID</th>
	<th width="40">وضعیت</th>
	<th width="100" >عنوان</th>
	<th width="400">متن</th>
	<th width="30">رفع ابهام</th>
</tr>
<?php
	$stmt = $dbh->prepare("SELECT *,groups.ID as gid FROM groups RIGHT JOIN messages ON (groups.ID*-2=messages.readerid)WHERE groups.ID<>0 ORDER BY mes_date");
    $stmt->execute();
    $row=$_GET['start']+1;
	while ( $db_field =  $stmt->fetch() ) {
	?>
	<tr bgcolor=<?php if($odd){echo "#CCECCC";}else{echo "#F7F7F7";} $odd=!$odd;  ?> align="center" vAlign="top">
		<td width="20"><?php echo $row++;?></td>
		<td width="60"><?php echo $db_field ['mes_date']?></td>
    	<td width="60"><?php echo $db_field ['groupname']?></td>
		<td width="70"><?php	echo $db_field ['groupcity']?></td>
		<td width="70" ><?php	echo $db_field ['schoolname']?></td>
		<td width="30" ><?php	echo $db_field ['schooltype']?></td>
		<td width="20" ><?php	echo $db_field ['gid']?></td>
		<td width="40" ><?php	echo $db_field ['enabled']?></td>
		<td width="100"  ><?php	echo $db_field ['mes_subject']?></td>
		<td width="400"><?php	echo $db_field ['mes_value']?></td>
		<td width="30"><a href="sendmessage.php?return=eterazlist.php&groupname=<?php	echo $db_field ['groupname']?>">پاسخ</a></td>
	</tr>
	<?php }
	$dbh=null;?>
</table>
</body>
<?php } else{?>
<center><b>شما قادر به استفاده از این صفحه نیستید</b></center>
<?php }?>

