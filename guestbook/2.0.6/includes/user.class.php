<?php

if(!defined('IN_GB')) {
   die('Direct access not permitted');
}

// User Login Object Class to be JSON Serialized and Stored ---------------

class userClass implements JsonSerializable
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
	
	// JSON Serialization support for secure data storage
	#[\ReturnTypeWillChange]
	public function jsonSerialize() {
		return [
			'id' => $this->id,
			'email' => $this->email,
			'password' => $this->password,
			'name' => $this->name,
			'address' => $this->address,
			'city' => $this->city,
			'state' => $this->state,
			'zip' => $this->zip,
			'country' => $this->country,
			'phone' => $this->phone
		];
	}
	
	// Create object from JSON data
	public static function fromArray($data) {
		$obj = new self();
		$obj->id = isset($data['id']) ? $data['id'] : '';
		$obj->email = isset($data['email']) ? $data['email'] : '';
		$obj->password = isset($data['password']) ? $data['password'] : '';
		$obj->name = isset($data['name']) ? $data['name'] : '';
		$obj->address = isset($data['address']) ? $data['address'] : '';
		$obj->city = isset($data['city']) ? $data['city'] : '';
		$obj->state = isset($data['state']) ? $data['state'] : '';
		$obj->zip = isset($data['zip']) ? $data['zip'] : '';
		$obj->country = isset($data['country']) ? $data['country'] : '';
		$obj->phone = isset($data['phone']) ? $data['phone'] : '';
		return $obj;
	}
}

// End User Login Object Class --------------------------------------
?>
