<?php
class message
{
	var $dbh;
	function __construct($dbh)
	{
		$this->dbh=$dbh;	
	}
	
	function Save($toid,$fromid,$subject,$message,$type)
	{//-1=all
		$stmt = $this->dbh->prepare("INSERT INTO messages (type,readerid,writerid,mes_date,mes_subject,mes_value) VALUES (?,?,?,NOW(),?,?)");
	    $stmt->execute(array($type,$toid,$fromid,$subject,$message));
	}
	
	function SendGroup2Master($subject,$message,$groupid){
		$this->Save('',$groupid,$subject,$message,'eteraz');
	}
	
	function ShowMessages($groupid,$flag='')
	{
		$stmt = $this->dbh->prepare("SELECT * FROM messages WHERE readerid=?");
	    $stmt->execute(array($groupid));
		while ( $db_mes = $stmt->fetch()) {
	      magic_start('<img src="gif/pm.gif"/> '.$db_mes ['mes_subject']);
	      if ($flag=='delete'){
	      	echo '<A href="sendmessage.php?groupname=all" >Delete this message</A>';
	      }
	      echo $db_mes ['mes_value'].'<br/>'.$db_mes ['mes_date'];
	      magic_end();
	      echo('</br>');
	     }
	}
	
	function ShowMasterMessages($groupname,$groupid)
	{
		$stmt = $this->dbh->prepare("SELECT * FROM messages WHERE readerid=?");
	    $stmt->execute(array($groupid));
		while ( $db_mes = $stmt->fetch()) {
	      magic_start('<img src="gif/pm.gif"/> '.$db_mes ['mes_subject']);
	      echo '<A href="sendmessage.php?groupname='.$groupname.'&action=delete&messageid='.$db_mes ['ID'].'" >Delete this message</A>';
	      echo $db_mes ['mes_value'].'<br/>'.$db_mes ['mes_date'];
	      magic_end();
	      echo('</br>');
	     }
	}
	
	function Delete($messageid)
	{
		$stmt = $this->dbh->prepare("DELETE FROM messages WHERE ID=?");
	    $stmt->execute(array($messageid));
	}
	
	function DeleteMessagesWithUName($messageid,$groupid)
	{
		$stmt = $this->dbh->prepare("DELETE FROM messages WHERE ID=? AND readerid=?");
	    $stmt->execute(array($messageid,$groupid));
	}
}