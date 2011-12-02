Thank You for Choosing the DigiOz Guestbook version 1.5. 


What's New in DigiOz Guestbook Version 1.5:                                                                      
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

Contents of this zip file:
--------------------------

    index.php - Redirects visitors to the guestbook entry form
guestbook.php - This is the main index of the Guestbook
   config.php - Contains all the customizing and configuration settings that you can adjust
 unctions.php - Contains all functions that make the add.php file work.
      add.php - The PHP file that processes new Guestbook entries
   header.inc - This is the header of the html for the pages
   footer.inc - This is the footer of the html for the pages
     list.php - Combines header, footer and list.txt to view Guestbook Entries (New One first)
    list2.php - Combines header, footer and list.txt to view Guestbook Entries (Old One first)
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
                file from guestbook versions 1.0 - 1.2 to the new version 1.5.
     language - This folder contains the language files for the guestbook system (text labels)
       images - This folder contains all the smiley face images and other related images.

Installation Instructions:
--------------------------

1- Download and Extract the file guestbook.zip into a temporary folder on your PC.
2- Using an FTP Software like WS_FTP, transfer the "guestbook" folder with all its 
   contents onto your web server. 
3- CHMOD the file "list.txt" to 777 (give read, write and execute permission to file)
4- Make sure that the remaining files in the above list have read and execute permission.
5- Modify the "header.inc" and "footer.inc" files to match the rest of your site. You can
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

Questions or Feedback:
----------------------
If you have any questions, comments or problems about this script or if you are having
problems installing the script, email us at digi_oz@yahoo.com or visit us on the web at
http://www.digioz.com and fill out the Suggestions Form on our site. You can also get support
on our support forum at http://bb.digioz.com . Enjoy!!!



