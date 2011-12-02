<?php
header('content-type: text/html; charset: utf-8');
session_start();
include("includes/header.php");

if ($image_verify == 2)
{
	require_once("includes/recaptchalib.php");
}

//set the form that will process our submission
$form_processor = 'add.php';
$inside_admin_area = "0";
include('includes/guestbook_new_entry_page_template.php');

include("includes/footer.php");
?>
