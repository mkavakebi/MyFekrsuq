<?php
function getcodescore($gid,$dbh)
{
	$stmt1=$dbh->prepare('SELECT fixemtiaz FROM codeemtiz WHERE groupid=?');
	$stmt1->execute(array($gid));
	if($db_field = $stmt1->fetch())
		return $db_field['fixemtiaz'];
}
function checkordu($ans)
{
	if($ans=='')return 0;
	$ans=strtolower($ans);
	//////check to be good format
	$f=explode('^',$ans);
	for ($i=0;$i<16;$i++)
	{
		if (strlen($f[$i])!=6) return 0;
	}
	//////////////////
	//////check if true
	//=================================================================
	for($x='a';$x<='p';$x++)
		for($y='a';$y<='p';$y++)
		{
			if($x!=$y)
			{
				$c=0;
				for ($i=0;$i<16;$i++)
				{
					if(strpos($f[$i], $x)!==false && strpos($f[$i], $y)!==false)$c++;
				}
				if ($c<2){return 0;}
			}
		}
	//=================================================================
	return 12;	
}
///////////////////////////////////////////////////////////////////////////
function checkcode($ans)
{
	$n=5;
	$p=0;
	$ans=str_replace(' ','',$ans);
	$f=explode('^',$ans);
	$t='ضکنهلچ';
	//var_dump($f[0]);echo 'db';
	//echo "</br>";
	//var_dump('ضکنهلچ');echo 'true';
	//echo "</br>";
	

	for($i=1;$i<12;$i+=2)
	{	
		//echo $t[$i];
		//var_dump($f[0][$i]==$t[$i]);
		//echo "</br>";
	}
	if($f[0]=='ضکنهلچ'){$p+=10/$n;}
	if($f[1]=='دشگر'){$p+=10/$n;}
	if($f[2]=='چشگر'){$p+=10/$n;}
	if($f[3]=='کخشخگ'){$p+=10/$n;}
	if($f[4]=='هدفخا'){$p+=10/$n;}
	return $p;	
}
///////////////////////////////////////////////////////////////////////////
function checkchomp($ans)
{
	/*if($ans=='')return 10;
	for($i=1;$i<7;$i++)
		for($j=1;$j<7;$j++)
			$board[$i][$j]=1;
	$f=explode(';',$ans);
	if(count($f)<3)return 3;
	for($i=1;$i<count($f);$i++)
	{
		$x=$f[$i]%10;
		$y=floor($f[$i]/190);
		echo $f[$i].'*';
	}	
	echo '<br/>';	
	return 0;*/
	if ($ans=='') return 0;
	$f=explode(';',$ans);
	if(count($f)%2==1) return 0;  		
	return 10;		
}
///////////////////////////////////////////////////////////////////////////
function t($n)
{
		$a =$n%9;
		$b= floor($n/9);
		return $a*9+$b;
}

function checknine($f)
{
	sort($f);
	//var_dump($f);
	for($i=0;$i<9;$i++)
		if ($f[$i]!=$i+1) {return false;}	
	return true;
}
function checksudoku($ans)
{
	$default='*^*^*^*^*^*^*^*^7'.'^'
			.'*^*^*^*^7^*^*^*^*'.'^'
			.'*^*^6^*^*^*^*^*^*'.'^'
			.'*^*^4^*^3^*^*^*^*'.'^'
			.'*^*^*^1^5^*^*^*^8'.'^'
			.'*^*^*^*^*^2^*^7^*'.'^'
			.'*^*^*^*^*^1^4^*^*'.'^'
			.'*^*^*^*^*^4^*^*^*'.'^'
			.'1^*^*^*^*^*^*^*^*';
			//echo $ans.'<br/>';
	$aa=explode('^',$default);
	$box=explode('^',$ans);		
	for($i=0;$i<9*9;$i++)
	//here
	{if ($aa[$i]!='*')$box[$i]=$aa[$i];
	//echo $box[$i].' ';
	//if ($i % 9==8) echo '<br/>';		
	}
	/////
	for($i=0;$i<3;$i++)
	for($j=0;$j<3;$j++)
	{
		$f=array();
		for($tt=0;$tt<3;$tt++)
		{
			$f[]=$box[$j*27+$i*3+$tt];
			$f[]=$box[$j*27+$i*3+9+$tt];
			$f[]=$box[$j*27+$i*3+18+$tt];
		}	
		if (!checknine($f)) {return 0; }
	}
	/////////
	for($p=0;$p<9;$p++){
		$f=array();      
	   	for ($i=0;$i<9;$i++)
	   		$f[]=$box[$p*9+$i];
	    if (!checknine($f)) {return 0;}
	}
	for($p=0;$p<9;$p++){
		$f=array();      
	   	for ($i=0;$i<9;$i++)
	   		$f[]=$box[t($p*9+$i)];
	    if (!checknine($f)) {return 0;}
	}
	/////////	
	$x=0;
	for($p=0;$p<9;$p++){
		$f=array();      
	   	for ($i=0;$i<3;$i++) {
	   		$f[]=$box[$i+$x];
	   		$f[]=$box[$i+$x+3*9];
	   		$f[]=$box[$i+$x+2*3*9];
	    }
	    
	    if (!checknine($f)) {return 4;	}
	     $x+=3;
	}		
	$y=0;
	for($p=0;$p<9;$p++){
		$f=array(); 
		for ($i=0;$i<3;$i++) {
	   		$f[]=$box[t($i+$y)];
	   		$f[]=$box[t($i+$y+3*9)];
	   		$f[]=$box[t($i+$y+2*3*9)];
	    }
	    $y+=3;
	    if (!checknine($f)) {return 4; }
	}
	return 10;
	//$r='3^5^9^2^4^8^1^6^^4^5^1^6^^3^5^9^2^7^2^^9^1^5^8^3^4^8^1^^7^^6^9^2^5^2^6^7^^^9^3^4^^5^9^3^4^8^^6^^1^6^7^2^5^9^^^8^3^9^3^5^8^2^^7^1^6^^4^8^3^6^7^2^5^9';
	//echo $r.':'.$ans;
	//if($ans==$r)return 1;
	//return 0;	
}
/*
 	for($p=0;$p<9;$p++){
		for ($i=0;$i<9*9;$i++) 
	    	    $box[$i]=0;
	
		if($y>100){
		   	for ($i=0;$i<3;$i++) {
		   		$box[$i+$x]=1;
		   		$box[$i+$x+3*9]=1;
		   		$box[$i+$x+2*3*9]=1;
		    }
		    $x+=3;
		    if ($x==3*9){$x=150;$y=0;}
		}else{
		   	for ($i=0;$i<3;$i++) {
		   		$box[t($i+$y)]=1;
		   		$box[t($i+$y+3*9)]=1;
		   		$box[t($i+$y+2*3*9)]=1;
		    }
		    $y+=3;
		    if ($y==3*9){$y=150;$x=0;}
			for ($i=0;$i<9*9;$i++)
			{
				if($box[$i]==1){}
			}		
		}
	}
 */