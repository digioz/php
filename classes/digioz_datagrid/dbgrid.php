<?php

include("dbclass.php");

/////////////////////////////////////////////////////////////////////
// Title:		DigiOz Data Grid
// Description:	The purpose of this PHP Class is to create
//			a Data Grid, through which to browse the records
//			in a specific database.
// PHP Version:	Works on PHP 4 , but obtimized for PHP 5
// Required:	DigiOz MySQL Database Class
// Created On:	02-07-06
// Updated:		11-28-07
// Author:		Pedram Soheil
// Website:		http://www.digioz.com
/////////////////////////////////////////////////////////////////////

class dbGrid extends dbClass
{
	var $nr_rows;
	var $nr_rows2;
	var $nr_cols;
	var $sql;
	var $rowOut = array();
	var $colOut = array();
	var $borderColor;
	var $cellPadding;
	var $cellSpacing;
	var $tableWidth;
	var $perPage;
	var $start;
	var $end;
	var $showHeader;
	var $customHeader;
      
	// Constructor -----------------------------------------------------------

	function dbGrid($dbHost, $dbName, $dbUser, $dbPass)
	{
		parent::dbClass($dbHost, $dbName, $dbUser, $dbPass);
		
        $this->borderColor = "#FF0000";
        $this->cellPadding = "5";
        $this->cellSpacing = "0";
        $this->tableWidth = "100%";
        $this->perPage = "10";
        $this->start = "0";
        $this->end = strval($this->start) + strval($this->perPage);
        $this->showHeader = 1;
        $this->customHeader = "";
	}
      
	// Function to change grid properties at runtime -------------------------
      
	function setProperties($a, $b, $c, $d)
	{
		$this->borderColor = $a;
        $this->cellPadding = $b;
        $this->cellSpacing = $c;
        $this->tableWidth  = $d;
	}
      
	// Function to set the number of records per page at runtime -------------
      
	function setPerPage($e)
	{
		$this->perPage = $e;
	}
      
	// Function to set if column header needs to be displayed ----------------
      
	function setShowHeader($f)
	{
		$this->showHeader = $f;
	}
      
	// Function to set custom column header ----------------------------------
      
	function setCustomHeader($g)
	{
		$this->customHeader = $g;
	}
    
	// Function to display the datagrid --------------------------------------

	function displayGrid($tablename, $begin)
	{
		parent::openConnection();

		if ($begin < (strval($this->start) + strval($this->perPage)))
		{
			$this->start = 0;
			$this->end = strval($this->start) + strval($this->perPage);
		}
		else
		{
			$this->start = $begin;
			$this->end = strval($this->start) + strval($this->perPage);
		}

		$this->sql    = "SELECT * FROM `$tablename` Limit $this->start,$this->perPage";
		$this->rowOut = parent::query2DArray($this->sql);

		$this->nr_rows = parent::queryNumRows();
		$this->nr_cols = parent::queryNumCols();

		echo "<center><table border=1 width=$this->tableWidth bordercolor=$this->borderColor cellpadding=$this->cellPadding cellspacing=$this->cellSpacing>\n";

		// Get Column Headers ---------------
        
		if ($this->showHeader == 1 && $this->customHeader == "")
		{
			$this->sql    = "SHOW COLUMNS FROM `$tablename`";
			$this->colOut = parent::query2DArray($this->sql);
        
			$this->nr_rows2 = count($this->colOut);
        
			echo "<tr>";

			for($i=0; $i < $this->nr_rows2; $i++)
			{
				echo "<td><center><b>".$this->colOut[$i][0]."</b></center></td>";
			}
        
			echo "</tr>\n";
		}
		elseif ($this->showHeader == 1 && $this->customHeader != "")
		{
			$cHeader = explode("|",$this->customHeader);
			$this->nr_rows2 = count($cHeader);
          
			echo "<tr>";
          
			for($i=0; $i < $this->nr_rows2; $i++)
			{
				echo "<td><center><b>".$cHeader[$i]."</b></center></td>";  
			}
          
			echo "</tr>\n";
        }

		// Show Detail ----------------------

		for($i=0; $i<$this->nr_rows; $i++)
		{
			echo "<tr>";
            for($j=0; $j<$this->nr_cols; $j++)
            {
                echo "<td>&nbsp;".$this->rowOut[$i][$j]."</td>\n";
            }
            echo "</tr>\n";
		}

		echo "<br><br><tr><td colspan=$this->nr_cols><center>\n";
        
		if($this->start > 0)
		{
			echo "<a href=\"".$_SERVER['PHP_SELF']."?st=".($this->start - $this->perPage)."\"><b>&lt;&lt</b></a>";
		}

		echo " <b> | </b> <a href=\"".$_SERVER['PHP_SELF']."?st=".(strval($this->start) + strval($this->perPage))."\"><b>&gt;&gt</b></a>";

		echo "</center></tr>\n";
        
		echo "</table></center>\n<br><br>\n";

		parent::closeConnection();
	}
}

?>
