<?php

if(!defined('IN_GB')) {
   die('Direct access not permitted');
}

// Encryption middleware ------------------------------------------------------------
function gbEncrypt($plaintext) {
    global $data_encryption_enabled, $data_encryption_key;
    if (empty($data_encryption_enabled)) { return $plaintext; }
    $key = hash('sha256', (string)$data_encryption_key, true); // 32 bytes
    $iv = random_bytes(16);
    $ciphertext = openssl_encrypt($plaintext, 'AES-256-CBC', $key, OPENSSL_RAW_DATA, $iv);
    if ($ciphertext === false) { return $plaintext; }
    return base64_encode($iv . $ciphertext);
}

function gbDecrypt($ciphertextB64) {
    global $data_encryption_enabled, $data_encryption_key;
    if (empty($data_encryption_enabled)) { return $ciphertextB64; }
    $raw = base64_decode($ciphertextB64, true);
    if ($raw === false || strlen($raw) < 17) { return $ciphertextB64; }
    $iv = substr($raw, 0, 16);
    $cipher = substr($raw, 16);
    $key = hash('sha256', (string)$data_encryption_key, true);
    $plain = openssl_decrypt($cipher, 'AES-256-CBC', $key, OPENSSL_RAW_DATA, $iv);
    return $plain === false ? $ciphertextB64 : $plain;
}

function writeDataFile($filename, $content) {
    $payload = gbEncrypt($content);
    $result = @file_put_contents($filename, $payload); // no LOCK_EX to avoid hangs on some FS
    return $result !== false;
}

function appendDataFile($filename, $content) {
    global $data_encryption_enabled;
    if (empty($data_encryption_enabled)) {
        // Plain append when encryption disabled
        $result = @file_put_contents($filename, $content, FILE_APPEND);
        return $result !== false;
    }
    // When encryption is enabled, read, append, then write full encrypted content
    $existing = readDataFile($filename);
    $payload = $existing . $content;
    return writeDataFile($filename, $payload);
}

function readDataFile($filename) {
    if (!file_exists($filename) || filesize($filename) == 0) { return ''; }
    $raw = file_get_contents($filename);
    if ($raw === false) { return ''; }
    // Try decrypt; if fails, return raw (supports legacy plaintext)
    $maybe = gbDecrypt($raw);
    // Heuristic: if decryption returned empty but file not empty, trust decryption result anyway
    return $maybe;
}

// Check to see if email address is valid --------------------------------
function checkmail($youremail)
{
    $youremail_clean = stripslashes(trim($youremail));
    return filter_var($youremail_clean, FILTER_VALIDATE_EMAIL) !== false;
}

// Smiley face insertion function --------------------------------------

function smiley_face($yourmessage)
{
	$i = 0;
	$ubb1 = array( "[b]", "[B]", "[/b]", "[/B]", "[u]", "[U]", "[/u]", "[/U]", "[i]", "[I]", "[/i]", "[/I]", "[center]", "[CENTER]", "[/center]", "[/CENTER]" );
	$ubb2 = array( "<b>", "<B>", "</b>", "</B>", "<u>", "<U>", "</u>", "</U>", "<i>", "<I>", "</i>", "</I>", "<center>", "<CENTER>", "</center>", "</CENTER>" );
	$sm1  = array( ":?:", ":D", ":?", ":cool:", ":cry:", ":shock:", ":evil:", ":!:", ":frown:", ":idea!", ":arrow:", ":lol:", ":x", ":mrgreen:", ":|", ":P", ":oops:", ":roll:", ":(", ":)", ":o", ":twisted:", ":wink:" );
	$sm2  = array( "question", "biggrin", "confused", "cool", "cry", "eek", "evil", "exclaim", "frown", "idea", "arrow", "lol", "mad", "mrgreen", "neutral", "razz", "redface", "rolleyes", "sad", "smile", "surprised", "twisted", "wink" );
	$sm3  = array( ": ?:", ":D", ":?", ":cool:", ":cry:", ":shock:", ":evil:", ":!:", ":frown:", ":idea!", ":arrow:", ":lol:", ":x", ":mrgreen:", ":|", ":P", ": oops :", ":roll:", ":(", ":)", ":o", ":twisted:", ":wink:" );

	// UBB Code Insertion and Replacing UBB tags with the appropriate HTML tag

	for ($i=0; $i<=15; $i++)
	{
		$yourmessage = str_replace($ubb1[$i], $ubb2[$i], $yourmessage);
	}

	// Inserting smiley faces for guestbook users - icons are in global images directory

	for ($i=0; $i<=22; $i++)
	{
		$yourmessage = str_replace($sm1[$i], "<img src=\"images/icon_$sm2[$i].gif\" ALT=\"$sm3[$i]\">", $yourmessage);
	}
	
	return $yourmessage;
}


