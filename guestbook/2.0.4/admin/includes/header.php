<?php
if(!defined('IN_GB')) {
   die('Direct access not permitted');
}
?>

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>SimpleAdmin</title>
<link rel="stylesheet" type="text/css" href="css/style.css" media="screen" />
<link rel="stylesheet" type="text/css" href="css/navi.css" media="screen" />
<script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
<script type="text/javascript">
$(function(){
	$(".box .h_title").not(this).next("ul").hide("normal");
	$(".box .h_title").not(this).next("#home").show("normal");
	$(".box").children(".h_title").click( function() { $(this).next("ul").slideToggle(); });
});
</script>
</head>
<body>
<div class="wrap">
	<div id="header">
		<div id="top">
			<div class="left">
				<p>[ <a href="login.php?mode=logout">logout</a> ]</p>
			</div>
			<div class="right">
				<div class="align-right">
					<p><h1 style="color:#ffffff;">Guestbook Admin Interface</h1></p>
				</div>
			</div>
		</div>
		<div id="nav">
			<ul>
				<li class="upp"><a href="#">Entry Management</a>
					<ul>
						<li>&#8250; <a href="index.php">Home</a></li>
					</ul>
				</li>
				<li class="upp"><a href="#">Tracking</a>
					<ul>
						<li>&#8250; <a href="view.php?lg=1">View User IP</a></li>
						<li>&#8250; <a href="view.php?lg=2">View Spammer IP</a></li>
					</ul>
				</li>
				<li class="upp"><a href="#">Languages</a>
					<ul>
						<li>&#8250; <a href="generate_language.php">Generate Language File</a></li>
					</ul>
				</li>
				<li class="upp"><a href="#">Settings</a>
					<ul>
						<li>&#8250; <a href="view.php?lg=3">Current Settings</a></li>
					</ul>
				</li>
			</ul>
		</div>
	</div>
	
	<div id="content">
		<div id="sidebar">
			<div class="box">
				<div class="h_title">&#8250; Entry Management</div>
				<ul id="home">
					<li class="b1"><a class="icon view_page" href="index.php">Home</a></li>
				</ul>
			</div>
			
			<div class="box">
				<div class="h_title">&#8250; Tracking</div>
				<ul id="home">
					<li class="b1"><a class="icon add_user" href="view.php?lg=1">View User IP</a></li>
					<li class="b1"><a class="icon block_users" href="view.php?lg=2">View Spammer IP</a></li>
				</ul>
			</div>
			<div class="box">
				<div class="h_title">&#8250; Languages</div>
				<ul id="home">
					<li class="b1"><a class="icon users" href="generate_language.php">Generate Language File</a></li>
				</ul>
			</div>
			<div class="box">
				<div class="h_title">&#8250; Settings</div>
				<ul id="home">
					<li class="b1"><a class="icon config" href="view.php?lg=3">Current Settings</a></li>
				</ul>
			</div>
		</div>
		<div id="main">
		<div class="full_w">
		<div class="h_title"><?php echo $pageTitle; ?></div>