//////////////////////////////////////////
//
//  MOD for phpMyChat 0.14.6 beta
//  
//  Created by Pedram Soheil
//     DigiOz Multimedia
//   http://www.digioz.com
//
//////////////////////////////////////////


List of Modifications Made:
---------------------------
- Additional Database added for storing of Configuration Variables.
- Option added to Admin Panel for changing settings of chatroom over the web through admin panel. 
- Search feature added to admin panel to allow admin to search by:
	* Username
	* IP Address
	* Permissions
	* Gender
- Admin Chat View Page Added for admin panel, to allow admin to see all private messages posted in chatrooms.

Installation:
-------------
1- Install the standard phpMyChat Code 0.14.6 to the desired location. 
2- Create an additional table using the "c_config.sql" SQL file provided in this zip file.
3- Replace your current "/chat/config/config.lib.php" with the one provided in this zip file. Make sure to keep a copy of it somewhere for later use. 
4- Change the following settings at the top of the new "config.lib.php" file to the ones from your old "config.lib.php" file. 
5- Replace your current "/chat/admin/" folder with the one provided in this zip file. Make sure to KEEP your old admin folder, just in case something goes wrong and you need to roll the admin panel back to the way it was. 

That's it. Give it a try now and see if it works out for you. 


/////////////////////////////////////////////
// IMPORTANT: THIS MOD IS PROVIDED AS IS! 
// THERE IS NO GUARANTEE THAT IT WILL WORK 
// ON YOUR CHATROOM, NOR THAT IT WILL NOT 
// MESS UP YOUR CHATROOM SETTINGS, SO PLEASE 
// DO NOT COMPLAIN TO US LATER ON!
/////////////////////////////////////////////

