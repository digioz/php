<?php

include("header.inc");

$fd = fopen ("list.txt", "r");
while (!feof ($fd)) 
{
$buffer = fgets($fd, 4096);
$lines[] = $buffer;
}
fclose ($fd);

$result = count($lines);
$count = $result-2;

while ($count != -1)
{
// echo $lines[$count];
echo (stripslashes($lines[$count]));
$count--;
}

include("footer.inc");

?>