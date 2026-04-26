<?php
// Database connection
$servername = getenv('MYSQLHOST');
$username   = getenv('MYSQLUSER');
$password   = getenv('MYSQLPASSWORD');
$dbname     = getenv('MYSQLDATABASE');
$port       = getenv('MYSQLPORT');

$conn = new mysqli($servername, $username, $password, $dbname, $port);

$id = isset($_GET['id']) ? $_GET['id'] : null;
$status = isset($_GET['status']) ? $_GET['status'] : null;

?>
<!DOCTYPE html>
<html>
<head>
    <title>NATC Status Update</title>
    <link rel="stylesheet" href="css/bootstrap.css">
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #f4f7f6; }
        .card { max-width: 500px; margin: 100px auto; padding: 40px; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); background: white; text-align: center; }
        .btn-custom { padding: 12px 25px; border-radius: 8px; font-weight: 600; text-decoration: none; display: inline-block; margin: 10px; transition: 0.3s; }
        .btn-home { background-color: #007bff; color: white; }
        .btn-home:hover { background-color: #0056b3; color: white; }
        .btn-track { background-color: #6c757d; color: white; border: none; }
        .btn-track:hover { background-color: #5a6268; color: white; }
    </style>
</head>
<body>

    <div class="card">
        <?php
        if ($id && $status) {
            $sql = "UPDATE natc_booking SET status = '$status' WHERE booking_id = '$id'";
            
            if ($conn->query($sql)) {
                // Fetch the booking number for the tracking button
                $query = $conn->query("SELECT booking_no FROM natc_booking WHERE booking_id = '$id'");
                $booking = $query->fetch_assoc();
                $bNo = $booking['booking_no'];

                if ($status == 2) {
                    echo "<h1 style='color: #28a745;'>✅ Booking Accepted</h1>";
                } else {
                    echo "<h1 style='color: #dc3545;'>❌ Booking Rejected</h1>";
                }
                
                echo "<p class='mt-3'>The customer tracking page has been updated. Drive safe!</p>";
                
                echo "<div class='mt-4'>";
                    // THE HOME BUTTON
                    echo "<a href='index.php' class='btn-custom btn-home'>Go to Home Page</a>";
                    
                    // THE TRACKING BUTTON (using a form to POST the ID)
                    echo "<form action='tracking.php' method='POST' style='display:inline;'>
                            <input type='hidden' name='bId' value='$bNo'>
                            <button type='submit' class='btn-custom btn-track'>View Tracking Page</button>
                          </form>";
                echo "</div>";
                
            } else {
                echo "<h2>Error updating status.</h2>";
            }
        } else {
            echo "<h2>Invalid Request.</h2>";
        }
        $conn->close();
        ?>
        <p class='mt-4 text-muted'><small>You can now safely close this tab.</small></p>
    </div>

</body>
</html>