<?php if($MyGr->HaveSoal()==false){?>
<table>
	<td>
		sathe khod ra entekhab konid
		<form>
		<?php for($i=0;$i<count(soal::$Levels);$i++){?> 
			<?php echo soal::$Levels[$i];?><input type="radio" name="level" value="<?php echo $i;?>"><br/>
			tozihate sathe <?php echo soal::$Levels[$i];?><br/> 
		<?php }?>
		<br/>
		قیمت پیش نهادی:<input type="text" name="money" >
		<input type="submit" name="buy" value="خرید سوال">
		</form>
	</td>
	<td></td>
</table>
<?php }else{?>
	<Center>
		<right><B>
			سطح:<?php echo $Levels[$MySoal->Level()];?><br/>
			دفعات پاسخ اشتباه:<?php echo $MySoal->WrongCount();?><br/>
			<a href="deletesoal.php">حذف سوال فعلی</a><br/>
		</B></right>	
		<center><h1>
			عنوان:<?php echo $MySoal->Title();?><br/>
		</h1></center>	 
		<br/><hr/>
		<Center>
			شرح:<br/>
			<?php echo $MySoal->Body();?>
		<br/><hr/><br/>
		<form method=post>
		    پاسخ:<input name="answer">
		    <input type=hidden name=num value=<?php echo $_REQUEST['num']; ?>>
		    <input type=submit name=answering value="ارسال">
		</form>
	</Center>
<?php }?>
