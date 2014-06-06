//////////////////////////////////////////////////////////
///  The purpose of this script is to convert the list.txt
///  data from the old format (which was used for DigiOz
///  Guestbook 1.0 to 1.6 to the new Object Oriented 
///  Serialized format used in Guestbook Version 1.7.
//////////////////////////////////////////////////////////

The converter script currently does NOT convert smiley faces inside the messages (takes out all HTML TAGS). 

To Use, do the following:

1- Download and Install the DigiOz Guestbook 1.7 to your server.
2- Place your old "list.txt" inside the converter directory.
3- Create a text file called "list_converted.txt" and place it the converter directory as "list.txt".
4- CHMOD "list_converted.txt" to 777 (give it read, write and execute permission). 
5- Run converter.php through the web. The code will display a message when it is done. ONLY RUN IT ONCE. DO NOT REFRESH THE BROWSER.
6- Delete the old "list.txt" from the directory, and rename the "list_converted.txt" to "list.txt", and move it into the "data"
   folder of the guestbook directory. 
   
That's it! Now run the guestbook and enjoy! :D

 

