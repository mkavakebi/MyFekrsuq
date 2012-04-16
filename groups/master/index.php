<?php
include '../config.php';
include_once  $MyClasses.'master.php';
$MyMas=new Master($dbh);
ob_start();
?>
<?php

if (isset ( $_POST ['Submit'] )) {
	$Error=$MyMas->Login($_POST ['username'], $_POST ['password']);
}
$dbh=null;
ob_flush();
?>
<html>
<head>
<title>Login Page</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head>
<BODY>
<p align="center">&nbsp;</p>
<center><Form Method="POST" style="line-height:1 ">
<?php if ($Error){print $Error;}else{if (isset ( $_POST ['Submit'] )) { print'Loging In!'; }}?>
<table border="0" dir="rtl">
    <tr>
      <td height="21" align="left" dir="rtl">نام کاربری :</td>
      <td rowspan="2"><div align="right">
          <input name="username" type="text" maxlength="40">
        </div>
          <div align="right">
            <input name="password" type="password" maxlength="40" >
        </div></td>
      <td rowspan="2"><input type="submit" name="Submit"	value="ورود" align="bottom" height="100%"></td>
    </tr>
    <tr>
      <td height="21" align="left" dir="rtl">کلمه عبور :</td>
    </tr>
  </table>
</Form></center>
</BODY>
</html>
