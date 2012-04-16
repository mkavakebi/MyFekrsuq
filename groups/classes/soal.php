<?php
class soal
{
	
	var $dbh;
	protected $db_field;
	var $WrongID=true;
	/////////////////constants/////////////
	static $Levels=array('ساده','معمولی','سخت');
	static $zarib=array(2,3,4);
	static $maxmoney=array(100000,100000,1000000);
	static $MaxGet=array(2,2,2);
	static $timeeffect=array(0.02,0.015,0.01);
	///////////////////////////
	function __construct($dbh=null)
	{
    	$this->dbh=$dbh;
    	$this->SetLevel(0);
	}
	
	function InitID($SoalID)
	{
		$stmt = $this->dbh->prepare("SELECT * FROM problems2 WHERE ID=?");
		$stmt->execute(array($SoalID));
		$db_field = $stmt->fetch();
		$this->db_field=$db_field;
		if($db_field){
			$this->WrongID=false;
			return true;
		}else{
			$this->WrongID=true;
			return false;
		}
	}
	function InitRow($db_field)
	{
		if($db_field){
			$this->db_field=$db_field;
			return true;
		}else{
			return false;
		}
	}		
	function CheckAnswer($value){
		if ($value==$this->Answer())
			return true;
		else
			return false;
	}
	///////////get functions
	function ID(){return $this->db_field['ID'];}
	function Level(){return $this->db_field['level'];}
	function Body(){return $this->db_field['body'];}
	function Answer(){return $this->db_field['answer'];}
	function Title(){return $this->db_field['title'];}
	function GetLevel(){
		return soal::$Levels[$this->Level()];
	}
	///////////set functions
	function SetID($value){ $this->db_field['ID']=$value;}
	function SetLevel($value){ $this->db_field['level']=$value;}
	function SetBody($value){ $this->db_field['body']=$value;}
	function SetAnswer($value){ $this->db_field['answer']=$value;}
	function SetTitle($value){ $this->db_field['title']=$value;}
	//////////Update ans save in db functions
	function SaveAsNew()
	{
		$stmt = $this->dbh->prepare("INSERT INTO problems2 (level,body,title,answer)VALUES(?,?,?,?)");
    	$stmt->execute(array($this->Level(),$this->Body(),$this->Title(),$this->Answer()));
	}
	function SaveEdited()
	{
		$stmt = $this->dbh->prepare("UPDATE problems2 SET level=?,body=?,title=?,answer=? WHERE ID=?");
		$stmt->execute(array($this->Level(),$this->Body(),$this->Title(),$this->Answer(),$this->ID()));
	}
	function DeleteByID($soalid)
	{
		$stmt = $this->dbh->prepare("DELETE FROM problems2 WHERE ID=?");
		$stmt->execute(array($soalid));
	}
	
}
