<?php
$servername = getenv('MYSQLHOST');
$username   = getenv('MYSQLUSER');
$password   = getenv('MYSQLPASSWORD');
$dbname     = getenv('MYSQLDATABASE');
$port       = getenv('MYSQLPORT');

$conn = new mysqli($servername, $username, $password, $dbname, $port);

$id = isset($_GET['id']) ? $_GET['id'] : null;
$status = isset($_GET['status']) ? $_GET['status'] : null;

if ($id && $status) {
    $sql = "UPDATE natc_booking SET status = '$status' WHERE booking_id = '$id'";
    
    if ($conn->query($sql)) {
        $booking = $conn->query("SELECT booking_no FROM natc_booking WHERE booking_id = '$id'")->fetch_assoc();
        $bNo = $booking['booking_no'];

        echo "<div style='text-align:center; padding-top:100px; font-family:sans-serif;'>";
        if ($status == 2) {
            echo "<h1 style='color: #28a745;'>✅ Booking Accepted</h1>";
        } else {
            echo "<h1 style='color: #dc3545;'>❌ Booking Rejected</h1>";
        }
        echo "<p style='font-size: 1.2em;'>The tracking page has been updated. Drive safe!</p>";
        
        echo "<div style='margin-top: 30px;'>";
            echo "<a href='index.php' style='display: inline-block; padding: 12px 25px; background-color: #007bff; color: white; text-decoration: none; border-radius: 5px; margin: 10px; font-weight:bold;'>Go to Home Page</a>";
            
            echo "<form action='tracking.php' method='POST' style='display:inline;'>
                    <input type='hidden' name='bId' value='$bNo'>
                    <button type='submit' style='padding: 12px 25px; background-color: #6c757d; color: white; border: none; border-radius: 5px; cursor: pointer; margin: 10px; font-weight:bold;'>View Tracking Result</button>
                  </form>";
        echo "</div>";
        echo "</div>";
    }
}
$conn->close();
?>