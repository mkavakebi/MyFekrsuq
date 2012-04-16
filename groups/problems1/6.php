soale 3 3333333333333333333333333
333333333333333333333333333333333
<?php
	$groupid=getgroupid($_SESSION ['username'],$dbh);
	$stmt = $dbh->prepare("SELECT ID FROM problems WHERE groupid=?");
    $stmt->execute(array($groupid));
    if($db_field = $stmt->fetch()){}
    else{
    	echo $groupid;
    	$stmt = $dbh->prepare("INSERT INTO problems (groupid)VALUES(?)");
    	$stmt->execute(array($groupid));
    }
    
if ($_REQUEST[completed] == 1) {
        move_uploaded_file($_FILES['imagefile']['tmp_name'],"latest.img");
        $instr = fopen("latest.img","rb");
        $image = fread($instr,filesize("latest.img"));
        if (strlen($instr) < 149000) {
                $stmt = $dbh->prepare("UPDATE problems SET rokhimg=?
                						WHERE groupid=?");
                $stmt->execute(array($image,$groupid));
        } else {
                $errmsg = "Too large!";
        }
}
?>
<h2>Please upload Answer picture</h2>
<form enctype=multipart/form-data method=post>
<input type=hidden name=completed value=1>
<input type=hidden name="page" value=<?php echo $current;?>>
<input type=file name=imagefile><br>
<input type=submit>
</form>
<br>
your last <img src="problems/3getimage.php?gim=1" width=144><br>