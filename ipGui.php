<?php
	
	$handle = fopen("hiddenfile.txt", "r") or die("couldn,t open\n");
	$actual_username=fgets($handle);
	$actual_password=fgets($handle);
	$password=$_POST['passwd'];
	$username=$_POST['uname']."\n";
	
	
	
	if($actual_password!=$password || $actual_username!=$username)
	{
		echo "<a href='auth.html'>log in</a>";
		die ("wrong password or username");
	}
	else {
		echo "welcome you are logged in";
		$password="";

	}
?>


<html>
	<head>

	</head>

	<body>
		<form action="ip_changer.php" method=post>
			<p>NEW IP :<input type="text" name="ip" placeholder="eg. xxx.xxx.xxx.xxx"></p>
			<p><button>submit</button>
		</form>
	</body>
</html>
