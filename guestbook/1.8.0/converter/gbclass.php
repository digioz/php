<?php

// Guestbook Entry Object Class to be Serialized and Stored ---------------

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
        return $this->gbDate;
     }
     
     // Show the Guestbook Entry From -----------------
     
     function showFrom()
     {
        return stripslashes($this->gbFrom);
     }
     
     // Show the Guestbook Entry Email ----------------
     
     function showEmail()
     {
        return $this->gbEmail;
     }
     
     // Show the Guestbook Entry Message --------------
     
     function showMessage()
     {
        return smiley_face(stripslashes($this->gbMessage));
     }
}

// End Guestbook Entry Object Class --------------------------------------

?>
