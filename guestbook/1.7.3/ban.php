<?php

foreach($banned_ip as $banned) 
{ 
	$ip = $_SERVER['REMOTE_ADDR'];
	if($ip == $banned)
	{ 
		print "<h1 align=center><font color=red>You have been banned!</font></h1><br>"; 
		include("footer.php");
		exit(); 
	} 
} 

?>

