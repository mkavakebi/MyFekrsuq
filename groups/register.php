<?php
include_once 'config.php';
include_once $MyClasses.'membergroup.php';
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
        }
}
?>
<?php 
if (isset ( $_POST ['signup'] )) {
	if($_POST ['repassword']==$_POST ['password'])
	{
		$MyGr=new membergroup($dbh);
		$mymem=new member();
		
		$MyGr->InsertAll($_POST ['username'], $_POST ['password'],$_POST ['groupname'],$_POST ['city'],$_POST ['schoolname'],$_POST ['schooltype']);
		
		$Error=$MyGr->CheckAll();
		if(!$Error)
			$Error=$MyGr->CheckReputation();
		if(!$Error)		
			$Error=$mymem->Initfields($_POST ['mem_name'],$_POST ['mem_family'],$_POST ['mem_email'],$_POST ['paye']);				
		if(!$Error)
		{
			if( $keyisvalid=='valid'){
				$MyGr->SaveAsNew();
				$MyGr->AddMember($mymem,'header');
				$MyGr->LoginMe();
				header ( "Location:index.php" );
			}else{
				$Error="کلمات داخل تصویر را درست وارد نکردید!";
			}
		}
	}else{
		$Error='رمز عبور شما با تکرارش برابر نیست.';
	}
}

$dbh=null;
?>
<?php include('header.php');?>
        <table>
          <tr>
            <td>
              <div class="textblock">
                 <?php border_start();?>
<?php readfile('http://fekrsuq.sampadia.com/?p=345&mode=inc');?>
                  <?php border_end();?>
              </div>
            </td>
            <td>
              <div class="textblock">
<Form Method="POST" action="register.php">
  <?php border_start();?>
  <img src="gif/register.gif"/> فرم ثبت نام گروه های فکرسوق ریاضی<br/>
  <?php magic_start('<b>مشخصات کاربری گروه</b>');?>این مشخصات برای دسترسی به صفحه گروه ها ست و تمامی اعضای گروه می توانند از آن استفاده کنند.
  <br/>از اطلاعات گروه خود به خوبی محافظت کنید؛ کمیته برگزاری هیچگونه مسئولیتی در قبال سهل انگاری گروه ها ندارد.<?php magic_end();?>
      <?php if ($Error){echo "<font color='red'>".$Error."</font><br/>";}?>
  <table border="0" dir="rtl"  cellSpacing="1" width="100%">
  	<tr>
      <td>
        <span class="mymagic">نام کاربری گروه<span>نام کاربری برای ورود به صفحه مشخصات گروه استفاده می شود<br/>
      پیشنهاد می شود برای سهولت، از کلمات انگلیسی استفاده کنید.</span>
      </span>
      </td>
      <td><input type="text" name="username" value="<?php echo $_POST['username'];?>"></td>
    </tr>
    <tr>
      <td>
        <span class="mymagic">کلمه عبور گروه<span>کلمه عبور برای ورود به صفحه ی مخصوص گروه ها استفاده می شود.<br/>
     کلمه عبور گروه خود را حتما به خاطر بسپارید یا جایی یادداشت کنید؛ این کلمه در مرحله بعدی نیز مورد استفاده قرار می گیرد.<br/>
     بهتر است در ساختار کلمه عبور خود کاراکتر هایی مثل @ $ یا ... نیز استفاده کنید.</span>
      </span>
      </td>
      <td><input type="password" name="password"></td>
    </tr>
    <tr>
      <td>
        <span class="mymagic">
          <small>تکرار</small> کلمه عبور<span>برای اینکه مطمئن باشیم شما کلمه عبور دلخواه خود را صحیح وارد کرده اید، کلمه عبور خود را مجددا در این قسمت وارد کنید.</span>
        </span>
      </td>
      <td><input type="password" name="repassword"></td>
    </tr></table>
  <?php border_end();?>
  <br/>
  <?php border_start();?>
  <?php magic_start('<b>مشخصات عمومی گروه</b>');?>گروه شما در مسابقه با "نام گروه"ی که در این قسمت انتخاب می کنید شناخته می شود.<?php magic_end();?>
  <table border="0" dir="rtl"  cellSpacing="1" width="100%">
    <tr>
      <td>
        <span class="mymagic">نام گروه<span>نام یا همان عنوان گروه یکی از مشخصاتی است که گروه ها با آن شناخته و به دیگران معرفی می شوند.<br/>
      نام گروه بایستی با حروف فارسی نوشته شود و حداکثر طول ممکن آن 30 حرف است.</span>
      </span>
      </td>
      <td><input type="text" name="groupname" value="<?php echo $_POST ['groupname'];?>"></td>
    </tr>
    <tr>
      <td>
        <span class="mymagic">شهر<span>این مشخصه بایستی با نام شهر شما پر گردد.<br/>
      در نوشتن شهر، از گذاردن فاصله در ابتدا ویا انتها خودداری کنید.<br/>
      نام شهر را به فارسی بنویسید.</span>
      </span>
      </td>
      <td><input type="text" name="city" value="<?php echo $_POST ['city'];?>"></td>
    </tr>
    <tr>
      <td>
        <span class="mymagic">نام مدرسه<span>نام مدرسه خود را بدون کلمه "دبیرستان" بنویسید.<br/>
      مثلا:<br/>
      شهید بهشتی یا علامه حلی یا ...</span>
      </span>
      </td>
      <td><input type="text" name="schoolname" value="<?php echo $_POST ['schoolname'];?>"></td>
    </tr>
    <tr>
      <td>
        <span class="mymagic">مدرسه‌ی<span>جنسیت گروه در مراحل ثبت نام و پذیرش و همچنین آمار و اطلاعات مربوط به تصحیح اوراق استفاده می گردد.</span>
      </span>
      </td>
     	<td>
        <input type="radio" name="schooltype" value="male" checked="check" />پسرانه
     	  <input type="radio" name="schooltype" value="female" />دخترانه</td>
    </tr>
