<?php

define('IN_GB', TRUE);

// Include security configuration first
include("includes/security_headers.php");
include("includes/secure_session.php");

startSecureSession();

include("includes/functions.php");
include("includes/config.php");
include("includes/gb.class.php");
include("includes/user.class.php");

// Validate theme after functions are loaded
$theme = validateTheme($theme);

$selected_language_session = $default_language[2];

if (isset($_SESSION["language_selected_file"]))
{
	$selected_language_session = validateLanguage($_SESSION["language_selected_file"], $language_array);
}

include("language/$selected_language_session");

include("includes/rain.tpl.class.php");
include("includes/csrf.class.php");

raintpl::configure("base_url", null);
raintpl::configure("tpl_dir", "themes/" . $theme . "/");
raintpl::configure("cache_dir", "cache/");
// Construct the language select array
$lang_select_array = array();
$lang_select_array = getLanguageArray($language_array);

// Check if logged in
$user_login_email = "";
$userid = "";

if (isset($_SESSION["login_email"]))
{
	$user_login_email = $_SESSION["login_email"];
	// Prefer the session user object if available
	if (isset($_SESSION["user_object"]) && is_object($_SESSION["user_object"])) {
		$sessUser = $_SESSION["user_object"]; 		
		if (isset($sessUser->id) && !empty($sessUser->id)) {
			$userid = $sessUser->id;
		}
	}

	// Fallback: look up by email if id still empty
	if (empty($userid)) {
		$user_login_object = getUserByEmail($user_login_email);
		if ($user_login_object && isset($user_login_object->id)) {
			$userid = $user_login_object->id;
		}
	}
}

//initialize a Rain TPL object
$tpl = new RainTPL;
$tpl->assign("theme", $theme);
$tpl->assign("title", $title);
$tpl->assign("headingtitletxt", $headingtitletxt);
$tpl->assign("addentrytxt", $addentrytxt);
$tpl->assign("viewguestbooktxt", $viewguestbooktxt);
$tpl->assign("newpostfirsttxt", $newpostfirsttxt);
$tpl->assign("newpostlasttxt", $newpostlasttxt);
$tpl->assign("searchlabeltxt", $searchlabeltxt);
$tpl->assign("searchbuttontxt", $searchbuttontxt);
$tpl->assign("currentyear", date("Y"));
$tpl->assign("goback", $goback);
$tpl->assign("langCode", $default_language[1]);
$tpl->assign("langCharSet", $default_language[4]);
$tpl->assign("lang_select_array", $lang_select_array);
$tpl->assign( "logintxt", $logintxt );
$tpl->assign( "logouttxt", $logouttxt );
$tpl->assign( "registertxt", $registertxt );
$tpl->assign( "loginemail", $user_login_email );
$tpl->assign( "info2", $info2 );
$tpl->assign( "loginusermanageposts", $login_allow_post_delete );
$tpl->assign( "info4", $info4 );

// Validate Form Token
$csrf = new csrf();

if ($csrf->check_valid('post') == false) 
{
    $tpl->assign("error_msg", $errorFormToken);
    $html = $tpl->draw('error', $return_string = true);
    echo $html;
    exit;
}

// Image Verification Classic
if ($image_verify == 1) 
{
    $number = $_POST['txtNumber'];
	
    if (md5($number) != $_SESSION['image_random_value']) 
	{
        $tpl->assign("error_msg", $errorImageVerification);
        $html = $tpl->draw('error', $return_string = true);
        echo $html;
        exit;
    }
}

// Image Verification Recaptcha
if ($image_verify == 2) 
{
    require_once('includes/recaptchalib.php');
    $privatekey = $recaptcha_private_key;
    $resp       = recaptcha_check_answer($privatekey, $_SERVER["REMOTE_ADDR"], $_POST["recaptcha_challenge_field"], $_POST["recaptcha_response_field"]);
    
    if (!$resp->is_valid) 
	{
        // The CAPTCHA was entered incorrectly
        $tpl->assign("error_msg", $errorImageVerification);
        $html = $tpl->draw('error', $return_string = true);
        echo $html;
        exit;
    }
}

