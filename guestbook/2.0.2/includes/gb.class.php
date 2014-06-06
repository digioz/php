<?php

if(!defined('IN_GB')) {
   die('Direct access not permitted');
}

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
        $this->gbFrom = stripslashes($b);
        $this->gbEmail = $c;
        $this->gbMessage = smiley_face(stripslashes($d));
     }
}

// End Guestbook Entry Object Class --------------------------------------

?>
