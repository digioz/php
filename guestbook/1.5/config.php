<?php

// Variables for making a field optional in form -------------------------------------
$email_optional     = 0;      // Set "1" for optional email, "0" to make it required
$name_optional      = 0;      // Set "1" for optional name, "0" to make it required
$message_optional   = 0;      // Set "1" for optional message, "0" for required

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

// Variable for choosing language file name ------------------------------------------
$default_language   = "language.php";


?>
