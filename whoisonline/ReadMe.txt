DigiOz Who Is Online Script Version 1.0
---------------------------------------

The DigiOz Who Is Online Script is a very simple PHP / MySQL
Driven script that shows how many visitors your site has at
any given time. To use this script, you will have to include
it on every PHP page your site is using, to allow the code 
to update the database whoisonline table with new visitor
count. 

Requirements:
-------------
* MySQL 3.23.x or higher.
* PHP 4.0.x or higher. 

Installation:
-------------
1- Open the file "whoisonline_config.php" in notepad, and 
   change all the database connection variables and purge
   settings in that file. 

2- Place The following files in the root directory of your
   server, where you intend to use the code:

	* dbclass.php
	* install.php
	* whoisonline.php
	* whoisonline_config.php

2- Navigate to install.php in your browser. All you database
   connectivity variables should already be filled out for 
   you. Simply hit "submit" to create the specified database
   and table. 

3- REMOVE the file "install.php" from your server COMPLETELY. 
   This is done for security reason. The script WILL NOT WORK
   If you don't remove this file. 

Enjoy It!

  