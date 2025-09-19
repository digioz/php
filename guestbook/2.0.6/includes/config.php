<?php

if(!defined('IN_GB')) {
   die('Direct access not permitted');
}

// Version of this Guestbook ---------------------------------------------------------

$gb_version = "2.0.4";

// Theme directory -------------------------------------------------------------------

$theme = "default";		  	  // Set to the name of the directory in "theme" folder

// Date Format Settings --------------------------------------------------------------

$timezone_offset = -5;		  // Number of hours to offset from UTC Time Zone
							  // Change the format to the date format for your region
$date_time_format = "D m/j/y g:i A";
$dst_auto_detect = 0; 		  // Set "1" to auto detect, "0" to disable

// Variables for making a field optional in form -------------------------------------

$email_optional      = 0;     // Set "1" for optional email, "0" to make it required
$name_optional       = 0;     // Set "1" for optional name, "0" to make it required
$message_optional    = 0;     // Set "1" for optional message, "0" for required
$let_user_hide_email = 0;	  // Set "1" to let users hide their own emails

// Variables for notifying administrator when a new message is posted ----------------

$notify_admin       = 0;      // Set "1" to notify administrator through email
                              // when a new guestbook entry is written.
                              // Warning: To use this feature you will have to have
                              // your "SMTP" and "smtp_port" setting in php.ini set.

                              // Enter the admin notification email subject bellow
$notify_subject     = "You have a new entry in your DigiOz Guestbook";
                              // Enter administrative email to receive notification
$notify_admin_email = "webmaster@yourdomain.com";
                              // Body of the notification message
$notify_message     = "A new entry has been submitted to your DigiOz Guestbook.";

// Guestbook Configuration Variables ------------------------------------------------

$total_records_per_page	= 10;	// determines how many messages show per page in list

// Variable for choosing language file name -----------------------------------------

								// Set the default language from the list below 
$default_language = array("English", "en", "language.php", "en_US", "UTF-8");
// $default_language = array("Norwegian", "no", "language_norwegian.php", "no_NO", "UTF-8");

$allow_user_language_select = 1;	// Allow the user to select a language 
									// The array below is a list of languages that 
									// the users will be able to select from. If 
									// adding a new language make sure to add the 
									// file listed below to the languages directory first
$language_array = array();
$language_array[] = array("English", "en", "language.php", "en_US", "UTF-8");
$language_array[] = array("Czech", "cs", "language_czech.php", "cs_CZ", "ISO-8859-2");
$language_array[] = array("Dutch", "nl", "language_dutch.php", "nl_NL", "UTF-8");
$language_array[] = array("German", "de", "language_german.php", "de_DE", "ISO-8859-1");
$language_array[] = array("Greek", "el", "language_greek.php", "el_GR", "UTF-8");
$language_array[] = array("Hungarian", "hu", "language_hungarian.php", "hu_HU", "ISO-8859-2");
$language_array[] = array("Persian", "fa", "language_persian.php", "fa_IR", "UTF-8");
$language_array[] = array("Slovak", "sk", "language_slovak.php", "sk_SK", "ISO-8859-2");
$language_array[] = array("Swedish", "sw", "language_swedish.php", "en_KE", "UTF-8");
$language_array[] = array("Norwegian", "no", "language_norwegian.php", "no_NO", "UTF-8");

// Image Verification Feature -------------------------------------------------------

$image_verify       = 0;      // Set to 1 for simple, or 2 for Recaptcha Version 1.0
							  // or set to 3 for Recaptcha Version 2.0. 
							  // If you select 2 or 3, you have to set the Recaptcha 
							  // public and private keys below as well
							  // Do Image Verification to prevent spam post
                              // Option 1 requires your PHP to have been
                              // compiled with GD 2.0.x or higher. Option 3 requires
							  // for your PHP to support CURL in order to communicate
							  // the image verification answer to Google and verify it.

$recaptcha_public_key = "";	  // Recaptcha Public Key obtained from google.com/recaptcha
$recaptcha_private_key = "";  // Recaptcha Private Key obtained from google.com/recaptcha
                              
// Admin Interface Username ---------------------------------------------------------

$_Username         = "admin";
$_Password         = "admin";

// User Login Settings --------------------------------------------------------------
							  // We recommend that you change the logion salt value
$login_salt		   			= "WfQCAgS3uISXDK7Azw";
$login_required	 			= "0";
$login_allow_post_delete 	= "1";

// Stop Forum Spam Settings ---------------------------------------------------------

$stop_forum_spam_enabled 	= "0";
$stop_forum_spam_key 		= "";

