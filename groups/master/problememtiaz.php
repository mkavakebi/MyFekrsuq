<?php
include '../config.php';
include '../functions.php';
include '../checkanswers.php';
?>
<?PHP
if ($_SESSION ['usernamemaster'] != ''){
// header ( "Location:master.php" );
if(isset($_REQUEST['recheck']))
{
	//clear table emtiaz
	$stmt2=$dbh->prepare("TRUNCATE TABLE emtiaz");
	$stmt2->execute();
	$stmt2=$dbh->prepare("ALTER TABLE emtiaz AUTO_INCREMENT = 1");
	$stmt2->execute();
	//////////
	$stmt1=$dbh->prepare("SELECT * FROM problems");
	$stmt1->execute();
	while($pr_field = $stmt1->fetch())
	{
		//if($pr_field['groupid']==170){
		$stmt2=$dbh->prepare("INSERT INTO emtiaz (groupid,ordu,code,sudoku,chomp) VALUES (?,?,?,?,?)");
		$orduscore=checkordu($pr_field['ordu']);
		//$codescore=checkcode($pr_field['code']);
		if($coderet=getcodescore($pr_field['groupid'],$dbh))
		{}else{
			$coderet=checkcode($pr_field['code']);
		}
		$sudokuscore=checksudoku($pr_field['sudoku']);
		$chompscore=checkchomp($pr_field['cacao']);
		$stmt2->execute(array($pr_field['groupid'],$orduscore,$coderet,$sudokuscore,$chompscore));
		//}
	}
}
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<body>
<a href="?recheck=1">recheck emtiaz</a>
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
	<th width="100" class="bTD" height="18">اردو</th>
	<th width="100" class="bTD" height="18">رمز نگاری</th>
	<th width="100" class="bTD" height="18">سودوکو</th>
	<th width="100" class="bTD" height="18">شکلات</th>
	<th width="100" class="bTD" height="18">جمع</th>
	<th width="50" class="bTD" height="18">جواب ها</th>
</tr>
<?php
	$stmt = $dbh->prepare("SELECT *,groups.ID as gid,(ordu+code+sudoku+chomp) as sum FROM groups RIGHT JOIN emtiaz ON (groups.ID=emtiaz.groupid) ORDER BY sum DESC");
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
		<td width="368" class="bTD" height="18"><?php	echo $db_field ['gid']?></td>
		<td width="368" class="bTD" height="18"><?php	echo $db_field ['enabled']?></td>
		<td width="100" class="bTD" height="18"><?php	echo $db_field ['ordu']?></td>
		<td width="100" class="bTD" height="18"><?php	echo $db_field ['code']?></td>
		<td width="100" class="bTD" height="18"><?php	echo $db_field ['sudoku']?></td>
		<td width="100" class="bTD" height="18"><?php	echo $db_field ['chomp']?></td>
		<td width="100" class="bTD" height="18"><?php	echo $db_field ['sum']?></td>
		<td width="50" class="bTD" height="18"><a href="problemanswer.php?groupid=<?php	echo $db_field ['gid']?>">??</a></td>
	</tr>
	<?php }
	$dbh=null;?>
</table>
</body>
<?php } else{?>
<center><b>شما قادر به استفاده از این صفحه نیستید</b></center>
<?php }?>

