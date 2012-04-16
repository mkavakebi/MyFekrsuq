<?php
include_once  '../config.php';
include_once  '../functions.php';
?><?PHP
if ($_SESSION ['usernamemaster'] != ''){
// header ( "Location:master.php" );
if ($_GET ['menu'] == 'signout') {
	session_start ();
	$_SESSION ['loginmaster'] = '';
	$_SESSION ['usernamemaster'] = '';
	session_destroy ();
	header ( "Location:master.php" );
}

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<body>
Hello user: <?php echo($_SESSION ['usernamemaster']); ?>
<br>
<A href="masterpage.php?menu=signout" >out</A>
<A href="sendmessage.php?groupname=all" >Send message to all</A>
<br/><hr/><br/>
<table border="0" style="border-collapse: collapse ;FONT-SIZE: 9pt; FONT-FAMILY: Tahoma" width="570" dir="rtl" cellspacing="1" align="center">
<tr>
	<td width="100" class="bTD" height="18">ردیف</td>
	<td width="120" class="bTD" height="18"><a href="masterpage.php<?php echo GetOrderQuery('groupname',$_GET['order'],$_GET['asc']); ?>"> نام گروه </a></td>
	<td width="368" class="bTD" height="18"><a href="masterpage.php<?php echo GetOrderQuery('groupcity',$_GET['order'],$_GET['asc']); ?>">شهر</a></td>
	<td width="368" class="bTD" height="18"><a href="masterpage.php<?php echo GetOrderQuery('schoolname',$_GET['order'],$_GET['asc']); ?>">دبیرستان</a></td>
	<td width="368" class="bTD" height="18"><a href="masterpage.php<?php echo GetOrderQuery('schooltype',$_GET['order'],$_GET['asc']); ?>">جنسیت</a></td>
	<td width="368" class="bTD" height="18"><a href="masterpage.php<?php echo GetOrderQuery('memcount',$_GET['order'],$_GET['asc']); ?>">تعداد اعضا</a></td>
	<td width="368" class="bTD" height="18"><a href="masterpage.php<?php echo GetOrderQuery('enabled',$_GET['order'],$_GET['asc']); ?>">وضعیت</a></td>
	<td width="368" class="bTD" height="18"><a href="masterpage.php<?php echo GetOrderQuery('datecreated',$_GET['order'],$_GET['asc']); ?>">تاریخ ثبت</a></td>
	<td width="368" class="bTD" height="18"><a href="masterpage.php<?php echo GetOrderQuery('fishid',$_GET['order'],$_GET['asc']); ?>">کد فیش</a></td>
</tr>
<?php
	//$stmt = $dbh->prepare("SELECT groups.ID,groupname,groupcity,schoolname,schooltype,enabled,COUNT(groupid) as count FROM groups JOIN members ON(members.groupid=groups.ID) GROUP BY groupid");
	$stmt = $dbh->prepare("SELECT *,COUNT(groups.ID) as memcount,groups.ID as gid FROM groups LEFT JOIN members ON (groups.ID=members.groupid) GROUP BY groups.ID  ".$_SESSION['order']);
    $stmt->execute();
    $row=$_GET['start']+1;
	while ( $db_field =  $stmt->fetch() ) {
	?>
	<tr bgcolor=<?php if($odd){echo "#CCECCC";}else{echo "#F7F7F7";} $odd=!$odd;  ?> align="center" vAlign="top">
<td><?php echo $row++;?></td>
    	<td width="120" class="bTD" height="18"><span dir="rtl"><?php echo $db_field ['groupname']?></span></td>
		<td width="368" class="bTD" height="18"><?php	echo $db_field ['groupcity']?></td>
		<td width="368" class="bTD" height="18"><?php	echo $db_field ['schoolname']?></td>
		<td width="368" class="bTD" height="18"><?php	echo $db_field ['schooltype']?></td>
<td><?php echo $db_field ['memcount']?></td>
		<td width="368" class="bTD" height="18"><?php	echo $db_field ['enabled']?></td>
		<td><?php echo $db_field ['datecreated']?></td>
		<td><?php echo $db_field ['fishid']?></td>
	</tr>
	<?php }
	$dbh=null;?>
</table>
</body>
<?php } else{?>
<center><b>شما قادر به استفاده از این صفحه نیستید</b></center>
<?php }?>