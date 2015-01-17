<?php

define('IN_GB', TRUE); 

include("includes/gb.class.php");
include("includes/config.php");
include("language/$default_language");
include("includes/rain.tpl.class.php");
include("includes/sanitize.php");       

raintpl::configure("base_url", null );
raintpl::configure("tpl_dir", "themes/$theme/" );
raintpl::configure("cache_dir", "cache/" );

//initialize a Rain TPL object
$tpl = new RainTPL;
$tpl->assign( "theme", $theme );
$tpl->assign( "title", $title );
$tpl->assign( "headingtitletxt", $headingtitletxt );
$tpl->assign( "addentrytxt", $addentrytxt );
$tpl->assign( "viewguestbooktxt", $viewguestbooktxt );
$tpl->assign( "newpostfirsttxt", $newpostfirsttxt );
$tpl->assign( "newpostlasttxt", $newpostlasttxt );
$tpl->assign( "searchlabeltxt", $searchlabeltxt );
$tpl->assign( "searchbuttontxt", $searchbuttontxt );
$tpl->assign( "currentyear", date("Y") );
$tpl->assign( "goback", $goback );

$search = sanitize_html_string($_POST['search_term']);
$pageNum = sanitize_int($_GET['page'],0,9000);

// Set Search Variables 
if ($search == "")
{
    $search = sanitize_html_string($_GET['search_term']);
}

if ($pageNum == "") { $pageNum = 0; } 

// If no search term then exit
if($search == "")
{
    $tpl->assign( "error_msg", $msgnosearchterm);
    $html = $tpl->draw( 'error', $return_string = true );
    echo $html;
    exit;
} 

// Check that the data file contains entries  

$filename = "data/list.txt";
$handle = fopen($filename, "r");

if (filesize($filename) == 0)
{
   fclose($handle);
   
    $tpl->assign( "error_msg", $msgnoentries);
    $html = $tpl->draw( 'error', $return_string = true );
    echo $html;
    exit;
}

    // Read all entries and put in array
    $datain = fread($handle, filesize($filename));
    fclose($handle);
    $out = explode("<!-- E -->", $datain);
    array_pop($out);
  

    // Search array "out" for user search term and put matches in array search_results
    foreach($out as $value)
    {
        $obj_info = unserialize($value);
        $obj_vars = get_object_vars($obj_info);

        foreach($obj_vars as  $value)
        {
            if(stristr($value, $search))
            {
                $search_results[] =  $obj_info;
                break;
            }
        }
    }

    // Notify user if no match found

    if (count($search_results) == 0)
    {
        $tpl->assign( "error_msg", $msgnomatchfound);
        $html = $tpl->draw( 'error', $return_string = true );
        echo $html;
        exit;
    }

    // Write header of search page
    $html = $tpl->draw( 'header', $return_string = true );
    echo $html;

    echo "<center><h3>$msgresultofsearch: <u><i>$search</i></u>:</h3><br></center>"; 



    // Display Search Results

    $perPage        = 5;
    $singlePage     = FALSE;
    $total_found    = count($search_results);
    $numberOfPages  = ceil($total_found/$perPage);
 
    if ($total_found <= $perPage)
    {                                               // Do the search results fit on a single page 
        $start = 0;                                 // YES: first entery starts at array location 0
        $end = $total_found - 1;                    // set last entry location, note -1    
        $singlePage = TRUE;                         // Set the single page indicator flag
    }
    else
    {
        if($pageNum == 0)
        {                                           // Did the user select a page to display 
            $pageNum = 1;                           // NO: we set a default to display first page 
        }

        $start = ($pageNum-1) * $perPage;           // Defines any page start boundary
        
        if($total_found >= ($pageNum * $perPage))
        {                                           // Check to see if it is a full page
            $end =  ($pageNum * $perPage)-1;        // Yes: Set end to page boundary end -1 
        }
        else
        {                                           // Not a full page end point is the total found
            $end = $total_found - 1;                // Set end accordingly again -1 
        }  
    }

    // Display search page results using our start and end points defined.
    for($i=$start; $i<=$end; $i++)
    {
       $tpl->assign( "listDatetxt", $listDatetxt);
        $tpl->assign( "listnametxt", $listnametxt);
        $tpl->assign( "listemailtxt", $listemailtxt);
        $tpl->assign( "listMessagetxt", $listMessagetxt);
        $tpl->assign( "outputdate", $search_results[$i]->gbDate);
        $tpl->assign( "outputfrom", $search_results[$i]->gbFrom);
        $tpl->assign( "outputemail", $search_results[$i]->gbEmail);
        $tpl->assign( "outputmessage", $search_results[$i]->gbMessage);
        
        $html = $tpl->draw( 'list', $return_string = true );
        echo $html;
    }

	echo '<div class="pagination">';
	
    // Navigation Bar  
    $self = $_SERVER['PHP_SELF'];                       // This page's path used in link creation
    $gbSearchNav = ""; 
    $numNavItems = 10;                                  // Number of seperate page links to display in nav menu

    $numNavGroup = (INT)(($pageNum-1)/$numNavItems) ;   // Calculate number of navigation groups
                                                        // multiples of nav items

    if($numberOfPages > (($numNavGroup+1)*$numNavItems))
    {                                                   // More than a full block of nav links required 
        $ref = ($numNavGroup+1)*$numNavItems;           // Yes: calculate pages catered for within
    }                                                   // a full group of links.
    else
    {                                                   // No: could be equal or less than a full group of links 
        $ref = $numberOfPages;                          // so all the pages are catered for.
    }

    //Show page 1 link, back ref (chevrons) to previous page and keep search term alive
    $back_ref    = $numNavGroup*$numNavItems;         // back navigation  
    $forward_ref = (($numNavGroup+1)*$numNavItems)+1; // forward navigation  

    if($numNavGroup >0)
    { // Add first page and back nav (chevrons)to menu 
        $gbSearchNav .= "<a href=\"$self?page=1&search_term=$search\">&nbsp;Page 1&nbsp;</a>";
        $gbSearchNav .= "<a href=\"$self?page=$back_ref&search_term=$search\">&nbsp;&lt;&lt;&lt;&nbsp;</a>";
    }

    // Add page nav core group and square brackets or other separator. 
    for($page = $numNavGroup*$numNavItems+1; $page < $ref+1; $page++)
    {
        $gbSearchNav .=  "<a href=\"$self?page=$page&search_term=$search\">$page</a>&nbsp;";
    }

    if($numberOfPages >(($numNavGroup+1)*$numNavItems) )
    {                                                   // Add last page and forward nav
        $gbSearchNav .=  "<a href=\"$self?page=$forward_ref&search_term=$search\">&gt;&gt&gt;</a> ";
        $gbSearchNav .= "<a href=\"$self?page=$numberOfPages&search_term=$search\">Page $numberOfPages</a> ";
    }

    echo $gbSearchNav;                                  // after all that hard work display it
	
	echo "</div>";
  
    // Write Footer 
    $html = $tpl->draw( 'footer', $return_string = true );
    echo $html;

?>

