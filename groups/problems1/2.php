<?php border_start();?>
16 تا دختر داريم ، مي خواهيم در 16 روز آنها را به گردش ببريم ، هر روز هم 6 نفر را می توانیم ببريم، دسته ها چگونه باشد تا هر دو نفر دقیقا دوبار هم گروه شوند.</br>
می توانید(باید!!) برای نام گذاری دختر ها از حروف a تا p استفاده کنید.</br>
حروف را بدون فاصله در جای خود وارد کنید: به طور مثال abcgfd شش دختر یک روز برنامه ی شماست.
<?php border_end();?><br/>
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
    
	if(isset($_POST['submitordu'])){
		$stmt = $dbh->prepare("UPDATE problems SET ordu=?  WHERE groupid=?");
    	$stmt->execute(array(implode('^',$_POST),$groupid));
	}
	
	$words=explode('-','*-ali-azizi-pedarss-85ss-kok.;l-ghh');
	
    $stmt2 = $dbh->prepare("SELECT ordu FROM problems WHERE groupid=?");
    $stmt2->execute(array($groupid));
	$db_fakes = $stmt2->fetch();
	$fakes=explode('^',$db_fakes['ordu']);
    ?>
<?php border_start();?>
<center>
<?php if(isset($_REQUEST['submitordu'])){?>
جوابی که ارسال کردید در بانک ذخیره شد;)<br><br>
<?php }?>
<?php if ($db_fakes['ordu']!=''){?>
اطلاعاتی که به شما در داخل جدول نمایش داده می شود دقیقا همان اطلاعاتی است که در بانک ما ذخیره شده است.<br>
پس از زدن دکمه ی ارسال اطلاعات جدید ذخیره می گردد.<br>
صحت این اطلاعات پس از پایان مهلت مسابقه بررسی می شود.<br> 
<?php }?>
</center>
<Form Method="POST" action="problempage.php">
  <?php  for($i=0;$i<$OrduCount;$i++){  ?>
    <br/><span style="margin-left:30px">روز<?php echo $i+1 ?> :</span><input name="<?php echo $i;?>" value="<?php echo $fakes[$i];?>" type="text" maxlength="6"/><br/>
  <?php }?>
  		<input type=hidden name="page" value=<?php echo $current;?>>
        <input type="submit" name="submitordu" value="ارسال" align="bottom" height="100%" />
</Form>
<?php border_end();?>