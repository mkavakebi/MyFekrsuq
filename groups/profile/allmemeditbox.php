<form method="post" action="?">
	<?php if($editing){?>
	<input type='hidden' name="memrow" value=<?php echo $_REQUEST['memrow'];?>>
	<?php }?>
  <b><?php echo($editing?'اصلاح مشخصات:':'عضو جدید:');?></b>
  <br/>
  <br/>
<table dir="rtl"  cellSpacing="1" width="100%" border="0">
	<tr>
	    <td style="HEIGHT:21px" >نام:</td>
	    <td><input name="mem_name" value="<?php if($showtime)echo($mem2edit?$mem2edit->Name():$_POST ['mem_name']);?>"  style="width: 150px;"/>
			</td>
	</tr>
	<tr>
    <td style="HEIGHT:21px" >نام خانوادگی:</td>
    <td><input name="mem_family" value="<?php if($showtime)echo($mem2edit?$mem2edit->Family():$_POST ['mem_family']);?>" style="width: 150px;"/>
		</td>
	</tr>
	<tr>
    <td style="HEIGHT:21px">پایه تحصیلی:</td>
    	<td>
        <table width="150px"><tr>
			<?php 
			if ($mem2edit)
				$paye=$mem2edit->Paye();
			else
				$paye=$_POST['paye'];
			?>        	
          	  <td width="50px"><input type="radio" name="paye" value="1" <?php if($showtime)echo($paye=='1'?'checked="check"':''); ?> />اول</td>
	     	  <td width="50px"><input type="radio" name="paye" value="2" <?php if($showtime)echo($paye=='2'?'checked="check"':''); ?>/>دوم</td>
	     	  <td width="50px"><input type="radio" name="paye" value="3" <?php if($showtime)echo($paye=='3'?'checked="check"':''); ?>/>سوم</td>
		    </tr></table>
      </td>
	</tr>
	<tr>
  	<td style="HEIGHT:21px">پست الکترونیکی:</td>
  	<td>
  		<input name="mem_email" value="<?php if($showtime)echo($mem2edit?$mem2edit->Email():$_POST ['mem_email']);?>" style="width: 150px;"/>
	</td>
	</tr>
	<tr>
		<td >
		  	<input type="submit"
	  		<?php if($editing) {?>
				name="edited" value="اصلاح کردن"
			<?php }else{?>
				name="newadded" value="اضافه کردن"
			<?php }?>
			style="width:100px;" /> 
		</td>
	</tr>
</table>
</form>