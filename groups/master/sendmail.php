<?php
include '../config.php';
include '../functions.php';
?>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<?php
if ($_SESSION ['usernamemaster'] != ''){
//header ( "Location:master.php" );
if (isset ( $_POST ['send'] )) {
	if($_POST ['txtto']!='all'){
		sendmail ( $_POST ['txtto'],'a@b.org', $_POST ['txtTitle'], $_POST ['txtContent'] );
	}else{
		$stmt = $dbh->prepare("SELECT email FROM members");
	    $stmt->execute();
		while ($db_field = $stmt->fetch()) {
			 sendmail ( $db_field['email'],'a@b.org', $_POST ['txtTitle'], $_POST ['txtContent'] );
		}
	}
	
}

if (isset ( $_GET ['groupid'] )) {
	if($_GET ['groupid']!='all'){
		$stmt = $dbh->prepare("SELECT email FROM members WHERE groupid=:groupid");
		$stmt->bindParam(':groupid', $_GET ['groupid'], PDO::PARAM_STR);
	    $stmt->execute();
		
		$email_list='';
		while ($db_field = $stmt->fetch()) {
			 $email_list =$email_list. $db_field['email'].',';
		}
	}else{
		$email_list='all';
	}
}

$dbh=null;
?>
<A href="masterpage.php" >back</A>
<form name="frmPost" method="post" action="sendmail.php" id="frmPost">
<div class="box" style="WIDTH: 598px">
<div class="content" align="center"><!-- START TABLE -->
<table dir='rtl'
	style="FONT-SIZE: 9pt; FONT-FAMILY: Tahoma; BORDER-COLLAPSE: collapse"
	cellSpacing="1" width="97%" border="0">
	<tr>
		<td style="HEIGHT: 21px" width="100%" height="21"><div align="right">To : 
		    <input
			name="txtto" type="text"
			value="<?= $email_list?>" id="txtTitle"
			class="TextBox" style="width: 480px;" />
		  </div></td>
	</tr>
	<tr>
		<td style="HEIGHT: 21px" width="100%" height="21"><div align="right">Title: 
		    <input
			name="txtTitle" type="text"
			value="" id="txtTitle"
			class="TextBox" style="width: 480px;" />
		  </div></td>
	</tr>
	<tr>
		<td width="100%">
		  <div align="center">
		    <textarea name="txtContent" id="txtContent"
			class="TextBox" style="WIDTH: 580px; HEIGHT: 241px" rows="15"
			cols="67"></textarea>
	      </div></td>
	</tr>

	<tr>
		<td align="left" width="100%" height="20"><div align="right">
		  <input type="submit"
			name="send"
			value="send" class="oBtn" style="width: 163px;" /> 
		&nbsp;</div></td>
	</tr>
</table>
<!--END TABLE --> <br>
</div>
</div>
</form>
<?php }else{?>
<center>
  <b>شما قادر به استفاده از این صفحه نیستید</b>
</center>
<?php }?>