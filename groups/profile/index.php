<?php
include_once  '../config.php';
include_once  $MyClasses.'group.php';

if ($_GET ['menu'] == 'signout') {
	session_start ();
	$_SESSION ['login'] = '';
	$_SESSION ['username'] = '';
	session_destroy ();
}
if ($_SESSION ['username'] == '') echo header ( "Location:../index.php" );

?>
<?php include($MyRoot.'header.php');?>
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
<?php
/////////////make a class for the Current Group
$MyGr=new group($dbh,$_SESSION ['username']);

////////////make Fish ID_edit Operations
if (isset($_POST ['submit'])) {
	if ($MyGr->CheckFishID($_POST ['fishid'])==false)
		echo '<font color="red">شماره سریال فیش خود را تصحیح کنید.</font><br/><br/>';
	else
		$MyGr->SetFishID($_POST ['fishid']);
}
//////////make pass_edit Operations
if (isset($_POST ['passedited'])) {
	if($MyGr->PassWord()==$_POST ['oldpass']){
		if ($_POST ['pass']==$_POST ['repass']){
			if($MyGr->CheckPassWord($_POST ['pass']))
				$MyGr->SetPassWord($_POST ['pass']);
			else
				$er='کلمه عبور جدید شما قابل قبول نیست!';
		}else{
			$er='کلمه عبور جدید با تکرار آن برابر نیست!';
		}
	}else{
		$er='کلمه عبور فعلی را اشتباه وارد کرده اید!';
	}
	if($er!='')header ( "Location:index.php?action=editpass&er={$er}" );
}

/////////make groupinf_edit Operation 
if (isset($_POST ['edited'])) {
	if (!$MyGr->CheckName($_POST ['groupname'])){
		$er='این نام گروه قابل قبول نیست';
	}elseif (!$MyGr->CheckCity($_POST ['groupcity'])){
		$er='این نام شهر قابل قبول نیست';
	}elseif (!$MyGr->CheckSchool($_POST ['schoolname'])){
		$er='این نام مدرسه قابل قبول نیست';
	}elseif (!$MyGr->CheckGender($_POST ['schooltype'])){
		$er='این نوع مدرسه قابل قبول نیست';
	}else{
		$MyGr->SetName($_POST ['groupname']);
		$MyGr->SetCity($_POST ['groupcity']);
		$MyGr->SetSchool($_POST ['schoolname']);
		$MyGr->SetGender($_POST ['schooltype']);
	}
	if($er!='')echo '<font color="red">'.$er.'</font><br/><br/>';
}
?>
<?php border_start();?>
<?php if ($MyGr->State()!='false'){ ?>
<center>
<table width="100%" style="text-align:center;"><tr><td width="30%">
<center><a href="<?php echo $SiteURL;?>download/about 2nd step.pdf"><img src="http://mail.yimg.com/a/i/us/pim/mail/pdf.gif"/><br/><small>در مورد مرحله ی دوم</small></a></center></td>
<td width="40%">
<center><a href="<?php echo $SiteURL;?>download/Jozve3.pdf"><img src="http://mail.yimg.com/a/i/us/pim/mail/pdf.gif"/><br/>جزوه 3</a></center>
</td>
<td width="30%">
<center><a href="<?php echo $SiteURL;?>download/Jozve4.pdf"><img src="http://mail.yimg.com/a/i/us/pim/mail/pdf.gif"/><br/><small>جزوه 4</small></center></a></td></tr></table>
</center>
<?php }
if ($MyGr->State()=='ghabul'){ ?>
گروه شما برای شرکت در مرحله ی دوم فکر سوق انتخاب شده است.
<?php }elseif($MyGr->State()!='false'){?>
<br/>بازدید های هفتگی خود را به صورت سر زده از ما دریغ نکنید، مطالب خوبی برای‌تان تهیه می‌کنیم...
<?php }else{?>
گروه شما غیر فعال است. این جمله بدان معنی است که گروه شما حق شرکت در مسابقه را ندارد.
<?php } ?>

<!--<a href="eteraz.php">اعتراض به داور در مورد سوالات</a>-->
<?php border_end(); ?>
<br/>
		<?php border_start();?>
			<?php include 'messagepart.php';?>
		<?php border_end();?><br />
		
		<?php border_start();?>
			<?php include 'infopart.php';?>
		<?php border_end();?><br />
		
		<?php border_start();?>
			<?php include 'fishpart.php';?>
		<?php border_end();?><br/>
		<?php $dbh=null;?>

<?php readfile($SiteURL.'/download/index.php?mode=inc');?>
		</td>
		</tr>
	</table>
<?php include($MyRoot.'footer.php')?>