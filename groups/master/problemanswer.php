<?php
include '../config.php';
include '../functions.php';
?>
<?php
if(isset($_REQUEST['groupid']))
{
	$stmt=$dbh->prepare("SELECT * FROM problems JOIN groups ON (groups.ID=problems.groupid) WHERE groupid=?");
	$stmt->execute(array($_REQUEST['groupid']));
	$db_field = $stmt->fetch();
}
?>
<P>group name: <?php echo $db_field['groupname'];  ?></P>
<P>answer to ordu: <?php echo $db_field['ordu'];  ?></P>
<P>answer to chomp: <?php echo $db_field['cacao'];  ?></P>
<P>answer to code: <?php echo $db_field['code'];  ?></P>
<P>answer to sudoku: <?php echo $db_field['sudoku'];  ?></P>
