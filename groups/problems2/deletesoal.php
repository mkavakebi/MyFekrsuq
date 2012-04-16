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
    $MyGr=new Test2Group($dbh,$_SESSION ['username']);
	if (($MyGr->State() =='enabled')){	
//////page contents////////////////////////////////////////////////////////?>
<a href="index.php">بازگشت به صفحه ی اصلی</a><br/>
<?php
	///first time people redirect to welcome page
	if($MyGr->NotSuchGroup) header ( "Location:welcome.php" );
?>
<?php
$MySoal=$MyGr->Problem();
$state='';	
if($MyGr->HaveSoal()){
	if(isset($_REQUEST['hazfed'])){
		if($_REQUEST['original']*2==$_REQUEST['number']){
			if($MySoal->AssignID()==$_REQUEST['code']){
				$MyGr->ProblemRemove('enseraf');
				$state='D';		
			}else{
				$state='C';
			}
		}else{
			$state='B';
		}
	} 
}else{
	$state='A';
}
if(!$MyGr->HaveSoal()){
	if($state!='D')
		$state='A';
}else{
	if($state=='D')
		$state='E';
}
?>
<?php
	///////group information 
	echo 'موجودی:'.$MyGr->mojodi.'<br/>';
	echo $MyGr->GetFullSchool().'<br/>';
?>
<?php
 switch ($state){
 	case 'A':echo 'شما هیچ سوالی را خریداری نکرده اید!';break;
 	case 'B':echo 'عدد وارد شده صحیح نیست!';break;
 	case 'C':echo 'این صفحه دیگر اعتبار ندارد!';break;
 	case 'D':echo 'سوال شما حذف شد.';break;
 	case 'E':echo 'دوباره سعی کنید!';break;
 	case '':echo '';
 }
 if($state!='')echo '<br/>';	
?>
<?php if($state=='B' or $state=='E' or $state==''){?>
	برای حذف سوال فعلی خود دو برابر عدد 
	<?php echo $randnum=rand(100,1000);?>
	را در کادر زیر وارد کرده و کلید حذف را فشار دهید<br/>
	در ضمن با خذف این سوال پول کسر شده هنگام خرید سوال باز گردانده نمی شود.<br/>
	<form method=post>
		<input name=number>
		<input type="hidden" name=original value=<?php echo $randnum;?>>
		<input type="hidden" name=code value=<?php echo $MySoal->AssignID();?>>
		<input type=submit name=hazfed value=حذف >
	</form>
<?php }?>
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