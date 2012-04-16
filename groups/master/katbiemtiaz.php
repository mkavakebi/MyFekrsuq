<?php
include_once '../config.php';
include_once '../functions.php';
include_once '../checkanswers.php';
include_once '../katbiconfig.php';
?>
<?PHP
if ($_SESSION ['usernamemaster'] != ''){
// header ( "Location:master.php" );
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<body>
<A href="masterpage.php" >back</A>
<br/><hr/><br/>
<table border="0" style="border-collapse: collapse ;FONT-SIZE: 9pt; FONT-FAMILY: Tahoma" width="570" dir="rtl" cellspacing="1" align="center">
<tr>
	<th width="100" class="bTD" height="18">ردیف</td>
	<th width="120" class="bTD" height="18">نام گروه</th>
	<th width="368" class="bTD" height="18">شهر</th>
	<th width="368" class="bTD" height="18">دبیرستان</th>
	<th width="368" class="bTD" height="18">جنسیت</th>
	<th width="100" class="bTD" height="18">ID</td>
	<th width="368" class="bTD" height="18">وضعیت</th>
<?php for($i=0;$i<count($names);$i++){?>
	<th width="100" class="bTD" height="18"><?php echo $names[$i];?></th>
<?php }?>
	<th width="100" class="bTD" height="18">جمع</th>
</tr>
<?php
	$stmt = $dbh->prepare("SELECT *,groups.ID as gid FROM groups RIGHT JOIN katbi ON (groups.ID=katbi.groupid)");
    $stmt->execute();
    $row=$_GET['start']+1;
	while ( $db_field =  $stmt->fetch() ) {
		$fakes=explode('^',$db_field ['nomre']);
	?>
	<tr bgcolor=<?php if($odd){echo "#CCECCC";}else{echo "#F7F7F7";} $odd=!$odd;  ?> align="center" vAlign="top">
		<td><?php echo $row++;?></td>
    	<td width="120" class="bTD" height="18"><span dir="rtl"><?php echo $db_field ['groupname']?></span></td>
		<td width="368" class="bTD" height="18"><?php	echo $db_field ['groupcity']?></td>
		<td width="368" class="bTD" height="18"><?php	echo $db_field ['schoolname']?></td>
		<td width="368" class="bTD" height="18"><?php	echo $db_field ['schooltype']?></td>
		<td width="368" class="bTD" height="18"><?php	echo $db_field ['gid']?></td>
		<td width="368" class="bTD" height="18"><?php	echo $db_field ['enabled']?></td>
<?php for($i=0;$i<count($names);$i++){?>
		<td width="100" class="bTD" height="18"><?php echo $fakes[$i]?></td>
<?php }?>		
		<td width="100" class="bTD" height="18"><?php	echo $db_field ['nomresum']?></td>
		<td width="50" class="bTD" height="18"><a href="setkatbi.php?return=katbiemtiaz.php&groupid=<?php	echo $db_field ['gid']?>">??</a></td>
	</tr>
	<?php }
	$dbh=null;?>
</table>
</body>
<?php } else{?>
<center><b>شما قادر به استفاده از این صفحه نیستید</b></center>
<?php }?>

