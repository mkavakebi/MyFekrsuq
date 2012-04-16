<?php
include_once 'config.php';
include_once $MyClasses.'group.php';
?>
<?php
if (isset ( $_POST ['Submit'] )) {
	$MyGr=new group($dbh,$_POST ['username'],$_POST ['password']);
	if ($MyGr->LoginState==true)
	{ 
		header("Location:".($_REQUEST['return']=='' ? "index.php":$_REQUEST['return']));	
	}else{
		$Error='گروهی با چنین اطلاعاتی موجود نمی باشد';
	}
}
$dbh = null;
?>
<?php include_once 'mhd.php';?>
<?php if ($_GET ['mode'] == 'inc'){?>
<!--to login in first page!-->
<?php border_start();?>
<Form Method="POST" action="index.php">
  <img src="gif/Keys.gif"/>WILL DESIGN WITH THEME<br/>
  <font color="red">
    <?php if ($Error){print $Error;}else{if (isset ( $_POST ['Submit'] )) { print'Rewrite URL!'; }}?>
  </font><br/>
  <p>
    <span style="margin-left:30px">نام کاربری:</span><input name="username" type="text" maxlength="40"/><br/>
    <span style="margin-left:31px">کلمه عبور:</span><input name="password" type="password" maxlength="40" /><br/>
  </p>
        <input type="submit" name="Submit"	value="ورود" align="bottom" height="100%" />
  <br/>
  <?php magic_start('<a href="register.php">ثبت نام گروه جديد!</a>');?>
  گروه های داوطلب شرکت در هشتمین فکرسوق ریاضی می توانند آزادانه فرم ثبت نام اولیه را پر کنند.<br/>
  داوطلبان شرکت در مسابقه بایستی از قوانین مسابقه آگاه باشند؛ یکی از شرایط حضور تیم ها، تحصیل در مدارس استعداد های درخشان است.
  <?php magic_end();?>
  <br/>
  <?php magic_start('<a href="forgotpass.php">کلمه عبور را فراموش کرده اید؟</a>');?>
  برای بازیابی رمز عبور گروه خود، اینجا را کلیک کنید.
  <?php magic_end();?>
</Form>
<?php border_end();?>
<!--he he :D-->
<?php }else{?>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<?php border_start();?>
<Form Method="POST" action="index.php">
  <img src="gif/Keys.gif"/> ورود گروه های فکرسوق ریاضی<br/>
  <font color="red">
    <?php if ($Error){print $Error;}else{if (isset ( $_POST ['Submit'] )) { print'Rewrite URL!'; }}?>
  </font><br/>
  <p>
    <span style="margin-left:30px">نام کاربری:</span><input name="username" type="text" maxlength="40"/><br/>
    <span style="margin-left:31px">کلمه عبور:</span><input name="password" type="password" maxlength="40" /><br/>
    <input type="hidden" name="return" value="<?php echo $_REQUEST['return'];?>">
  </p>
        <input type="submit" name="Submit"	value="ورود" align="bottom" height="100%" />
  <br/>
  <?php magic_start('<a href="register.php">ثبت نام گروه جديد!</a>');?>
  گروه های داوطلب شرکت در هشتمین فکرسوق ریاضی می توانند آزادانه فرم ثبت نام اولیه را پر کنند.<br/>
  داوطلبان شرکت در مسابقه بایستی از قوانین مسابقه آگاه باشند؛ یکی از شرایط حضور تیم ها، تحصیل در مدارس استعداد های درخشان است.
  <?php magic_end();?>
  <br/>
  <?php magic_start('<a href="forgotpass.php">کلمه عبور را فراموش کرده اید؟</a>');?>
  برای بازیابی رمز عبور گروه خود، اینجا را کلیک کنید.
  <?php magic_end();?>
</Form>
<?php border_end();?>
<?php }?>