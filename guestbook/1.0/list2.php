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
$count = $result-1;
$i = 0;

while ($i != $result)
{
echo (stripslashes($lines[$i]));
$i++;
}

include("footer.inc");

?>