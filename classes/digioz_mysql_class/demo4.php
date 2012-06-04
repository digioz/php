<?php

///////////////////////////////////////
// Example to show how to Obtain the 
// insert ID of the Last Record
// inserted into the database table
///////////////////////////////////////


include("dbclass.php");

$a = new dbClass('localhost','test','root','password');

// Open database connection -------------------------------------------------------------------------

$a->openConnection();

// Execute an SQL command like INSERT or UPDATE ----------------------------------------------

$a->execCommand("INSERT INTO `test1` (column1,column2,column3,column4) VALUES ('1','2','3','4');");
$LastInsertID = $a->getLastInsertID();

echo "The Last Record ID you Inserted was: ".$LastInsertID;

$a->closeConnection();

?>

