<?php
function getfullschool($db_field){?>
	گروه <?php echo ($db_field['groupname']); ?>، از
		دبیرستان <?php if ($db_field['schooltype']=='male') echo ('پسرانه'); else echo('دخترانه'); echo(''); ?>‌ی
		<?php echo ($db_field['groupcity']); ?> <small> (<?php echo ($db_field['schoolname']); ?>)
		</small><br />
<?php }
function IsGroupEnabled($username,$dbh){
	$stmt = $dbh->prepare("SELECT enabled FROM groups WHERE username=?");
    $stmt->execute(array($username));
	if($db_field = $stmt->fetch()){
		return $db_field ['enabled'];
	}
}

function getgroupid($username,$dbh){
	$stmt = $dbh->prepare("SELECT ID FROM groups WHERE username=?");
    $stmt->execute(array( $username));
	if($db_field = $stmt->fetch()){
		return $db_field ['ID'];
	}
}

function getgroupidfromfield($value,$field_name,$dbh){
	if ($value=="all" && $field_name=='groupname')return -1;
	$stmt = $dbh->prepare("SELECT ID FROM groups WHERE $field_name=?");
    $stmt->execute(array($value));
	if($db_field = $stmt->fetch()){
		return $db_field ['ID'];
	}
}

function GetOrderQuery($field,$curfield,$asc){
	if ($field==$curfield){
		if ($asc=='ASC')
			$asc='DESC';
		else $asc='ASC';
	}else{
		$asc='ASC';
	}
	return '?order='.$field.'&asc='.$asc;		
}

function GetPageNavigation($cur,$size,$dbh){
	$stmt = $dbh->prepare("SELECT COUNT(ID) AS num FROM groups");
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

function GetProblemNavigation($cur,$size){
	$text='<center>';
	////////////before
	if($cur>1)
		$text=$text.' <a href="problempage.php?page='.($cur-1).'">Before</a> ';
	else
		$text=$text.' Before ';
	//////////////////////next	
	if($cur<$size){
		$text=$text.' <a href="problempage.php?page='.($cur+1).'">Next</a> ';
	}else{
		$text=$text.' Next ';
	}
	//////////////////////br
	$text=$text.'</br>';
	//////////////////////page numbers
	for ($i=1;$i<=$size;$i++){
		if ($i!=$cur)
			$text=$text.'<a href="problempage.php?page='.$i.'"> '.$i.' </a> ';
		else
			$text=$text.' ['.$i.'] ';
	}
	//////////////////////
	$text=$text.'</center>';
	return $text;	
}

function MemberCount($username,$dbh){
	$stmt = $dbh->prepare("SELECT COUNT(ID) AS num FROM members  WHERE groupid=?");
    $stmt->execute(array(getgroupid($username,$dbh)));
	$db_field = $stmt->fetch();
	if ($db_field ['num']>=3) return 'تعداد عضو های گروه شما بیش از این نمیتواند افزایش یابد.';	
}