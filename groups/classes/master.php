<?php
include 'message.php';
class Master
{
	var $dbh;
	function __construct($dbh){
		$this->dbh=$dbh;
	}
	function Login($username,$master_pass) {
		$check1=$this->FilterStrict($username,1);	
		if ($check1==1 or $check1==2) return 'نام کاربری خود را تصحیح کنید.';
		$check2=$this->FilterStrict($master_pass,1);
		if ($check2==1 or $check2==2) return 'رمز عبور خود را تصحیح کنید.';
		
		$stmt = $this->dbh->prepare("SELECT username FROM owners WHERE username=? AND password=?");
	    $stmt->execute(array($username,$master_pass));
		if ($db_field =$stmt->fetch()) {
			session_start ();
			$_SESSION ['loginmaster'] = '2';
			$_SESSION ['usernamemaster'] = $db_field ['username'];
			header ( 'Location:masterpage.php' );
			return '';
		} else {
			session_start ();
			$_SESSION ['loginmaster'] = '';
			$_SESSION ['usernamemaster'] = '';
			return 'چنین کاربری یافت نشد';
		}
	}
	function LogOut(){
		session_start ();
		$_SESSION ['loginmaster'] = '';
		$_SESSION ['usernamemaster'] = '';
		session_destroy ();
	}
	///////////////////groups
	var $Limit;
	var $Order;
	var $Filter;
	/**
	 * 
	 * @param $id
	 * @return group
	 */
	function GroupByID($id){
		$p= new group($this->dbh);
		$p->LoadByField('ID',$id);
		return $p;
	}
	function groups($from=0,$count=0)
	{
		//$stmt = $dbh->prepare("SELECT *,COUNT(groups.ID) as memcount,groups.ID as gid FROM groups LEFT JOIN members ON (groups.ID=members.groupid) ".$_SESSION['filter'].' GROUP BY groups.ID '.$_SESSION['order']." ". $_SESSION['limit']);
		$stmt = $this->dbh->prepare("SELECT * FROM groups ".$_SESSION['filter'].' GROUP BY groups.ID '.$_SESSION['order']." ". $this->Limit);
    	$stmt->execute();
	}
	function AddFilter()
	{
		
	}
	///////////////////messages
	function SendMessage2AllGroups($subject,$message){
		$mes=new message($dbh);
		$mes->Save('','',$subject,$message,'all');
	}
	
	function SendMessage2Group($subject,$message,$groupid){
		$mes=new message($dbh);
		$mes->Save($groupid,'',$subject,$message,'group');
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