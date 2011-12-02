<?php

/////////////////////////////////////////////////////////////////////
// Title:       DigiOz Who Is Online                               //
// Description: The purpose of this PHP script is to show how      //
//              many visitors are connected to your website at     //
//              any given time.                                    //
// Created On:  02-21-07                                           //
// Author:      Pedram Soheil                                      //
// Company:     DigiOz Multimedia                                  //
// Website:     http://www.digioz.com                              //
/////////////////////////////////////////////////////////////////////

@session_start();

function ago($timestamp)
{
       $difference = time() - $timestamp;
       //echo "<br>".$difference."<br>";
       return $difference;
}

include("whoisonline_config.php");
include("dbclass.php");
$count = 0;

if ($_SESSION['entrytime']==""){ $_SESSION['entrytime'] = time(); }

if (file_exists("install.php")) { echo "Who Is Online Security:<br>Please Remve <b>install.php</b>."; exit; }

$db1 = new dbClass();
$db1->setDBVars($dbhost,$dbname,$dbuser,$dbpass);
$db1->openConnection();

$ip = $_SERVER['REMOTE_ADDR'];

$sql = "SELECT COUNT(*) FROM `$dbname`.`$dbtable` WHERE `ip`='$ip';";
$rowOut = $db1->queryRowArray($sql);
$ip_exists = $rowOut[0];

if ($ip_exists > 0)
{
     $sql = "SELECT COUNT(*) FROM `$dbname`.`$dbtable`";
     $rowOut = $db1->queryRowArray($sql);
     $count = $rowOut[0];
}
else
{
     $db1->execCommand("INSERT INTO `$dbname`.`$dbtable` (`ip`) VALUES ('$ip');");
     $sql = "SELECT COUNT(*) FROM `$dbname`.`$dbtable`;";
     $rowOut = $db1->queryRowArray($sql);
     $count = $rowOut[0];
}

echo "<table>";
echo "<tr><td>".$txtVisitors."</td><td>".$count."</td></tr>";
echo "<tr><td>".$txtYourIP."</td><td>".$ip."</td></tr>";
echo "</table>";

if (ago($_SESSION['entrytime']) > 600)
{
     // -------------- REMOVE OLD IP ENTRIES ------------------------------------------------------------------------
     $db1->execCommand("DELETE FROM `$dbname`.`$dbtable` WHERE modified < (now() - INTERVAL $purge_length MINUTE);");
     // -------------------------------------------------------------------------------------------------------------
     $_SESSION['entrytime'] = time();
     echo "Purged Rows";
}

$db1->closeConnection();

?>