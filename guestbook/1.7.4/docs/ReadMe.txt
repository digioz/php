Thank You for Choosing the DigiOz Guestbook version 1.7.3.

Changes in DigiOz Guestbook Version 1.7.3:
------------------------------------------
add.php 	  - Added additional sanitization to the log write code
config.php 	  - moved the Guestbook version into this file
footer.php 	  - Removed the version of the Guestbook from this file to make it more 
			    difficult for hackers to identify the guestbook version. 
sanitize.php  - Adds additional data sanitization functions to prevent XSS and script
			    injection and remove special characters.
search.php 	  - Added additional data sanitation check to this file and fixed the paging issue.				
changelog.log - Removed this file and combined it with ReadMe.txt file for ease of 
				maintenance.

Changes in DigiOz Guestbook Version 1.7.2:
------------------------------------------
- Browser input validation added to the following pages:
		* admin/delete.php
		* admin/delete_process.php
		* admin/view.php

Changes in DigiOz Guestbook Version 1.7.1:                                                
------------------------------------------                                                 
- Small patch issued for previous version to prevent a security hole in the guestbook,
  which allowed an attacker to obtain the absolute path to the server directory where
  the guestbook is installed.


Changes in DigiOz Guestbook Version 1.7:
----------------------------------------
- Guestbook Entries are now stored as OBJECTS into the text file (Pete).
- New Administrative Interface Allows Admin to Delete Guestbook Entries Safely (Pete).
- Some bug fixes on the code thanks to Mike (mr pain) and Robbert (Thank you both).
- New Search Feature Added, which allows searching by any entry field (Thanks Mike).
- Language File generator form now allows admin to create their own wording for language.
- Option added to log visitor IP and Spammer IP Number and address. 
- Ban option added based on visitor's IP Number. 
- Spam block feature added based on keyword specified by admin in config.php file.
- Optional GD Image Verification feature was added to prevent spam.  

Changes in in DigiOz Guestbook Version 1.6:
-------------------------------------------                                                 
- Bad word filter was added to the guestbook system.                                        
- Messsage flooding prevention was added to the system.                                     
- German Language file translation corrected.                                               
                                                                                            
Changes in in DigiOz Guestbook Version 1.5:                                                 
-------------------------------------------                                                 
- Language files included for guestbook for the following languages were added:             
	- Danish                                                                            
	- Swedish                                                                           
	- Greek                                                                             
- Email notification of administator was added.                                             
- Option added for making Email, Name and/or Message optional.                              
- All configuration adjustments can now be made from config.php file.                       
- All functions moved to the "functions.php" file for easier inclusion.                     
- New PHP file "index.php" was added which redirects visitor to the entry fom. It aslo      
  Provides additional security by not allowing visitors to access the guestbook directory.  
- GNU License was added to the script in order to make this code officially open source.    
- HTML tags are now disabled in Name field                                                  
                                                                                            
Changes in in DigiOz Guestbook Version 1.4:                                                 
-------------------------------------------                                                 
- Language files included for guestbook for the following languages:                        
	- English                                                                           
	- German                                                                            
	- Dutch                                                                             
	- Philippino                                                                        
- JavaScript Smiley insertion buttons added to the entry add form                           
- UBB Code added for BOLD, UNDERLINED, ITALIC, and CENTER formatting                        
  of text entered in the guestbook                                                          
                                                                                            
DigiOz Guestbook Version 1.3 Changelog:                                                     
---------------------------------------                                                     
-Your Name entered will now have to be 40 or less characters.                               
-Your Email entered will now have to be 40 or less characters.                              
-You will have to entere an email address in the proper format                              
 for the scrip to add the entry to the guestbook.                                           
-Any words longer then 25 characters will now be broken up, to                              
 avoid the resizing of the table with of the guestbook by odd                               
 length word entries.                                                                       
                                                                                            
DigiOz Guestbook Version 1.2 Changelog:                                                     
---------------------------------------                                                     
- System dynamically breaks guestbook entries into pages.                                   
- You can choose how many guestbook entries per page you would like to view.                
                                                                                            
- Some display formatting was done on the file add.php to allow better viewing of results.  
                                                                                            
DigiOz Guestbook Version 1.1 Changelog:                                                     
---------------------------------------                                                     
                                                                                            
