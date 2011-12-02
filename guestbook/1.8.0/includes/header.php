<?php
$lang = "en";
include("config.php");
include($language_file);

//mb_internal_encoding("UTF-8");
//mb_http_output("UTF-8");

echo <<<HTML
<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="$lang" lang="$lang">

HTML;
?>
<!-- NOTE: PLEASE DO NOT REMOVE THE ABOVE LINES FROM YOUR HEADER FILE -->

<head>
    <title>Powered by DigiOz Guestbook</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <link rel="STYLESHEET" type="text/css" href="<?php echo 'templates/'.$template_folder.'/style.css' ?>" >
</head>
<body>
    <h1><?php echo $headingtitletxt ?></h1>
    <p>
        [ <a href="guestbook.php"><b><?php echo $addentrytxt ?></b></a> ]
        [ <a href="list.php?page=1&order=new_first"><b><?php echo $viewguestbooktxt ?></b></a> ]<br>
        [ <a href="list.php?page=1&order=new_first"><b><?php echo $newpostfirsttxt ?></b></a> ]
        [ <a href="list.php?page=1&order=new_last"><b><?php echo $newpostlasttxt ?></b></a> ]
    </p>

    <form action="search.php" method=post id="search">
       <p>
        <span class="search">Enter Search <b>WORD</b>:&nbsp;&nbsp;<input type="text" name="search_term" size=20 maxlength=50>&nbsp;&nbsp;<input type=submit value="Find Now!">
	</span></p>
    </form>