// Image Verification Recaptcha V2
if ($image_verify == 3) 
{
    require_once('includes/recaptcha2.php');
    $privatekey = $recaptcha_private_key;
    $reCaptcha  = new ReCaptcha($privatekey);
    
    if ($_POST["g-recaptcha-response"]) 
	{
        $resp = $reCaptcha->verifyResponse($_SERVER["REMOTE_ADDR"], $_POST["g-recaptcha-response"]);
    }
    
    if ($resp == null || $resp->success == false) 
	{
        // The CAPTCHA was entered incorrectly
        $tpl->assign("error_msg", $errorImageVerification);
        $html = $tpl->draw('error', $return_string = true);
        echo $html;
        exit;
    }
}

// Check Stop Forum Spam if enabled -------------------------------------

if ($stop_forum_spam_enabled == 1) 
{
    require_once('includes/stopforumspam.php');
    $stopforumspamkey = $stop_forum_spam_key;
    $sfs              = new StopForumSpam();
	
    $sfsargs          = array(
        'email' => $_POST['youremail'],
        'ip' => $sfs->getUserIP()
    );
	
    $sfsspamcheck     = $sfs->is_spammer($sfsargs);
    
    if ($sfsspamcheck['spammer'] == true) 
	{
        // User is in the Spam Database
        $tpl->assign("error_msg", $errorSFS);
        $html = $tpl->draw('error', $return_string = true);
        echo $html;
        exit;
    }
}

// Checking to see if the visitor has already posted --------------------

if ($gbflood == 1) 
{
    if (isset($_COOKIE['entry'])) 
	{
        $cookieval = $_COOKIE['entry'];
        $tpl->assign("error_msg", $cookieval);
        $html = $tpl->draw('error', $return_string = true);
        echo $html;
        
        exit;
    } 
	else 
	{
        // Set cookie for flood protection --------------------------------------------------------------
        $cookie = setcookie('entry', '<br><br><center><font color=red><b>' . $msgfloodprotection . '</b></font><br><br></center>', time() + (120)); // Todo: Test on Linux Server
    }
}

// Check for Banned IP if Option is set ---------------------------------

if ($banIPKey == 1) 
{
    include("includes/ban.php");
}

// Check to make sure that the post is coming from YOUR domain ----------

if ($referersKey == 1) 
{
    if (!check_referer($referers)) 
	{
        $tpl->assign("error_msg", $msgreferrerkey);
        $html = $tpl->draw('error', $return_string = true);
        echo $html;
        exit;
    }
}

// Re-assigning the variables passed by posted form ---------------------

$hideemail = false;

// Validate and sanitize input data
$yourname = validateInput($_POST['yourname'], 'string', 40);
$youremail = validateInput($_POST['youremail'], 'email', 254);
$yourmessage = validateInput($_POST['yourmessage'], 'string', 1000);

// Check for validation failures
if ($yourname === false) {
    $tpl->assign("error_msg", "Invalid name provided");
    $html = $tpl->draw('error', $return_string = true);
    echo $html;
    exit;
}

if ($youremail === false && $email_optional != 1) {
    $tpl->assign("error_msg", "Invalid email address provided");
    $html = $tpl->draw('error', $return_string = true);
    echo $html;
    exit;
}

if ($yourmessage === false) {
    $tpl->assign("error_msg", "Invalid message content");
    $html = $tpl->draw('error', $return_string = true);
    echo $html;
    exit;
}

$timestamp = date_create();
$date = date_timestamp_get($timestamp);

if ($let_user_hide_email == "1")
{
	if (isset($_POST['hideemail']) && $_POST['hideemail'] == "hideemail")
	{
		$hideemail	 = true;
	}
}

// Name Validation Section -----------------------------

$error = "";

if ($name_optional != 1) 
{
    if (strlen($yourname) > 40) // Check Name Length
	{
        $error .= "<br>$error1";
    }
	
    if (empty($yourname)) // Check if Name field is empty
	{
        $error .= "<br>$error4";
    }
}

// Email Validation Section ----------------------------

