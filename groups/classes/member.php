<?php
class member
{
	var $dbh;
	protected $db_field;
	var $WrongID=true;
	function __construct($dbh=null)
	{
    	$this->dbh=$dbh;
	}
	
	function InitID($SoalID)
	{
		$stmt = $this->dbh->prepare("SELECT * FROM members WHERE ID=?");
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
	function Initfields($mem_name, $mem_family,$mem_email,$paye) {
		if (!$this->CheckName($mem_name)){
			$error='نام عضو خود را تصحیح کنید.';
		}elseif (!$this->CheckFamily($mem_family)){
			$error='نام خانوادگی عضو خود را تصحیح کنید.';
		}elseif (!$this->CheckEmail($mem_email)){
			$error='پست الکترونیکی عضو خود را تصحیح کنید.';
		}elseif (!$this->CheckPaye($paye)){
			$error='پایه عضو خود را تصحیح کنید.';
		}else{
			$this->SetName($mem_name);
			$this->SetFamily($mem_family);
			$this->SetEmail($mem_email);
			$this->SetPaye($paye);
		}
	}	
	///////////get functions
	function ID(){return $this->db_field['ID'];}
	function GroupID(){return $this->db_field['groupid'];}
	function Name(){return $this->db_field['membername'];}
	function Family(){return $this->db_field['memberfamily'];}
	function Email(){return $this->db_field['email'];}
	function Paye(){return $this->db_field['paye'];}
	function Type(){return $this->db_field['type'];}
	function DateCreated(){return $this->db_field['datecreated'];}
	function DateEdited(){return $this->db_field['dateedited'];}
	///////////set functions
	function SetID($value){ $this->db_field['ID']=$value;}
	function SetGroupID($value){ $this->db_field['groupid']=$value;}
	function SetName($value){ $this->db_field['membername']=$value;}
	function SetFamily($value){ $this->db_field['memberfamily']=$value;}
	function SetEmail($value){ $this->db_field['email']=$value;}
	function SetPaye($value){ $this->db_field['paye']=$value;}
	function SetType($value){ $this->db_field['type']=$value;}
	/////////////////Check Functions
	function CheckName($value){
		$check=$this->FilterStrict($value,1);
		if ($check==1){
			return false;
		}else{
			return true;
		}
	}
	function CheckFamily($value){
		$check=$this->FilterStrict($value,1);
		if ($check==1){
			return false;
		}else{
			return true;
		}
	}
	function CheckEmail($value){
		$check=$this->FilterStrict($value,1);
		if ($check==1 or $check==2){
			return false;
		}else{
			return true;
		}
	}
	function CheckPaye($value){
		if ($value=='1' or $value=='2' or $value=='3'){
			return true;
		}else{
			return false;
		}
	}
	function IsThereEmail($email){
		$stmt = $this->dbh->prepare("SELECT * FROM members WHERE email=? AND ID!=?");
	    $stmt->execute(array($email,$memid));
	    if ($db_field = $stmt->fetch())  return 'پست الکترونیکی در بانک اطلاعاتی موجود می باشد!';
	}
	//////////Update ans save in db functions
	function SaveAsNew()
	{
		$stmt = $this->dbh->prepare("INSERT INTO members (groupid,membername,memberfamily,email,paye,type,datecreated,dateedited) VALUES (?,?,?,?,?,?,NOW(),NOW())");
	    $stmt->execute(array($this->GroupID() ,$this->Name(),$this->Family(),$this->Email(),$this->Paye(),$this->Type()));
	}
	function SaveEdited()
	{
		$stmt = $this->dbh->prepare("UPDATE members SET membername=?,memberfamily=?,email=?,paye=?,type=?,dateedited=NOW() WHERE ID=?");
		$stmt->execute(array($this->Name(),$this->Family(),$this->Email(),$this->Paye(),$this->Type(),$this->ID()));
	}
	function Delete()
	{
		if ($db_field['type']=='header'){
			return false;
		}else{
			$stmt = $this->dbh->prepare("DELETE FROM members WHERE ID=?");
			$stmt->execute(array($this->ID()));
			return true;
		}
	}
	//////////////////////////////////filters
	function FilterStrict($string,$minchar/*,$type*/) {
		$CharsAll='';
		$CharsB = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$CharsS = 'abcdefghijklmnopqrstuvwxyz';
		$charfa='ابپتثجچحخدذرزژسشصضطظعغفقکگلمنوهیآأإؤيةءـۀ';
		$CharsC = '.@#%^*_';
		$CharsN = '0123456789';
		$space=' ';
		
		$CharsAll=$CharsB.$CharsS.$charfa.$CharsC.$CharsN.$space;	
		
		if (strlen ( $string ) < $minchar or  strlen ( $string ) > 25) { //size limitation
			return 1;
		}
		for($i = 0; $i < strlen ( $string ); $i ++) {
			if (strpos ( $CharsAll, $string[$i] ) === false) {
				return 2;
			}
		}
		$string = str_replace ( '.', ':', $string );
		return $string;
	}
	function FilterStrictNew($string,$minchar,$maxchar,$type) {
		$CharsAll='';
		$CharsB = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$CharsS = 'abcdefghijklmnopqrstuvwxyz';
		$Charfa='ابپتثجچحخدذرزژسشصضطظعغفقکگلمنوهیآأإؤيةءـۀ';
		$CharsC = '.@#%^*_';
		$CharsN = '0123456789';
		$space=' ';
		
		if ($type=='' ) {
		$CharsAll=$CharsB.$CharsS.$Charfa.$CharsC.$CharsN.$space;
		}
		
		if (!(strpos ( $type, 'N' )===false)) {
		$CharsAll = $CharsAll . $CharsN;
		}
		
		if (!(strpos ( $type, 'B' )===false)) {
		$CharsAll = $CharsAll . $CharsB;
		}
		
		if (!(strpos ( $type, 'S' )===false)) {
		$CharsAll = $CharsAll . $CharsS;
		}
		
		if (!(strpos ( $type, 'C' )===false)) {
		$CharsAll = $CharsAll . $CharsC;
		}
		
		if (!(strpos ( $type, 'F' )===false)) {
		$CharsAll = $CharsAll . $Charfa;
		}
		
		if (!(strpos ( $type, ' ' )===false)) {
		$CharsAll = $CharsAll . $space;
		}
		
		if (strlen ( $string ) < $minchar or  strlen ( $string ) > $maxchar) { //size limitation
			return 1;
		}
		for($i = 0; $i < strlen ( $string ); $i ++) {
			if (strpos ( $CharsAll, $string [$i] ) === false) {
				return 2;
			}
		}
		$string = str_replace ( '.', ':', $string );
		return $string;
	}
	
}