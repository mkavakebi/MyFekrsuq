<?php
function SaveKatbiEmtiaz($groupid,$emtiazha,$dbh)
{
		$stmt = $dbh->prepare("UPDATE katbi SET nomre=?,nomresum=?  WHERE groupid=?");
		$sum=0;
		for($i=0;$i<count($emtiazha);$i++)
			$sum+=$emtiazha[$i];
			
    	$stmt->execute(array(implode('^',$emtiazha),$sum,$groupid));
}

function KatbiRecordExist($groupid,$dbh)
{
	$stmt = $dbh->prepare("SELECT ID FROM katbi WHERE groupid=?");
    $stmt->execute(array($groupid));
    if($db_field = $stmt->fetch()){}
    else{
    	echo $groupid;
    	$stmt = $dbh->prepare("INSERT INTO katbi (groupid)VALUES(?)");
    	$stmt->execute(array($groupid));
    }
}