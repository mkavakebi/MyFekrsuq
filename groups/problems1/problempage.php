<?php
include_once 'config.php';
include_once 'functions.php';
include_once 'problems/problemsconfig.php';
ob_start();
?>
<?php include 'header.php';?>
        <table>
          <tr>
            <td class="maineffect">
<div>
                 <?php border_start();?>
<?php readfile($MotherAdd.'/?p=345&mode=inc');?>
                  <?php border_end();?>
</div>
            </td>
            <td class="contentmain">
<br/>
<?php

if ($_SESSION ['username'] != ''){
   if ((isgroupenabled($_SESSION ['username'],$dbh)=='enabled') or (isgroupenabled( $_SESSION ['username'],$dbh)=='taligh') ){
   	
	if (isset($_REQUEST['page']))if ($_REQUEST['page']>0 && $_REQUEST['page']<=$count)$current=$_REQUEST['page'];
?>
<?php echo GetProblemNavigation($current,$count);?>
<br/>
<?php include 'problems/'.$current.'.php';ob_flush(); ?>
  <?php  }else{?>
  <center>
    <b>گروه شما هنوز فعال نشده</b>
  </center>
  <?php  }?>
<?php  }else{?>
<center>
  <b>شما قادر به استفاده از این صفحه نیستید</b>
</center>
<?php }?>
            </td>
          </tr>
        </table>
<?php include 'footer.php';?>
<?php $dbh=null;?>