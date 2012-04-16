<?php
include_once '../config.php';
include_once '../functions.php';
include_once '../mhd.php';
?>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<?php if ($_SESSION ['usernamemaster'] == ''){?>
<center>
  <b>شما قادر به استفاده از این صفحه نیستید</b>
</center>
<?php return 0;}?>
<?php ///////////////////////////////////////?>
<?php
if (isset($_GET['groupid']))$_SESSION['groupid']=$_GET['groupid'];
if (isset($_POST ['submit'])) {
	if (FilterStrict($_POST ['fishid'],1)==1 or FilterStrict($_POST ['fishid'],1)==2)
	{
		echo '<font color="red">شماره سریال فیش خود را تصحیح کنید.</font><br/><br/>';
	}else{
		$fishid = $_POST ['fishid'];
		$stmt = $dbh->prepare("UPDATE groups SET  fishid=? WHERE ID=?");
		$stmt->execute(array($fishid, $_SESSION['groupid']));
	}
}

if (isset($_POST ['edited'])) {
	if (FilterStrict($_POST ['groupname'],1)==1 or FilterStrict($_POST ['groupname'],1)==2){
		$er='این نام گروه قابل قبول نیست';
	}elseif (FilterStrictNew($_POST ['groupcity'],1,30,'FN ')==1 or FilterStrictNew($_POST ['groupcity'],1,30,'FN ')==2){
		$er='این نام شهر قابل قبول نیست'.'  '.FilterStrictNew($group_city,1,30,'FN ');
	}elseif (FilterStrictNew($_POST ['schoolname'],1,30,'FN ')==1 or FilterStrictNew($_POST ['schoolname'],1,30,'FN ')==2){
		$er='این نام مدرسه قابل قبول نیست';
	}elseif (FilterStrict($_POST ['schooltype'],1)==1 or FilterStrict($_POST ['groupcity'],1)==2){
		$er='این نوع مدرسه قابل قبول نیست';
	}else{
		$stmt = $dbh->prepare("UPDATE groups SET  groupname=?,groupcity=?,schoolname=?,schooltype=? WHERE ID=?");
		$stmt->execute(array($_POST ['groupname'], $_POST ['groupcity'],$_POST ['schoolname'],$_POST ['schooltype'], $_SESSION['groupid']));
	}
	if($er!='')echo '<font color="red">'.$er.'</font><br/><br/>';
	
}

?>
<?php
$stmt = $dbh->prepare("SELECT * FROM groups WHERE ID=?");
$stmt->execute(array($_SESSION['groupid']));

$db_field =$stmt->fetch();
$fishid=$db_field['fishid'];

?>
<A href="masterpage.php" >back</A>
<?php border_start();?>
<td width="250px"><img src="gif/folder.gif" /> <?php echo ($db_field['groupname']); ?>

		<?php border_start();?>
