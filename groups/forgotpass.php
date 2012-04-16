<?php
die('nopage');
include 'config.php';
include 'functions.php';
?>
<?php
require_once('recaptchalib.php');
// Get a key from http://recaptcha.net/api/getkey
$publickey = "6LcUgAkAAAAAAGK54LH_86Bmgy-Jbz_ziFBYu_92";
$privatekey = "6LcUgAkAAAAAACjP6ZfKahU5CqHaai_Dmwzb898k";

# the response from reCAPTCHA
$resp = null;
# the error code from reCAPTCHA, if any
$error = null;

$keyisvalid='';

# was there a reCAPTCHA response?
if ($_POST["recaptcha_response_field"]) {
        $resp = recaptcha_check_answer ($privatekey,
                                        $_SERVER["REMOTE_ADDR"],
                                        $_POST["recaptcha_challenge_field"],
                                        $_POST["recaptcha_response_field"]);

        if ($resp->is_valid) {
                $keyisvalid='valid';
        } else {
                //$Error = $resp->error;
                $Error="کلمات داخل تصویر را درست وارد نکردید!";
        }
}
?>
<?php 
if (isset ($_POST ['signup'] ) AND $keyisvalid=='valid') {
	$stmt = $dbh->prepare("SELECT * FROM groups join members ON(groups.ID=members.groupid) WHERE (username=? OR email=?) AND fishid=? AND type='header'");
    $stmt->execute(array($_POST['username'],$_POST['masteremail'],$_POST['fishid']));
    if($sdb_field = $stmt->fetch())
    {
    	$pass=$sdb_field['pass']; 
    }else{
    	$Error='there is no such group!';
    }
    
}
$dbh=null;
include 'header.php';
if ($pass){
	echo 'your password is this "'.$pass.'"';
}else{
if($Error) echo $Error;
?>
<center>
<div style="width:500px">
  <?php border_start();?>
برای دریافت رمز عبور خود می بایست یکی از دو قسمت "نام کاربری" و "پست الکترونیکی سرگروه"را وارد کنید
  <br/>گروههایی کد فیش بانکی خود را وارد نکرده اند قادر به بازیابی رمز عبور خود نمیباشند.<br/>
  <Form Method="POST" action="forgotpass.php">
    <table dir="rtl"  cellSpacing="1" width="100%" border="0">
      <tr>
        <td style="HEIGHT:21px" >نام کاربری:</td>
        <td>
          <input name="username" type="text" 
        value="<?php echo $_POST['username'];?>" id="txtTitle"
              class="TextBox" style="width: 150px;" />
            </td>
      </tr>
      <tr>
        <td style="HEIGHT:21px" >پست الکترونیکی سر گروه:</td>
        <td>
          <input name="msteremail" type="text"
        value="<?php echo $_POST ['masteremail'];?>" id="txtTitle"
        class="TextBox" style="width: 150px;" />
        </td>
      </tr>
      <tr>
        <td style="HEIGHT:21px" >کد فیش بانکی:</td>
        <td>
          <input name="fishid" type="text"
        value="<?php echo $_POST ['fishid'];?>" id="txtTitle"
        class="TextBox" style="width: 150px;" />
        </td>
      </tr>
    </table>
    <!--  ////////////////-->
    <br/>
    دو کلمه ای که در شکل زیر می خوانید را وارد کنید
    <div dir="ltr" width="100%">
      <?php echo recaptcha_get_html($publickey, $error); ?>
    </div>
    <input type="submit" name="signup"	value="تایید و ثبت">
    </Form>

  <?php border_end();?>
</div>
</center>
<?php } include 'footer.php';?>