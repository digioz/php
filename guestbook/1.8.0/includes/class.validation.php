<?php

/**
 *   Author:     Pedram Soheil
 *   Copmpany:   DigiOz Multimedia
 *   Website:    www.digioz.com
 *   Created:    03-26-2008
 *   Modified:   03-26-2008
 */
class validation
{
    /**
     *   Function to validate if a string
     *   passed to it is an email address 
     *   input:  string
     *   return: boolean
     */
    function IsEmail($email)
    {
        if (ereg('^[-!#$%&\'*+\\./0-9=?A-Z^_`a-z{|}~]+'.'@'.'[-!#$%&\'*+\\/0-9=?A-Z^_`a-z{|}~]+\.'.'[-!#$%&\'*+\\./0-9=?A-Z^_`a-z{|}~]+$', $email)) 
        {
            return true;
         } 
         else 
         {
            return false;
         }
    }
    
    /**
     *   Function that checks a string for
     *   any occurance of an array of bad 
     *   words passed to it
     *   input:  string
     *           array
     *   return: boolean    
     */
    function IsSpam($string,$aBadWords)
    {
        $cSpam = 0;

        $nSpam = sizeof($aBadWords);
  
        $tmpString = str_replace(" ", "", $string);
        $tmpString = strtolower($tmpString);

        for ($i = 0; $i < $nSpam; $i++) 
        {
            $cSpam += substr_count($tmpString, $aBadWords[$i]);
        }
  
        if ($cSpam > 0)
        {
            return true;
        } 
        else
        {
            return false;
        }
    }    
}

?>
