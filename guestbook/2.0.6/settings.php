<?php

define('IN_GB', TRUE);

// Use unified secure session handling
include("includes/security_headers.php");
include("includes/secure_session.php");
include("includes/functions.php");
include("includes/config.php");

// Start secure session AFTER class/function includes needed for session objects
startSecureSession();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['language_selected'])) {
    $posted = trim($_POST['language_selected']);

    if ($posted !== '' && $posted !== 'Select Language') {
        // Find matching display name and store related file + code
        foreach ($language_array as $lang) { // [DisplayName, Code, File, Locale, Charset]
            if ($lang[0] === $posted) {
                $_SESSION['language_selected'] = $lang[0];
                $_SESSION['language_selected_file'] = $lang[2];
                $_SESSION['language_selected_code'] = $lang[1];
                break;
            }
        }
    }
}

header('Location: list.php?page=1&order=asc');
exit;