- Option of the display New Entries First (on top of page) added                            
- Option to display New Entries Last (bottom of page) added                                 
- Problem with displaying double and single quotes fixed                                    
- HTML insertion in the body of guestbook entries has been disabled                         
- Smilie Face feature added to convert :) :( :o to smiley images.                           
- Default table background color changed from gray to white.                                
- Each Guestbook Entry is now stored on a new line in the list.txt file(Data Storage Change)                                                                     

Description of some important files in this zip:
------------------------------------------------

add.php 	- The PHP file that processes new Guestbook entries
ban.php 	- Script that loops through the various banned IP's and bans the users with those IP
config.php 	- Contains all the customizing and configuration settings that you can adjust
footer.php 	- This is the footer of the html for the pages
functions.php 	- Contains all functions that make the add.php file work.
gbclass.php 	- Guestbook Class that creates the guestbook entry object which is stored 
		  as a serialized object in the "list.txt" text file.
guestbook.php 	- This is the main index of the Guestbook
header.php 	- This is the header of the html for the pages
index.php 	- Redirects visitors to the guestbook entry form
list.php 	- Combines header, footer and list.txt to view Guestbook Entries
random.php	- Generates a random image verification image for the guestbook
sanitize.php	- Additional data cleanup functions to prevent XSS and script injection
search.php	- Allows users to search for specific entries
style.css 	- Style sheet for the guestbook system. You can replace this with your own style 
		  sheet or modify the current one to fit your need.    

Data folder:
------------
     
list.txt 	- This is where all entries are stored
GNULicense.txt	- Free Software License, which basically states that you can modify and share
                  this script with others, as long as you email us back a copy of your modified
                  version of the script.

Folders:
--------
    converter - This folder contains a converter script, to convert the list.txt database
                file from guestbook versions 1.0 - 1.6 to the new version 1.7.
         data - Folder for storing all data and log files. 
     language - This folder contains the language files for the guestbook system (text labels)
       images - This folder contains all the smiley face images and other related images.
        admin - This folder contains the administrative interface for deleting guestbook posts.

Installation Instructions:
--------------------------

1- Download and Extract the file guestbook.zip into a temporary folder on your PC.
2- Using an FTP Software like WS_FTP, transfer the "guestbook" folder with all its 
   contents onto your web server.
3- CHMOD the "data" folder to 777 (give it read, write and execute permission)
4- CHMOD ALL text files in the data folder to 777 (give read, write and execute permission to file)
5- Make sure that the remaining files in the above list have read and execute permission.
6- Modify the "header.inc" and "footer.inc" files to match the rest of your site. You can
   add standard HTML tags in these two files containing the page background, font size, 
   your website's css style sheet, etc to help blend the guestbook into your site.

Customizing Language:
---------------------
The language template has been implemented into DigiOz Guestbook 1.4 and up. 
To use a different language, please open the "config.php" file, and change the
language file name to the language file name of your choice located in the "language"
directory in your guestbook. 

Making fields optional:
-----------------------
You can now make one or more fields in the guestbook optional. This is done by going to 
"config.php" file, and changing the appropriate setting for a field to "0".

Notifying the Administrator:
----------------------------
You can have the script send you a notification through email when a new entry has been
added to your guestbook. Open "config.php" file and change the appropriate setting for it.
WARNING: You will have to have the SMTP settings in php.ini file of your server configured
to use this feature. 

Please, DO NOT use Wordpad, Microsoft WORD, or any other word editing software
for this task. USE NOTEPAD ONLY!!!

If you would like to help us add support for other languages besides English to
the DigiOz Guestbook, visit http://bb.digioz.com and post a translation of guestbook
text in your native language there.

Deleting Guestbook Entries:
---------------------------
Starting with Digioz Guestbook Version 1.7, we have added an administrative interface, which 
can be used to DELETE Existing Guestbook Entries quickly and safely. You can access this 
administrative interface by going to "/guestbook/admin/index.php" path on the server that you
install the Guestbook on. THE DEFAULT USERNAME IS "admin" AND THE DEFAULT PASSWORD IS "admin". 

Questions or Feedback:
----------------------
If you have any questions, comments or problems about this script or if you are having
problems installing the script, email us at webmaster@digioz.com or visit us on the web at
http://www.digioz.com and fill out the Suggestions Form on our site. You can also get support
on our support forum at http://bb.digioz.com . Enjoy!!!



