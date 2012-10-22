<?php
//start session 
session_start(); 
  
//define your string 
$string = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789"; 
  
//generate the code 
$rand = substr(str_shuffle($string), 0, 5); 
  
//put the md5 hash of the code into a session 
$_SESSION['image_random_value'] = md5($rand); 
  
// choose background image 
$bgNum = rand(1, 5); 
$image = imagecreatefromjpeg("images/back$bgNum.jpg"); 
  
  
// Make text color blak 
$textColor = imagecolorallocate ($image, 0, 0, 0); 
  
//put the code onto the background 
imagestring ($image, 5, 5, 8, $rand, $textColor); 
  
//send headers 
// Date in the past 
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); 
  
// always modified 
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); 
  
// HTTP/1.1 
header("Cache-Control: no-store, no-cache, must-revalidate"); 
header("Cache-Control: post-check=0, pre-check=0", false); 
  
// HTTP/1.0 
header("Pragma: no-cache"); 
  
  
// send the content type header so the image is displayed as a jpeg 
header('Content-type: image/jpeg'); 
  
// send the image to the browser 
imagejpeg($image); 
  
// destroy the image 
imagedestroy($image); 
?>