// Message Cleanup function --------------------------------------

function clean_message($yourmessage)
{
	 $i = 0;
	 $rep1 = array( "<", ">", "\n", "'" );
	 $rep2 = array( "&lt;", "&gt;", "<br>", "&#39;" );

	// Disable HTML Code in message body ---------------------------------------------------------------
	// Replacing Brackets to disable the insertion of HTML in the Guestbook and breaking long words
	$yourmessage = wordbreak($yourmessage, 40);

	for ($i=0; $i<=2; $i++)
	{
		$yourmessage = str_replace($rep1[$i], $rep2[$i], $yourmessage);
	}

	$yourmessage = str_replace('"','&#34;', $yourmessage);

	return $yourmessage;
}

// Function to breakup log words in message -------------------------

function wordbreak($text, $wordsize) 
{
	if (strlen($text) <= $wordsize) { return $text; } # No breaking necessary, return original text.

	$text = str_replace("\n", "", $text); # Strip linefeeds
	$done = "false";
	$newtext = "";
	$start = 0; # Initialize starting position
	$segment = substr($text, $start, $wordsize + 1); # Initialize first segment

	while ($done == "false") 
	{
		$lastspace = strrpos($segment, " ");
		$lastbreak = strrpos($segment, "\r");

		if ( $lastspace == "" AND $lastbreak == "" ) 
		{
			$newtext .= substr($text, $start, $wordsize) . " ";
			$start = $start + $wordsize; 
		}
		else 
		{
			$last = max($lastspace, $lastbreak);
			$newtext .= substr($segment, 0, $last + 1);
			$start = $start + $last + 1;
		}

		$segment = substr($text, $start, $wordsize + 1);

		if ( strlen($segment) <= $wordsize ) 
		{
			$newtext .= $segment;
			$done = "true";
		}
	}

	$newtext = str_replace("\r", "\r\n", $newtext); # Replace linefeeds

	return $newtext;
}

// Function to filter out bad words ------------------------------------------

function swapBadWords($string) 
{
	global $gbBadWords;

	// Count the number of array element of the bad word array
	$nBadWords = sizeof($gbBadWords);

	for ($i = 0; $i < $nBadWords; $i++) 
	{
		// Grab the first letter of bad word
		$banned = substr($gbBadWords[$i], 0, 1);
		
		// Replace remaining letters of bad word
		for ($j = 1; $j < strlen($gbBadWords[$i]); $j++) 
		{
			$banned .= "*";
		}
		
		// chars replaced with *.
		$string = str_replace($gbBadWords[$i], $banned, $string);
	}
	
	return $string;
}

// Function to detect if form submitted using injection ------------------------

function check_referer($referers)
{ 
	// If there are any referrers in the list ...
	if (count($referers))
	{
		$found = false;

		// Use the browsers referrer header.
		$temp = explode("/",getenv("HTTP_REFERER"));
		$referer = $temp[2];

		if ($referer=="")
		{
			$referer = $_SERVER['HTTP_REFERER'];
			list($remove,$stuff)=split('//',$referer,2);
			list($home,$stuff)=split('/',$stuff,2);
			$referer = $home;
		}

		// Check agains list.
		for ($x=0; $x < count($referers); $x++)
		{
			if (preg_match ('/'.$referers[$x].'/', $referer))
			{
			  $found = true;
			}
		}

		// Refererer is blank.
		if ($referer =="")
		$found = false;

		return $found;
	}
	else
	{
		return true;
	}
}

