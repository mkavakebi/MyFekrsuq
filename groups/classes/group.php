<?php
class group
{
	var $db_field;
	var $dbh;
	var $LoginState=false;
	function group($dbh,$username=false,$password=false)
	{
		$this->dbh=$dbh;
		
		if($username==false) return;
		
		if($password!==false)
		{
			if(! $this->LoginGroup($username,$password)){
				$this->LoginState=false;
				return;
			}else{
				$this->LoginState=true;
			}
		}
		$this->LoadByField('username',$username);
	}
	function LoadByField($field,$value)
	{
		$stmt = $this->dbh->prepare("SELECT * FROM groups WHERE $field=?");
		$stmt->execute(array($value));
		$db_field = $stmt->fetch();
		if(!$db_field){
			$this->LoginState=false;
			return false;
		}else{
			$this->db_field=$db_field;
			$this->LoginState=true;
		}
	}
	function LoginGroup($username, $group_pass) {
	    $stmt = $this->dbh->prepare("SELECT username FROM groups WHERE username=? AND pass=?");
	    $stmt->execute(array($username,$group_pass));
		
	    session_start();
		if ($db_field = $stmt->fetch()) {
			$_SESSION ['login'] = '1';
			$_SESSION ['username'] = $db_field ['username'];
			return true;
		} else {
			$_SESSION ['login'] = '';
			$_SESSION ['username'] = '';
			return false;
		}
	}
	
	function LoginMe() {
	    session_start();
		$_SESSION ['login'] = '1';
		$_SESSION ['username'] = $this->UserName();
		return true;
	}
	
