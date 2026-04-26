<?php
// Report every single detail to Railway logs
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
        error_log("DATABASE CONNECTION ERROR: " . $conn->connect_error);
        die("Connection failed");
    } else {
        $time = date('H:i:s');
        $newDate = date("Y-m-d", strtotime($_POST['date']));
        
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

            $res = $conn->query("SELECT * FROM natc_destination_rates WHERE dr_id='{$dest_id}' LIMIT 1")->fetch_assoc();
            $rate = ($vehicle == 'Innova') ? $res['dr_rate_innova'] : $res['dr_rate_van'];

            // API KEYS - TRIMMING TO REMOVE HIDDEN SPACES
            $apiKey = trim(getenv('MAILJET_API_KEY'));
            $apiSecret = trim(getenv('MAILJET_SECRET_KEY'));

            $payload = json_encode([
                'Messages' => [[
                    'From' => ['Email' => 'andreicapili4@gmail.com', 'Name' => 'NATC'],
                    'To' => [['Email' => $email, 'Name' => $name]],
                    'Subject' => "Booking #$bookingNo Confirmed",
                    'HTMLPart' => "<h3>Success!</h3><p>Your booking #$bookingNo is confirmed. Rate: $rate php.</p>"
                ]]
            ]);

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://api.mailjet.com/v3.1/send');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json',
                'Authorization: Basic ' . base64_encode($apiKey . ":" . $apiSecret)
            ]);

            $response = curl_exec($ch);
            $err = curl_error($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            
            // LOG THIS DATA
            error_log("MAILJET HTTP CODE: " . $httpCode);
            if ($err) {
                error_log("CURL ERROR: " . $err);
            } else {
                error_log("MAILJET RESPONSE: " . $response);
            }
            
            curl_close($ch);

            header('Location: https://natc-production.up.railway.app/bookingSuccess.php?bid='.$last_id);
            exit;
        }
    }
}
?>