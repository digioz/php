<?php

/////////////////////////////////////////////////////////////////////
// Title:             	DigiOz DB Connectivity and Transaction Class
// Description: 	The purpose of this PHP Class is to establish 
//              		a connection to MySQL Database, and allow you 
//              		to perform tasks such as DB Query, DB Insert
//              		and DB Update to a specific table.
// PHP Version:	Works on PHP 4 , but obtimized for PHP 5
// Created On:  	01-31-06
// Updated:		11-28-07
// Author:      	Pedram Soheil 
// Website:     	http://www.digioz.com 
/////////////////////////////////////////////////////////////////////

class dbClass
{
	var $dbHost;
	var $dbName;
	var $dbUser;
	var $dbPass;
	var $conn;
	var $result  = array();
	var $output  = array();
	var $numrows;
	var $current_query;
	 
	function dbClass($dbHost, $dbName, $dbUser, $dbPass)
	{
		$this->dbHost = $dbHost;
		$this->dbName = $dbName;
		$this->dbUser = $dbUser;
		$this->dbPass = $dbPass;
	}
     
	// Open Database connection ---------
     
	function openConnection()
	{
		$this->conn = mysql_connect($this->dbHost, $this->dbUser, $this->dbPass)or die ("Error Connecting to Database!");
		mysql_select_db($this->dbName);
	}
     
	// Close Database Connection --------
     
	function closeConnection()
	{
		mysql_close($this->conn);
	}
     
	// Return Single Row in Array -------
     
	function queryRowArray($sql)
	{
		$result = @mysql_query($sql);
         
		if (!$result)
		{ 
			echo "<br>Error: ".mysql_error();
			return(false);
		} 
		else 
		{
			$output = @mysql_fetch_array($result);
			$this->current_query = $sql;
			return($output);
		}
	}
     
	// Return result in 2D Array -------
     
	function query2DArray($sql)
	{
		$datapool  = array();
		$result = @mysql_query($sql);

		for($i=0;$i<$this->queryNumRows($sql);$i++)
		{
			$datapool[$i] = mysql_fetch_row($result);            
		}
	   
		$this->current_query = $sql;
		return $datapool;
	}
     
	// Return Row Count -------
     
	function queryNumRows($sql = "")
	{
		if ($sql == "")
		{
			$sql = $this->current_query;
		}
		
		$result = @mysql_query($sql);
         
		if (!$result)
		{ 
			echo "<br>Error: ".mysql_error();
			return(false);
		} 
		else 
		{
			$numrows = @mysql_num_rows($result);
			return($numrows);
		}
	}
	 
	// Return Column Count --------
	 
	function queryNumCols($sql = "")
	{
		if ($sql == "")
		{
			$sql = $this->current_query;
		}

		$result = @mysql_query($sql);
         
		if (!$result)
		{ 
			echo "<br>Error: ".mysql_error();
			return(false);
		} 
		else 
		{
			$numcols = @mysql_num_fields($result);
			return($numcols);
		}
	}
     
	// Insert Or Update -------
     
	function execCommand($sql)
	{
		mysql_query($sql)or die("<br><br>Error:".mysql_error()."<br><br>");
	}

	// Show list of tables in database ----------------

	function showTables()
	{
		$datapool  = array();
		$result = @mysql_query("SHOW TABLES;");

		for($i=0;$i<mysql_num_rows($result);$i++)
		{
			$datapool[$i] = mysql_fetch_row($result);
		}

		return $datapool;
	}

	// Show list of databases -------------------------

	function showDatabases()
	{
		$datapool  = array();
		$result = @mysql_query("SHOW DATABASES;");

		for($i=0;$i<mysql_num_rows($result);$i++)
		{
			$datapool[$i] = mysql_fetch_row($result);
		}

		return $datapool;
	}
     
	// Get Latst Insert ID ---------------------------
     
	function getLastInsertID()
	{
		$result = @mysql_query("SELECT LAST_INSERT_ID();");
         
		if (!$result)
		{ 
			echo "<br>Error: ".mysql_error();
			return(false);
		} 
		else 
		{
			$output = @mysql_fetch_array($result);
			return($output[0]);
		}
	}
     
	// Return Column Information ----------------------
     
	function getColumnInformation($sql)
	{
		$datapool  = array();
		$result = @mysql_query("SHOW COLUMNS FROM ".$sql.";");

		for($i=0;$i<mysql_num_rows($result);$i++)
		{
			$datapool[$i] = mysql_fetch_row($result);            
		}
	   
		$this->current_query = "SHOW COLUMNS FROM ".$sql.";";
		return $datapool;
	}

	// ------------------------------------------------
}

// End Of Database Class -------------------------------

?>