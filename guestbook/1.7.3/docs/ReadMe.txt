Thank You for Choosing the DigiOz Guestbook version 1.7.2.

What's New in DigiOz Guestbook Version 1.7.2:
--------------------------------------------
- Browser input validation added to the following pages:
		* admin/delete.php
		* admin/delete_process.php
		* admin/view.php

What's New in DigiOz Guestbook Version 1.7.1:                                                
--------------------------------------------                                                  
- Small patch issued for previous version to prevent a security hole in the guestbook,
  which allowed an attacker to obtain the absolute path to the server directory where
  the guestbook is installed.


What's New in DigiOz Guestbook Version 1.7:
-------------------------------------------
- Guestbook Entries are now stored as OBJECTS into the text file (Pete).
- New Administrative Interface Allows Admin to Delete Guestbook Entries Safely (Pete).
- Some bug fixes on the code thanks to Mike (mr pain) and Robbert (Thank you both).
- New Search Feature Added, which allows searching by any entry field (Thanks Mike).
- Language File generator form now allows admin to create their own wording for language.
- Option added to log visitor IP and Spammer IP Number and address. 
- Ban option added based on visitor's IP Number. 
- Spam block feature added based on keyword specified by admin in config.php file.
- Optional GD Image Verification feature was added to prevent spam.  
                                                                     

Contents of this zip file:
--------------------------

    index.php - Redirects visitors to the guestbook entry form
guestbook.php - This is the main index of the Guestbook
   config.php - Contains all the customizing and configuration settings that you can adjust
  gbclass.php - Guestbook Class that creates the guestbook entry object which is stored 
		as a serialized object in the "list.txt" text file.
functions.php - Contains all functions that make the add.php file work.
      add.php - The PHP file that processes new Guestbook entries
   header.php - This is the header of the html for the pages
   footer.php - This is the footer of the html for the pages
     list.php - Combines header, footer and list.txt to view Guestbook Entries
     list.txt - This is where all entries are stored
   ReadMe.txt - Current file you are reading. Documentation of script.
changelog.log - List of all the changes made to this guestbook script since verison 1.0.
GNULicense.txt- Free Software License, which basically states that you can modify and share
                this script with others, as long as you email us back a copy of your modified
                version of the script.
    style.css - Style sheet for the guestbook system. You can replace this with your own style 
                sheet or modify the current one to fit your need.
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



