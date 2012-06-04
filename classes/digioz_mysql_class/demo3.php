<?php

//////////////////////////////////
// Example to Show How to get a
// List of Database Tables and
// MySQL Databases on system
//////////////////////////////////

include("dbclass.php");

$a = new dbClass('localhost','test','root','password');
$tblList = array();
$dbList  = array();
$rowOut  = array();

// Open database connection ------------------------------------------------------------------

$a->openConnection();

// Show a List of Tables in Selected Database -----------------------------------------------

$tblList = $a->showTables();

$nr_rows = count($tblList);

echo "<table border=1 bordercolor=black cellspacing=0 align=center>";
echo "<tr><td><u><b>TABLES LIST</b></u></td></tr>";

for($i=0; $i<$nr_rows; $i++)
{
 echo "<tr><td>".$tblList[$i][0]."</td></tr>";
}

echo "</table>";

// Show a List Databases Available for query -----------------------------------------------

$dbList = $a->showDatabases();

$nr_rows = count($dbList);

echo "<br><table border=1 bordercolor=black cellspacing=0 align=center>";
echo "<tr><td><u><b>DATABASE LIST</b></u></td></tr>";

for($i=0; $i<$nr_rows; $i++)
{
 echo "<tr><td>".$dbList[$i][0]."</td></tr>";
}

echo "</table>";

// Get Column Information for a table ------------------------------------------------------

$rowOut = $a->getColumnInformation("test1");

$nr_rows = $a->queryNumRows();				// Number of rows in dataset
$nr_cols = $a->queryNumCols();				// Number of columns in dataset

echo "<br><table border=1 bordercolor=black align=center cellspacing=0>";
echo "<tr><td colspan=6><b><u><center>TABLE COLUMN INFORMATION</center></u></b></td></tr>";
echo "<tr><td><b><u><center>Field</center></u></b></td><td><b><u><center>Type</center></u></b></td>";
echo "<td><b><u><center>Null</center></u></b></td><td><b><u><center>Key</center></u></b></td>";
echo "<td><b><u><center>Default</center></u></b></td><td><b><u><center>Extra</center></u></b></td></tr>";

for($i=0; $i<$nr_rows; $i++)
{
 echo "<tr>";
 for($j=0; $j<$nr_cols; $j++)
 {
   echo "<td>&nbsp;".$rowOut[$i][$j]."</td>";
 }
 echo "</tr>";
}

echo "</table><br><br>";

$a->closeConnection();

?>