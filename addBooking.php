<?php
// Enable error logging for Railway Deploy Logs
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
        error_log("DB Connection Error: " . $conn->connect_error);
        die("Connection failed: " . $conn->connect_error);
    } else {
        $time = date('H:i:s');
        $originalDate = $_POST['date'];
        $newDate = date("Y-m-d", strtotime($originalDate));
        
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);

        $sql = "INSERT INTO natc_booking (booking_no, booking_date, booking_time, driver_id, vehicle_id, status, booking_fare, name, phone, email, pickup, vehicle_type, passengers, luggage, notes, dr_id)
                VALUES ('none', '{$newDate}', '{$time}', 0, 0, 1, 0, '{$_POST['name']}', '{$_POST['phone']}', '{$_POST['email']}', '{$_POST['pickup']}', '{$_POST['vehicle']}', '{$_POST['passengers']}', '{$_POST['luggage']}', '{$_POST['notes']}', '{$_POST['destination']}')";

        if (!mysqli_query($conn, $sql)) {
            error_log("SQL Error: " . mysqli_error($conn));
        } else {
            $last_id = $conn->insert_id;
            $bookingNo = strtoupper(substr(md5(base64_encode($last_id.$newDate."natc".$time)), 0, 10));
            $conn->query("UPDATE natc_booking SET booking_no='{$bookingNo}' WHERE booking_id=$last_id");

            $sql_rate = "SELECT * FROM natc_destination_rates WHERE dr_id={$_POST['destination']} limit 1";
            $result = $conn->query($sql_rate);
            $res = $result->fetch_assoc();

            $rate = ($_POST['vehicle'] == 'Innova') ? $res['dr_rate_innova'] : $res['dr_rate_van'];

            // Mailjet Config from Railway Variables
            $apiKey = getenv('MAILJET_API_KEY');
            $apiSecret = getenv('MAILJET_SECRET_KEY');

            $postData = json_encode([
                'Messages' => [[
                    'From' => ['Email' => 'andreicapili4@gmail.com', 'Name' => 'NATC Booking'],
                    'To' => [
                        ['Email' => $_POST['email'], 'Name' => $_POST['name']],
                        ['Email' => 'andreicapili4@gmail.com']
                    ],
                    'Subject' => 'Booking Confirmation - ' . $bookingNo,
                    'HTMLPart' => "<h3>Booking Received!</h3><p>No: {$bookingNo}</p><p>Rate: {$rate} php</p>"
                ]]
            ]);

            $ch = curl_init('https://api.mailjet.com/v3.1/send');
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json',
                'Authorization: Basic ' . base64_encode($apiKey . ":" . $apiSecret)
            ]);

            $response = curl_exec($ch);
            $err = curl_error($ch);
            
            // Log results to Railway Deploy Logs
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