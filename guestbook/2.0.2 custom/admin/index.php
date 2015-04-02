<?php

// Begin Login Verification --------------------------------------------

define('IN_GB', TRUE);

session_start();

$pageTitle = "Home";  

include("login_check.php");
include("includes/header.php");

include("../includes/gb.class.php");
include("../includes/config.php");
include("../language/$default_language");

$page = isset($_GET['page']) ? $_GET['page'] : "";
$order= isset($_GET['order']) ? $_GET['order'] : "";

if ($page == "") { $page = 1; }
if ($order == "") { $order = "asc"; }

$currentPage = $page;

if (is_numeric($page) == true && ($order == "asc" || $order == "desc"))
{
    // Check page value ------------------------------------------------------------------

    $fwd = $page + 1;
    $rwd = $page - 1;

    // Setting the default values for number of records per page -------------------------
    $perpage = 5;

    // Reading in all the records, putting each guestbook entry in one Array Element -----

    $filename = "../data/list.txt";
    $handle = fopen($filename, "r");

    if (filesize($filename) == 0)
    {
       print "No enteries to delete";
    }
    else
    { 
        // there are entries let the user select one
        $datain = fread($handle, filesize($filename));
        fclose($handle);
        $out = explode("<!-- E -->", $datain);

        $outCount = count($out) - 1;
        $j = $outCount-1;

        if ($order == "desc")
        {
            for ($i=0; $i<=$outCount; $i++)
            {
                $lines[$j] = unserialize($out[$i]);
                $j = $j - 1;
            }
        }
        else
        {
            for ($i=0; $i<=$outCount; $i++)
            {
                $lines[$i] = unserialize($out[$i]);
            }
        }

        // Counting the total number of entries (lines) in the data text file ----------------

        $result = count($lines);
        $count = $result-1;

        // Caclulate how many pages there are ----------------------------------------

        if ($count == 0) { $totalpages = 0; }
        else { $totalpages = intval(($count - 1) / $perpage) + 1; }

        $page = $totalpages - ($page - 1);

        $end = $count - (($totalpages - $page) * $perpage);
        $start = $end - ($perpage - 1); if ($start < 1) { $start = 1; }

        if ($start < 0) { $start = 0; }
?>

<center>

<table>
    <thead>
        <tr>
            <th scope="col">From</th>
            <th scope="col">Email</th>
            <th scope="col">Date</th>
            <th scope="col" style="width: 30px;">Action</th>
        </tr>
    </thead>

    <?php
    for ($i=$end-1; $i>$start-2; $i--)
    {
    ?>
        
    <tbody>
        <tr>
            <td><?php echo $lines[$i]->gbFrom; ?></td>
            <td><a href="mailto:<?php echo $lines[$i]->gbEmail; ?>"><?php echo $lines[$i]->gbEmail; ?></a></td>
            <td><?php echo $lines[$i]->gbDate; ?></td>
            <td>
                <!--<a href="#" class="table-icon edit" title="Edit"></a>
                <a href="#" class="table-icon archive" title="Archive"></a>-->
                <a href="delete_process.php?id=<?php echo $i; ?>" class="table-icon delete" title="Delete"></a>
            </td>
        </tr>
        <tr>
             <td colspan="4">
                <?php echo $lines[$i]->gbMessage; ?>   
             </td>
        </tr>
    </tbody>
    
    <?php
    }
    ?>
</table> 

<?php
    } 
}

// Creating the Forward and Backward links -------------------------------------
echo "<center>";
echo '<div class="pagination">';



if ($fwd > 0 && $rwd > 0 && $rwd<$totalpages+1)
{
    echo "<a href=\"index.php?page=1&order=$order\">&lt&lt</a>"; 
    echo "<a href=\"index.php?page=$rwd&order=$order\">&lt</a>";
}
else if ($rwd > 0)
{ 
    echo "<a href=\"index.php?page=$fwd&order=$order\">&lt</a>"; 
}

// loop through pages

$startPagination = $currentPage - 3;
$endPagination = $currentPage + 3;

if ($startPagination < 1)
{
    $startPagination = 1;
}

if ($endPagination > $totalpages)
{
    $endPagination = $totalpages;
}

//for ($i = 1; $i<=$totalpages; $i++)
for ($i = $startPagination; $i<=$endPagination; $i++)  
{
    if ($currentPage == $i)
    {
        echo " <a href=\"index.php?page=$i&order=$order\"><b>$i</b></a> ";  
    }
    else
    {
        echo " <a href=\"index.php?page=$i&order=$order\">$i</a> ";      
    }
}

if ($fwd > 0 && $rwd > 0 && $fwd<$totalpages+1)
{
    echo "<a href=\"index.php?page=$fwd&order=$order\">&gt</a>";
}
else if ($fwd > 0 && $fwd <= $totalpages)
{ 
    echo "<a href=\"index.php?page=$fwd&order=$order\">&gt</a>"; 
}

if ($currentPage < $totalpages)
{
    echo "<a href=\"index.php?page=$totalpages&order=$order\">&gt&gt</a>"; 
}

echo '</div>';
echo "</center>";

include ("includes/footer.php");
?>
