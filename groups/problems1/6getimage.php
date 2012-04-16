<?php
include_once '../config.php';
include_once '../functions.php'; 
$groupid=getgroupid($_SESSION ['username'],$dbh);
// Find out about latest image
	
	$stmt = $dbh->prepare("select rokhimg from problems WHERE groupid=?");
    $stmt->execute(array($groupid));
if ($row =  $stmt->fetch()) {
        $bytes = $row['rokhimg'];
} else {
        $errmsg = "There is no image in the database yet";
        $title = "no database image available";
}
if ($_REQUEST[gim] == 1) {
        header("Content-type: image/jpeg");
        print $bytes;
        exit ();
        }?>