	function InsertAll($username,$group_pass,$group_name ,$group_city,$school_name,$school_type) {
		$this->SetUserName($username);
		$this->SetPassWord($group_pass);
		$this->SetName($group_name);
		$this->SetCity($group_city);
		$this->SetSchool($school_name);
		$this->SetGender($school_type);
	}
	///////////get functions
	function ID(){return $this->db_field['ID'];}
	function UserName(){return $this->db_field['username'];}
	function PassWord(){return $this->db_field['pass'];}
	function City(){return $this->db_field['groupcity'];}
	function Gender(){return $this->db_field['schooltype'];}
	function FishID(){return $this->db_field['fishid'];}
	function School(){return $this->db_field['schoolname'];}
	function State(){return $this->db_field['enabled'];}
	function Name(){return $this->db_field['groupname'];}
	//////////////////////other functions
	function GetFullSchool(){
		echo 'گروه '.$this->Name().
		'، از دبیرستان '.($this->Gender()=='male'?'پسرانه':'دخترانه').
		'‌ی '.$this->City().'<small>('.$this->School().')</small><br />';
	}
	function IsMale(){return ($this->Gender()=='male');	}
	function IsFemale(){return !$this->IsMale();}
	/////////////////Update db Function
	var $CheckBeforeUpdate=true;
	function Update($field,$value)
	{
		if ($CheckBeforeUpdate and  $this->db_field[$field]==$value){
			return;
		}else{
		$this->db_field[$field]=$value;
		$stmt = $this->dbh->prepare("UPDATE groups SET ".$field."=? WHERE ID=?");
		$stmt->execute(array($value,$this->ID()));
		}
	}
	function SaveAsNew()
	{
		$stmt = $this->dbh->prepare("INSERT INTO groups
						(username,groupname,enabled,groupcity,schoolname,schooltype,pass,datecreated,dateedited)
						VALUES (?,?,'unknown',?,?,?,?,NOW(),NOW())");
	    $stmt->execute(array($this->UserName(),$this->Name(),$this->City(),$this->School(),$this->Gender(),$this->PassWord()));
	    $this->db_field['ID']=$this->dbh->lastInsertId();
	}
	/////////////////Check Functions
	function CheckAll()
	{
		if (!$this->CheckUserName($this->UserName()))return 'نام کاربری خود را تصحیح کنید.';
		if (!$this->CheckPassWord($this->PassWord()))return'کلمه عبور جدید شما قابل قبول نیست!';
		if (!$this->CheckName($this->Name()))return 'این نام گروه قابل قبول نیست';
		if (!$this->CheckCity($this->City()))return 'این نام شهر قابل قبول نیست';
		if (!$this->CheckSchool($this->School()))return 'این نام مدرسه قابل قبول نیست';
		if (!$this->CheckGender($this->Gender()))return 'این نوع مدرسه قابل قبول نیست';	
	}
	function CheckReputation()
	{
		if ($this->IsThereUsername($this->UserName()))return 'این نام کاربری توسط گروه دیگری استفاده شده است.';
		if ($this->IsThereName($this->Name()))return 'نام گروه شما توسط گروه دیگری استفاده شده است!';
	}
	function CheckName($value){
		$check=$this->FilterStrict($value,1);
		if ($check==1 or $check==2){
			return false;
		}else{
			return true;
		}
	}
	function CheckFishID($value){
		$check=$this->FilterStrict($value,1);
		if ($check==1){
			return false;
		}else{
			return true;
		}
	}
	function CheckPassWord($value){
		$check=$this->FilterStrict($value,1);
		if ($check==1 or $check==2){
			return false;
		}else{
			return true;
		}
	}
	function CheckCity($value){
		$check=$this->FilterStrictNew($value,1,30,'FN ');
		if ($check==1 or $check==2){
			return false;
		}else{
			return true;
		}
	}	
	function CheckSchool($value){
		$check=$this->FilterStrictNew($value,1,30,'FN ');
		if ($check==1 or $check==2){
			return false;
		}else{
			return true;
		}
	}	
	function CheckUserName($value){
		$check=$this->FilterStrict($value,5);
		if ($check==1 or $check==2){
			return false;
		}else{
			return true;
		}
	}
	function CheckGender($value){
		if ($value=='male' or $value=='female')
			return true;
		else 
			return false;
	}
	
	function CheckState($value){return $this->db_field['enabled'];}
	/////////////////Set Functions
	function SetFishID($value){
		$this->Update('fishid',$value);
		$this->Update('enabled','taligh');
	}
	function SetPassWord($value){$this->Update('pass',$value);}
	function SetName($value){$this->Update('groupname',$value);}
	function SetCity($value){$this->Update('groupcity',$value);}
	function SetSchool($value){$this->Update('schoolname',$value);}
	function SetGender($value){$this->Update('schooltype',$value);}
	function SetUserName($value){$this->Update('username',$value);}	
	function SetState($value){$this->Update('enabled',$value);}
	/////////////////IS THERE Functions
	function IsThereField($field,$value){
		$stmt = $this->dbh->prepare("SELECT * FROM groups WHERE $field=?");
		$stmt->execute(array($value));
		if($db_field = $stmt->fetch())
			return true;
		else
			return false;
	}
	function IsThereUsername($value){return $this->IsThereField('username',$value);}
	function IsThereName($value){return $this->IsThereField('groupname',$value);}
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
/*
function GroupError($username, $group_name, $group_pass,$group_city,$school_name,$school_type,$dbh) {
	if (FilterStrict($username,5)==2) return 'نام کاربری خود را تصحیح کنید.';
	//return FilterStrict($username,5);
	if(FilterStrict($username,5)==1) return 'نام کاربری باید حداقل 5کاراکتر باشد.'; 
	
	//if (FilterStrict($group_name,4)==1 or FilterStrict($group_name,4)==2) return 'نام گروه خود را تصحیح کنید.';
	if (FilterStrict($group_name,4)==1) return 'نام گروه خود را تصحیح کنید.';
	
	$stmt = $dbh->prepare("SELECT * FROM groups WHERE username=?");
    $stmt->execute(array($username));
	if ($db_field = $stmt->fetch()) return 'گروه دیگری با این نام ثبت شده';
	
	if (FilterStrictNew($group_city,1,30,'FN ')==1 or FilterStrictNew($group_city,1,30,'FN ')==2) return 'نام شهر خود را تصحیح کنید(به صورت فارسی (.';
	if (FilterStrictNew($school_name,1,30,'FN ')==1 or FilterStrictNew($school_name,1,30,'FN ')==2) return 'نام مدرسه خود را تصحیح کنید(به صورت فارسی (.';
	
	if (FilterStrict($school_type,1)==1 or FilterStrict($school_type,1)==2) return 'نوع مدرسه خود را تصحیح کنید.';
	
	if (FilterStrict($group_pass,5)==2) return 'رمز عبور خود را تصحیح کنید.';
	if(FilterStrict($group_pass,5)==1) return 'رمز عبور باید حداقل 5کاراکتر باشد.'; 
	
}
 */