<?php

echo "<center><h2>DigiOz Version 1.0 to 1.1 Converter</h2></center><br><br>";

$filename = "list.txt"; 

// Read old entries 
$handle = fopen ($filename, "rb"); 
$yourmessage = fread ($handle, filesize ($filename)); 
fclose ($handle); 

$yourmessage = str_replace("\n", "", $yourmessage);
$yourmessage = str_replace("\r", "", $yourmessage);
$yourmessage = str_replace("<hr>", "<hr>\n", $yourmessage);

// open file for appending 
@ $fp = fopen("converted.txt", "a"); 

flock($fp, 2); 

if (!$fp) 
{ 
echo "<center><p><strong> The Conversion could not be processed at this time.</center> " 
."Please try again in a few minutes.</strong></p></body></html>"; 
exit; 
} 

fwrite($fp, $yourmessage); 
flock($fp, 3); 
fclose($fp); 

echo "<center><br>Conversion Completed. Download your new list.txt file from <a href=converted.txt>Here</a></center>";

?>