<?php

/**
 * gbXML
 *
 * This class is the main storage engine for DigiOz Guestbook.
 * It handles reading and writing of guestbook records to and
 * from XML files. It is generic enough to handle other types of
 * XML data. It is fully compatible with PHP4 and PHP5. *
 *
 * @author 		DigiOz Guestbook, Scott Trevithick, Dhaval Shah
 * @copyright 	DigiOz.com, 2009.
 *
 */
class gbXML
{
    var $data_string = FALSE; //store contents of files as a single string
                                //this always holds a complete XML file, whether it has just been read from disk
                                //or is about to be written to disk
    var $data_array = array();  //store contents of files as an array - holds only RAW XML DATA as read from file

    var $parsed_array = array(); //store parsed data as an array: multimensional array with each subarray a complete XML record
                                    //for ex., subarray may be a GB entry or may be an IP Address record
    var $element = FALSE;   //a single XML element (<tag>value</tag>)
    var $data_type = '';     //the tag_name that appears in the file open and file end tag XML tags
    var $record_delim = '';  //the tag_name that appears at the start and end of each XML record
    var $filename = '';     //the name of the XML file we are working with;
    var $dirty_data_string = FALSE;     //boolean: TRUE if data on disk is newer than in $this->data_string;
    var $dirty_data_array = TRUE; //boolean: TRUE if data on disk is newer than $this->data_array();
    var $dirty_parsed_array = TRUE; //boolean: TRUE if $this->parsed_array is empty or not as new as data on disk or in $data_string or $data_array;

    function gbXML($data_type, $record_delim, $filename) //constructor - compatible with PHP4
    {
        //when creating an instance of this class, we must specify
        //what type of XML data we are reading/writing: IPAddresses or Messages, etc.
        $this->data_type = $data_type;
        $this->record_delim = $record_delim;
        $this->filename = $filename;

        //if file does not exist, first create it with XML header
        if (!file_exists($filename))
        {
            if ( ($handle = @fopen($filename, 'wb')) === FALSE )
            {
                return FALSE;
            }



            $file_start_tag = $this->start_tag($data_type);
            $file_end_tag = $this->close_tag($data_type);

            flock($handle, LOCK_EX);
            $result = @fwrite($handle, "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n$file_start_tag\n$file_end_tag\n");
            flock($handle, LOCK_UN);
            fclose($handle);

        }

        //OK, file exists: open it for read/write
        $this->get_xml_data_as_string($this->filename);

    }

    function __destruct()
    {
      //nothing to do...
    }


    function start_tag($tag_name)
    {
        return("<".$tag_name.">");
    }

    function close_tag($tag_name)
    {
        return("</".$tag_name.">");
    }

    function append_start_tag($tag_name)
    {
        $this->element .= "<".$tag_name.">\n";
    }

    function append_close_tag($tag_name)
    {
        $this->element .= "</".$tag_name.">\n";
    }

    function append_element($tag_name, $tag_value)
    {
        $this->element .= "\t" . $this->start_tag($tag_name) . $tag_value . $this->close_tag($tag_name) . "\n";
    }

    function reset_element()
    {
        $this->element = FALSE;
    }

    function get_xml_data_as_string()
    {
        //READ THE CONTENTS OF AN XML FILE INTO AN A STRING

        if ($this->dirty_data_string === FALSE && $this->data_string)
        {
            return;
        }

        $this->data_string = file_get_contents($this->filename);
        $this->dirty_data_string = FALSE;
        $this->dirty_data_array = TRUE;
        $this->dirty_parsed_array = TRUE;
    }

    function get_xml_data_as_array()
    {
        //EXPLODE CONTENTS OF $this->data_string INTO A ONE-DIMENSIONAL ARRAY, EACH LINE BEING ONE ARRAY ITEM

        if ($this->data_array && $this->dirty_data_string === FALSE && $this->dirty_data_array===FALSE)
        {
            return;
        }
        else
        {
            $this->get_xml_data_as_string();
            $this->data_array = explode("\n", $this->data_string);
            $this->dirty_data_array = FALSE;
            $this->dirty_parsed_array = TRUE;
            return;
        }

    }

