<?php
// PROPOSED GUESTBOOK SEARCH REF DIGIOZ Beta17

// Know issues: 
// a) Search string  eg what's fails backslash problem eg what\'s
// b) Is encoding of search term required before adding to nav bar links
// c) Fixed format for tables/links extract and use common CSS 

// MPG V2.0.1  26-9-05
// Added sliding window navigation for large result output
// Code:     a) Nav bar MPG Guest book 1 
 
// MPG V1.0.0  24-9-05
// Material: Basic search concept DIGIOZ 16 and notes from forum
// Code:     a) Based on DIGIOZ Guest book beta 17 

// Note: When a search results spreads over one page the search term must remain alive.
// Page numbers are received as a direct result of a multi-page search result. The page number
// being in responce to a user selection from the menu bar.
//##################################################################################################
include("header.php");                // contains the search form using GET method.

$search = $_POST['search_term'];       // get user search information 
$pageNum = $_GET['page'];             // generated only on multi-page results and selected by user
if ($pageNum == "") { $pageNum = 0; } // for initial search always undefined. Pages start from 1 
                                      // 0 effectively indicates undefined.

if($search == ""){                    // has user entered any search data. NO: ask user to supply 
 echo "<center><font color=blue>Please enter a search term and try again.</font></center>";  
 include("footer.php");               // write footer to complete page
 exit;                                // nothing else to do
} 
//##################################################################################################
// A user has entered some search information so we continue. 
// First we check that the database file contains entries.  

$filename = "data/list.txt";                           // database file name
$handle = fopen($filename, "r");                  // get file reference

if (filesize($filename) == 0){                    // are there any entries to search 
   fclose($handle);                               // finished with file close it
   print" The Guestbook is empty <br>";           // NO: inform user
   print" Be the first to make an entry";         // optional 
   include("footer.php");                         // write footer, completes page
   exit;                                          // nothing else to do
}
// We have established there are entries to search. Read in all records, put each guestbook entry
// into a seperate array element. But first output user feedback message  

 echo "<center><h3>The result of your search<br> for the term <u><i>$search</i></u>:</h3><br></center>"; 

 $datain = fread($handle, filesize($filename));   // read all entries into a variable 
 fclose($handle);                                 // finished with file close it
 $out = explode("<!-- E -->", $datain);           // split enteries and save into array $out
 array_pop($out);                                 // remove last element of array contains no valid
                                                  // data result of the last end terminator.   
//##################################################################################################
// We now search the array "out" for the users search term. All matches found are stored in the
// array "search_results".
  foreach($out as $value){                        // search each array element for users search term
       $obj_info = unserialize($value);           // extract serilised object information 
       $obj_vars = get_object_vars($obj_info);    // we are interested only in the object variables

      foreach($obj_vars as  $value){              // loop to check each of these object variables 
	     if(stristr($value, $search)){            // for users search term. If a match is found 
		   $search_results[] =  $obj_info;        // save object info (rechord) in an array.  
		   break;                                 // no reason to check further, we found and saved 
		 }                                        // a match.
	   }
  } // keep looking for a match until end of array "out" is reached 
//##################################################################################################
// With the searched completed we check to see if any matches were found. If no matches we clean up
// by informing the user and finally output the footer and exit.

  if (count($search_results) == 0){                      // no match found inform user accordingly 
     echo "<center><font color=red>No Match found.</font></center>"; 
     include("footer.php");                              // write footer, completes page
     exit;                                               // nothing else to do
  }
//##################################################################################################
// We have a number of search results to display. These will either fit onto one page or spread over
// several pages. To determine the number of pages we define the number of enteries to display per
// page. From this value we define the start and end positions of the data stored in the array and
// display it. Note: A user will have been provided with the option to select a page from multi-page
// search menu bar this page number is used to determine what is displayed.  

 $perPage=3;       // Number of guestbook search entries to show per page. Resonable default is 10.
 $singlePage = FALSE;  // true if search results fit onto a single page
 $total_found    = count($search_results);      // Total number of matching items 
 $numberOfPages  = ceil($total_found/$perPage); // Total number of pages from search
 
 if ($total_found <= $perPage){           // Do the search results fit on a single page 
  $start = 0;                             // YES: first entery starts at array location 0
  $end = $total_found - 1;                // set last entry location, note -1    
  $singlePage = TRUE;                     // Set the single page indicator flag
 }

 else{                                     // NO: Use default or users page selection.

   if($pageNum == 0){                     // Did the user select a page to display 
     $pageNum = 1;                        // NO: we set a default to display first page 
   }

   // To output a page from the results array we define page start and end based on page number
   $start = ($pageNum-1) * $perPage;           // Defines any page's start boundary
   if($total_found >= ($pageNum * $perPage)){  // Check to see if it is a full page
     $end =  ($pageNum * $perPage)-1;          // Yes: Set end to page boundary end -1 
   }
   else{                                       // Not a full page end point is the total found
     $end = $total_found - 1;                  // Set end accordingly again -1 
   }  
 }
