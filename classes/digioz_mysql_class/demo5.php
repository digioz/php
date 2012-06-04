<?php

/////////////////////////////////////
// Example to show how to obtain 
// a resultset from a database table
/////////////////////////////////////

include("dbclass.php");

// Set connection variables and open database connection ------------------------------------ 
$db = new dbClass('localhost','database','root','password');
$db->openConnection();

// Execute Single Row Query and display results ---------------------------------------------

$sql = "SELECT * FROM `test1`;";
$result = $db->queryResultset($sql);

$i=0;
$num = mysql_numrows($result);

while ($i < $num) 
{
    $c1 = mysql_result($result,$i,"column1");
    $c2 = mysql_result($result,$i,"column2");

    echo "$c1 - $c2 <br>";

    $i++;
}

$db->closeConnection();

?>