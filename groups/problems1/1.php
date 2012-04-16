<?php border_start();?>در متن زیر هر حرف الفبا با یک حرف دیگر جایگزین شده است. شما باید بفهمید که هر حرف با چه چیز جایگزین شده است. برای گرفتن امتیاز این سوال کافیست پنج کلمه ای که در قسمت تحتانی سوال دیده می شود با همین کلید، رمز کنید و کلید ارسال را فشار دهید.
<?php border_end(); ?><br/>
<?php border_start();?> و اما جملات كتيبه :<br/>
خدنلز، نلزو جه عتوج جنخو انجخن سدو جلا کس دلتجخص کنخسص خدون نخ ضنخسد رناخگوا. زلتو دعقلد خقحخق جس دحمن خوشخگ شنض وخج رناواگا ل خاعخ جگدلاس کس ضلخیق جعواس خو ظو گدلاس خگا ل جس گزا دخ خداس خگا! دن خدون نخ خوگ هطگ هطص رنخگ خدا. رضصدش خدونخ؛ گشخوا جس طخظن هطگ گهگتواس و خوگ ال دتگلگ طخظن دجخنک طلوش نخ فنوشخگ کگوا، زگسخنو اسوا خگخگ نخ کس تز ز هخارو ل تسخقص هطگ گنخگاس خگا. ثل هطگ دگ ان لو دچجلق خضصخا، دن خوشخگ نخ ضنیصو فوش فخو گسخا صخ درن تخگ طلوش گتخص اسگا ل چضخ ضخنپ جاخنگا خز رزگا صوپ خدون... . جخنو؛ کصوجس خو کس خز صداگ سضص سزخن هگس و چجق جن تخو دخگاس جلاگاو ل که گصلخگهصو نخز خگ جرشخوا نخ جس خگخگ سدو اخا صخ درن نخز گسضصس ان جظگ خگ خضشخ کگگا. هخعخصو جربشصو ل ثلگ خدون خگخگ نخ ان رنس رشخوو خز نخز کصوجس عختز اوا، اهصلن جاخا صخ خگخگ نخ خز اد صوپ جربنخگگا ل سن ثس دگ تسا جگدلاد صخ درن خز هاص ل شاص دتخزخص خوشخگ جکخسد ان لو خغن گکنا ل خگ ال دتگلگ نخ تخگ هصخگوا صخ درن عجنصو شلا جنخو هخونوگ...<br>
<p align="left"> 
کخصجس و دطیلیس و انجخن<br>
هگس فگت سزخن ل هویا ل شیص ل سضص چجق خز دوقخا
</p>
<?php border_end(); ?><br/>
<?php 
	$groupid=getgroupid($_SESSION ['username'],$dbh);
	$stmt = $dbh->prepare("SELECT ID FROM problems WHERE groupid=?");
    $stmt->execute(array($groupid));
    if($db_field = $stmt->fetch()){}
    else{
    	echo $groupid;
    	$stmt = $dbh->prepare("INSERT INTO problems (groupid)VALUES(?)");
    	$stmt->execute(array($groupid));
    }
    
	if(isset($_POST['submitcode'])){
		$stmt = $dbh->prepare("UPDATE problems SET code=?  WHERE groupid=?");
    	$stmt->execute(array(implode('^',$_POST),$groupid));
	}
	
	$words=explode('-','فکرسوق-مشنگ-قشنگ-کاشان-سمپاد-پیشرفت');
	
    $stmt2 = $dbh->prepare("SELECT code FROM problems WHERE groupid=?");
    $stmt2->execute(array($groupid));
	$db_fakes = $stmt2->fetch();
	$fakes=explode('^',$db_fakes['code']);
    ?>
<Form Method="POST" action="problempage.php">
  <br/><?php border_start(); ?>
  <center>
<?php if(isset($_REQUEST['submitcode'])){?>
جوابی که ارسال کردید در بانک ذخیره شد;)<br><br>
<?php }?>
<?php if ($db_fakes['code']!=''){?>
اطلاعاتی که به شما در داخل جدول نمایش داده می شود دقیقا همان اطلاعاتی است که در بانک ما ذخیره شده است.<br>
پس از زدن دکمه ی ارسال اطلاعات جدید ذخیره می گردد.<br>
صحت این اطلاعات پس از پایان مهلت مسابقه بررسی می شود.<br> 
<?php }?>
</center>
<table width="400px"><tr>
  <?php  for($i=0;$i<$CodeCount;$i++){  ?>
    <td dir=rtl style="text-align:right;width:50%;"><?php echo ($i+1).':'.$words[$i];?></td>
<td width="50%"><input name="<?php echo $i;?>" value="<?php echo $fakes[$i];?>" type="text" maxlength="40"/></td></tr><tr>
  <?php }?>
        <td> </td><td><input type="submit" name="submitcode" value="ارسال" align="bottom" height="100%" /></td></tr></table>
  <?php border_end(); ?>
</Form>