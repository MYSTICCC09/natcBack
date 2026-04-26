<?php
$servername = getenv('MYSQLHOST');
$username   = getenv('MYSQLUSER');
$password   = getenv('MYSQLPASSWORD');
$dbname     = getenv('MYSQLDATABASE');
$port       = getenv('MYSQLPORT');

$conn = new mysqli($servername, $username, $password, $dbname, $port);

$booking_id = $_GET['id'];
$status_code = $_GET['status']; // 2 for Accept, 3 for Reject

$sql = "UPDATE natc_booking SET status = '$status_code' WHERE booking_id = '$booking_id'";

if ($conn->query($sql)) {
    $msg = ($status_code == 2) ? "Booking Accepted! Drive safe." : "Booking Rejected.";
    echo "<h1>$msg</h1><p>You can close this window now.</p>";
} else {
    echo "<h1>Error updating booking.</h1>";
}
?>