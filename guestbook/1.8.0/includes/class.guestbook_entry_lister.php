<?php

/**
 * class.guestbook_entry_lister
 *
 * a wrapper class for listing guestbook entries whose
 * main purpose is to help listing of records new first or last
 * with different options on various pages
 *
 * depends: class.gbXML.php, functions.php
 *
 * @author DigiOz Guestbook, Scott Trevithick
 * @copyright 2009 DigiOz Guestbook.
 *
 */

class guestbook_entry_lister 
{
    var $perpage;
    var $gbXML;
    var $records_array;
    var $page; // the current page being displayed
    var $context; //the location of the page from which we are being called
    var $email_image_source; //the path from the calling page to the email image generator page
    var $DateLabelText;
    var $NameLabelText;
    var $EmailLabelText;
    var $MessageLabelText;

    function guestbook_entry_lister($records_per_page, $context='main', $path_to_datafile = '', $records = array())
    {
        // Reading in all the records, putting each guestbook entry in one Array Element -----
        $this->perpage = $records_per_page;
        
	    if($path_to_datafile !== '')
	    {		
        	$this->gbXML = new gbXML('messages','message', $path_to_datafile);
        	$this->records_array = $this->gbXML->parse_XML_data();
	    }
	    else
	    {
		    $this->records_array = $records;
	    }

        if ($context == 'main')
        {
            $this->email_image_source = 'includes/';
        }
        elseif ($context == 'admin')
        {
            $this->email_image_source = '../includes/';
        }

        global $listDatetxt;
        global $listnametxt;
        global $listMessagetxt;
        global $listemailtxt;
        $this->DateLabelText = $listDatetxt;
        $this->NameLabelText = $listnametxt;
        $this->MessageLabelText = $listMessagetxt;
        $this->EmailLabelText = $listemailtxt;
    }

    function get_records_per_page()
    {
        return $this->perpage;
    }

    function get_count()
    {
        return count($this->records_array);
    }

    function guestbook_is_empty()
    {
        // Test to see if there are any entries to display -----------------------------------
        return count($this->records_array) == 0;
    }

    function list_new_first($page, $with_buttons=FALSE)
    {
        $this->records_array = array_reverse($this->records_array);
        $this->list_records($page, $with_buttons);
    }

    function list_new_last($page, $with_buttons=FALSE)
    {
        $this->list_records($page, $with_buttons);
    }

    function list_records($page, $with_buttons=FALSE)
    {
       // Counting the total number of records (subarrays) in the meta-array ----------------
        // array index starts at 0;
        $count = count($this->records_array);
        $totalpages = ceil($count/$this->perpage);

        if ($page > $totalpages )
        {
            $page = $totalpages;
        }
        else if ($page < 1 )
        {
            $page = 1;
        }

        //end equals the page number x the number of records per page
        $end = $this->perpage * $page;
        //start equals the last record of the previous page + 1 or prev page's $end val
        $start = $this->perpage * ($page -1);

        //however, if we are on the first page, start = 1
        if ($page == 1) { $start = 0;}

        //and if we are on the last page, end = total number of records
        if ($page == $totalpages ) {$end = $count; }

        // Print out the records in whatever order they exist in the array
        //if asc, we have already reversed the array

        for ($i=$start; $i<$end; $i++)
        {
            extract($this->records_array[$i]);

            //allow us to display an edit or delete button depending on parameters we
            //were called with
            if ( !FALSE == $with_buttons && in_array('delete', $with_buttons) )
            {
              $delete_button = '<p class="deleteRecordButton"><a href="delete_process.php?id='.$id.'" title="Delete this record">Delete this record</a></p>';
            }

            if ( !FALSE == $with_buttons && in_array('edit', $with_buttons) )
            {
              $edit_button = '<p class="editRecordButton"><a href="edit.php?id='.$id.'" title="Edit this record">Edit this record</a></p>';
            }

            if ($with_buttons !== FALSE)
            {
                @$buttons_div = '<div class="modifyButtons">'. $edit_button . $delete_button . '</div>';
            }
            else
            {
                $buttons_div = '';
            }

            echo "

            <div class='gbookRecordBanner'></div>
            <div class='gbookRecord'>
                    $buttons_div
                    <p><span class='gbookRecordLabel'>{$this->DateLabelText}:</span> $date </p>
                    <p><span class='gbookRecordLabel'>{$this->NameLabelText}:</span> $name  </p>
                    <p><span class='gbookRecordLabel'>{$this->EmailLabelText}:</span>
                        <a href='mailto:" . display_email($email, $no_image=TRUE, $this->email_image_source) . "' />" . display_email($email, $no_image=FALSE,$this->email_image_source). "</a>
                    </p>
                    <p class='gbookRecordMsg'><span class='gbookRecordLabel'>{$this->MessageLabelText}:</span> $msg </p>
            </div>

    ";
        }

    }
}
?>
