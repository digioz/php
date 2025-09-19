<?php

define('IN_GB', TRUE);

session_start();

include("includes/config.php");

if (isset($_POST['language_selected']))
{
	$tmp_selected_lang = $_POST['language_selected'];
	$tmp_selected_file = "";
	$tmp_selected_lang_code = "en";
	
	if ($tmp_selected_lang != "" && $tmp_selected_lang != "Select Language")
	{
		$_SESSION["language_selected"] = $tmp_selected_lang;
		
		$lang_select_file = "";
		$lang_count = 0;
		$lang_count = count($language_array); 

		for($i=0; $i<$lang_count; $i++)
		{
			if ($language_array[$i][0] == $tmp_selected_lang)
			{
				$tmp_selected_file = $language_array[$i][2];
				$tmp_selected_lang_code = $language_array[$i][1];
				$_SESSION["language_selected_file"] = $tmp_selected_file;
				$_SESSION["language_selected_code"] = $tmp_selected_lang_code;
			}
		}
	}
}

//echo "Language Selected: ".$tmp_selected_lang."<br>";
//echo "Language Selected File: ".$tmp_selected_file."<br>";
//echo "Language Session: ".$_SESSION["language_selected"]."<br>";
//echo "Language Session File: ".$_SESSION["language_selected_file"]."<br>";

header( 'Location: list.php?page=1&order=asc' ) ;

?>