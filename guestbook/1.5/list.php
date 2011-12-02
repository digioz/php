<?php

include("header.inc");

$page = $_GET['page'];
if ($page == "") { $page = 1; }
$fwd = $page - 1;
$rwd = $page +1;

// Setting the default values for number of records per page -------------------------
$perpage = 10;
$filename = "list.php";

// Reading in all the records, putting each guestbook entry in one Array Element -----

$fd = fopen ("list.txt", "r");
while (!feof ($fd)) 
{
$buffer = fgets($fd, 4096);
$lines[] = $buffer;
}
fclose ($fd);

// Counting the total number of entries (lines) in the data text file ----------------

$result = count($lines);
$count = $result-1;
//echo $count."<br>";

// Caclulate how many pages there are ----------------------------------------

if ($count == 0) { $totalpages = 0; }
else { $totalpages = intval(($count - 1) / $perpage) + 1; }

$page = $totalpages - ($page - 1);

$end = $count - (($totalpages - $page) * $perpage);
$start = $end - ($perpage - 1); if ($start < 1) { $start = 1; }

if ($start < 0) { $start = 0; }

for ($i = $end; $i>=($start-1); $i--) 
{
	echo (stripslashes($lines[$i]));
}

echo "<center>";

// Creating the Forward and Backward links -------------------------------------

if ($fwd > 0 && $rwd > 0 && $rwd<$totalpages+1)
{
echo "<br><a href=\"$filename?page=$fwd\">&lt&lt</a>";
echo "<a href=\"$filename?page=$rwd\">&gt&gt</a><br>";
}
else if ($fwd == 0)
{ echo "<a href=\"$filename?page=$rwd\">&gt&gt</a><br>"; }
else if ($rwd == 0)
{ echo "<br><a href=\"$filename?page=$fwd\">&lt&lt</a>"; }
else if ($rwd == $totalpages+1)
{ echo "<a href=\"$filename?page=$fwd\">&lt&lt</a><br>"; }


for ($i = 1; $i<=$totalpages; $i++)
{
echo " [<a href=\"$filename?page=$i\">$i</a>] ";
}
echo "</center>";





include("footer.inc");

?>


