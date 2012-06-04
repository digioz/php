<?php

///////////////////////////////////
// Example to Show How to get 2D
// Array AKA Recordset from a
// Database and output to screen
///////////////////////////////////

include("dbclass.php");

$a = new dbClass('localhost','test','root','password');
$rowOut  = array();
$tblList = array();
$dbList  = array();

// Set connection variables and open database connection ------------------------------------

$a->openConnection();

// Execute Single Row Query and display results ---------------------------------------------

$sql = "SELECT * FROM `test1`";
$rowOut = $a->query2DArray($sql);

$nr_rows = $a->queryNumRows();				// Number of rows in dataset
$nr_cols = $a->queryNumCols();				// Number of columns in dataset          

echo "<table border=1 bordercolor=black>";

for($i=0; $i<$nr_rows; $i++)
{
 echo "<tr>";
 for($j=0; $j<$nr_cols; $j++)
 {
   echo "<td>".$rowOut[$i][$j]."</td>";
 }
 echo "</tr>";
}

echo "</table><br><br>";

echo "<b>Number of Columns in Query is:</b> ".$nr_cols."<br>";
echo "<b>Number of Rows in Query is:</b> ".$nr_rows."<br>";

$a->closeConnection();

?>