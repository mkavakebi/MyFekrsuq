<?php ob_flush(); ?>
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