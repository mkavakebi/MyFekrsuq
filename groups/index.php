<?php
include_once 'config.php';
ob_start();
if ($_SESSION ['username'] != '')header("location:profile");
?>
<?php include('header.php');?>
	<table>
		<tr>
		<td class="maineffect">
			<div>
			<?php border_start();?>
			<?php readfile($SiteURL.'/?p=345&mode=inc');?>
			<?php border_end();?>
			</div>
		</td>
		<td class="contentmain">
			<?php include 'login.php';?>
		</td>
		</tr>
	</table>
<?php ob_flush();?>
<?php include('footer.php')?>
