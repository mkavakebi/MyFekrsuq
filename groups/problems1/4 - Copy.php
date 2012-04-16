<?php 
	$groupid=getgroupid($_SESSION ['username'],$dbh);
	if(isset($_REQUEST['token'])){
		$stmt = $dbh->prepare("UPDATE problems SET cacao=?,cacaoip=?,cacaotime=NOW()  WHERE groupid=?");
    	$stmt->execute(array($_REQUEST['token'],$test_ip,$groupid));
    	$myadd='http://localhost/fekrsuq/groups/';
    	header('Location:'.$myadd.'problempage.php?page='.+$current);
	}
?>
<?php border_start();?>سوال 2: من و مشنگ شورع به خوردن يك شكلات 4×7 مي كنيم با انتخاب هر خانه از شكلات آن خانه همراه با خانه هاي سمت بالا و راست آن توسط كسي كه خانه را انتخاب كرده خورده مي شود. هر بازيكن آرزو مي كند شكلات تمام نشود (يعني به خانه ي پايين و سمت چپ نرسد). حالا شما به مشنگ کمک کنید تا در این بازی از من ببرد. این رو هم بگم که من توی بازی های کامپیوتری مهارت خارق العاده ای دارم!!!
<?php border_end();?><br/>
<?php border_start();?>
<div dir=ltr style="text-align:center">
<center>
<?php 
	$groupid=getgroupid($_SESSION ['username'],$dbh);
	$stmt = $dbh->prepare("SELECT ID FROM problems WHERE groupid=?");
    $stmt->execute(array($groupid));
    if($db_field = $stmt->fetch()){}
    else{
    	echo $groupid;
    	$stmt = $dbh->prepare("INSERT INTO problems (groupid)VALUES(?)");
    	$stmt->execute(array($groupid));
    }
    
	if(isset($_POST['submitcacao'])){
		$stmt = $dbh->prepare("UPDATE problems SET cacao=?  WHERE groupid=?");
    	$stmt->execute(array(implode('^',$_POST),$groupid));
	}
	
    $stmt2 = $dbh->prepare("SELECT cacao FROM problems WHERE groupid=?");
    $stmt2->execute(array($groupid));
	$db_fakes = $stmt2->fetch();
	$fakes=$db_fakes['cacao'];
    ?>
	<?php if ($fakes!=''){?>
	<br>شما این بازی را یک بار به پایان رسانده اید ولی هنوز از طرف داور ها مورد تایید قرار نگرفته اید
	<?php }else{?>
	<br>شماهنوز این بازی را به پایان نرسانده اید :D
	<?php }?>
	<script language="JavaScript">
		var username = "<?php echo $_SESSION ['username'];?>"; 
		var shiftind = 10; 
		var myurl='http://localhost/fekrsuq/groups/problems/getwinner.php';
	</script>
	<?php include "problems/chomp.html";?>
</center>
</div>
<?php border_end();?>