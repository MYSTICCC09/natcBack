<?php
if(isset($_GET['bid'])){
    $servername = getenv('MYSQLHOST');
    $username   = getenv('MYSQLUSER');
    $password   = getenv('MYSQLPASSWORD');
    $dbname     = getenv('MYSQLDATABASE');
    $port       = getenv('MYSQLPORT');

    $conn = new mysqli($servername, $username, $password, $dbname, $port);
    $bid = intval($_GET['bid']);

    $sql = "UPDATE natc_booking SET status=2, driver_id=1 WHERE booking_id={$bid}";
    
    if($conn->query($sql)){
        echo "<h2>Booking confirmed! Driver Andrei has been assigned.</h2>";
        echo "<a href='https://natc-production.up.railway.app'>Go to NATC website</a>";
    } else {
        echo "Error: " . $conn->error;
    }
    $conn->close();
}