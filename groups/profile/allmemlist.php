<table border="0" style="border-collapse:collapse ;" cellspacing="1" align="right">
	<?php
	for ($i=0;$i<count($allmems);$i++) {
	?> 
	<tr bgcolor=<?php if($odd){echo "#CCECCC";}else{echo "#F7F7F7";} $odd=!$odd;  ?> align="center"  vAlign="top">
    	<td width="50px" class="bTD" height="18"><span dir=ltr><?php echo $allmems[$i]->Name();?></span></td>
		<td width="50px" class="bTD" height="18"><?php	echo $allmems[$i]->Family();?></td>
		<td width="10px" class="bTD" height="18"><?php	echo $allmems[$i]->Paye();?> </td>
		<td width="32px" class="bTD" height="18">
			<?php magic_start('<img src="../gif/mail.gif"')?><?php echo $allmems[$i]->Email();?><?php magic_end();?>
		</td>
		<td width="32px" class="bTD" height="18" align="center"><a href="allmembers.php?action=edit&memrow=<?php echo $allmems[$i]->ID();?>"><img border="0" src="../gif/Edit_yes.gif" alt="Edit"></a></td>
		<td width="32px" class="bTD" height="18" align="center"><a href="allmembers.php?action=delete&memrow=<?php echo $allmems[$i]->ID();?>"> <img border="0" src="../gif/delete.gif" alt="delete"  ></a></td>
		<td width="25px" class="bTD" height="18" align="center"><?php if ($allmems[$i]->Type()=='header') echo 'سرگروه'; else echo 'عضو';?></td>
	</tr>
	<?php }?>
</table>