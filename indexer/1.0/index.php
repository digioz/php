<?php

$filedir = "files"; 				//The file folder
$columns = 2; 				//How many files displayed per line

include "header.inc";

echo "<table width=\"400\" cellpadding=\"2\"><tr>";


$i=0;

$handle = opendir($filedir); 

while (false !==($file = readdir($handle))) 
{ 
    if ($file != "." && $file != "..") 
	{ 
	echo "<td bgcolor=#C0C0EF><a href=\"$filedir/$file\">$file</a><br></td>\n";
	++$i;
	  	if($i == $columns) 
		{ 
			echo "</tr><tr>"; 
	  		$i = 0;
	  	}
    	} 
}

closedir($handle); 

include "footer.inc";

?>


