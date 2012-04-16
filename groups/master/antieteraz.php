<?php
include_once  '../config.php';
include_once  './functions.php';
include_once '../mhd.php';
?>
<?PHP
 if ($_SESSION ['usernamemaster'] != ''){
 	if (isset($_GET ['groupid'])){
 	$_SESSION['groupid']=$_GET ['groupid'];
 	}
 	$id=$_SESSION['groupid'];
?>
<?php 
 	$stmt = $dbh->prepare("SELECT * FROM groups WHERE ID=?");
    $stmt->execute(array($id));
    $db_inf = $stmt->fetch();
	echo 'groupname: '.$db_inf['groupname'].'<br>';
	echo 'ID: '.$db_inf['ID'].'<br>';
	echo 'groupcity: '.$db_inf['groupname'].'<br>';
	echo 'schoolname: '.$db_inf['schoolname'].'<br>'.'<br>';
?>
<?php showmessages2($id*-2,$dbh);?>
<?php }else{?>
<center><b>شما قادر به استفاده از این صفحه نیستید</b></center>
<?php }?>
<?php include('footer.php'); ?>