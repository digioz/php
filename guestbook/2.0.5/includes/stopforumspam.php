<?php

if(!defined('IN_GB')) {
   die('Direct access not permitted');
}

/**
 * StopForumSpam
 *
 * Wrapper class for stopforumspam.com API. Uses json internally.
 *
 * @author Armin Rosu
 * @copyright 2011, Armin Rosu
 * @license http://www.opensource.org/licenses/BSD-3-Clause BSD 3-Clause License
 * @link http://www.stopforumspam.com/usage API Reference
 * @version 0.1
 */

class StopForumSpam
{
    /**
    * The API key.
    *
    * @var string
    */
    private $api_key;

    /**
    * The base url, for tha API/
    *
    * @var string
    */
    private $endpoint = 'http://www.stopforumspam.com/';


    /**
    * Constructor.
    *
    * @param string $api_key Your API Key, optional (unless adding to database).
    */
    public function __construct( $api_key = null ) {
        // store variables
        $this->api_key = $api_key;
    }

    /**
    * Add to the database
    *
    * @param array $args associative array containing email, ip, username and optionally, evidence
    * e.g. $args = array('email' => 'user@example.com', 'ip_addr' => '8.8.8.8', 'username' => 'Spammer?', 'evidence' => 'My favourite website http://www.example.com' );
    * @return boolean Was the update succesfull or not.
    */
    public function add( $args )
    {
        // check for mandatory arguments
        if (empty($args['username']) || empty($args['ip_addr']) || empty($args['email']) ) {
            return false;
        }

        // known?
        $is_spammer = $this->is_spammer($args);
        if (!$is_spammer || $is_spammer['known']) {
            return false;
        }

        // add api key
        $args['api_key'] = $this->api_key;

        // url to poll
        $url = $this->endpoint.'add.php?'.http_build_query($args, '', '&');

        // execute
        $response = file_get_contents($url);

        return (false == $response ? false : true);
    }

    /**
    * Get record from spammers database.
    *
    * @param array $args associative array containing either one (or all) of these: username / email / ip.
    * e.g. $args = array('email' => 'user@example.com', 'ip' => '8.8.8.8', 'username' => 'Spammer?' );
    * @return object Response.
    */
    public function get( $args )
    {
        // should check first if not already in database

        // url to poll
        $url = $this->endpoint.'api?f=json&'.http_build_query($args, '', '&');

        //
        return $this->poll_json( $url );
    }

    /**
    * Check if either details correspond to a known spammer. Checking for username is discouraged.
    *
    * @param array $args associative array containing either one (or all) of these: username / email / ip
    * e.g. $args = array('email' => 'user@example.com', 'ip' => '8.8.8.8', 'username' => 'Spammer?' );
    * @return boolean
    */
    public function is_spammer( $args )
    {
        // poll database
        $record = $this->get( $args );

        if ( !isset($record->success) ) {
            return false;
        }

        // give the benefit of the doubt
        $spammer = false;

        // are all datapoints on SFS?
        $known = true;

        // parse database record
        $datapoint_count = 0;
        $known_datapoints = 0;
        foreach( $record as $datapoint )
        {
            // not 'success'
            if ( isset($datapoint->appears) ) {
                $datapoint_count++;

                // are ANY of the datapoints on SFS?
                if ( $datapoint->appears == true)
                {
                    $known_datapoints++;
                    $spammer = true;
                }
            }
        }

        // are ANY of the datapoints not on SFS
        if ( $datapoint_count > $known_datapoints) {
            $known = false;
        }

        return array(
            'spammer' => $spammer,
            'known' => $known
        );
    }

    /**
    * Get json and decode. Currently used for polling the database, but hoping for future
    * json response support, when adding.
    *
    * @param string $url The url to get
    * @return object Response.
    */
    protected static function poll_json( $url )
    {
        $json = file_get_contents( $url );
        $object = json_decode($json);

        return $object;
    }
	
	/**
	*
	*/
	
	public static function getUserIP()
	{
		$client  = @$_SERVER['HTTP_CLIENT_IP'];
		$forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
		$remote  = $_SERVER['REMOTE_ADDR'];

		if(filter_var($client, FILTER_VALIDATE_IP))
		{
			$ip = $client;
		}
		elseif(filter_var($forward, FILTER_VALIDATE_IP))
		{
			$ip = $forward;
		}
		else
		{
			$ip = $remote;
		}

		return $ip;
	}
}
?>