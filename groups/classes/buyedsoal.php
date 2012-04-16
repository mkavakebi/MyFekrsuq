<?php
include_once $MyClasses.'soal.php';

class buyedsoal extends soal
{
	////////////////////////////////////////
	protected $db2;
	function __construct($dbh=null){
		parent::__construct($dbh);

	}
	function InitAssign($soalID,$groupid){
		if($this->InitID($soalID)==false)return false;
		$stmt = $this->dbh->prepare("SELECT * FROM probassign2 WHERE problemid=? AND groupid=? ");
		$stmt->execute(array($this->ID(),$groupid));
		$db=$stmt->fetch();
		if($db){
			$this->db2=$db;
			return true;			
		}else{
			return false;
		}
		
	}
	///////////get functions
	function GroupID(){return $this->db2['groupid'];}
	function Time(){return $this->db2['time'];}
	function Money(){return $this->db2['money'];}
	function WrongCount(){return $this->db2['counter'];}
	function AssignID(){return $this->db2['ID'];}
	function Stat(){return $this->db2['stat'];}
	function GottenEmtiaz(){return $this->db2['gottenemtiaz'];}
	function Emtiaz(){
		return 5;
	}
	///////////set functions
	function IncreaseCounter(){ $this->db2['counter']=$this->db2['counter']+1;}
	function SetGroupID($value){ $this->db2['groupid']=$value;}
	function SetGottenEmtiaz($emtiaz){
		$stmt = $this->dbh->prepare("UPDATE probassign2 SET gottenemtiaz=? WHERE ID=?");
		echo $this->AssignID();
		$stmt->execute(array($emtiaz,$this->AssignID()));
	}
	//////////Update functions
	function UpdateCounter(){
		$stmt = $this->dbh->prepare("UPDATE probassign2 SET counter=? WHERE ID=?");
		$stmt->execute(array($this->WrongCount(),$this->AssignID()));
	}
}