if ($email_optional != 1) 
{
    if (strlen($youremail) > 254) // Check Email Length
	{
        $error .= "<br>$error2";
    }
	
    if (empty($youremail)) // Check if Email field is empty
	{
        $error .= "<br>$error5";
    }
	
    if (checkmail($youremail) != 1) // Validate Email format
	{
        $error .= "<br>$error3";
    }
}

// Message Validation Section ---------------------------

if ($message_optional != 1) 
{
    if (empty($yourmessage)) // Check if Message field is empty
	{
        $error .= "<br>$error6";
    }
}

// Exit Program if there is an error --------------------

if (strlen($error) > 0) 
{
    $z = "1";
    $tpl->assign("error_msg", $error);
    $html = $tpl->draw('error', $return_string = true);
    echo $html;
    exit;
}

if (strlen($error) == 0) 
{
    include("includes/sanitize.php");
    
    // Detect Spam based on keywords ------------------------------------------------------------------
    
    if ($gbSpamKey == 1) 
	{
        $detectSpam = spamDetect($yourmessage);
		
        if ($detectSpam == true) {
            $yourmessage            = str_replace("\n", "<br>", $yourmessage);
            $yourmessage            = str_replace("\r", "<br>", $yourmessage);
            $yourmessage            = filter_var($yourmessage, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW);
            $message_ip_log         = $_SERVER['REMOTE_ADDR'];
            $message_ip_address_log = gethostbyaddr($_SERVER['REMOTE_ADDR']);
            $message_time_log       = $date;
            $message_log_string     = $message_time_log . " | " . $message_ip_log . " | " . $message_ip_address_log . " | " . sanitize_html_string($yourname) . " | " . sanitize_html_string($yourmessage) . "\n";
            $fp                     = fopen("data/message_spam.log", "a");
            fwrite($fp, $message_log_string);
            fclose($fp);
            
            $tpl->assign("error_msg", $msgspamdetected);
            $html = $tpl->draw('error', $return_string = true);
            echo $html;
            exit;
        }
    }
    
    // Log visitor IP Number and IP Address if option is set by guestbook administrator ---------------
    
    if ($gbIPLogKey == 1) 
	{
        $message_ip_log         = $_SERVER['REMOTE_ADDR'];
        $message_ip_address_log = gethostbyaddr($_SERVER['REMOTE_ADDR']);
        $message_time_log       = $date;
        $message_log_string     = $message_time_log . " | " . $message_ip_log . " | " . $message_ip_address_log . " | " . sanitize_html_string($yourname) . "\n";
        $fp                     = fopen("data/message_post.log", "a");
        fwrite($fp, $message_log_string);
        fclose($fp);
    }
    
    // Notify administrator of new email if option is selected ----------------------------------------
    
    if ($notify_admin == 1) 
	{
        mail("$notify_admin_email", "$notify_subject", "$notify_message");
    }
    
    // Smiley face insertion into the message ---------------------------------------------------------
    
    $yourname    = clean_message(stripslashes($yourname));
    $yourmessage = clean_message(stripslashes($yourmessage));
    
    // Call for filtering bad words -------------------------------------------------------------------
    
    if ($gbBadWordsKey == 1) 
	{
        $yourmessage = swapBadWords($yourmessage);
    }
    
    // Attachment processing ------------------------------------------------
    
    if ($gbAllowAttachments == 1) 
	{
        $attachment_text = "";
        $attachment_upload_count_success = 0;
        $i = 0;
        
        // Define allowed MIME types for security
        $allowedMimeTypes = [
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg', 
            'png' => 'image/png',
            'gif' => 'image/gif',
            'pdf' => 'application/pdf',
            'txt' => 'text/plain'
        ];
        
        for ($i = 0; $i < count($_FILES['file']['name']); $i++) 
		{
            if ($_FILES['file']['name'][$i] == '') continue;
            
            $ext = explode('.', basename($_FILES['file']['name'][$i]));
            $fileext = strtolower($ext[count($ext) - 1]);
            
            // Validate file extension
            if (!in_array($fileext, $attach_ext)) {
                echo "File " . sanitizeOutput($_FILES['file']['name'][$i]) . " extension not allowed!<br />";
                continue;
            }
            
            // Validate file upload and MIME type
            $uploadValidation = validateFileUpload($_FILES['file'][$i], array_values($allowedMimeTypes));
            if (!$uploadValidation['success']) {
                echo "File " . sanitizeOutput($_FILES['file']['name'][$i]) . " upload failed: " . $uploadValidation['message'] . "<br />";
                continue;
            }
            
            // Generate secure filename
            $filename = generateSecureFilename($fileext);
            $target_path = "uploads/" . $filename;
            
            // Ensure upload directory exists and is properly secured
            if (!file_exists("uploads")) {
                mkdir("uploads", 0755, true);
                // Add .htaccess to prevent direct execution of uploaded files
                file_put_contents("uploads/.htaccess", "Options -ExecCGI\nAddHandler cgi-script .php .pl .py .jsp .asp .sh .cgi\n");
            }
            
            if (move_uploaded_file($_FILES['file']['tmp_name'][$i], $target_path)) 
			{
                $safeOriginalName = sanitizeOutput($_FILES['file']['name'][$i]);
                $attachment_text .= "<li><a href=\"" . sanitizeOutput($target_path) . "\" target=\"_blank\" style=\"color:blue;font-size:10px;\">" . $safeOriginalName . "</a></li>";
                
                if ($gbDisplayImageInBody == 1 && in_array($fileext, $attach_img)) 
				{
                    if ($attachment_upload_count_success == 0) 
					{
                        $yourmessage .= "<br /><br />";
                    }
                    
                    $yourmessage .= "<a href=\"" . sanitizeOutput($target_path) . "\" target=\"_blank\"><img src=\"" . sanitizeOutput($target_path) . "\" style=\"width:120px;\" /></a>&nbsp;&nbsp;";
                }
                
                $attachment_upload_count_success++;
            } 
			else 
			{
                echo "There was an error uploading the file " . sanitizeOutput($_FILES['file']['name'][$i]) . ", please try again!<br />";
            }
        }
        
        if (count($_FILES['file']['name']) > 0) 
		{
            $attachment_text .= "</ul>";
        }
        
        if ($attachment_upload_count_success > 0) 
		{
            $yourmessage .= "<hr><b style=\"font-size:10px;\">Attachments:</b><br /><ul>";
        }
        
        $yourmessage .= $attachment_text;
    }
    
    // Write the verified guestbook entry to file ----------------------------------------------------
    
    $a = new gbClass();
    $a->setGBVars($date, $yourname, $youremail, $yourmessage, $hideemail, $userid);
    $data = json_encode($a) . "<!-- E -->";
    appendDataFile("data/list.txt", $data);
    
    // Give Confirmation that the Guestbook Entry was written -----------------------------------------
    
    $date_format_locale = gmdate($date_time_format, $date + 3600 * ($timezone_offset + date("I")));
    
    if ($dst_auto_detect == 0) 
	{
        $date_format_locale = gmdate($date_time_format, $date + 3600 * ($timezone_offset));
    }
    
    $tpl->assign("yournametxt", $yournametxt);
    $tpl->assign("youremailtxt", $youremailtxt);
    $tpl->assign("yourMessagetxt", $yourMessagetxt);
	$tpl->assign("lang_select_array", $lang_select_array);	
    
    $temp1 = sanitizeOutput(stripslashes($yourname));
    $temp2 = sanitizeOutput(stripslashes($youremail));
    // Do not escape the message so <br> remains as line breaks, like list.php
    $temp3 = $yourmessage;
    
    $tpl->assign("temp1", $temp1);
    $tpl->assign("temp2", $temp2);
    $tpl->assign("temp3", smiley_face($temp3));
    
    $tpl->assign("result1", $result1);
    $tpl->assign("entryDate", sanitizeOutput($date_format_locale));
    $tpl->assign("result2", $result2);
    
    $html = $tpl->draw('add', $return_string = true);
    echo $html;  
}

?>
