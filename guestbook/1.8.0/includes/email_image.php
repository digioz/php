<?php

/**
 * email_display.php
 * 
 * Displays an image of the given email address ($_GET['email'])
 * using GD. If the email length is over 32 characters, it is truncated.
 * ascii_to_text() is used to convert the string.
 * 
 * @author 		DigiOz Guestbook, Mark Skilbeck (http://mahcuz.com)
 * @copyright 	DigiOz.com, 2009.
 * @return 			
 */

# Include the functions.php file.
require('functions.php');

# The email address, provided via GET. Defaults to noemail@gmail.com
$email = (isset($_GET['email'])) ? ascii_to_text($_GET['email']) : 'noemail@gmail.com';
# Email length; used for truncation.
$email_length = strlen($email);

# Truncate the email if it is too long.
if ($email_length >= 32)
{
	$email = substr($email, 0, 29) . '...';
}

# Set our header type: png.
header('Content-type: image/png');

# Image resource.
$image = imagecreatetruecolor(200, 11);
# Transparent background
$bk = imagecolorallocate($image, 0, 0, 0);
	  imagecolortransparent($image, $bk);
# Add text
$text_color = imagecolorallocate($image, 1, 1, 1);
imagestring($image, 2, 1, -1, $email, $text_color);


imagepng($image);

?>