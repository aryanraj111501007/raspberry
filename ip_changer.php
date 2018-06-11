<?php

	$count=$_POST['camera'];
	echo $count;
	$Ip=array();
	#echo $_POST['ip2'];
	
	for($i=0;$i<$count;$i++)
	{	
		
		$Ip[$i]=$_POST['ip'.$i];
	}


	
	    ##echo("$ip is a valid IP address");
    $frequency=$_POST['frequency'];
    $bandwidth=$_POST['bandwidth'];
    $modulation=$_POST['modulation'];
    $fec=$_POST['FEC'];
    $gi=$_POST['GI'];
    $Gain=$_POST['Gain'];
    echo "frequency=".$frequency;
    echo "bandwidth=".$bandwidth;
    echo "modulation".$modulation;
    echo "fec=".$fec;
    echo "gi=".$gi;
    echo "gain=".$Gain;
    $myfile = fopen("/home/pi/Desktop/ar.txt", "w") or die("could,nt open\n");
    $myfile1=fopen("ar.txt" ,"w") or die("could,nt open ar\n");
    
    for($i=0;$i<$count;$i++)
    {
    	$txt="$txt"."$Ip[$i]"."\n";
    }
	$txt = "$count"."\n"."$txt"."$frequency"."\n"."$bandwidth"."\n"."$modulation"."\n"."$fec"."\n"."$gi"."\n"."$Gain"."\n";
	fwrite($myfile, $txt);
	fwrite($myfile1, $txt);
	fclose($myfile);
	fclose($myfile1);
	session_start();
	$_SESSION['visited']=1;
	header('Location:ipGui.php');
	echo $Ip[2];




?>
<html>
	<head>

	</head>
	<body>
		<p>click here to enter ip again</p>
		<a href="auth.html"> click here</a>

	</body>


</html>


