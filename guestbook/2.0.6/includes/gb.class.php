<?php

if(!defined('IN_GB')) {
   die('Direct access not permitted');
}

// Guestbook Entry Object Class to be JSON Serialized and Stored ---------------

class gbClass implements JsonSerializable
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
	
	// JSON Serialization support for secure data storage
	#[\ReturnTypeWillChange]
	public function jsonSerialize() {
		return [
			'id' => $this->id,
			'gbUserId' => $this->gbUserId,
			'gbDate' => $this->gbDate,
			'gbFrom' => $this->gbFrom,
			'gbEmail' => $this->gbEmail,
			'gbMessage' => $this->gbMessage,
			'gbHideEmail' => $this->gbHideEmail
		];
	}
	
	// Create object from JSON data
	public static function fromArray($data) {
		$obj = new self();
		$obj->id = isset($data['id']) ? $data['id'] : '';
		$obj->gbUserId = isset($data['gbUserId']) ? $data['gbUserId'] : '';
		$obj->gbDate = isset($data['gbDate']) ? $data['gbDate'] : '';
		$obj->gbFrom = isset($data['gbFrom']) ? $data['gbFrom'] : '';
		$obj->gbEmail = isset($data['gbEmail']) ? $data['gbEmail'] : '';
		$obj->gbMessage = isset($data['gbMessage']) ? $data['gbMessage'] : '';
		$obj->gbHideEmail = isset($data['gbHideEmail']) ? $data['gbHideEmail'] : false;
		return $obj;
	}
}

// End Guestbook Entry Object Class --------------------------------------

?>
