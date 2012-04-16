<?php
include_once '../config.php';
include_once $MyClasses.'membergroup.php';
ob_start();
?>
<?php include($MyRoot.'header.php');?>
<?php if ($_SESSION ['username'] != ''){?>
<?php //////////////////////////////////////////content/////////////////////////////?>
	<?php
	/////////////make a class for the Current Group
	$MyGr=new membergroup($dbh,$_SESSION ['username']);

	//////////////do edit member to one's group
	if (isset ( $_POST ['edited'] ))
	{
		$mymem=$MyGr->Member($_REQUEST ['memrow']);
		if (!$mymem){
			$error2='همچین عضوی دیگر وجود ندارد دوباره تلاش کنید.';
		}elseif (!$mymem->CheckName($_POST ['mem_name'])){
			$error='نام عضو خود را تصحیح کنید.';
		}elseif (!$mymem->CheckFamily($_POST ['mem_family'])){
			$error='نام خانوادگی عضو خود را تصحیح کنید.';
		}elseif (!$mymem->CheckEmail($_POST ['mem_email'])){
			$error='پست الکترونیکی عضو خود را تصحیح کنید.';
		}elseif (!$mymem->CheckPaye($_POST ['paye'])){
			$error='پایه عضو خود را تصحیح کنید.';
		}else{
			$mymem->SetName($_POST ['mem_name']);
			$mymem->SetFamily($_POST ['mem_family']);
			$mymem->SetEmail($_POST ['mem_email']);
			$mymem->SetPaye($_POST ['paye']);
			$mymem->dbh=$dbh;
			$mymem->SaveEdited();
		}
		if($error)$editing=true;
	}

	//////////////do add member to one's group
	if (isset ( $_POST ['newadded'] ))
	{
		$mymem=new member();
		if (!$mymem->CheckName($_POST ['mem_name'])){
			$error='نام عضو خود را تصحیح کنید.';
		}elseif (!$mymem->CheckFamily($_POST ['mem_family'])){
			$error='نام خانوادگی عضو خود را تصحیح کنید.';
		}elseif (!$mymem->CheckEmail($_POST ['mem_email'])){
			$error='پست الکترونیکی عضو خود را تصحیح کنید.';
		}elseif (!$mymem->CheckPaye($_POST ['paye'])){
			$error='پایه عضو خود را تصحیح کنید.';
		}else{
			$mymem->SetName($_POST ['mem_name']);
			$mymem->SetFamily($_POST ['mem_family']);
			$mymem->SetEmail($_POST ['mem_email']);
			$mymem->SetPaye($_POST ['paye']);
			if($MyGr->AddMember($mymem)==false)
				$error2='تعداد عضو های گروه شما بیش از این نمیتواند افزایش یابد.';	
		}
	}
	/////////////////////delete chosen member
	if (isset ( $_GET ['memrow'] ) AND $_GET['action']=='delete'){
		$mymem=$MyGr->Member($_REQUEST ['memrow']);
		if (!$mymem){
			$error2='همچین عضوی دیگر وجود ندارد دوباره تلاش کنید.';
		}else{
			if(!$mymem->Delete()){
				 $error2='شما اجازه ی حذف سر گروه را ندارید!';
			}
		}
	}	
	/////////////////////show member chosen to edit	
	if (isset ( $_GET ['memrow'] ) AND $_GET['action']=='edit'){
		$mem2edit=$MyGr->Member($_REQUEST['memrow']);
		if($mem2edit)$editing=true;
	}
	$allmems=$MyGr->Members();
	if ($error OR $editing) $showtime=true; else $showtime=false;
	?>
<table>
<tr>
	<td><div class="textblock">
    	<?php echo (($error OR $error2)?"<font color='red'>".$error.$error2."</font><br/><br/>":'');?>
		<?php border_start();?>
			<?php include 'allmemlist.php';?>
		<?php border_end();?>
	</div></td>
	
	<td><div class="textblock">
		<?php border_start();?>
			<?php include 'allmemeditbox.php';?>
		<?php border_end();?>
	</div></td>
	
	<td><div class="textblock">
		<?php border_start();?>
			<b>قوانین</b> هشتمین دوره همایش خلاقانه فکرسوق ریاضی:<br/><br/>
		<?php border_end();?>
	</div></td>
</tr>
</table>
<?php //////////////////////////////////////////content/////////////////////////////?>
<?php } else {?>
	<?php border_start();?>
		<center>
		<b>شما قادر به استفاده از این صفحه نیستید</b><br/>
		<a href="../index.php?return=profile/allmembers.php">Login</a> 
		</center>
	<?php border_end();?>
<?php }?>
<?php 
$dbh=null;
ob_flush();
include($MyRoot.'footer.php');?>