<?php

if(!defined('IN_GB')) {
   die('Direct access not permitted');
}

// User Login Object Class to be Serialized and Stored ---------------

class userClass
{
	var $id;
	var $email;
	var $password;
	var $name;
	var $address;
	var $city;
	var $state;
	var $zip;
	var $country;
	var $phone;

	// Set the User Login Field Variables -------

	function setUserVars($email, $password, $name, $address, $city, $state, $zip, $country, $phone)
	{
		$this->id = getGUID();
		$this->email = $email;
		$this->password = $password;
		$this->name = stripslashes($name);
		$this->address = stripslashes($address);
		$this->city = stripslashes($city);
		$this->state = stripslashes($state);
		$this->zip = stripslashes($zip);
		$this->country = stripslashes($country);
		$this->phone = stripslashes($phone);
	}
}

// End User Login Object Class --------------------------------------

?>