    function conv_array_to_xml_string()
    {
        //return $this->parsed_array into a string which can be written to file
        //string to be written will be stored in $this->data_string

        $file_start_tag = $this->start_tag($this->data_type);
        $file_end_tag = $this->close_tag($this->data_type);
        $this->data_string = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n$file_start_tag\n";

        foreach ($this->parsed_array as $key => $array)
        {
            $this->append_start_tag($this->record_delim);  //start XML record

            foreach ($array as $tag_name => $tag_value )
            {
                $this->append_element($tag_name, $tag_value); //append each value within record
            }
            $this->append_close_tag($this->record_delim); //close XML Record

            $this->data_string .= $this->element;    //append record to data_string
            $this->reset_element(); //zero element for next record
        }

        //properly close the XML file
        $this->data_string .= $file_end_tag . "\n";
        //mark $this->data_string as clean
        $this->dirty_data_string = FALSE;

    }

    function parse_XML_data()
    {
        //check to see if the parsed array is up-to-date: if it is, return it
        if ($this->dirty_parsed_array === FALSE)
        {
            return $this->parsed_array;
        }
        else
        {
            //otherwise, reset it
            $this->parsed_array = array();
        }

        $record_start_tag = $this->start_tag($this->record_delim);
        $record_end_tag = $this->close_tag($this->record_delim);
        $file_end_tag = $this->close_tag($this->data_type);
        $line = 1; //keep track of what line we're on (don't start until we hit line 3)
        $lineInRecord = 0; //this helps us identify the first line inside a record

        //make sure our data array is populated and fresh
        $this->get_xml_data_as_array();

        //loop through each line in the array and parse it into an array of subarrays, each subarray being a complete XML record,
        //keyed in the encompassing array by the first XML element inside the record, e.g., by ip or by ID
        foreach ($this->data_array as $item)
        {
            $buffer = trim($item);

            //are we at the closing tag or an empty line?
            if (strcasecmp($buffer, $file_end_tag) == 0 || !$buffer )
            {
                continue;
            }

            //check to see if we've hit the beginning of a record
            if (strcasecmp($buffer, $record_start_tag) == 0)
            {
                $lineInRecord = 1; //set for next loop through
                continue;   //jump to the next line to begin reading data for this record
            }

            //are we at the end of a record?
            if (strcasecmp($buffer, $record_end_tag) == 0)
            {
                //we have a complete record: append it to the master array, zero our tmparray and continue
                $this->parsed_array[] = $tmp_array;
                $tmpArray = array();
                continue;
            }

            //we reading in data from a record
            if ($line > 2)
            {
                //identify the start tag and create start and end XML tags
                $tag_regex = '/^<{1}(.+?)>{1}/';
                $matches = array();
                $result = preg_match($tag_regex, $buffer, $matches);

                //should not need to be this careful, but the user might have corrupted the XML
                //file while manually editing it, so... check we have a proper match
                if (isset($matches[1]))
                {
                    $cur_key = $matches[1];
                }
                else
                {
                    continue;
                }

                $cur_key = trim($cur_key); //trim any whitespace between the tags
                $start_tag = $this->start_tag($cur_key);
                $end_tag = $this->close_tag($cur_key);


                $matches = array();
                $val_regex = "|^$start_tag(.*)$end_tag$|";
                $result = preg_match($val_regex, $buffer, $matches);
                if (isset($matches[1]))
                {
                    $curVal = $matches[1];
                }
                else
                {
                    continue;
                }

                //collect the record into a temporary array;
                $tmp_array[$cur_key] = $curVal;
            }

            $line++;

        }

        $this->dirty_parsed_array = FALSE;
        //ensure the index of the record in the parsed array and the record's internal id are identical
        $this->synchronize_record_id_with_array_index();
        return $this->parsed_array;

        echo(var_dump($this->parsed_array));
        exit();
    }


