<?php

$style = 2;                       // Image Style for the Counter
$file = "counter.txt";      // File to store the count for counter

$fp = fopen($file , "r");
$count = (int)fread($fp, 1024);
$count++;
fclose($fp);

for ($i = 0 ;$i < strlen($count) ; $i++)
{
$imgsrc = substr($count,$i ,1);
echo "<img src =\"images/$style/" . $imgsrc . ".gif\">";
}
$fp = fopen($file, "w"); 
fwrite($fp, $count); 
fclose($fp); 
?>