// Flood protection setting ---------------------------------------------------------

$gbflood            = 0;      // Set "1" to prevent flooding, "0" to disable it

$referersKey        = 0;      // Set "1" to check to see where submitted guestbook
                              // messages are coming from or "0" to disable it
$referers = array (
  'yourdomain.com',           // Your domain name without WWW
  'www.yourdomain.com',       // Your domain name with WWW
  '111.222.333.444');         // IP Address of your site

$gbIPLogKey         = 1;      // Set "1" to log IP of Visitor for each post "0" to disable

$banIPKey           = 0;      // Set "1" to block posting of banned IP or "0" to disable

// Attachment Settings -------------------------------------------------------------

$gbAllowAttachments = 0;	  // Flag to enable file upload
$gbDisplayImageInBody = 1;	  // Only works if Attachments are Allowed

$attach_ext = array();  	  // List of file extensions that are allowed as attachments
$attach_ext[] = 'jpg';
$attach_ext[] = 'png';
$attach_ext[] = 'gif';
$attach_ext[] = 'pdf';
$attach_ext[] = 'txt';

$attach_img = array();  	  // List of file extensions to show as image in the body 
$attach_img[] = 'jpg';		  // of message
$attach_img[] = 'png';
$attach_img[] = 'gif';

// ---------------------------------------------------------------------------------
// Bellow you can list known IP addresses you would like to block. -----------------
// We have given you a list of known spammers bellow. Feel free --------------------
// to either use our list or delete our list and create your own -------------------
// based on the IP logs of the guestbook. For updates to our list ------------------
// of known spammers please visit www.digioz.com or email our ----------------------
// tech support team. --------------------------------------------------------------
// ---------------------------------------------------------------------------------

$banned_ip = array();
$banned_ip[] = '195.225.176.57';
$banned_ip[] = '212.62.19.185';
$banned_ip[] = '202.3.130.20';
$banned_ip[] = '222.104.7.196';
$banned_ip[] = '61.33.229.80';
$banned_ip[] = '63.138.25.195';
$banned_ip[] = '205.208.226.61';
$banned_ip[] = '213.46.224.101';
$banned_ip[] = '167.193.194.101';
$banned_ip[] = '207.63.100.162';
$banned_ip[] = '210.177.248.130';
$banned_ip[] = '195.225.176.57';
$banned_ip[] = '80.58.50.107';
$banned_ip[] = '80.58.33.170';
$banned_ip[] = '80.58.11.42';
$banned_ip[] = '207.63.100.163';
$banned_ip[] = '211.233.9.201';
$banned_ip[] = '82.236.86.223';
$banned_ip[] = '63.98.230.188';
$banned_ip[] = '195.228.156.106';
$banned_ip[] = '200.9.37.220';
$banned_ip[] = '200.57.91.108';
$banned_ip[] = '69.212.48.169';
$banned_ip[] = '61.0.62.4';
$banned_ip[] = '12.160.225.230';
$banned_ip[] = '219.93.174.101';
$banned_ip[] = '203.162.27.199';
$banned_ip[] = '66.94.81.202';
$banned_ip[] = '210.113.222.227';
$banned_ip[] = '59.23.9.141';
$banned_ip[] = '58.227.196.150';
$banned_ip[] = '59.23.9.141';
$banned_ip[] = '218.26.207.66';
$banned_ip[] = '84.254.189.37';
$banned_ip[] = '203.162.27.195';
$banned_ip[] = '202.101.173.69';
$banned_ip[] = '203.145.159.45';
$banned_ip[] = '63.138.25.195';
$banned_ip[] = '207.63.100.162';
$banned_ip[] = '80.56.174.130';
$banned_ip[] = '211.53.64.127';
$banned_ip[] = '200.2.128.2';
$banned_ip[] = '204.113.91.19';

// Bad word filter for guestbook -----------------------------------------------------

$gbBadWordsKey = 0;           // Set "1" to filter bad words, "0" to not filter
$gbBadWords = array(
  "ass",
  "bitch",
  "clit",
  "cock",
  "c0ck",
  "cum",
  "cunt",
  "fucking",
  "fuck",
  "fuking",
  "fuk");
  
// Spam Detection -------------------------------------------------------------------

$gbSpamKey = 1;               // Set "1" to Block Spam based on Keyword entered
$gbSpam = array (
  "cheap",
  "phentermine",
  "splinder",
  "hydrocodone",
  "vicodin",
  "vicodin",
  "pharmacy",
  "prescription",
  "buy",
  "drug",
  "pills",
  "soma");

// End of Configuration File --------------------------------------------------------


?>