    /**
     * synchronize_record_id_with_array_index()
     *
     * This private utility function makes sure that the 'id' key of each record
     * is identical to the record's position in $this->parsed_array. The 'id'
     * of the record can easily get out of sync and should be identical as some operations
     * us this value to delete or replace records.
     */
    function synchronize_record_id_with_array_index()
    {
        foreach ($this->parsed_array as $index => $subarray)
        {
            $this->parsed_array[$index]['id'] = $index;
        }
        return $this->parsed_array;
    }

    /**
     *APPEND CONTENTS OF $this->element TO THE XML FILE
     * this means reading the entire file in (if it hasn't been), removing the file close tag
     * appending our data, adding the file close tag, and writing the string to file
     */
    function append_element_to_file()
    {
        $file_end_tag = $this->close_tag($this->data_type);

        //read XML Data into $this->data_string if it is not up-to-date
        if ($this->dirty_data_string)
        {
            $this->get_xml_data_as_string($this->filename);
        }

        //make sure we have something to write
        if ( $this->element === FALSE)
        {
            echo "<b>Error in " . __FUNCTION__ . " in " . __FILE__ . ": no element to write.</b>";
            exit();
        }

        //open a file handle for writing
        $handle = @fopen($this->filename, 'w');
        if ($handle === FALSE)
        {
            //debug
            echo "<b>Error in " . __FUNCTION__ . " in " . __FILE__ . ": could not open $filename for writing.</b>";
            return FALSE; //operation failed
        }


        //remove the file end tag and trailing \n from the file
        $replace_this = $file_end_tag . "\n";
        $this->data_string = str_ireplace($replace_this, "", $this->data_string);
        //append our element and end tag
        $this->data_string .= $this->element . $file_end_tag . "\n";

        //now write the data out to file:
        if ( @fwrite($handle, $this->data_string ) === FALSE )
        {
            //debug;
            echo "<b>Error in " . __FUNCTION__ . " in " . __FILE__ . ": could not write this->data_string.</b>";
            return FALSE;
        }
        //close handle and flush data to disk
        fclose($handle);

        //set dirty variable to so we know file on disk is newer than that in RAM
        $this->dirty_data_string = TRUE;
        $this->reset_element();
        return TRUE;

    }

    /**
     * WRITE A SINGLE XML RECORD TO THE END OF A FILE
     *
     * take an associative array with keys as tag names and values as element values
     * append this record to the end of an XML file
     * @return - TRUE on success; FALSE on failure
     **/
    function append_record_to_file($array)
    {
        $this->reset_element();
        $this->append_start_tag($this->record_delim);

        foreach ($array as $tag_name => $tag_value)
        {
            $this->append_element($tag_name, $tag_value);
        }
        $this->append_close_tag($this->record_delim);

        return $this->append_element_to_file();

    }

    /**
     * Delete a guestbook or other record from the XML data file
     *
     * @param   int id  The ID of the record to delete
     * @return  bool    The result of the attempted operation (TRUE=success)
     * @access  public
     */
    function delete_record_from_file($id)
    {
        //generate the parsed_array for us to work with
        $this->parse_XML_data();

        //delete the entire record
        unset($this->parsed_array[$id]);

        //reindex the array by returning the values of $this->parsed_array as an $array = array();
        $this->parsed_array = array_values($this->parsed_array);

        //synchronize the index of the record in the parsed array with the record's internal id
        $this->synchronize_record_id_with_array_index();

        //convert the new parsed_array into a complete string (in $this->data_string )
        $this->conv_array_to_xml_string();

        //write the string out to file
        if ( ($handle = @fopen($this->filename, 'wb')) === FALSE)
        {
            echo"<b>The data file could not be opened for writing.</b><br />";
            return FALSE;
        }
        else
        {
            if ( (@fwrite($handle, $this->data_string)) !== FALSE)
            {
                fclose($handle);
                $this->dirty_data_string = TRUE;
                $this->dirty_data_array = TRUE;
                return TRUE;
            }
            else
            {
                echo "<b>The data file could not be written to disk.</b></br>";
                return FALSE;
            }
        }
    }

