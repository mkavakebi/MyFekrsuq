<?php
include_once '../config.php';
include_once '../functions.php';
include_once '../katbiconfig.php';
?>
<?php 
	if(isset($_REQUEST['return']))
		$retu=$_REQUEST['return'];
	else
		$retu='masterpage.php';
		
	if(isset($_REQUEST['groupid']))
		$groupid=$_REQUEST['groupid'];
	else
		die('no group id');
    
	KatbiRecordExist($groupid,$dbh);
		
	if(isset($_POST['submitkatbi'])){
		$f=array();
		for($i=0;$i<count($names);$i++)
			$f[$i]=$_REQUEST[$names[$i]];
		SaveKatbiEmtiaz($groupid,$f,$dbh);
    	echo 'ذخیره شد<br/>';
	}
	
	
    $stmt2 = $dbh->prepare("SELECT nomre FROM katbi WHERE groupid=?");
    $stmt2->execute(array($groupid));
	$db_fakes = $stmt2->fetch();
	$fakes=explode('^',$db_fakes['nomre']);
?>
<A href="<?php echo $retu?>">back</A>
<form method="post">
<?php for($i=0;$i<count($names);$i++){?>
<p><?php echo $names[$i];?><input type="text" name="<?php echo $names[$i];?>" value="<?php echo $fakes[$i];?>"></p>
<?php }?>
<input type="hidden" name="groupid" value="<?php echo $groupid;?>">
<input type="hidden" name="return" value="<?php echo $retu;?>">
<input type="submit" name="submitkatbi" value="ثبت" >
</form>