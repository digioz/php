<?php

/////////////////////////////////////
// Example to show how to obtain 
// a single record from database
// table, how to get the number 
// of rows returned for a query 
// and how to Insert a new record
// into an existing database table
/////////////////////////////////////

include("dbclass.php");

$a = new dbClass('localhost','test','root','password');
$rowOut  = array();
$tblList = array();
$dbList  = array();
$numRows = 0;

// Set connection variables and open database connection ------------------------------------

$a->openConnection();

// Execute Single Row Query and display results ---------------------------------------------

$sql = "SELECT * FROM `test1`;";
$rowOut = $a->queryRowArray($sql);

// Count the number of rows returned in a query ----------------------------------------------

$numRows = $a->queryNumRows();
$numCols = $a->queryNumCols();

echo "<table border=1 bordercolor=black>";
for($i=0; $i<$numCols; $i++)
{
	echo "<tr><td><b>Column $i:</b></td><td>".$rowOut[$i]."</td></tr>";
}

echo "</table><br><br>";

echo "<b>Number of Columns in Query is:</b> ".$numCols."<br>";
echo "<b>Number of Rows in Query is:</b> ".$numRows."<br>";

// Execute an SQL command like INSERT or UPDATE ----------------------------------------------

$a->execCommand("INSERT INTO `test1` (column1,column2,column3,column4) VALUES ('1','2','3','4');");

$a->closeConnection();

?>

