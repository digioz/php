<?php

include("config.php");

$fp = fopen($file , "r+");
$count = (int)fread($fp, 1024);
$count++;
if ( flock($fp,LOCK_EX) )
{
	fseek($fp,0);
	fwrite($fp, $count); 
}
fclose($fp);

for ($i = 0 ;$i < strlen($count) ; $i++)
{
	$imgsrc = substr($count,$i ,1);
	echo "<img src =\"" . $counterurl . "counter/images/$style/" . $imgsrc . ".gif\">";
}
?>
