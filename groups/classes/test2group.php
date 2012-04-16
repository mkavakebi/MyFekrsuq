<?php
include_once $MyClasses.'group.php';
class Test2Group extends group
{
	var $mojodi;
	var $NotSuchGroup=false;
	const StartingMoney=10000;
	function __construct($dbh,$username)
	{
            parent::__construct($dbh,$username);
            $this->GetCurrentMoney();
	}
	function GetCurrentMoney()
	{
		$stmt = $this->dbh->prepare("SELECT mojodi FROM bank2 WHERE groupid=?");
		$stmt->execute(array($this->ID()));
		if($db_field = $stmt->fetch()){
			$this->NotSuchGroup=false;
			$this->mojodi=$db_field['mojodi'];
		}else{
			$this->NotSuchGroup=true;
		}
	}
	function MakeDBRow()
	{
		$stmt = $this->dbh->prepare("SELECT mojodi FROM bank2 WHERE groupid=?");
		$stmt->execute(array($this->ID()));
		$db_field = $stmt->fetch();
		if(!$db_field){
			$stmt = $this->dbh->prepare("INSERT INTO bank2 (groupid,mojodi)VALUES(?,?)");
    		$stmt->execute(array($this->ID(),Test2Group::StartingMoney));
		}
	}

	function PossibleProblems($level)
	{
		$f=array();
		$stmt = $this->dbh->prepare("SELECT problems2.ID FROM problems2 WHERE level=? AND ID NOT IN
									(SELECT problemid FROM probassign2 WHERE groupid=?) ");
		$stmt->execute(array($level,$this->ID()));
		while($db=$stmt->fetch())
			$f[]=$db['ID'];
		
		return $f;
	}
	function HaveSoal()
	{
		if($this->Problem()==false)
			return false;
		else
			return true;
	}
	
	function BuyByID($SoalID,$Money)
	{
		$stmt = $this->dbh->prepare("INSERT INTO probassign2 (groupid,problemid,time,money) VALUES (?,?,NOW(),?)");
		$stmt->execute(array($this->ID(),$SoalID,$Money));
	}
	function Buy($Level,$Money)
	{
		$f=$this->PossibleProblems($Level);
		if(count($f)==0)return false;
		$soalid=array_rand($f,1);
		$this->BuyByID($f[$soalid],$Money); 
		$this->EmtiazDadan(-$Money);
		return true;
	}
	/**
	 * 
	 * @return buyedsoal
	 */
	function Problem()
	{
		$stmt = $this->dbh->prepare("SELECT problemid FROM probassign2 WHERE groupid=? AND stat=''");
		$stmt->execute(array($this->ID()));
		if($db=$stmt->fetch()){
			$f=new buyedsoal($this->dbh);
			$f->InitAssign($db['problemid'],$this->ID());
			return $f;	
		}else{
			return false;
		}
	}
	
	/**
	 * 
	 * @return buyedsoal
	 */
	function AllProblems()
	{
		$f=array();
		$stmt = $this->dbh->prepare("SELECT problemid FROM probassign2 WHERE groupid=?");
		$stmt->execute(array($this->ID()));
		While($db=$stmt->fetch()){
			$t=new buyedsoal($this->dbh);
			$t->InitAssign($db['problemid'],$this->ID());
			$f[]=$t;	
		}
		if(count($f)==0){
			return false;
		}else{
			return $f;
		}
	}
	
	function ProblemRemove($stat='enseraf'){
		$stmt = $this->dbh->prepare("UPDATE probassign2 SET stat=? WHERE groupid=? AND ID=?");
		$stmt->execute(array($stat,$this->ID(),$this->Problem()->AssignID()));
	}
	function EmtiazDadan($emtiaz){
		$this->mojodi= $this->mojodi+$emtiaz;
		$stmt = $this->dbh->prepare("UPDATE bank2 SET mojodi=? WHERE groupid=?");
		$stmt->execute(array($this->mojodi,$this->ID()));
	}
	function DoAnswer($value){
		$f=$this->Problem();
		if($f->CheckAnswer($value)){
			$this->EmtiazDadan($f->Emtiaz());
			$f->SetGottenEmtiaz($f->Emtiaz());
			$this->ProblemRemove('win');
			return true;
		}else{
			$f->IncreaseCounter();
			$f->UpdateCounter();
			return false;	
		}
	}
	function Rotbe(){
		$stmt = $this->dbh->prepare("SELECT COUNT(ID)as rotbe FROM bank2 WHERE mojodi<?");
		$stmt->execute(array($this->GetCurrentMoney()));
		if($db_field = $stmt->fetch()){
			return $db_field['rotbe'];
		}else{
			return false;
		}
	}
	
}
