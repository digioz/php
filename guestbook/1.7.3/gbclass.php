<?php

// Guestbook Entry Object Class to be Serialized and Stored ---------------

include("functions.php");

class gbClass
{
     var $gbDate;
     var $gbFrom;
     var $gbEmail;
     var $gbMessage;

     // Set the Guestbook Entry Field Variables -------

     function setGBVars($a,$b,$c,$d)
     {
        $this->gbDate = $a;
        $this->gbFrom = $b;
        $this->gbEmail = $c;
        $this->gbMessage = $d;
     }
     
     // Show the Guestbook Entry Date -----------------
     
     function showDate()
     {
        echo $this->gbDate;
     }
     
     // Show the Guestbook Entry From -----------------
     
     function showFrom()
     {
        echo stripslashes($this->gbFrom);
     }
     
     // Show the Guestbook Entry Email ----------------
     
     function showEmail()
     {
        echo $this->gbEmail;
     }
     
     // Show the Guestbook Entry Message --------------
     
     function showMessage()
     {
        echo smiley_face(stripslashes($this->gbMessage));
     }
}

// End Guestbook Entry Object Class --------------------------------------

?>
