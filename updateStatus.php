<?php
$servername = getenv('MYSQLHOST');
$username   = getenv('MYSQLUSER');
$password   = getenv('MYSQLPASSWORD');
$dbname     = getenv('MYSQLDATABASE');
$port       = getenv('MYSQLPORT');

$conn = new mysqli($servername, $username, $password, $dbname, $port);

$id = $_GET['id'];
$status = $_GET['status']; // 2=Confirmed, 3=Rejected

if($id && $status){
    $sql = "UPDATE natc_booking SET status = '$status' WHERE booking_id = '$id'";
    if($conn->query($sql)){
        echo "<div style='text-align:center; padding-top:100px; font-family:sans-serif;'>";
        echo "<h1>Status Updated Successfully!</h1>";
        echo "<p>The customer's tracking page now reflects this change.</p>";
        echo "</div>";
    }
}
?>