<?php
	

	if ( $_SERVER['REQUEST_METHOD'] == 'POST' )     //this is to prevent directly accessing the page.......
	{
		$count=$_POST['camera'];                   //it stores the the number of camera filled in form in page ipGui.php     
		//echo $count;
		$Ip=array();                              //declaring Ip to be array
		#echo $_POST['ip2'];
		
		for($i=0;$i<$count;$i++)
		{	
			
			$Ip[$i]=$_POST['ip'.$i];        //storing all the value of ip of camera in the array
		}


		
		    ##echo("$ip is a valid IP address");
	    $frequency=$_POST['frequency'];                //then we store the value of frequency filled in form in previous page
	    $bandwidth=$_POST['bandwidth'];               //here bandwidth
	    $modulation=$_POST['modulation'];            //here modulation
	    $fec=$_POST['FEC'];                         //here fec
	    $gi=$_POST['GI'];                          //here gi
	    $Gain=$_POST['Gain'];                     //here gain
	    $carrier=$_POST['carrier'];              //here subcarrier
	    /*             
	    echo "frequency=".$frequency;
	    echo "bandwidth=".$bandwidth;
	    echo "modulation".$modulation;
	    echo "fec=".$fec;
	    echo "gi=".$gi;
	    echo "gain=".$Gain;*/
	    $myfile = fopen("/home/pi/Desktop/ar.txt", "w") or die("could,nt open\n");     //opening the file in write mode.this is local 
	    $myfile1=fopen("ar.txt" ,"w") or die("could,nt open ar\n");                   //this file is on server     
	    
	    for($i=0;$i<$count;$i++)
	    {
	    	$txt="$txt"."$Ip[$i]"."\n";       //concatenating ip at the right of txt one by one
	    }
		$txt = "$count"."\n"."$txt"."$frequency"."\n"."$bandwidth"."\n"."$modulation"."\n"."$fec"."\n"."$gi"."\n"."$Gain"."\n"."$carrier"."\n";   //then concatenating everything with newline character to break the line after each.
		
		fwrite($myfile, $txt);    //it writes the txt in the opened file
		fwrite($myfile1, $txt);   //it writes the txt in the opened file
		fclose($myfile);         //it closes the file
		fclose($myfile1);
		session_start();           //starting the session to remember the fact that we have travelled this page and then we are going back to ipGui.php.so that we dont have to log in again
		$_SESSION['visited']=1;     //that is why we are storing session variables $_SESSION['visited']=1
		header('Location:ipGui.php'); //then we return back to ipGui.php
		//echo $Ip[2];
	}
	else
	{
		echo "forbidden page";    //if someone tries to access this page directly
	}
	




?>
<html>
	<head>

	</head>
	<body>
		<p>click here to log in</p>
		<a href="auth.html"> click here</a>

	</body>


</html>


