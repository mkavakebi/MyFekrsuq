<?php
include_once  '../config.php';
include_once  $MyClasses.'test2group.php';
ob_start();
?>
<?php include $MyRoot.'header.php';?>
        <table>
          <tr>
            <td class="maineffect">
<div>
                 <?php border_start();?>
<?php //readfile($MotherAdd.'/?p=345&mode=inc');?>
                  <?php border_end();?>
</div>
            </td>
            <td class="contentmain">
<br/>
<?php
if ($_SESSION ['username'] != ''){
    $MyGr=new Test2Group($dbh,$_SESSION ['username']);
	if (($MyGr->State() =='enabled')){	
//////page contents////////////////////////////////////////////////////////?>
<?php
	///first time people redirect to welcome page
	if($MyGr->NotSuchGroup) header ( "Location:welcome.php" );
	echo $MyGr->mojodi.'<br/>';
	echo $MyGr->GetFullSchool();
?>
<?php ?>   	
tozihat<br/>
tozihat<br/>
tozihat<br/>
tozihat<br/>
tozihat<br/>
tozihat<br/>
tozihat<br/>
tozihat<br/>
<a href="index.php">رفتن به صفحه ی اصلی مسابقه</a>
<?php ////////////////////////////////////////////////////////////////////////
ob_flush(); ?>
  <?php  }else{?>
  <center>
    <b>گروه شما هنوز فعال نشده</b>
  </center>
  <?php  }?>
<?php  }else{?>
<center>
  <b>شما قادر به استفاده از این صفحه نیستید</b>
  <br/>
  <a href="../index.php?return=problems2/info.php">login</a>
</center>
<?php }?>
            </td>
          </tr>
        </table>
<?php include $MyRoot.'footer.php';?>
<?php $dbh=null;?>