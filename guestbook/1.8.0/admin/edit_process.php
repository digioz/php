<?php

/* edit_process.php */
/* process submission of guestbook form by administrator */

session_start();

require_once('login_check.php');
require_once('../config.php');
require_once('../includes/class.gbXML.php');
include_once('../includes/admin_header.php');
require_once('../includes/functions.php');
require_once('../includes/class.UBBCodeN.php');
require_once("../$language_file");

//instantiate our variables with a value:
$id = FALSE;
$yourname = FALSE;
$yourmessage = FALSE;
$youremail = FALSE;

//make sure we have an ID through POST. We cannot save the modified record without this
if ( empty($_POST['id']) )
{
    echo <<<HTML
    <p class="error">You tried to save an edited guestbook entry, but the ID was not passed on. We cannot proceed without the ID. Please try again.</p>
    <p><a href="javascript: history.go(-1)" title="Go back">Go back</a></p>
HTML;

    include('../includes/admin_footer.php');
    exit();
}

//check that we have at least a partial record to save to the data file
if ( !@($_POST['yourname'] && $_POST['youremail'] && $_POST['yourmessage']))
{
    echo <<<HTML
    <p class="error">You tried to save an edited guestbook entry while leaving all the fields blank. Please go back and fill out at least once field.</p>
    <p><a href="javascript: history.go(-1)" title="Go back">Go back</a></p>

HTML;
    include('../includes/admin_footer.php');
    exit();

}

// Assign, clean, add smiley faces and UBB encode user input
// Note, we do not check input for bad words: if administrator wants to swear in their guestbook that's up the him/her.
$id = $_POST['id'];
$date = date("D m/j/y g:iA");
$yourname    = @stripslashes($_POST['yourname']);
$youremail = @stripslashes($_POST['youremail']);
$yourmessage = smiley_face($_POST['yourmessage']);
$myUBB = new UBBCodeN();
$yourmessage = $myUBB->encode($yourmessage);
$yourmessage = stripslashes($yourmessage);

//instantiate an instance of gbXML for working with the data file
$data_type='messages';
$record_delim='message';
$filename='../data/data.xml';
$mygbXML = new gbXML($data_type,$record_delim, $filename);

//get our record ready to append
$tmp_array = array('id' => $id,
                  'name' => $yourname,
                  'date' => $date,
                  'email' => $youremail,
                  'msg' => $yourmessage,

                  );

//try to replace the existing record with the new one and display confirmation
if ($mygbXML->replace_record_in_file($id, $tmp_array) )
{
     echo <<<HTML
     <center><h2>Record Saved</h2>

        <p>This modified record has been saved: </p>
        <div class="gbookRecordBanner"></div>
        <div class="gbookRecord">
                <p><span class="gbookRecordLabel">$listnametxt:</span> $yourname  </p>
                <p><span class="gbookRecordLabel">$listemailtxt:</span> <a href="mailto:$youremail" />$youremail</a>  </p>
                <p class="gbookRecordMsg"><span class="gbookRecordLabel">$listMessagetxt:</span> $yourmessage</p>
        </div>

    <p><a href="modify.php" title="return to edit/delete page">Edit or Delete another record?</a></p></center>

HTML;

    include('../includes/admin_footer.php');

}
else
{
    echo <<<HTML
    <p class="error">An unknown error occurred. The modified guestbook entry could not be saved."</p>

HTML;
    include('../includes/admin_footer.php');
    exit();
}
