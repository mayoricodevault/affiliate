<?php
include('../auth/db-connect.php');
$sql = "SELECT * FROM ap_payouts WHERE status=0 AND payment_method=1 ORDER BY id DESC";
$result = mysqli_query($mysqli, 'SELECT * FROM ap_payouts WHERE status=0 AND payment_method=1 ORDER BY id DESC');
$row = mysqli_fetch_array($result, MYSQLI_ASSOC);

$fp = fopen('file.csv', 'w');

foreach ($row as $val) {
    fputcsv($fp, $val);
}

fclose($fp);
?>