// Function to detect spam keywords ------------------------------------------

function spamDetect($string)
{
	global $gbSpam;
	$cSpam = 0;

	// Count the number of array element of the bad word array
	$nSpam = sizeof($gbSpam);

	$tmpString = str_replace(" ", "", $string);
	$tmpString = strtolower($tmpString);

	for ($i = 0; $i < $nSpam; $i++) 
	{
	  $cSpam += substr_count($tmpString, $gbSpam[$i]);
	}

	if ($cSpam > 0)
	{
		return true;
	}
	else
	{
		return false;
	}
}

// Function to create the installed language array ---------------------------

function getLanguageArray($language_array)
{
	$lang_select_array = array();
	$lang_count = 0;
	$lang_count = count($language_array); 

	$lang_select_array[] = "Select Language";

	for($i=0; $i<$lang_count; $i++)
	{
		$lang_select_array[] = $language_array[$i][0];
	}
	
	return $lang_select_array;
}

function encryptPassword($password)
{
	// Use PHP's secure password_hash() function instead of weak crypt()
	return password_hash($password, PASSWORD_DEFAULT);
}

function validateLogin($username, $password, $storedHash, $salt = null)
{
	// Use PHP's secure password_verify() function
	return password_verify($password, $storedHash);
}

function getAllUsers()
{
    $filename = "data/users.txt";
    $datain = readDataFile($filename);
    if ($datain === '' ) {
        return array();
    }
    $out = explode("<!-- E -->", $datain);
    $outCount = count($out) - 1;
    $lines = array();

    for ($i=0; $i<$outCount; $i++)
    {
        $raw = trim($out[$i]);
        if ($raw === '') continue;

        // Try JSON first (new format)
        $data = json_decode($raw, true);
        if (is_array($data)) {
            $user = userClass::fromArray($data);
            if ($user) $lines[] = $user;
            continue;
        }

        $legacy = @unserialize($raw, ["allowed_classes" => ["userClass"]]);
        if ($legacy instanceof userClass) {
            $lines[] = $legacy;
        }
    }
    return array_filter($lines);
}

function getUserByEmail($email)
{   
    $users = getAllUsers();
    $emailNorm = strtolower($email);
    
    foreach ($users as $user) 
    {
        if ($user != null && isset($user->email) && strtolower($user->email) == $emailNorm)
        {   
            return $user;
        }
    }
    
    return null;
}

function getUserById($id)
{
	$users = getAllUsers();
	
	foreach ($users as $user) 
	{		
		if ($user != null && $user->id == $id)
		{	
			return $user;
		}
	}
	
	return null;
}

function getGUID(){
    if (function_exists('com_create_guid'))
	{
        return com_create_guid();
    }
	else
	{
        // Use cryptographically secure random bytes for GUID generation
        return sprintf('{%04X%04X-%04X-%04X-%04X-%04X%04X%04X}',
            random_int(0, 65535), random_int(0, 65535),
            random_int(0, 65535),
            random_int(16384, 20479), // 4xxx
            random_int(32768, 49151), // 8xxx, 9xxx, Axxx or Bxxx
            random_int(0, 65535), random_int(0, 65535), random_int(0, 65535)
        );
    }
}

function getAllPosts()
{
    $filename = "data/list.txt";
    $datain = readDataFile($filename);
    if ($datain === '') { return array(); }
    $lines = array();

    $out = explode("<!-- E -->", $datain);
    $outCount = count($out) - 1;

    for ($i=0; $i<$outCount; $i++)
    {
        if (trim($out[$i]) !== '') {
            $data = json_decode($out[$i], true);
            if ($data !== null) {
                $lines[] = gbClass::fromArray($data);
            }
        }
    }
    return array_filter($lines);
}

function isUserPostOwner($postid, $userid)
{
	$allPosts = getAllPosts();
	
	foreach ($allPosts as &$post) 
	{
		if ($post != null && $post->id == $postid && $post->gbUserId == $userid)
		{
			return true;
		}
		
	}
	
	return false;
}

