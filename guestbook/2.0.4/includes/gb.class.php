<?php

if(!defined('IN_GB')) {
   die('Direct access not permitted');
}

// Guestbook Entry Object Class to be Serialized and Stored ---------------

class gbClass
{
	var $id;
	var $gbUserId;
	var $gbDate;
	var $gbFrom;
	var $gbEmail;
	var $gbMessage;
	var $gbHideEmail;

	// Set the Guestbook Entry Field Variables -------

	function setGBVars($gbdate,$gbfrom,$gbemail,$gbmessage,$gbhideemail, $gbuserid)
	{
		$this->id = getGUID();
		$this->gbDate = $gbdate;
		$this->gbFrom = stripslashes($gbfrom);
		$this->gbEmail = $gbemail;
		$this->gbMessage = smiley_face(stripslashes($gbmessage));
		$this->gbHideEmail = $gbhideemail;
		$this->gbUserId = $gbuserid;
	}
}

// End Guestbook Entry Object Class --------------------------------------

?>
