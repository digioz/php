<?php

$ip = $_SERVER['REMOTE_ADDR'];  //$ip is the user's IP address.
foreach($banned_ip as $banned) { //$banned_ip is an array of banned IP adresses.
    if($ip == $banned) {
    //THE IP ADDRESS IS BANNED/
        print "<h1 align=center><font color=red>You have been banned!</font></h1><br>";
        include("footer.php");
        exit();
    }
} 

?>

