<?php border_start();?>سوال 2: من و مشنگ شروع به خوردن يك شكلات 4×7 مي كنيم با انتخاب هر خانه از شكلات آن خانه همراه با خانه هاي سمت بالا و راست آن توسط كسي كه خانه را انتخاب كرده خورده مي شود. هر بازيكن آرزو مي كند شكلات تمام نشود (يعني به خانه ي پايين و سمت چپ نرسد). حالا شما به مشنگ کمک کنید تا در این بازی از من ببرد. این رو هم بگم که من توی بازی های کامپیوتری <B>سرعت</B> و <B>مهارت</B> خارق العاده ای دارم!!!</br>
<?php border_end();?><br/>
<?php border_start();?>
<div dir=ltr style="text-align:center">
<center>
<?php 
	$groupid=getgroupid($_SESSION ['username'],$dbh);
	if(isset($_REQUEST['token'])){
		$stmt = $dbh->prepare("UPDATE problems SET cacao=?,cacaoip=?,cacaotime=NOW()  WHERE groupid=?");
    	$stmt->execute(array($_REQUEST['token'],$test_ip,$groupid));
    	header('Location:'.$GroupAdd.'/'.'problempage.php?page='.$current);
	}
?>
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
    <center>
    <p style="font-size:11px">
	<?php if ($fakes!=''){?>
	<br><font color=green>برد شما ثبت شده است.</font>
	<?php }else{?>
	<br>شماهنوز این بازی را با موفقیت به پایان نرسانده اید :D
	</center>
	<script language="JavaScript">
		var shiftind = 10; 
		var myurl='?page=4';//'problems/getwinner.php';
	</script>
	<?php //include "problems/chomp.html";?>
	<?php }?>
</p>

</center>
</div>
<?php border_end();?>