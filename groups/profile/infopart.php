<table>
	<tr>
		<td>
			<?php if  ($_GET['action']!='editall') {?>
				<?php magic_start('<A href="index.php?action=editall" ><img src="gif/edit.gif"/></A>');?>
				برای اصلاح مشخصات گروه خود کلیک کنید 
				<?php magic_end();?> <br />
			<?php }?>
			
			<?php if  ($_GET['action']!='editpass') {?>
				<?php magic_start('<A href="index.php?action=editpass" ><img src="gif/Settings32.gif"/></A>');?>
				برای تغییر کلمه عبور کلیک کنید 
				<?php magic_end();?>
			<?php }?>
		</td>

		<td width="490px">
		<?php 	if($_GET['action']=='editall'){ ?>
			<form method="post" action="index.php" style="line-height: 30px;">
				<table>
					<tr style="height: 30px;">
						<td style="width: 100px;">نام گروه:</td>
						<td style="width: 100px;"><input name="groupname" value="<?php echo $MyGr->Name(); ?>"/></td>
					</tr>
					<tr style="height: 30px;">
						<td style="width: 100px;">شهر :</td>
						<td style="width: 100px"><input name="groupcity" value="<?php echo $MyGr->City(); ?>"/></td>
					</tr>
					<tr style="height: 30px;">
						<td style="width: 100px;">نام دبیرستان :</td>
						<td style="width: 100px"><input name="schoolname" value="<?php echo $MyGr->School(); ?>"/></td>
					</tr>
				</table>
				
				دبیرستان 
				<input type="radio" name="schooltype" value="male"
				<?php if ($MyGr->IsMale())echo'checked="checked"'; ?> />پسرانه 
				<input type="radio" name="schooltype" value="female"
				<?php if ($MyGr->IsFemale())echo'checked="checked"'; ?> />دخترانه <br />
				
				<input type="submit" name="edited" value="تایید"/><A href="index.php">انصراف</A> <br>
			</form>
		<?php }else{?>
			<?php $MyGr->GetFullSchool();?><br/>
		<?php }?>
		
		<font color="red"> <?php if(isset($_GET['er'])){echo($_GET['er']);}?> </font>
		
		<?php 	if($_GET['action']=='editpass'){ ?>
			<form method="post" action="index.php">
			<table>
				<tr>
					<td>کلمه عبور قدیمی:</td>
					<td><input name="oldpass" type="password"/></td>
				</tr>
				<tr>
					<td>کلمه عبور جدید:</td>
					<td><input name="pass" type="password"/></td>
				</tr>
				<tr>
					<td>تکرار کلمه عبور جدید:</td>
					<td><input name="repass" type="password"/></td>
				</tr>
				<tr>
					<td><input type="submit" name="passedited" value="تایید"/></td>
					<td><A href="index.php">انصراف</A></td>
				</tr>
			</table>
			</form>
		<?php }?>
		</td>
	</tr>
</table>