    /**
     * replace_record_in_file($id)
     *
     * Replace a guestbook or other record in the XML file by deleting the
     * current record an inserting a new one with the same $id. A convenience method
     * since it calls two public methods on the class.
     *
     * @param int $id the id of the record to be replaced
     * @param array $array of values to be appended to the file
     * @return bool true on success; false on failure
     * @access public
     *
     */
    function replace_record_in_file($id, $array)
    {
        //first get rid of the current record
        if (! $this->delete_record_from_file($id) )
        {
            return FALSE;
        }


        //then append the new record to the end of the file
        if (! $this->append_record_to_file($array))
        {
            return FALSE;
        }

        return TRUE;

    }

    /**
     * get_record_from_file($id)
     *
     * Get the record matching $id as an array of values
     * keyed by the names of the XML tags
     *
     * @param int $id the $id of the record to be returned
     * @return array $tmparray values keyed by names of XML tags
     * @return bool FALSE on failure to find match
     * @access public
     */
    function get_record_from_file($id)
    {
        $this->parse_XML_data();

        foreach ($this->parsed_array as $subarray)
        {
            if ($subarray['id'] == $id)
            {
                return $subarray;
            }
        }

        return FALSE;

    }


    /**
     * GIVEN A tag_name (E.G., ID) FIND & RETURN ITS HIGHEST VALUE
     * read all the tags of this type in the file and return the highest
     *  value found
     *
     *  OBVIOUSLY THIS ONLY WORKS ON ELEMENTS HOLDING A NUMERIC VALUE
     *
     *  @param  string  $tag_name   The name of the tag to be queried
     *  @return int     $max_val    The highest value found for this tag
     */
    function get_max_value_for_tag($tag_name)
    {
        $this->get_xml_data_as_array();
        $max_val = 0;
        $start_tag = $this->start_tag($tag_name);
        $end_tag = $this->close_tag($tag_name);

        foreach ($this->data_array as $item)
        {
            $buffer = trim($item);

            //we only care about lines containing the type of tag we want
            if ( preg_match("/^$start_tag/", $buffer) )
            {
                //parse out the value the start and close tags
                $matches = array();
                $val_regex = "|^$start_tag(.*)$end_tag$|";
                preg_match($val_regex, $buffer, $matches);

                //$matches[1] holds the value inside the parentheses (.*)
                if ( isset($matches[1]) && is_numeric($matches[1]) )
                {
                    if ( $max_val < (int) $matches[1])
                    {
                        $max_val = (int) $matches[1];
                    }
                }
            }
        }

        return $max_val;

    }

    /**
     * GIVEN A $tag_name (e.g., ID) and a $tag_value (e.g., 25), peruse
     * the $this->parsed_array to see if they exist in the XML file
     *
     * for ex., does <id>25</id> exist in the XML file
     *
     *  @param  string  $tag_name   The name of the tag to be queried
     *  @param  string  $tag_value  The value to be queried inside the tag
     *  @return bool                TRUE if exists;
     */
    function tag_and_value_exist($tag_name, $tag_value)
    {
        $tag_to_match = $tag_name; unset($tag_name);
        $tag_val_to_match = $tag_value; unset($tag_value);

        //make sue we have all the
        $this->parse_XML_data();

        foreach ($this->parsed_array as $subarray)
        {
            foreach ($subarray as $tag_name => $tag_value)
            {
                if (strcasecmp($tag_name, $tag_to_match) == 0)
                {
                    if (strcasecmp($tag_value, $tag_val_to_match) == 0 )
                    {
                        return TRUE;
                    }
                }

            }

        }

        //if we fell through the loops, we did not find a matching tag/val pair
        return FALSE;
    }


}

?>
