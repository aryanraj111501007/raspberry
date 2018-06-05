<?php

	$ip=$_POST['ip'];

	if (filter_var($ip, FILTER_VALIDATE_IP)) {
	    echo("$ip is a valid IP address");
	    $myfile = fopen("/home/pi/Desktop/ar.txt", "w") or die("could,nt open\n");
		$txt = "$ip"."\n";
		fwrite($myfile, $txt);
		fclose($myfile);
		header('Location:auth.html');
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
