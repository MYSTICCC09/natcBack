<?php
// Force Railway to show every possible error in the logs
ini_set('display_errors', 1);
error_reporting(E_ALL);

if(isset($_POST)){
    $servername = getenv('MYSQLHOST');
    $username   = getenv('MYSQLUSER');
    $password   = getenv('MYSQLPASSWORD');
    $dbname     = getenv('MYSQLDATABASE');
    $port       = getenv('MYSQLPORT');

    $conn = new mysqli($servername, $username, $password, $dbname, $port);

    if ($conn->connect_error) {
        error_log("DB FAIL: " . $conn->connect_error);
        die("Connection failed");
    } else {
        $time = date('H:i:s');
        $newDate = date("Y-m-d", strtotime($_POST['date']));
        
        // Escape data for database
        $name = $conn->real_escape_string($_POST['name']);
        $email = $conn->real_escape_string($_POST['email']);
        $phone = $conn->real_escape_string($_POST['phone']);
        $pickup = $conn->real_escape_string($_POST['pickup']);
        $vehicle = $conn->real_escape_string($_POST['vehicle']);
        $dest_id = $conn->real_escape_string($_POST['destination']);

        $sql = "INSERT INTO natc_booking (booking_no, booking_date, booking_time, driver_id, vehicle_id, status, booking_fare, name, phone, email, pickup, vehicle_type, passengers, luggage, notes, dr_id)
                VALUES ('none', '{$newDate}', '{$time}', 0, 0, 1, 0, '{$name}', '{$phone}', '{$email}', '{$pickup}', '{$vehicle}', '{$_POST['passengers']}', '{$_POST['luggage']}', '{$_POST['notes']}', '{$dest_id}')";

        if ($conn->query($sql)) {
            $last_id = $conn->insert_id;
            $bookingNo = strtoupper(substr(md5($last_id . "natc"), 0, 10));
            $conn->query("UPDATE natc_booking SET booking_no='{$bookingNo}' WHERE booking_id=$last_id");

            // Fetch Rate
            $res = $conn->query("SELECT * FROM natc_destination_rates WHERE dr_id='{$dest_id}' LIMIT 1")->fetch_assoc();
            $rate = ($vehicle == 'Innova') ? $res['dr_rate_innova'] : $res['dr_rate_van'];

            // MAILJET CORE LOGIC
            $apiKey = trim(getenv('MAILJET_API_KEY'));
            $apiSecret = trim(getenv('MAILJET_SECRET_KEY'));

            $payload = json_encode([
                'Messages' => [[
                    'From' => ['Email' => 'andreicapili4@gmail.com', 'Name' => 'NATC'],
                    'To' => [['Email' => $email, 'Name' => $name]],
                    'Subject' => "Booking #$bookingNo Confirmed",
                    'HTMLPart' => "<h3>Booking Confirmed!</h3><p>Tracking: $bookingNo</p><p>Rate: $rate php</p>"
                ]]
            ]);

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://api.mailjet.com/v3.1/send');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Bypasses SSL certificate issues on cloud hosts
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json',
                'Authorization: Basic ' . base64_encode($apiKey . ":" . $apiSecret)
            ]);

            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            
            // This is the most important part: check your Railway logs for this!
            error_log("MAILJET ATTEMPT: Code $httpCode");
            error_log("MAILJET BODY: " . $response);
            
            curl_close($ch);

            header('Location: https://natc-production.up.railway.app/bookingSuccess.php?bid='.$last_id);
            exit;
        }
    }
}
?>