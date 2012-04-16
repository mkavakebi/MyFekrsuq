<?php
include_once '../config.php';
include $MyClasses.'message.php';
?>
<?php include($MyRoot.'master/header.php'); ?>
<?php if ($_SESSION ['usernamemaster'] != ''){?>
	<?php
	$MyMes=new message($dbh);
	if ( $_GET ['action'] =='delete') $MyMes->Delete($_GET['messageid']);
	
	if(isset($_REQUEST['return']))
		$retu=$_REQUEST['return'];
	else
		$retu='masterpage.php';
	
	if (isset ( $_POST ['send'] )) {
		if($_POST ['txtto']=='all')
			$MyMes->SendMaster2AllGroups ($_POST ['txtTitle'], $_POST ['txtContent']);
		else
			$MyMes->SendMaster2Group($_POST ['txtTitle'], $_POST ['txtContent'],$_POST ['txtto']);
	}
	?>
	<A href="<?php echo $retu;?>" >back</A>
	<form method="post" action="?">
	<input type=hidden name=txtto value=<?php echo $_REQUEST['txtto'];?>>
	<div align="center" style="WIDTH: 598px">
	<table dir='rtl' width="97%" border="0">
		<tr>
			<td height="21">
			<div align="right">
				
			</div>
			</td>
		</tr>
		
		<tr>
			<td height="21">
			<div align="right">Title: 
				<input name="txtTitle" style="width: 480px;" />
			</div>
			</td>
		</tr>
		
		<tr>
			<td>
			<div align="center">
				<textarea name="txtContent" style="WIDTH: 580px; HEIGHT: 241px" rows="15" cols="67"></textarea>
			</div>
			</td>
		</tr>
	
		<tr>
			<td align="left" width="100%" height="20">
			<div align="right">
				<input type="submit" name="send" value="send"/> 
			</div>
			</td>
		</tr>
	</table>
	</div>
	</form>
	<br>
	<?php ShowMasterMessages($_GET ['groupname'],getgroupidfromfield($_GET ['groupname'].$_POST['txtto'],"groupname",$dbh),$dbh);?>
<?php }else{?>
	<center>
	  <b>شما قادر به استفاده از این صفحه نیستید</b>
	</center>
<?php }?>
<?php $dbh=null;?>
<?php include($MyRoot.'master/footer.php'); ?>