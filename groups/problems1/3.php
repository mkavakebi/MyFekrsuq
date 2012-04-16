<?php border_start();?>
صورت این سوال در جزوه سوالات وجود دارد(سوال 9 جزوه)!<br>
نیم سطر و نیم ستون:<br>
هر نیم سطر(یا نیم ستون) شامل 9 خانه است. نظر به اینکه درک تعریف آن کمی مشکل است تمام نیم سطر های جدول را در ذیل می آوریم:<br>

نیم سطر اول: خانه های جدول با اندیس های 1و2و3و28و29و30و55و56و57<br>
نیم سطر دوم: 10و11و12و37و38و39و64و65و66<br>
.<br>
.<br>
.<br>
25و26و27و52و53و54و79و80و81<br>
نیم ستون ها هم به طریق مشابه تعریف می شوند<br>
<div dir=ltr style="text-align:center;">
<center>
<?php include 'problems/sudokudescribe.php';?>
</center>
</div>
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
    
	if(isset($_POST['submitsudoku'])){
		for($i=0;$i<9*9;$i++)
			$ff[$i]=$_POST[$i];
		$stmt = $dbh->prepare("UPDATE problems SET sudoku=?  WHERE groupid=?");
    	$stmt->execute(array(implode('^',$ff),$groupid));
	}
	
	$default='*^*^*^*^*^*^*^*^7'.'^'
			.'*^*^*^*^7^*^*^*^*'.'^'
			.'*^*^6^*^*^*^*^*^*'.'^'
			.'*^*^4^*^3^*^*^*^*'.'^'
			.'*^*^*^1^5^*^*^*^8'.'^'
			.'*^*^*^*^*^2^*^7^*'.'^'
			.'*^*^*^*^*^1^4^*^*'.'^'
			.'*^*^*^*^*^4^*^*^*'.'^'
			.'1^*^*^*^*^*^*^*^*';
	
	$default=explode('^',$default);
	
    $stmt2 = $dbh->prepare("SELECT sudoku FROM problems WHERE groupid=?");
    $stmt2->execute(array($groupid));
	$db_fakes = $stmt2->fetch();
	if ($db_fakes['sudoku'])
	$fakes=explode('^',$db_fakes['sudoku']);
    ?>
<?php border_start();?>
<div dir=ltr style="text-align:center;">
<center>
<?php if(isset($_REQUEST['submitsudoku'])){?>
جوابی که ارسال کردید در بانک ذخیره شد;)<br><br>
<?php }?>
<?php if ($db_fakes['sudoku']!=''){?>
اطلاعاتی که به شما در داخل جدول نمایش داده می شود دقیقا همان اطلاعاتی است که در بانک ما ذخیره شده است.<br>
پس از زدن دکمه ی ارسال اطلاعات جدید ذخیره می گردد.<br>
صحت این اطلاعات پس از پایان مهلت مسابقه بررسی می شود.<br> 
<?php }?>
<Form Method="POST" action="problempage.php">
<table border="5">
  <?php for($k=0;$k<3;$k++){  ?>
  <tr>
  	<?php  for($m=0;$m<3;$m++){  ?>
	  	<td>		
		  <table>
		  <?php for($i=0;$i<3;$i++){  ?>
		  <tr>
		  	<?php  for($j=0;$j<3;$j++){ 
		  		$ind=27*$k+3*$m+9*$i+$j; ?>
			  	<td id='td<?php echo $ind;?>'>
			 	<input class='inp<?php echo ($ind+1);?>' <?php if ($default[$ind]!='*')
			     echo 'disabled="disabled"';
			    ?> style="width:20px"  align="center" name="<?php echo $ind;
			    ?>" value="<?php 
			     		if ($default[$ind]=='*'){ 
			     		 echo $fakes[$ind];
			     		}else{ 
			    		 echo $default[$ind];
			    		}?>" type="text" maxlength="1" />
				</td>
		    <?php }?>
		  </tr> 
		  <?php }?>
		  </table>
		  </td>
    <?php }?>
  </tr> 
  <?php }?>
  </table>
  		<input type=hidden name="page" value=<?php echo $current;?>>
        <input type="submit" name="submitsudoku" value="ارسال" align="bottom" height="100%" />
</Form>
</center>
</div>
<?php border_end(); ?>