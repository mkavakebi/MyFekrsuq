<table border=5>
<?php for($k=0;$k<3;$k++){  ?>
  <tr>
  	<?php  for($m=0;$m<3;$m++){  ?>
	  	<td>		
		  <table>
		  <?php for($i=0;$i<3;$i++){  ?>
		  <tr>
		  	<?php  for($j=0;$j<3;$j++){ 
		  		$ind=27*$k+3*$m+9*$i+$j; ?>
			  	<td width="200px" id='element<?php echo $ind;?>'><center><?php echo $ind+1;?></center></td>
		    <?php }?>
		  </tr> 
		  <?php }?>
		  </table>
		  </td>
    <?php }?>
  </tr> 
  <?php }?>
</table>
<script language="JavaScript">
var x=0,y=150;
var box = [];
intervalHandler=setInterval("draw()",1000);
function t(n){
	var a =n%9;
	var b= Math.floor(n/9);
	return a*9+b;
}
function draw(){
	for (var i=0;i<9*9;i++) 
    	    box[i]=0;

	if(y>100){
	   	for (var i=0;i<3;i++) {
	   		box[i+x]=1;
	   		box[i+x+3*9]=1;
	   		box[i+x+2*3*9]=1;
	    }
	    x+=3;
	    if (x==3*9){x=150;y=0;}
	}else{
	   	for (var i=0;i<3;i++) {
	   		box[t(i+y)]=2;
	   		box[t(i+y+3*9)]=2;
	   		box[t(i+y+2*3*9)]=2;
	    }
	    y+=3;
	    if (y==3*9){y=150;x=0;}
	}
	var element;
	for (var i=0;i<9*9;i++){
			element=document.getElementById("element"+i);
			if(box[i]==0){element.bgColor="white";}
			if(box[i]==1){element.bgColor="#00ff00";}
			if(box[i]==2){element.bgColor="yellow";}
	}
}
</script>
  