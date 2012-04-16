<?php
class ListTable
{
	var $dbh;
	function __construct($dbh)
	{
		$this->dbh=$dbh;
	}
	function GetPageNavigation($cur,$size){
	$stmt = $this->dbh->prepare("SELECT COUNT(ID) AS num FROM groups");
    $stmt->execute();
	$db_field = $stmt->fetch();
	$text='';
	////////////first
	$text=$text.' <a href="masterpage.php?start=0">First</a> ';
	////////////before
	if($cur>0)
		$text=$text.' <a href="masterpage.php?start='.($cur-$size).'">Before</a> ';
	else
		$text=$text.' Before ';
	//////////////////////////page number
	$text=$text.' (Page'.(($cur/$size)+1).') ';
	//////////////////////next	
	if($cur+$size<$db_field['num']){
		$text=$text.' <a href="masterpage.php?start='.($cur+$size).'">Next</a> ';
	}else{
		$text=$text.' Next ';
	}
	//////////////////////last
	$text=$text.' <a href="masterpage.php?start='.($db_field['num']-$db_field['num']%$size).'">Last</a> ';
	return $text;	
	}
	
}