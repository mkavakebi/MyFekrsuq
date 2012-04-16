<?php
include_once  '../config.php';
include_once  $MyClasses.'test2group.php';
include_once  $MyClasses.'buyedsoal.php';
ob_start();
?>
<?php include '../header.php';?>
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
    $MyGr=new Test2Group($_SESSION ['username'],$dbh);
    ///first time people redirect to welcome page
    if($MyGr->NotSuchGroup) header ( "Location:welcome.php" );
	if (($MyGr->State() =='enabled')){
		if(!$MyGr->HaveSoal())header("Location:index.php");
		$MySoal=$MyGr->Problem();
		
//////page contents////////////////////////////////////////////////////////?>
<?php border_start(); ?>
	<right><B>
		سطح:<?php echo $Levels[$MySoal->Level()];?>
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
	    <input type=submit name=submit value="ارسال">
	    </form>
	</Center>
<?php border_end(); ?>
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
  <a href="../index.php?return=problems2/index.php">login</a>
</center>
<?php }?>
            </td>
          </tr>
        </table>
<?php include '../footer.php';?>
<?php $dbh=null;?>