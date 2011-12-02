<?php

include ("header.inc");
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
$st = $_GET['st'];
if ($st == ""){ $st = 1; }

// Table Title row -------------------------------

echo "<table width=\"$tablewidth\" cellpadding=\"2\"><tr>";

while ($k < $columns)
{
echo "<td bgcolor=#C0C0C0 width=$namecolumn align=center><font color=#000000><a href=\"index.php?st=1\"><u><b> File Name </b></u><a/></font></td>\n";
echo "<td bgcolor=#C0C0C0 width=$datecolumn align=center><font color=#000000><a href=\"index.php?st=2\"><u><b> File Date </b></u></a></font></td>\n";
echo "<td bgcolor=#C0C0C0 width=$sizecolumn align=center><font color=#000000><a href=\"index.php?st=3\"><u><b> File Size </b></u></a></font></td>\n";
$k++;
}

echo "</tr><tr>";

$handle = opendir($filedir); 

while (false !==($file = readdir($handle)))
{ 
    if ($file != "." && $file != "..") 
	{
	$filename[$i][1] = $file;
        $filename[$i][2] = date ("m/d/y", filemtime($filedir.$file));
        $filename[$i][3] = round(filesize($filedir.$file)/1024);
	++$i;
    	}
}

closedir($handle);

// Sorting --------------------------------------------

$filename_sorted = csort($filename,$st);

// End of Sorting -------------------------------------

while($m<(count($filename)))
{
 echo "<td bgcolor=#C0C0EF width=$namecolumn><a href=\"$filedir".$filename_sorted[$m][1]."\"><font color=#000000>".$filename_sorted[$m][1]."<font></a><br></td>\n";
        echo "<td bgcolor=#C0C0EF width=$datecolumn align=center><font color=#000000>";
	echo $filename_sorted[$m][2]."</font></td>";
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

if ($st == "1"){ echo "<b>FILE NAME</b>"; } elseif ($st == "2"){ echo "<b>FILE DATE</b>"; }else{ echo "<b>FILE SIZE</b>"; }

include ("footer.inc");

?>


