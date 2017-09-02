<?php

if(!defined('IN_GB')) {
   die('Direct access not permitted');
}

// Guestbook Entry Object Class to be Serialized and Stored ---------------

class gbClass
{
     var $gbDate;
     var $gbFrom;
     var $gbEmail;
     var $gbMessage;
	 var $gbHideEmail;

     // Set the Guestbook Entry Field Variables -------

     function setGBVars($a,$b,$c,$d,$e)
     {
        $this->gbDate = $a;
        $this->gbFrom = stripslashes($b);
        $this->gbEmail = $c;
        $this->gbMessage = smiley_face(stripslashes($d));
		$this->gbHideEmail = $e;
     }
}

// End Guestbook Entry Object Class --------------------------------------

?>
