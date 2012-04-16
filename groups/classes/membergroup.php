<?php
include 'group.php';
include 'member.php';
class membergroup extends group
{
	function __construct($dbh,$username=false,$password=false){
		parent::group($dbh,$username,$password);
	}
	/**
	 * 
	 * @param member $member
	 */
	function AddMember($member,$type=''){
		if ($this->MemberCount()>=3) return false;	
		$member->dbh=$this->dbh;
		$member->SetType($type);
		$member->SetGroupID($this->ID());
		$member->SaveAsNew();
		return true;
	}
	/**
	 * 
	 * @return member
	 */
	function Members(){
		$f=array();
		$stmt = $this->dbh->prepare("SELECT * FROM members WHERE groupid=?");
		$stmt->execute(array($this->ID()));
		while($db = $stmt->fetch()){
			$mem=new member($this->dbh);
			$mem->InitRow($db);
			$f[]=$mem;
		}
		if(count($f)==0){
			return false;
		}else{
			return $f;
		}
	}
	
	/**
	 * 
	 * @return member
	 */
	function Member($memid){
		$stmt = $this->dbh->prepare("SELECT * FROM members WHERE groupid=? AND ID=?");
		$stmt->execute(array($this->ID(),$memid));
		if($db = $stmt->fetch()){
			$mem=new member($this->dbh);
			$mem->InitRow($db);
			return $mem;
		}else{
			return false;
		}
	}
	
	/**
	 * 
	 * @return member
	 */
	function HeaderMember(){
		$stmt = $this->dbh->prepare("SELECT * FROM members WHERE groupid=? AND type='header'");
		$stmt->execute(array($this->ID()));
		if($db = $stmt->fetch()){
			$mem=new member($this->dbh);
			$mem->InitRow($db);
			return $mem;
		}else{
			return false;
		}
	}
	
	function MemberCount(){
		$stmt = $this->dbh->prepare("SELECT COUNT(ID) AS num FROM members WHERE groupid=?");
	    $stmt->execute(array($this->ID()));
		$db= $stmt->fetch();
		return $db['num'];	
	}
	function DeleteMember($memid){
		$mem=$this->Member($memid);
		$mem->dbh=$this->dbh;
		return $mem->Delete();
	}
}