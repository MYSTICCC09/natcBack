<?php
// Force errors to show up in Railway logs
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
        error_log("DATABASE CONNECTION FAILED: " . $conn->connect_error);
        die("Connection failed: " . $conn->connect_error);
    } else {
        $time = date('H:i:s');
        $originalDate = $_POST['date'];
        $newDate = date("Y-m-d", strtotime($originalDate));
        
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);

        $sql = "INSERT INTO natc_booking (booking_no, booking_date, booking_time, driver_id, vehicle_id, status, booking_fare, name, phone, email, pickup, vehicle_type, passengers, luggage, notes, dr_id)
                VALUES ('none', '{$newDate}', '{$time}', 0, 0, 1, 0, '{$_POST['name']}', '{$_POST['phone']}', '{$_POST['email']}', '{$_POST['pickup']}', '{$_POST['vehicle']}', '{$_POST['passengers']}', '{$_POST['luggage']}', '{$_POST['notes']}', '{$_POST['destination']}')";

        if (!mysqli_query($conn, $sql)) {
            error_log("INSERT ERROR: " . mysqli_error($conn));
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        } else {
            $last_id = $conn->insert_id;
            $bookingNo = strtoupper(substr(md5(base64_encode($last_id.$newDate."natc".$time)), 0, 10));
            $sql = "UPDATE natc_booking SET booking_no='{$bookingNo}' WHERE booking_id=$last_id";

            if ($conn->query($sql)) {
                $sql_rate = "SELECT * FROM natc_destination_rates WHERE dr_id={$_POST['destination']} limit 1";
                $result = $conn->query($sql_rate);
                $res = $result->fetch_assoc();

                $rate = 0;
                if($_POST['vehicle'] == 'Innova') $rate = $res['dr_rate_innova'];
                if($_POST['vehicle'] == 'Van') $rate = $res['dr_rate_van'];

                $confirmUrl = "https://natcback-production.up.railway.app/confirmBooking.php?bid={$last_id}";
                
                // Get Keys
                $apiKey = getenv('MAILJET_API_KEY');
                $apiSecret = getenv('MAILJET_SECRET_KEY');

                $postData = json_encode([
                    'Messages' => [[
                        'From' => ['Email' => 'andreicapili4@gmail.com', 'Name' => 'NATC Booking'],
                        'To' => [['Email' => $_POST['email'], 'Name' => $_POST['name']]],
                        'Subject' => 'Booking Confirmation - ' . $bookingNo,
                        'HTMLPart' => "<h3>Booking Received!</h3><p>No: {$bookingNo}</p><p>Rate: {$rate} php</p><br><a href='{$confirmUrl}'>CONFIRM</a>"
                    ]]
                ]);

                // SEND VIA CURL
                $ch = curl_init('https://api.mailjet.com/v3.1/send');
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, [
                    'Content-Type: application/json',
                    'Authorization: Basic ' . base64_encode($apiKey . ":" . $apiSecret)
                ]);

                $response = curl_exec($ch);
                $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                
                // This logs the status to your Railway Deploy Logs
                error_log("MAILJET STATUS CODE: " . $httpCode);
                error_log("MAILJET RAW RESPONSE: " . $response);
                
                curl_close($ch);

                header('Location: https://natc-production.up.railway.app/bookingSuccess.php?bid='.$last_id);
                exit;
            }
        }
    }
}
?>