<?php
function border_start(){
	echo('<table class="bordertable" cellspacing="0" cellpading="0">
  <tr>
    <td class="rtbt"> </td>
    <td class="tbt"> </td>
    <td class="ltbt"> </td>
  </tr>
  <tr>
    <td class="rbt"> </td>
    <td class="cbt">');
	return 1;
}
function border_end(){
	echo('</td>
    <td class="lbt"> </td>
  </tr>
  <tr>
    <td class="rbbt"> </td>
    <td class="bbt"> </td>
    <td class="lbbt"> </td>
  </tr>
</table>');
	return 1;
}

function magic_start($avstext){
	echo('<span class="mymagic">'.$avstext.'<span>');
	return 1;
}
function magic_end(){
	echo('</span></span>');
	return 1;
}
 ?>