<?php

if(!defined('IN_GB')) {
   die('Direct access not permitted');
}
 
class csrf 
{
	/*
	* This function get the token id from the 
	* users session, if one has not already 
	* been created then it generates a random token.
	*/
	public function get_token_id() 
	{
		if(isset($_SESSION['token_id'])) 
		{ 
			return $_SESSION['token_id'];
		} 
		else 
		{
			$token_id = $this->random(10);
			$_SESSION['token_id'] = $token_id;
			return $token_id;
		}
	}
	
	/*
	* This function gets the token value, if 
	* one has not already been generated then 
	* it generates one.
	*/
	public function get_token() 
	{
		if(isset($_SESSION['token_value'])) 
		{
			return $_SESSION['token_value']; 
		} 
		else 
		{
			$token = hash('sha256', $this->random(500));
			$_SESSION['token_value'] = $token;
			return $token;
		}
	}
	
	/*
	* This function is used to check if the token id 
	* and the token value are valid. It does this by 
	* checking the values of the GET or POST request 
	* with the values stored in the users SESSION variable.
	*/
	public function check_valid($method) 
	{
		if($method == 'post' || $method == 'get') 
		{
			$post = $_POST;
			$get = $_GET;
			
			if(isset(${$method}[$this->get_token_id()]) && (${$method}[$this->get_token_id()] == $this->get_token())) 
			{
				return true;
			} 
			else 
			{
				return false;   
			}
		} 
		else 
		{
			return false;   
		}
	}
	
	/*
	* This is the second defence against CSRF. This 
	* function generates random names for the form fields.
	*/
	public function form_names($names, $regenerate) 
	{
		$values = array();
		
		foreach ($names as $n) 
		{
			if($regenerate == true) 
			{
				unset($_SESSION[$n]);
			}
			
			$s = isset($_SESSION[$n]) ? $_SESSION[$n] : $this->random(10);
			$_SESSION[$n] = $s;
			$values[$n] = $s;       
		}
		
		return $values;
	}
	
	/*
	* This function generates a random string using the 
	* linux random file for more entropy.
	*/
	private function random($len) 
	{
		if (@is_readable('/dev/urandom')) 
		{
			$f = fopen('/dev/urandom', 'r');
			$urandom = fread($f, $len);
			fclose($f);
		}
 
		$return = '';
		
		for ($i=0; $i<$len; ++$i) 
		{
			if (!isset($urandom)) 
			{
				if ($i % 2 == 0) mt_srand(time() % 2147 * 1000000 + (double)microtime() * 1000000);
				$rand = 48 + mt_rand() % 64;
			} 
			else 
			{
				$rand = 48 + ord($urandom[$i]) % 64;
			}

			if ($rand>57)
			{
				$rand += 7;
			}
			
			if ($rand>90)
			{
				$rand += 6;
			}

			if ($rand==123) 
			{
				$rand = 52;
			}
			
			if ($rand==124) 
			{
				$rand = 53;
			}
			
			$return.=chr($rand);
		}
		
		return $return;
	}
}