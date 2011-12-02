<?php

include ("header.php");
include ("functions.php");

// Settings section ------------------------------

$filedir = "files/"; 				// The file folder
$columns = 1; 				        // Number of columns of files listed per row
$tablewidth = 800;                              // Table Width
$namecolumn = ($tablewidth / $columns) / 2;     // File Name Column Width
$datecolumn = $namecolumn / 2;                  // Date column width
$sizecolumn = $datecolumn;                      // File Size Column width
global $filename;
global $filename_sorted;

$i=0;
$j=0;
$k=0;
$m=0;

if(isset($_GET['st']))
{
  $st = $_GET['st'];
}
else
{
  $st = 1;
}

if(isset($_GET['order']))
{
  $order = "SORT_".$_GET['order'];
}
else
{
  $order = "SORT_ASC";
}  

// Table Title row -------------------------------

echo "<table width=\"$tablewidth\" cellpadding=\"2\"><tr>";

while ($k < $columns)
{
echo "<td bgcolor=#C0C0C0 width=$namecolumn align=center><font color=#000000>";
echo "    <table border=0 cellpadding=0 cellspacing=0>";
echo "    <tr>";
echo "        <td rowspan=2><a href=\"index.php?st=1\"><u><b>File Name</b></u><a/>&nbsp;&nbsp;</td>";
echo "        <td><a href=\"index.php?st=1&order=ASC\"><img src=\"images/arrow_up.gif\" border=0></a></td>";
echo "    </tr>";
echo "    <tr>";
echo "        <td><a href=\"index.php?st=1&order=DESC\"><img src=\"images/arrow_down.gif\" border=0></a></td>";
echo "    </tr>";
echo "    </table></font>";
echo "</td>\n";
echo "<td bgcolor=#C0C0C0 width=$datecolumn align=center><font color=#000000>";
echo "    <table border=0 cellpadding=0 cellspacing=0>";
echo "    <tr>";
echo "        <td rowspan=2><a href=\"index.php?st=2\"><u><b>File Date</b></u><a/>&nbsp;&nbsp;</td>";
echo "        <td><a href=\"index.php?st=2&order=ASC\"><img src=\"images/arrow_up.gif\" border=0></a></td>";
echo "    </tr>";
echo "    <tr>";
echo "        <td><a href=\"index.php?st=2&order=DESC\"><img src=\"images/arrow_down.gif\" border=0></a></td>";
echo "    </tr>";
echo "    </table></font>";
echo "</td>\n";
echo "<td bgcolor=#C0C0C0 width=$sizecolumn align=center><font color=#000000>";
echo "    <table border=0 cellpadding=0 cellspacing=0>";
echo "    <tr>";
echo "        <td rowspan=2><a href=\"index.php?st=3\"><u><b>File Size</b></u><a/>&nbsp;&nbsp;</td>";
echo "        <td><a href=\"index.php?st=3&order=ASC\"><img src=\"images/arrow_up.gif\" border=0></a></td>";
echo "    </tr>";
echo "    <tr>";
echo "        <td><a href=\"index.php?st=3&order=DESC\"><img src=\"images/arrow_down.gif\" border=0></a></td>";
echo "    </tr>";
echo "    </table></font>";
echo "</td>\n";

$k++;
}

echo "</tr><tr>";

$handle = opendir($filedir); 

while (false !==($file = readdir($handle)))
{ 
    if ($file != "." && $file != "..") 
    {
	//$filename[$i][1] = $file;
        //$filename[$i][2] = date ("m/d/y", filemtime($filedir.$file));
        //$filename[$i][3] = round(filesize($filedir.$file)/1024);
        $filename[$i][1] = $file;
        $filename[$i][2] = filemtime($filedir.$file); //date ("m/d/y", filemtime($filedir.$file));
        $filename[$i][3] = round(filesize($filedir.$file)/1024);
	++$i;
    }
}

closedir($handle);

// Sorting --------------------------------------------

$filename_sorted = csort($filename, $order, $st);

// End of Sorting -------------------------------------

while($m<(count($filename)))
{
 echo "<td bgcolor=#C0C0EF width=$namecolumn><a href=\"$filedir".$filename_sorted[$m][1]."\"><font color=#000000>".$filename_sorted[$m][1]."<font></a><br></td>\n";
        echo "<td bgcolor=#C0C0EF width=$datecolumn align=center><font color=#000000>";
	echo date("m/d/y",$filename_sorted[$m][2])."</font></td>";
        echo "<td bgcolor=#C0C0EF width=$sizecolumn  align=right><font color=#000000>";
	echo $filename_sorted[$m][3]." KB ";
        echo "</font></td>";
	++$j;
	  	if($j == $columns)
		{ 
			echo "</tr><tr>";
	  		$j = 0;
	  	}
 $m++;
}

echo "</tr></table><br><br><br>";
echo "There are currently <b>".$i."</b> files in the directory.<br>";
echo "List currently sorted by ";

if ($st == "1"){ echo "<b>FILE NAME $order</b>"; } elseif ($st == "2"){ echo "<b>FILE DATE $order</b>"; }else{ echo "<b>FILE SIZE $order</b>"; }

include ("footer.php");

?>


