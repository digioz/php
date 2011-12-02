<?php
/*This function removes all special
 * characters from the parameter.
 *
 * "Special characters" is defined as all characters in the array
 * $spec (set in config.php) AS WELL AS the '<' character.
 */

function remove_special_chars($string) {
    global $spec; //Grant acess to the config array variable: $spec
    foreach ($spec as $char) {
        $string=str_replace($char, '', $string);
    //Remove all the instances of the character
    //by replacing it with an empty string.

    }
    $string=str_replace('<', '', $string);
    return $string;
}
?>