function deletePostById($postid, $userid)
{
    $datanew = "";
    $allPosts = getAllPosts();
    foreach ($allPosts as $post) 
    {
        if ($post != null && $post->id != $postid)
        {
            $datanew .= json_encode($post) . "<!-- E -->";
        }
    }
    writeDataFile("data/list.txt", $datanew);
    return;
}

function updatePostById($postid, $userid, $newMessage, $newHideEmail = null)
{
    $allPosts = getAllPosts();
    $datanew = "";
    $updated = false;

    foreach ($allPosts as $post) {
        if ($post == null) { continue; }
        if ($post->id === $postid && $post->gbUserId === $userid) {
            $post->gbMessage = $newMessage;
            if ($newHideEmail !== null) {
                $post->gbHideEmail = (bool)$newHideEmail;
            }
            $updated = true;
        }
        $datanew .= json_encode($post) . "<!-- E -->";
    }

    writeDataFile("data/list.txt", $datanew);
    return $updated;
}

// Security Functions -----------------------------------------------------

/**
 * Validate and sanitize input data
 * @param mixed $input The input to validate
 * @param string $type The type of validation (email, string, int, etc.)
 * @param int $maxLength Maximum allowed length
 * @return mixed Sanitized input or false if invalid
 */
function validateInput($input, $type, $maxLength = null) {
    if ($input === null || $input === '') {
        return '';
    }
    
    $input = trim($input);
    
    switch($type) {
        case 'email':
            $input = filter_var($input, FILTER_VALIDATE_EMAIL);
            if (!$input) return false;
            break;
            
        case 'string':
            // Remove null bytes and control characters
            $input = str_replace(["\0", "\r"], '', $input);
            break;
            
        case 'int':
            $input = filter_var($input, FILTER_VALIDATE_INT);
            if ($input === false) return false;
            break;
            
        case 'filename':
            // Validate filename - only allow alphanumeric, dots, hyphens, underscores
            if (!preg_match('/^[a-zA-Z0-9._-]+$/', $input)) {
                return false;
            }
            break;
    }
    
    if ($maxLength && strlen($input) > $maxLength) {
        return false;
    }
    
    return $input;
}

/**
 * Sanitize output for HTML display to prevent XSS
 * @param string $string The string to sanitize
 * @return string Sanitized string
 */
function sanitizeOutput($string) {
    return htmlspecialchars($string, ENT_QUOTES | ENT_HTML5, 'UTF-8');
}

/**
 * Validate theme name against whitelist
 * @param string $theme Theme name
 * @return string Valid theme name
 */
function validateTheme($theme) {
    $allowedThemes = ['default', 'bootstrap', 'simple'];
    return in_array($theme, $allowedThemes) ? $theme : 'default';
}

/**
 * Validate language file against whitelist
 * @param string $language Language filename
 * @param array $allowedLanguages Array of allowed language files
 * @return string Valid language filename
 */
function validateLanguage($language, $allowedLanguages) {
    $validLanguages = array_column($allowedLanguages, 2);
    return in_array($language, $validLanguages) ? $language : 'language.php';
}

/**
 * Generate cryptographically secure random filename
 * @param string $extension File extension
 * @return string Secure filename
 */
function generateSecureFilename($extension) {
    return bin2hex(random_bytes(16)) . '.' . $extension;
}

/**
 * Validate file upload
 * @param array $file $_FILES array element
 * @param array $allowedTypes Allowed MIME types
 * @param int $maxSize Maximum file size in bytes
 * @return array Result array with success boolean and message
 */
function validateFileUpload($file, $allowedTypes, $maxSize = 5242880) { // 5MB default
    if ($file['error'] !== UPLOAD_ERR_OK) {
        return ['success' => false, 'message' => 'Upload error occurred'];
    }
    
    if ($file['size'] > $maxSize) {
        return ['success' => false, 'message' => 'File too large'];
    }
    
    // Check MIME type
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mimeType = finfo_file($finfo, $file['tmp_name']);
    finfo_close($finfo);
    
    if (!in_array($mimeType, $allowedTypes)) {
        return ['success' => false, 'message' => 'File type not allowed'];
    }
    
    return ['success' => true, 'mime_type' => $mimeType];
}


?>

