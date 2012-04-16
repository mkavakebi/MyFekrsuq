<?php
include_once '../config.php';
include_once '../functions.php';
?>
<?php 
	$groupid=2;//getgroupid($_SESSION ['username'],$dbh);
	//if(isset($_REQUEST['token'])){
		$stmt = $dbh->prepare("UPDATE problems SET cacao=?,cacaoip=?  WHERE groupid=?");
    	$stmt->execute(array($_REQUEST['token'],$test_ip,$groupid));
	//}
?>