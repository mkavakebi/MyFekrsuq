<table>
	<tr>
		<td style="text-align: left;">
			<?php magic_start('<A href="allmembers.php" ><img src="../gif/members.gif" title="صفحه اعضا"/></A>')?>
			برای تغییر در مشخصات اعضا به اینجا بروید.
			<?php magic_end();?><br />
			
			<?php magic_start('<A href="index.php?menu=signout" ><img src="../gif/Lock.gif" title="خروج"/></A>');?>
			برای خارج شدن از پروفایل خود، کلیک کنید.
			<?php magic_end();?>
		</td>
		
		<td width="490px">
			<img src="gif/folder.gif" />
			<font style="font-size:12px;color:green;"><?php echo $MyGr->Name(); ?>، سلام!</font><br/>
			<b>(شماره گروه شما : <?php echo $MyGr->ID()+100; ?> است.)</b><br/>
			<?php if ($MyGr->State()=='enabled' || $MyGr->State()=='ghabul' ){ ?>
				گروه شما تایید شده است.<br/>
				تا پایان برگزاری مرحله یک فرصت برای تکمیل یا تغییر مشخصات اعضا دارید.
			<?php }else{?>
				در مشخصات ثبت نام شما اشکالی بوده است.
				<?php if($MyGr->State()=='taligh'){?>
					چنانچه شما از طریق کارت به کارت وجه ثبت نام را پرداخت کرده اید، شماره کارت خود را به جای شماره رهگیری یا ارجاع ثبت کنید.<br/>
					مشخصات گروه ها بعد از اتمام مهلت پاسخگویی مجددا بررسی خواهد شد. نگران نباشید.
				<?php }?>
			<?php }?>
			<br/>
			<?php
			$stmt = $dbh->prepare("SELECT * FROM messages WHERE readerid=?");
			$stmt->execute(array($MyGr->ID()));
			while ( $db_mes = $stmt->fetch()) {?>
				<p>
					<img src="gif/pm.gif"/> <?php echo $db_mes ['mes_subject'];?><br/><?php echo $db_mes ['mes_value']?><br/>
					<small><?php echo $db_mes['mes_date'];?></small>
				</p><br/>
			<?php }?>
			
			<?php
			$stmt = $dbh->prepare("SELECT * FROM messages WHERE readerid=-1");
			$stmt->execute();
			while ( $db_mes = $stmt->fetch()) {?>
				<p>
					<img src="gif/pm.gif"/> <?php echo $db_mes ['mes_subject'];?><br/><?php echo $db_mes ['mes_value']?><br/>
					<small><?php echo $db_mes['mes_date'];?></small>
				</p><br/>
			<?php }?>
	    </td>
	</tr>
</table>
