<?php 	if($MyGr->FishID()=='' or $_GET['action']=='edit'){ ?>
<form name="frmPost" method="post" action="index.php" id="frmPost">
	چنانچه وجه ثبت نام را پرداخت كرده ايد، شماره سریال آن را در کادر زیر وارد كنيد<br />
	<p><strong>هزینه ثبت نام چقدر است و نحوه پرداخت آن چگونه می باشد؟</strong></p>
	<p>گروه هایی که می خواهند ثبت نام خود را قطعی کنند، لازم است هزینه ثبت نام (۹۰۰۰۰ریال) را به شماره حساب های مسابقه واریز کنند و شماره پیگیری آن را در مشخصات گروه وارد کنند.</p>
	<p>شماره حساب بانک ملی شعبه مرکزی کاشان:  ۴۱۵۰۰۲۰۴۲۴۰۰۴ ، دبیرستان شهید بهشتی کاشان</p>
	<p>شماره کارت: ۶۰۳۷۹۹۱۰۹۹۵۶۶۹۲۳ عباس جامعی (مدیریت دبیرستان شهید بهشتی کاشان)</p>
	<p>* تا پایان زمان ثبت نام فرصت واریز وجه دارید<br/>* به هیچ وجه گروه ها هزینه ثبت نام را با سه پرداخت 30000ریالی انجام ندهند</p>
	<font color="red">توجه داشته باشید:<br/>
	چنانچه کارت به کارت وجه را واریز کنید، شناسه پیگیری یا رهگیری را بایستی وارد کنید.<br/>
	چنانچه از داخل شعب پرداخت کنید، شماره سند را بایستی وارد کنید؛ کافی است از مسئول پرداخت در شعب بپرسید تا شماره مورد نظر را به شما نشان دهد  ;)</font>
	<input name="fishid" value="<?php echo $MyGr->FishID(); ?>" style="width: 200px;" />
	<input type="submit" name="submit" value="تایید" style="width: 60px;" />
	 <?php magic_start('<A href="index.php" >انصراف</A>');?>
	 پرداخت وجه تا آخرین روز ثبت نام ممکن است؛ چنانچه برای شرکت در مسابقه شک دارید،اندکی صبر کنید... 
	 <?php magic_end();?>
</form>
<?php }else{ ?>
	شماره رهگیری فیش پرداختی گروه شما:
	<br />
	<?php if($MyGr->State()=='unknown' AND $MyGr->FishID()!=''){ ?>شماره فیش شما بررسی می شود. اندکی صبر کنید ;)<?php }?>
	<?php if($MyGr->State()=='false' AND $MyGr->FishID()!=''){ ?>شماره فیش شما مورد تایید قرار نگرفت.<?php }?>
	<?php if($MyGr->State()=='enabled' AND $MyGr->FishID()!=''){ ?>شماره فیش شما مورد تایید می باشد.<?php }?>
	<br />
	<p style="text-align: left;"><?php echo $MyGr->FishID(); ?></p>
	
	<?php if  ($_GET['action']=='' and $MyGr->State()!='enabled' and  $MyGr->State()!='ghabul') {?>
	<?php  magic_start('<A href="index.php?action=edit" >اصلاح شماره رهگیری</A>');?>
	برای اصلاح شماره رهگیری خود کلیک کنید
	<?php magic_end();?>
	<?php }?>
<?php }?>