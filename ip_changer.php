<?php

	$ip=$_POST['ip'];


	if (filter_var($ip, FILTER_VALIDATE_IP)) {
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
		$txt = "$ip"."\n"."$frequency"."\n"."$bandwidth"."\n"."$modulation"."\n"."$fec"."\n"."$gi"."\n"."$Gain"."\n";
		fwrite($myfile, $txt);
		fclose($myfile);

		header('Location:confirmation.php');
	} else {
	    echo("$ip is not a valid IP address");

	}





?>
<html>
	<head>

	</head>
	<body>
		<p>click here to enter ip again</p>
		<a href="auth.html"> click here</a>

	</body>


</html>


