<?php

include("header.php");

$page = $_GET['page'];
$order= $_GET['order'];

// Validate browser input ------------------------------------------------------------

if (is_numeric($page) == false) 
{
  echo "<font color=\"red\">Non Numeric Page Number</font>";
  include("footer.php"); 
  exit; 
}

if (!($order == "asc" || $order == "desc"))
{
  echo "<font color=\"red\">Entry order can only be 'asc' or 'desc'</font>";
  include("footer.php");
  exit;
}  

// -----------------------------------------------------------------------------------

if ($page == "") { $page = 1; }
$fwd = $page - 1;
$rwd = $page +1;

// Setting the default values for number of records per page -------------------------
$perpage = 10;
//$filename = "list.php";

// Reading in all the records, putting each guestbook entry in one Array Element -----

$filename = "data/list.txt";
$handle = fopen($filename, "r");

if (filesize($filename) == 0){                         // mpg are there any entries to display
   print "There are currently no entries to display";  // mpg no inform user
}
else
{

$datain = fread($handle, filesize($filename));
fclose($handle);
$out = explode("<!-- E -->", $datain);

$outCount = count($out) - 1;
$j = $outCount-1;

if ($order == "desc")
{
    for ($i=0; $i<=$outCount; $i++)
    {
        $lines[$j] = unserialize($out[$i]);
        $j = $j - 1;
    }
}
else
{
    for ($i=0; $i<=$outCount; $i++)
    {
        $lines[$i] = unserialize($out[$i]);
    }
}

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

//$end =  ($perpage * $page) - 1;
//$start = $end - $perpage;

if ($start < 0) { $start = 0; }

//for ($i = $end; $i>=($start-1); $i--)
//for ($i = 0; $i<$outCount; $i++)
//for ($i=$start-1; $i<$end; $i++)
for ($i=$end-1; $i>$start-2; $i--)
{
	//echo $i."<br>end-".$end."-start-".$start;
        echo "<table bgcolor=#EFEFEF bordercolor=#C0C0C0 border=1 width=500 cellspacing=0 cellpadding=10><tr><td background=\"images/toolbar.jpg\" height=\"20\"></td></tr><tr><td>";
        echo "<b>$listDatetxt: </b>";
        $lines[$i]->showDate();
	echo "<br><b>$listnametxt: </b>";
        $lines[$i]->showFrom();
        echo "<br><b>$listemailtxt: </b><a href=\"mailto:";
        $lines[$i]->showEmail();
        echo "\">";
        $lines[$i]->showEmail();
        echo "</a><br><br><b>$listMessagetxt: </b>";
        $lines[$i]->showMessage();
        echo "</td></tr></table><br>";
}

echo "<center>";

// Creating the Forward and Backward links -------------------------------------

if ($fwd > 0 && $rwd > 0 && $rwd<$totalpages+1)
{
echo "<br><a href=\"list.php?page=$fwd&order=$order\">&lt&lt</a>";
echo "<a href=\"list.php?page=$rwd&order=$order\">&gt&gt</a><br>";
}
else if ($fwd == 0)
{ echo "<a href=\"list.php?page=$rwd&order=$order\">&gt&gt</a><br>"; }
else if ($rwd == 0)
{ echo "<br><a href=\"list.php?page=$fwd&order=$order\">&lt&lt</a>"; }
else if ($rwd == $totalpages+1)
{ echo "<a href=\"list.php?page=$fwd&order=$order\">&lt&lt</a><br>"; }


for ($i = 1; $i<=$totalpages; $i++)
{
echo " <b>[ <a href=\"list.php?page=$i&order=$order\"><b>$i</b></a> ]</b> ";
}
echo "</center>";

} // mpg end if
include("footer.php");

?>


