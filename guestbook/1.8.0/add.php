<?php

session_start();
ob_start();

// Including configuration files -----------------------------------------
include("config.php");

// Include XML class
include("includes/class.gbXML.php");

// include core functions
include("includes/functions.php");

//include UBB Code Class for converting to and from UBB
include('includes/class.UBBCodeN.php');
include('includes/log_add.php');

if ($image_verify == 2)
{
    require_once("includes/recaptchalib.php");
}

if($image_verify == 1) {
    $number = $_POST['txtNumber'];
    if (md5($number) != $_SESSION['image_random_value']) {
        include("includes/header.php");
        echo "<p class='error'>Wrong Image Verification Code
        Entered!<br>Please go back and enter it again.</p>";
        include("includes/footer.php");
        exit;
    }
}

if($image_verify == 2) {
    $resp = null;
    $resp = recaptcha_check_answer ($recaptcha_private_key,
                                $_SERVER["REMOTE_ADDR"],
                                $_POST["recaptcha_challenge_field"],
                                $_POST["recaptcha_response_field"]);

    if ($resp->is_valid) {
        // Validation ok        
    }
    else {
        include("includes/header.php");
        echo "<p class='error'>".$resp->error."Entered!<br>Please go back and enter it again.</p>";
        include("includes/footer.php");
        exit;
    }
}

// Checking to see if the visitor has already posted --------------------

if ($gbflood == 1) {
    if (isset($_COOKIE['entry'])) {
        include("includes/header.php");
        $cookieval = $_COOKIE['entry'];
        echo $cookieval;
        echo "<center><br><a href=\"javascript:history.go(-1)\" class=\"text\">$goback</a></center>";
        include("includes/footer.php");
        exit;
    }
}

// Including header of the system ---------------------------------------
include("includes/header.php");

// Check for Banned IP if Option is set ---------------------------------

if ($banIPKey == 1) {
    include("includes/ban.php");
}

// Check to make sure that the post is coming from YOUR domain ----------

if ($referersKey == 1) {
    if (!check_referer($referers)) {
        echo "<p><a href=\"javascript:history.go(-1)\" class='alert'>You are attempting to submit this entry from an<br>UNAUTHORIZED LOCATION. Your IP Number and Address has been logged.<br>Please be warned that continuing your attempt<br>to flood this guestbook may result<br>in legal action against you and your organization. </a></p>";
        include("includes/footer.php");
        exit;
    }
}

// Re-assigning the variables passed by posted form ---------------------

$yourname = @$_POST['yourname'];
$youremail = @$_POST['youremail'];
$yourmessage = @$_POST['yourmessage'];
$date = date("D m/j/y g:iA");

// Error Handeling and entry checking -----------------------------------
echo "<h2>$addentryheadtxt</h2>";

// Name Validation Section -----------------------------

$error = "";

if ($name_optional != 1) {
    if (strlen($yourname) > 40) {
        $error .= "<br>$error1";
    }
    if (empty($yourname)) {
        $error .= "<br>$error4";
    }
}

// Email Validation Section ----------------------------

if ($email_optional != 1) {
    if (strlen($youremail) > 40) {
        $error .= "<br>$error2";
    }
    if (empty($youremail)) {
        $error .= "<br>$error5";
    }
    if (checkmail($youremail) != 1) {
        $error .= "<br>$error3";
    }
}

// Message Validation Section ---------------------------

if ($message_optional != 1) {
    if (empty($yourmessage)) {
        $error .= "<br>$error6";
    }
}

// Exit Program if there is an error --------------------

if (strlen($error) > 0) {
    $z="1";
    echo "<p class='alert'>$error";
    echo "<br><a href=\"javascript:history.go(-1)\" >$goback</a></p>";
    include("includes/footer.php");
    exit;
}
// The program will exit at this point if there was an error.
// Detect Spam based on keywords ------------------------------------------------------------------

if ($gbSpamKey == 1) {
    $detectSpam = spamDetect($yourmessage);
    if($detectSpam == true) {
        $yourmessage = str_replace("\n", "<br>", $yourmessage);
        $yourmessage = str_replace("\r", "<br>", $yourmessage);
        $message_ip_log = $_SERVER['REMOTE_ADDR'];
        $message_ip_address_log = gethostbyaddr($_SERVER['REMOTE_ADDR']);
        $message_time_log = $date;
        add_to_spam_log($yourname, $message_ip_log, $message_ip_address_log, $message_time_log);
        echo "<p class='alert'>SPAM DETECTED!<br>Your IP HAS BEEN LOGGED<br>AND WILL BE REPORTED TO YOUR ISP.</p>";
        echo "<p><a href=\"javascript:history.go(-1)\" class=\"text\">$goback</a><p>";
        include("includes/footer.php");
        exit;
    }
}

// Log visitor IP Number and IP Address if option is set by guestbook administrator ---------------

if ($gbIPLogKey == 1) {
    $message_ip_log = $_SERVER['REMOTE_ADDR'];
    $message_ip_address_log = gethostbyaddr($_SERVER['REMOTE_ADDR']);
    $message_time_log = $date;
    add_to_post_log($yourname, $message_ip_log, $message_ip_address_log, $message_time_log);

}
// Notify administrator of new email if option is selected ----------------------------------------

if ($notify_admin == 1) {
    mail("$notify_admin_email", "$notify_subject", "$notify_message");
}

// Make user input safe, insert emoticons, and encode UBB code -------------------------------------

$yourname    = clean_encode_message(stripslashes($yourname));
$youremail = stripslashes($youremail);
$yourmessage = smiley_face($yourmessage);
$myUBB = new UBBCodeN();
$yourmessage = $myUBB->encode($yourmessage);
$yourmessage = stripcslashes($yourmessage);

// Call for filtering bad words -------------------------------------------------------------------

if ($gbBadWordsKey == 1) {
    $yourmessage = swap_bad_words($yourmessage);
}

// Write the verified guestbook entry to file ----------------------------------------------------

$gbXML = new gbXML('messages', 'message', 'data/data.xml');
$id = $gbXML->get_max_value_for_tag('id');
++$id;
$tmpArray = array ('id' => $id,
    'date' => $date,
    'name' => $yourname,
    'email' => $youremail,
    'msg' => $yourmessage,
);

if ($gbXML->append_record_to_file($tmpArray) === TRUE) {
// Give Confirmation that the Guestbook Entry was written ----------------------------------------

    echo "<p>$result1</p>";
    echo "<p>$date</p>";
    echo "<div class=\"gbookRecordBanner\"></div>";
    echo "<div class=\"gbookRecord\">";
    echo "        <p><span class=\"gbookRecordLabel\">$listnametxt:</span> $yourname  </p>";
    echo "        <p><span class=\"gbookRecordLabel\">$listemailtxt:</span> <a href=\"mailto:$youremail\" />$youremail</a></p>";
    echo "        <p class=\"gbookRecordMsg\"><span class=\"gbookRecordLabel\">$listMessagetxt:</span> $yourmessage</p>";
    echo "</div>";

    // Set cookie for flood protection --------------------------------------------------------------

    $cookie = setcookie('entry','<p class="error">Sorry, you have already posted a message
                  on this guestbook.<br>Please wait 2 minutes and try again.</p>',time() + (120));

    echo "<p><b>$result2.</b></p>";
}
else {
//need some error handling code here
}


include("includes/footer.php");
?>
