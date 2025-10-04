<?php

// Begin Login Verification --------------------------------------------

define('IN_GB', TRUE);

include("../includes/security_headers.php");
include("../includes/secure_session.php");
include("../includes/config.php");
include("../includes/functions.php");
include("../includes/gb.class.php");

startSecureSession();

$pageTitle = "Home";

include("login_check.php");
include("includes/header.php");
include("../language/$default_language[2]");

// Params ------------------------------------------------------------------
$page  = isset($_GET['page']) ? $_GET['page'] : 1;
$order = isset($_GET['order']) ? $_GET['order'] : 'asc';

if (!ctype_digit((string)$page) || (int)$page < 1) { $page = 1; } else { $page = (int)$page; }
if ($order !== 'asc' && $order !== 'desc') { $order = 'asc'; }

$perpage = 5;

// Load posts ---------------------------------------------------------------
$filename = "../data/list.txt";
$datain = readDataFile($filename);
$lines = [];
if ($datain !== '') {
    $out = explode("<!-- E -->", $datain);
    foreach ($out as $chunk) {
        $chunk = trim($chunk);
        if ($chunk === '') continue;
        $data = json_decode($chunk, true);
        if (is_array($data)) {
            $lines[] = gbClass::fromArray($data);
        }
    }
}

$lines = array_values(array_filter($lines));

if ($order === 'desc') {
    $lines = array_reverse($lines);
}

$count = count($lines);
if ($count === 0) {
    echo "<center>No entries to display</center>";
    include("includes/footer.php");
    exit;
}

$totalpages = (int)ceil($count / $perpage);
if ($page > $totalpages) { $page = $totalpages; }

$startIndex = ($page - 1) * $perpage;
$endIndex = min($startIndex + $perpage, $count);

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
    <tbody>
<?php for ($i = $startIndex; $i < $endIndex; $i++): $post = $lines[$i];
    // Local date conversion
    $date_format_locale = gmdate($date_time_format, $post->gbDate + 3600 * ($timezone_offset + date("I")));
    if ($dst_auto_detect == 0) {
        $date_format_locale = gmdate($date_time_format, $post->gbDate + 3600 * ($timezone_offset));
    }
?>
        <tr>
            <td><?php echo htmlspecialchars($post->gbFrom); ?></td>
            <td><a href="mailto:<?php echo htmlspecialchars($post->gbEmail); ?>"><?php echo htmlspecialchars($post->gbEmail); ?></a></td>
            <td><?php echo htmlspecialchars($date_format_locale); ?></td>
            <td><a href="delete_process.php?id=<?php echo $i; ?>&order=<?php echo $order; ?>" class="table-icon delete" title="Delete"></a></td>
        </tr>
        <tr>
            <td colspan="4"><?php echo $post->gbMessage; ?></td>
        </tr>
<?php endfor; ?>
    </tbody>
</table>
</center>
<?php
// Pagination ------------------------------------------------------------
echo '<center><div class="pagination" style="margin-top:10px;">';
if ($page > 1) {
    echo '<a href="index.php?page=1&order=' . $order . '">&lt;&lt;</a>';
    echo '<a href="index.php?page=' . ($page-1) . '&order=' . $order . '">&lt;</a>';
}
$startPagination = max(1, $page - 3);
$endPagination   = min($totalpages, $page + 3);
for ($p = $startPagination; $p <= $endPagination; $p++) {
    if ($p == $page) {
        echo '<b><a class="current" href="index.php?page=' . $p . '&order=' . $order . '">' . $p . '</a></b>';
    } else {
        echo '<a href="index.php?page=' . $p . '&order=' . $order . '">' . $p . '</a>';
    }
}
if ($page < $totalpages) {
    echo '<a href="index.php?page=' . ($page+1) . '&order=' . $order . '">&gt;</a>';
    echo '<a href="index.php?page=' . $totalpages . '&order=' . $order . '">&gt;&gt;</a>';
}
echo '</div></center>';

include ("includes/footer.php");
?>
