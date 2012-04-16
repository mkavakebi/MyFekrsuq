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
		
	/*if(isset($_REQUEST['groupid']))
		$groupid=$_REQUEST['groupid'];
	else
		die('no group id');*/
		
	$stmt = $dbh->prepare("SELECT ID FROM katbi WHERE groupid=?");
    $stmt->execute(array($groupid));
    if($db_field = $stmt->fetch()){}
    else{
    	echo $groupid;
    	$stmt = $dbh->prepare("INSERT INTO katbi (groupid)VALUES(?)");
    	$stmt->execute(array($groupid));
    }
    
	if(isset($_POST['submitkatbi'])){
		$f=array();
		for($i=0;$i<count($names);$i++)
			$f[$i]=$_REQUEST[$names[$i]];
			
    	echo 'succesfully saved<br/>';
	}
	
	
    $stmt2 = $dbh->prepare("SELECT nomre FROM katbi WHERE groupid=?");
    $stmt2->execute(array($groupid));
	$db_fakes = $stmt2->fetch();
	$fakes=explode('^',$db_fakes['nomre']);
?>
<A href="<?php echo $retu?>">back</A>

<form method="post">
	start:<input type="text" name="start" value="<?php echo max($_REQUEST['start'],1);?>"><br/>
	count:<input type="text" name="count" value="<?php echo ((isset($_REQUEST['count']))?$_REQUEST['count']:10);?>">
	<?php for($i=0;$i<count($names);$i++){?>
		<input type="checkbox"
		 name="<?php echo $names[$i] ?>checkTick"
		 value="OK"
		 <?php if( $_REQUEST[$names[$i].'checkTick']=="OK") echo "checked"; ?>>
		 <?php echo $names[$i]?>
	<?php }?>
	<input type="submit" name="resetkatbi" value="نمایش" >
</form>


<form method="post">
<?php for($i=0;$i<count($names);$i++){?>
<p><?php echo $names[$i];?><input type="text" name="<?php echo $names[$i];?>" value="<?php echo $fakes[$i];?>"></p>
<?php }?>
<input type="hidden" name="groupid" value="<?php echo $groupid;?>">
<input type="hidden" name="return" value="<?php echo $retu;?>">
<input type="submit" name="submitkatbi" value="ثبت" >
</form>