<?php
include_once '../config.php';
include_once 'functions.php';
?>
<?php include($MyRoot.'header.php'); ?>
<?php
if ($_SESSION ['username'] != ''){
if (isset ( $_POST ['send'] )) {
	 sendmessage (getgroupid($_SESSION ['username'],$dbh) *-2,$_POST ['txtTitle'], $_POST ['txtContent'],$dbh );
}

if ( $_GET ['action'] =='delete') {
	DeleteMessagesWithUName ($_GET ['messageid'],getgroupid($_SESSION ['username'],$dbh) *-2,$dbh);
}

?>
<p style="text-align: center"><A href="index.php" >back</A></p>
<form name="frmPost" method="post" id="frmPost">
<div class="box" style="WIDTH: 598px">
<div class="content" align="center"><!-- START TABLE -->
<table dir='rtl'
	style="FONT-SIZE: 9pt; FONT-FAMILY: Tahoma; BORDER-COLLAPSE: collapse;text-align: center;"
	cellSpacing="1" width="97%" border="0">
	<tr>
		<td style="HEIGHT: 21px" width="100%" height="21"><div align="right">عنوان: 
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
			value="ارسال" class="oBtn" style="width: 163px;" /> 
		&nbsp;</div></td>
	</tr>
</table>
<!--END TABLE --> <br>
</div>
</div>
</form>
<?php showmessages2(getgroupid($_SESSION ['username'],$dbh)*-2,$dbh);?>
<?php }else{?>
<center>
  <b>شما قادر به استفاده از این صفحه نیستید</b>
    <br/>
  <a href="index.php?return=eteraz.php">login</a>
</center>
<?php }?>
<?php $dbh=null;?>
<?php include($MyRoot.'footer.php'); ?>