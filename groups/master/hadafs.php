<?php
include '../config.php';
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
	<th width="10">ردیف</th>
	<th width="60">نام گروه</th>
	<th width="70">شهر</th>
	<th width="70">دبیرستان</th>
	<th width="30">جنسیت</th>
	<th width="20">ID</th>
	<th width="40">وضعیت</th>
	<th width="300">هدف</th>
	<th width="300">خاطره</th>
</tr>
<?php
	$stmt = $dbh->prepare("SELECT *,groups.ID as gid FROM groups RIGHT JOIN hadafs ON (groups.ID=hadafs.groupid)");
    $stmt->execute();
    $row=$_GET['start']+1;
	while ( $db_field =  $stmt->fetch() ) {
	?>
	<tr bgcolor=<?php if($odd){echo "#CCECCC";}else{echo "#F7F7F7";} $odd=!$odd;  ?> align="center" vAlign="top">
		<td width="10"><?php echo $row++;?></td>
		<td width="60"><?php echo $db_field ['groupname']?></td>
		<td width="70"><?php	echo $db_field ['groupcity']?></td>
		<td width="70" ><?php	echo $db_field ['schoolname']?></td>
		<td width="30" ><?php	echo $db_field ['schooltype']?></td>
		<td width="20" ><?php	echo $db_field ['gid']?></td>
		<td width="40" ><?php	echo $db_field ['enabled']?></td>
		<td width="300"><?php	echo $db_field ['hadaf']?></td>
		<td width="300"><?php	echo $db_field ['khatere']?></td>
	</tr>
	<?php }
	$dbh=null;?>
</table>
</body>
<?php } else{?>
<center><b>شما قادر به استفاده از این صفحه نیستید</b>
<br/>
<a href="index.php">login</a></center>

<?php }?>