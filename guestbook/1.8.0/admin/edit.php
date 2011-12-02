<?php

header('content-type: text/html; charset: utf-8');
session_start();

//verify that we are logged in: must be logged in to edit a guestbook entry
require_once('login_check.php');
require_once('../includes/class.gbXML.php');
require_once('../includes/functions.php');
require_once('../language/language.php');

include('../config.php');
include('../includes/admin_header.php');
require_once('../includes/class.UBBCodeN.php');

?>

<h2>Edit Specified Guestbook Entry</h2>

<?php
//check that ID is numeric
if ( @ !is_numeric($_GET['id']))
{
    echo <<<HTML
    <p class="error">The id supplied is not a number. Please try again.</p>
    <p><a href="javascript: history.go(-1);">Go back</a></p>

HTML;
    include('../includes/admin_footer.php');
    exit();
}

//Instantiate a gbXML object to work with the guestbook entries
$data_type = 'messages';
$record_delim = 'message';
$filename = '../data/data.xml';
$mygbXML = new gbXML($data_type, $record_delim, $filename);

//Check that the id we are trying to edit actually exists
$tag_name = 'id';
$tag_value = $_GET['id'];

if ( ! $mygbXML->tag_and_value_exist($tag_name, $tag_value))
{
    echo <<<HTML
    <p class="error">The id supplied does not exist in the guest book. Please try again.</p>
    <p><a href="javascript: history.go(-1);">Go back</a></p>

HTML;
    include('../includes/admin_footer.php');
    exit();
}

//go to the guestbook and get the ID requested to edit
if (! ($recordArray = $mygbXML->get_record_from_file($_GET['id'])) )
{
    echo <<<HTML
    <p class="error">An unknown error occured. The record could not be read from the data file.</p>
    <p><a href="javascript: history.go(-1);">Go Back</a></p>

HTML;

    include('../includes/admin_footer.php');
    exit();
}
else
{
    //get a UBBClass object to decode values
    $myUBB = new UBBCodeN();

    //decode the HTML to UBB and assign the variables to populate our template included below:
    $id_value = $_GET['id'];
    $your_name_value = stripslashes($myUBB->decode($recordArray['name']));
    $your_email_value = stripslashes($myUBB->decode($recordArray['email']));
    $your_message_value = stripslashes(swap_image($myUBB->decode($recordArray['msg'])));

    //set the form that will process our submission
    $form_processor = 'edit_process.php';

    //set the path to the javascript file that the guestbook form uses
    $guestbook_entry_javascript = '../includes/guestbook_entry.js';
}

echo "<center>";
//include the main editing interface:
$inside_admin_area = "1";
include('../includes/guestbook_new_entry_page_template.php');
echo "</center>";

include("../includes/admin_footer.php");
?>