//##################################################################################################
// Display search page results using our start and end points defined.
   for($i=$start; $i<=$end; $i++){            // Display page or part of page
        echo "<table bgcolor=#EFEFEF bordercolor=#C0C0C0 border=1 width=500 cellspacing=0 cellpadding=10><tr><td background=\"images/toolbar.jpg\" height=\"20\"><tr><td>";
        echo "<b>$listDatetxt: </b>";
        $search_results[$i]->showDate();
    	echo "<br><b>$listnametxt: </b>";
        $search_results[$i]->showFrom();
        echo "<br><b>$listemailtxt: </b><a href=\"mailto:";
        $search_results[$i]->showEmail();
        echo "\">";
        $search_results[$i]->showEmail();
        echo "</a><br><br><b>$listMessagetxt: </b>";
        $search_results[$i]->showMessage();
        echo "</td></tr></table><br>";
		print"\n";
   }
//##################################################################################################
// If the search results were a single page for display we can clean up and finish.
 if($singlePage){             // Was it a single page search result
     include("footer.php");   // YES: write footer, completes page
     exit;                    // nothing else to do
 }
//##################################################################################################
// The search results produced multi-pages we have displayed either the deafult or one a user
// selected. In either case we need to return a navigation bar allowing the user to select another
// page from the results. Each nav link needs to keep the search term alive so we add it to all nav
// bar links. A user can overide these by entering a new search term in the form

//==================================================================================================
// The nav bar is dynamic and adjusts to the number of pages found. Links are added until a predefined
// maximum is reached. For example if I define a core group to have a maximum of three the links are 
// displayed in this sequence [1], [1] [2] and [1] [2][3].

// When the number of pages exceeds the core group’s capacity, additional links (I use chevrons)
// transform the core group into a variable block for example <<<[4][5][6]>>> clicking on the left
// chevrons slides the block to give <<<[1][2][3]>>>  and click on the right chevrons produce
//   <<<[7][8][9]>>> .

// Once the number of pages exceeds three blocks, I hammer in fixed reference points. These are the
// first and last page links; again, added only when required.
// It is more difficult to explain than implement. 
//==================================================================================================
// Dynamic nav bar creation. Setup 
 $self = $_SERVER['PHP_SELF'];      // This page's path used in link creation
 // The nav bar is contained in a paragraph tag. We add to this string to build a complete nav bar.
 $gbSearchNav = "<p  align='center' style=\"font-size: 12px; font-weight: bold; text-decoration: none;	background-color: #FFFFFF;\">"; 
 $numNavItems = 10;                 // Number of seperate page links to display in nav menu

 $numNavGroup = (INT)(($pageNum-1)/$numNavItems) ; // Calculate number of navigation groups
                                                   // multiples of nav items

 if($numberOfPages > (($numNavGroup+1)*$numNavItems)){ // More than a full block of nav links required 
  $ref = ($numNavGroup+1)*$numNavItems;                // Yes: calculate pages catered for within
 }                                                     // a full group of links.
 else{                       // No: could be equal or less than a full group of links 
   $ref = $numberOfPages;    // so all the pages are catered for.
 }

 //Show page 1 link, back ref (chevrons) to previous page and keep search term alive
 $back_ref    = $numNavGroup*$numNavItems;         // back navigation  
 $forward_ref = (($numNavGroup+1)*$numNavItems)+1; // forward navigation  

 if($numNavGroup >0){ // Add first page and back nav (chevrons)to menu 
    $gbSearchNav .= "<a href=\"$self?page=1&search_term=$search\">&nbsp;Page 1&nbsp;</a>";
    $gbSearchNav .= "<a href=\"$self?page=$back_ref&search_term=$search\">&nbsp;&lt;&lt;&lt;&nbsp;</a>";
 }

 // Add page nav core group and square brackets or other separator. 
 for($page = $numNavGroup*$numNavItems+1; $page < $ref+1; $page++){
    $gbSearchNav .=  "[<a href=\"$self?page=$page&search_term=$search\">&nbsp;$page&nbsp;</a>]";
 }

  if($numberOfPages >(($numNavGroup+1)*$numNavItems) ){ // Add last page and forward nav
    $gbSearchNav .=  "<a href=\"$self?page=$forward_ref&search_term=$search\">&nbsp;&gt;&gt&gt;&nbsp;</a> ";
    $gbSearchNav .= "<a href=\"$self?page=$numberOfPages&search_term=$search\">&nbsp;Page $numberOfPages&nbsp;</a> ";
  }

  $gbSearchNav .= "</P>"; // complete the paragraph
  echo $gbSearchNav;     // after all that hard work display it

  //print"<br><p align='center'><b>Remove this line Finished</b></p>";
//######################################## END #####################################################
?>


















<?
/*############################## General notes ############################
This guest book has an excellent modular architecture that makes it easy to
integrate. The perceived simplicity reflects hard work and time put into the
coding.  

1) Next step: The code is working however this like the guest book display 
   menu will suffer bloat. Integrate my alternative sliding window menu into
   the above code. 
    
*/
?>
