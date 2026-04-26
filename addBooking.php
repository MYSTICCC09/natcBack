<?php
if(isset($_POST)){
    // Use Railway environment variables
    $servername = getenv('MYSQLHOST');
    $username   = getenv('MYSQLUSER');
    $password   = getenv('MYSQLPASSWORD');
    $dbname     = getenv('MYSQLDATABASE');
    $port       = getenv('MYSQLPORT');

    $conn = new mysqli($servername, $username, $password, $dbname, $port);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } else {
        $time = date('H:i:s');
        $originalDate = $_POST['date'];
        $newDate = date("Y-m-d", strtotime($originalDate));
        
        // Sanitize input
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);

        $sql = "INSERT INTO natc_booking (booking_no, booking_date, booking_time, driver_id, vehicle_id, status, booking_fare, name, phone, email, pickup, vehicle_type, passengers, luggage, notes, dr_id)
                VALUES ('none', '{$newDate}', '{$time}', 0, 0, 1, 0, '{$_POST['name']}', '{$_POST['phone']}', '{$_POST['email']}', '{$_POST['pickup']}', '{$_POST['vehicle']}', '{$_POST['passengers']}', '{$_POST['luggage']}', '{$_POST['notes']}', '{$_POST['destination']}')";

        if (!mysqli_query($conn, $sql)) {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        } else {
            $last_id = $conn->insert_id;
            $bookingNo = strtoupper(substr(md5(base64_encode($last_id.$newDate."natc".$time)), 0, 10));
            $sql = "UPDATE natc_booking SET booking_no='{$bookingNo}' WHERE booking_id=$last_id";

            if ($conn->query($sql)) {
                $sql = "SELECT * FROM natc_destination_rates WHERE dr_id={$_POST['destination']} limit 1";
                $result = $conn->query($sql);
                $res = $result->fetch_assoc();

                $rate = 0;
                if($_POST['vehicle'] == 'Innova') $rate = $res['dr_rate_innova'];
                if($_POST['vehicle'] == 'Van') $rate = $res['dr_rate_van'];

                $confirmUrl = "https://natcback-production.up.railway.app/confirmBooking.php?bid={$last_id}";
                
                // Get API Keys from Railway Variables
                $apiKey = getenv('MAILJET_API_KEY');
                $apiSecret = getenv('MAILJET_SECRET_KEY');

                // Prepare the Email Data
                $postData = json_encode([
                    'Messages' => [[
                        'From' => [
                            'Email' => 'andreicapili4@gmail.com', 
                            'Name' => 'NATC Booking'
                        ],
                        'To' => [
                            ['Email' => $_POST['email'], 'Name' => $_POST['name']], // To the Customer
                            ['Email' => 'andreicapili4@gmail.com'] // Copy to yourself
                        ],
                        'Subject' => 'Booking Confirmation - ' . $bookingNo,
                        'HTMLPart' => "
                            <h3>New Booking Received!</h3>
                            <p><strong>Booking No:</strong> {$bookingNo}</p>
                            <p><strong>Name:</strong> {$_POST['name']}</p>
                            <p><strong>Pickup:</strong> {$_POST['pickup']}</p>
                            <p><strong>Date:</strong> {$newDate}</p>
                            <p><strong>Rate:</strong> {$rate} php</p>
                            <br>
                            <a href='{$confirmUrl}' style='background: green; color: white; padding: 10px; text-decoration: none;'>CONFIRM BOOKING</a>"
                    ]]
                ]);

                // Send via cURL (more reliable on Railway than file_get_contents)
                $ch = curl_init('https://api.mailjet.com/v3.1/send');
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, [
                    'Content-Type: application/json',
                    'Authorization: Basic ' . base64_encode($apiKey . ":" . $apiSecret)
                ]);

                $response = curl_exec($ch);
                curl_close($ch);

                // Redirect to success page
                header('Location: https://natc-production.up.railway.app/bookingSuccess.php?bid='.$last_id);
                exit;
            }
        }
    }
}
?>