</table>  
  <?php border_end();?>
  <br/>
  <?php border_start();?>
  <?php magic_start('<b>مشخصات سرگروه</b>');?>هر گروه برای رسیدگی به کارهای گروه نماینده و سرگروهی دارد. در این قسمت مشخصات سرگروه ثبت می شود.<?php magic_end();?>
<table border="0" dir="rtl"  cellSpacing="1" width="100%" >
	<tr>
    <td style="HEIGHT:21px" >نام:</td>
    <td><input name="mem_name" type="text" 
      value="<?php echo $_POST ['mem_name'];?>" id="txtTitle"
			class="TextBox" style="width: 150px;" />
		</td>
	</tr>
	<tr>
    <td style="HEIGHT:21px" >نام خانوادگی:</td>
    <td><input name="mem_family" type="text"
			value="<?php echo $_POST ['mem_family'];?>" id="txtTitle"
			class="TextBox" style="width: 150px;" />
		</td>
	</tr>
	<tr>
    <td style="HEIGHT:21px">پایه تحصیلی:</td>
    	<td>
        <table width="150px"><tr>
          <td width="50px"><input type="radio" name="paye" value="1" <?php if ($db_field['paye']=="1" || $db_field['paye']=='' || $_POST['paye']=="1") echo('checked="check"'); ?> /> اول</td>
	     	  <td width="50px"><input type="radio" name="paye" value="2" <?php if ($db_field['paye']=="2" || $_POST['paye']=="2") echo('checked="check"'); ?> /> دوم</td>
	     	  <td width="50px"><input type="radio" name="paye" value="3" <?php if ($db_field['paye']=="3" || $_POST['paye']=="3") echo('checked="check"'); ?> /> سوم</td>
		    </tr></table>
      </td>
	</tr>
<tr>
  <td style="HEIGHT:21px">پست الکترونیکی:</td>
  <td><input name="mem_email" type="text"
			value="<?php echo $_POST ['mem_email'];?>" id="txtTitle"
			class="TextBox" style="width: 150px;" />
		  </td>
	</tr>
</table>
<?php border_end();?>
  <br/>
  دو کلمه ای که در شکل زیر می خوانید را وارد کنید
  <div dir="ltr" width="100%">
    <?php echo recaptcha_get_html($publickey, $error); ?>
  </div>
 	<input type="submit" name="signup"	value="تایید و ثبت">

</Form>                
                
              </div>
            </td>
            <td>
              <div class="textblock">
                 <?php border_start();?>
					<?php readfile('http://fekrsuq.sampadia.com/?p=371&mode=inc');?>
                  <?php border_end();?>
              </div>
            </td>

          </tr>
        </table>

    <?php include('footer.php');?>