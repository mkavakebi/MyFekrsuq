<?php
include_once  '../config.php';
include_once  '../functions.php';
include_once  $MyClasses.'group.php';
include_once  $MyClasses.'master.php';
$MyMas=new Master($dbh);
?>
<?php include($MyRoot.'master/header.php'); ?>
<a href="masterpage.php">صفحه اصلی</a> 
<?PHP
if ($_SESSION ['usernamemaster'] != ''){
///////////////contents
	$searchfields=array('groupname'=>'نام گروه','username'=>'نام کاربری','fishid'=>'فیش بانکی','schooltype'=>'جنسیت');
	$sortfields=array('groupname'=>'نام گروه','groupcity'=>'شهر','schoolname'=>'دبیرستان','schooltype'=>'جنسیت','memcount'=>'تعداد اعضا','enabled'=>'وضعیت','datecreated'=>'تاریخ ثبت','fishid'=>'کد فیش');
	
 	if(isset($_REQUEST['searchsubmit']))
	{
		 $_SESSION['filter']='';
		 foreach ($searchfields as $key_name => $key_value)
		 	$ff[$key_name]=$key_name." LIKE '%".$_REQUEST[$key_name.'filter']."%' ";
		 $_SESSION['filter']=implode(' AND ',$ff);
		 $_SESSION['filter']=' WHERE '.$_SESSION['filter'];
	}
	if(isset($_GET['order'])){
		$_SESSION['order']='ORDER BY '.$_GET['order'].' '.$_GET['asc'].' '; 
	}
	$rowcount=20;
	if(isset($_GET['start'])){
		$_SESSION['limit']='LIMIT '.$_GET['start'].','.$rowcount; 
	}else{
		$_SESSION['limit']='LIMIT 0,'.$rowcount;
	}

if ($_GET ['action'] == 'changestat') {
	$p=$MyMas->GroupByID($_GET ['groupid']);
	$p->SetState($_GET ['stat']);
}
?>
<body>
<center>
<Form Method="POST" action="?">
<table border="0" width="570" dir="rtl" cellspacing="1" align="center">
<tr>
	<center>
	<br>
	یابیدن
	<br>
<?php foreach ($searchfields as $key_name => $key_value) {?>	
    	<td width="120" class="bTD" height="18"><?php echo $key_value;?>:<input name="<?php echo $key_name;?>filter" value="<?php echo $_REQUEST[$key_name.'filter'];?>" type="text" maxlength="40"/></td>
<?php }?>
	</center>
</tr></table>
        <input type="submit" name="searchsubmit"	value="search" align="bottom" height="100%" />
</Form>

<?php echo GetPageNavigation($_GET['start'],$rowcount,$dbh);?>
<br/><br/>
<table border="0" style="border-collapse: collapse ;FONT-SIZE: 9pt; FONT-FAMILY: Tahoma" width="570" dir="rtl" cellspacing="1" align="center">
<tr>
	<center>
	<br>
	مرتب کردن بر اساس:
	<br>
<select name=sortby>
<?php foreach ($sortfields as $key_name => $key_value) {?>
	<option selected="true"><?php echo $key_value;?>	
<?php }?>
</select>
<td width="120" class="bTD" height="18"><a href="<?php echo GetOrderQuery($key_name,$_GET['order'],$_GET['asc']); ?>"><?php echo $key_value;?></a></td>
	</center>
</tr></table>
<div style="width:500px;text-align:center;FONT-SIZE: 9pt;">
	<?php
	$stmt = $dbh->prepare("SELECT *,COUNT(groups.ID) as memcount,groups.ID as gid FROM groups LEFT JOIN members ON (groups.ID=members.groupid) ".$_SESSION['filter'].' GROUP BY groups.ID '.$_SESSION['order']." ". $_SESSION['limit']);
    $stmt->execute();
    $row=$_GET['start']+1;
	while ( $db_field =  $stmt->fetch() ) {
	?>
<br>
	<?php border_start(); ?><right>
	<b><span dir="rtl"><?php echo $row++;?> -</span>
    	<span dir="rtl"><?php echo $db_field ['groupname']?> (ID=<?php echo $db_field['gid'];?>) </span></b>
<br>
		<?php getfullschool($db_field);?>
		تعداد اعضا: <?php echo $db_field ['memcount']?> 
		وضعیت: <?php echo $db_field ['enabled']?>
		تاریخ ساخت: <?php echo $db_field ['datecreated']?><br/>
		<b>شماره فیش: <span color=red><?php echo $db_field ['fishid']?> </span></b>
<br/><p align=left dir=ltr>username:<?php echo $db_field ['username']?> - pass:<?php echo $db_field ['pass']?></p><br/>

<br>
		<a href="mastereditpage.php?groupid=<?php echo $db_field ['gid']?>"><img border="0" src="./gif/edit.gif" width="32" height="30" alt="ویرایش"></a>
		<a href="sendmessage.php?groupname=<?php echo $db_field ['groupname']?>"><img border="0" src="./gif/mail.gif" width="32" height="28" alt="پیغامگذاری"></a>
		<br/>
		<a href="?action=changestat&stat=enabled&groupid=<?php echo $db_field ['gid']?>"><img border="0" src="./gif/members.gif" width="32" height="26" alt="فعال"></a>
		<a href="?action=changestat&stat=disabled&groupid=<?php echo $db_field ['gid']?>"><img border="0" src="./gif/dmembers.gif" width="32" height="26" alt="غیرفعال"></a>
		<a href="?action=changestat&stat=taligh&groupid=<?php echo $db_field ['gid']?>"><img border="0" src="./gif/Tmembers.gif" width="32" height="26" alt="تعلیق"></a>
		<a href="?action=changestat&stat=ghabul&groupid=<?php echo $db_field ['gid']?>"><img border="0" src="./gif/gmembers.gif" width="32" height="26" alt="قبول1"></a>
		<br/>
		<a href="antieteraz.php?groupid=<?php echo $db_field ['gid']?>"><img border="0" src="./gif/sos.gif" width="32" height="26" alt="(بررسی اعتراض)"></a>
		<a href="setkatbi.php?return=groups.php&groupid=<?php echo $db_field ['gid']?>"><img border="0" src="./gif/katbi.gif" width="32" height="26" alt="نمره کتبی"></a>
	</right><?php border_end(); ?><br>

	<?php }?>
</table>
<?php echo GetPageNavigation($_GET['start'],$rowcount,$dbh);?>
<?php $dbh=null;?>
</div></center>
</body>
<?php }else{?>
<center><b>شما قادر به استفاده از این صفحه نیستید</b></center>
<?php }?>
<?php include($MyRoot.'footer.php'); ?>