<table>
	<tr>
		<td width="250px"><?php 	if($_GET['action']=='editall'){ ?>
		<form name="frmPost" method="post" action="mastereditpage.php" id="frmPost"
			style="line-height: 30px;">
		<table>
			<tr style="height: 30px;">
				<td style="width: 100px;">نام گروه:</td>
				<td style="width: 100px;"><input name="groupname" type="text"
					value="<?php echo ($db_field['groupname']); ?>" id="txtTitle"
					class="TextBox" style="width: 100px;" /></td>
			</tr>
			<tr style="height: 30px;">
				<td style="width: 100px;">شهر :</td>
				<td style="width: 100px"><input name="groupcity" type="text"
					value="<?php echo ($db_field['groupcity']); ?>" id="txtTitle"
					class="TextBox" style="width: 100px;" /></td>
			</tr>
			<tr style="height: 30px;">
				<td style="width: 100px;">نام دبیرستان :</td>
				<td style="width: 100px"><input name="schoolname" type="text"
					value="<?php echo ($db_field['schoolname']); ?>" id="txtTitle"
					class="TextBox" style="width: 100px;" /></td>
			</tr>
		</table>
		دبیرستان <input type="radio" name="schooltype" value="male"
		<?php if ($db_field['schooltype']=='male')echo'checked="checked"'; ?> />
		پسرانه <input type="radio" name="schooltype" value="female"
		<?php if ($db_field['schooltype']=='female')echo'checked="checked"'; ?> />
		دخترانه <br />
		<input type="submit" name="edited" value="تایید" class="oBtn"
			style="width: 50px;" /> <A href="mastereditpage.php">انصراف</A> <br>
		</form>
		<?php }else{?> گروه <?php echo ($db_field['groupname']); ?>، از
		دبیرستان <?php if ($db_field['schooltype']=='male') echo ('پسرانه'); else echo('دخترانه'); echo(''); ?>‌ی
		<?php echo ($db_field['groupcity']); ?> <small> (<?php echo ($db_field['schoolname']); ?>)
		</small><br />
		<br />
		<?php }?> <font color="red"> <?php if(isset($_GET['er'])){echo($_GET['er']);}?>
		</font> <?php 	if($_GET['action']=='editpass'){ ?>
		<form name="frmPost" method="post" action="mastereditpage.php" id="frmPost">
		<table>
			<tr>
				<td>کلمه عبور قدیمی:</td>
				<td><input name="oldpass" type="password" id="txtTitle"
					class="TextBox" style="width: 100px;" /></td>
			</tr>
			<tr>
				<td>کلمه عبور جدید:</td>
				<td><input name="pass" type="password" id="txtTitle" class="TextBox"
					style="width: 100px;" /></td>
			</tr>
			<tr>
				<td>تکرار کلمه عبور جدید:</td>
				<td><input name="repass" type="password" id="txtTitle"
					class="TextBox" style="width: 100px;" /></td>
			</tr>
			<tr>
				<td><input type="submit" name="passedited" value="تایید"
					class="oBtn" style="width: 50px;" /></td>
				<td><A href="mastereditpage.php">انصراف</A></td>
			</tr>
		</table>
		</form>
		<?php }?></td>
		<td><?php if  ($_GET['action']!='editall') {
			magic_start('<A href="mastereditpage.php?action=editall" ><img src="gif/edit.gif"/></A>');?>برای
		اصلاح مشخصات گروه خود کلیک کنید <?php magic_end();?> <br />
		<?php }
		if  ($_GET['action']!='editpass') {
			magic_start('<A href="mastereditpage.php?action=editpass" ><img src="gif/Settings32.gif"/></A>');?>برای
		تغییر کلمه عبور کلیک کنید <?php magic_end();
		}?></td>
	</tr>
</table>

		<?php border_end();?>
<br />
		<?php border_start();?>
		<?php 	if($fishid=='' or $_GET['action']=='edit'){ ?>

<form name="frmPost" method="post" action="mastereditpage.php" id="frmPost">

<input name="fishid" type="text"
	value="<?php echo ($db_field['fishid']); ?>" id="txtTitle"
	class="TextBox" style="width: 200px;" /> <input type="submit"
	name="submit" value="تایید" style="width: 60px;" /> <?php magic_start('<A href="mastereditpage.php" >انصراف</A>');?>پرداخت
وجه تا آخرین روز ثبت نام ممکن است؛ چنانچه برای شرکت در مسابقه شک دارید،
اندکی صبر کنید... <?php magic_end();?></form>
		<?php border_end();?>
		<?php }else{ ?>
شماره رهگیری فیش پرداختی گروه شما:
<br />
<p style="text-align: left;"><?php echo ($db_field['fishid']); ?></p>
		<?php if  ($_GET['action']=='') {?>
		<?php magic_start('<A href="mastereditpage.php?action=edit" >اصلاح شماره رهگیری</A>')?>
برای اصلاح شماره رهگیری خود کلیک کنید
		<?php magic_end();?>
		<?php }?>
		<?php border_end();?>


		<?php }?>
		<?php $dbh=null;?>