<?php
// Enable error logging for Railway
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if(isset($_POST)){
    $servername = getenv('MYSQLHOST');
    $username   = getenv('MYSQLUSER');
    $password   = getenv('MYSQLPASSWORD');
    $dbname     = getenv('MYSQLDATABASE');
    $port       = getenv('MYSQLPORT');

    $conn = new mysqli($servername, $username, $password, $dbname, $port);

    if ($conn->connect_error) {
        error_log("DB CONNECTION ERROR: " . $conn->connect_error);
        die("Connection failed");
    } else {
        $time = date('H:i:s');
        $originalDate = $_POST['date'];
        $newDate = date("Y-m-d", strtotime($originalDate));
        
        // Sanitize inputs
        $name = $conn->real_escape_string($_POST['name']);
        $email = $conn->real_escape_string($_POST['email']);
        $phone = $conn->real_escape_string($_POST['phone']);
        $pickup = $conn->real_escape_string($_POST['pickup']);
        $vehicle = $conn->real_escape_string($_POST['vehicle']);
        $destination = $conn->real_escape_string($_POST['destination']);

        $sql = "INSERT INTO natc_booking (booking_no, booking_date, booking_time, driver_id, vehicle_id, status, booking_fare, name, phone, email, pickup, vehicle_type, passengers, luggage, notes, dr_id)
                VALUES ('none', '{$newDate}', '{$time}', 0, 0, 1, 0, '{$name}', '{$phone}', '{$email}', '{$pickup}', '{$vehicle}', '{$_POST['passengers']}', '{$_POST['luggage']}', '{$_POST['notes']}', '{$destination}')";

        if ($conn->query($sql)) {
            $last_id = $conn->insert_id;
            $bookingNo = strtoupper(substr(md5($last_id . $time), 0, 10));
            $conn->query("UPDATE natc_booking SET booking_no='{$bookingNo}' WHERE booking_id=$last_id");

            // Fetch destination rate
            $res = $conn->query("SELECT * FROM natc_destination_rates WHERE dr_id='{$destination}' LIMIT 1")->fetch_assoc();
            $rate = ($vehicle == 'Innova') ? $res['dr_rate_innova'] : $res['dr_rate_van'];

            // Mailjet API logic
            $apiKey = getenv('MAILJET_API_KEY');
            $apiSecret = getenv('MAILJET_SECRET_KEY');

            $data = json_encode([
                'Messages' => [[
                    'From' => [
                        'Email' => 'andreicapili4@gmail.com', 
                        'Name' => 'NATC Transport'
                    ],
                    'To' => [
                        ['Email' => $email, 'Name' => $name],
                        ['Email' => 'andreicapili4@gmail.com', 'Name' => 'Admin Copy']
                    ],
                    'Subject' => "New Booking #$bookingNo",
                    'HTMLPart' => "
                        <h3>Booking Success!</h3>
                        <p><strong>Tracking No:</strong> $bookingNo</p>
                        <p><strong>Pickup:</strong> $pickup</p>
                        <p><strong>Date:</strong> $newDate</p>
                        <p><strong>Rate:</strong> $rate php</p>
                        <p>Thank you for choosing NATC!</p>"
                ]]
            ]);

            $ch = curl_init('https://api.mailjet.com/v3.1/send');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Required for some cloud environments
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json',
                'Authorization: Basic ' . base64_encode($apiKey . ":" . $apiSecret)
            ]);

            $response = curl_exec($ch);
            $err = curl_error($ch);
            
            if ($err) {
                error_log("MAILJET CURL ERROR: " . $err);
            } else {
                error_log("MAILJET API RESPONSE: " . $response);
            }
            
            curl_close($ch);

            // Final Redirect
            header('Location: https://natc-production.up.railway.app/bookingSuccess.php?bid='.$last_id);
            exit;
        }
    }
}
?>