<?php
include_once '../config.php';
include_once '../functions.php';
include_once 'problemsconfig.php';
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
	if (($MyGr->State() =='enabled')){ ?>	