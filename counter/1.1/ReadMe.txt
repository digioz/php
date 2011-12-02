Thank You for Choosing the DigiOz Graphic PHP Counter Version 1.1. 

Requirements:
-------------
For the counter script to work, it will have to be used inside of a PHP file. 
Simply open the PHP file where you want to insert the counter, and paste the
following code where you want the counter to appear:

<?php
include("counter/counter.php"); 
?>


What's New in Version 1.1:
--------------------------
- Worked on the counter.txt file locking to fix a bug that would reset the counter 
  if two people try to write to it at the same time
- Added domain URL and change file path to absolute path to enable placement of 
  counter anywhere at any level on a website
- Created a seperate configuration file "config.php" to set the counter settings in.

Contents of this zip file:
--------------------------

changelog.log - List of all the changes made to the counter script so far
counter.php   - The PHP file that processes new counting
counter.txt   - This is where the page count is stored
index.php     - Displays the actual counter
ReadMe.txt    - Tells you what's what and walks you through the whole script
style.css     - Style Sheet for the counter page, which can be replaced with your own

Installation Instructions:
--------------------------

1- Download and Extract the file counter.zip into a temporary folder on your PC.
2- Using an FTP Software like WS_FTP, transfer the "counter" folder with all its 
   contents onto your web server. 
3- CHMOD the file "counter.txt" to 755 (give read, write and execute permission to file)
4- Make sure that the remaining files in the above list have read and execute permission.
5- Open the file index.php in the counter folder and view the counter.


Using different style of counter:
---------------------------------
To switch the style of counter open the file "counter.php" and modify the following:

$style = 2;             // Change this number to the folder number of the style you like to use
$file  = "counter.txt"; // If you want to use a different file name to store the count modify counter.txt file name to whatever file name you want.

If you want to create your own counter images, create them in photoshop or any other paint software, then save them in the "images" folder with a new folder number (like 7) as 0.gif, 1.gif, etc. You can then specify this number in front of the "$style" variable to use your own counter images.


Questions or Feedback:
----------------------

If you have any questions, comments or problems about this script or if you are having
problems installing the script, email us at digi_oz@yahoo.com or visit us on the web at
http://www.digioz.com and fill out the Suggestions Form on our site. Enjoy!!!
