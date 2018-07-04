<?php



if ( $_SERVER['REQUEST_METHOD'] == 'POST' )   //this is to prevent user to directly access the page
{
	echo "rebooting......";                  //this is just to echo message

	exec("sudo reboot");                  //this is system call for reboot
	echo "done";                         //this won,t be executed
}
else{                                     //if someone tries to access this page directly
	echo("FORBIDDEN PAGE");               // it will show forbidden page
}


//header('Location:ipGui.php');

?>