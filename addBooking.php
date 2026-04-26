<?php
// Report errors but don't let them break the redirect
error_reporting(E_ALL);
ini_set('display_errors', 0); 

if(isset($_POST)){
    $servername = getenv('MYSQLHOST');
    $username   = getenv('MYSQLUSER');
    $password   = getenv('MYSQLPASSWORD');
    $dbname     = getenv('MYSQLDATABASE');
    $port       = getenv('MYSQLPORT');

    $conn = new mysqli($servername, $username, $password, $dbname, $port);

    if ($conn->connect_error) {
        die("Connection failed");
    } else {
        $time = date('H:i:s');
        $newDate = date("Y-m-d", strtotime($_POST['date']));
        
        $name = $conn->real_escape_string($_POST['name']);
        $phone = $conn->real_escape_string($_POST['phone']);
        $pickup = $conn->real_escape_string($_POST['pickup']);
        $vehicle = $conn->real_escape_string($_POST['vehicle']);
        $dest_id = $conn->real_escape_string($_POST['destination']);

        $sql = "INSERT INTO natc_booking (booking_no, booking_date, booking_time, driver_id, vehicle_id, status, booking_fare, name, phone, email, pickup, vehicle_type, passengers, luggage, notes, dr_id)
                VALUES ('none', '{$newDate}', '{$time}', 0, 0, 1, 0, '{$name}', '{$phone}', '{$_POST['email']}', '{$pickup}', '{$vehicle}', '{$_POST['passengers']}', '{$_POST['luggage']}', '{$_POST['notes']}', '{$dest_id}')";

        if ($conn->query($sql)) {
            $last_id = $conn->insert_id;
            $bookingNo = strtoupper(substr(md5($last_id . "natc"), 0, 10));
            $conn->query("UPDATE natc_booking SET booking_no='{$bookingNo}' WHERE booking_id=$last_id");

            $res = $conn->query("SELECT * FROM natc_destination_rates WHERE dr_id='{$dest_id}' LIMIT 1")->fetch_assoc();
            $rate = ($vehicle == 'Innova') ? $res['dr_rate_innova'] : $res['dr_rate_van'];

            // --- TELEGRAM LOGIC ---
            $token = trim(getenv('TELEGRAM_BOT_TOKEN'));
            $chat  = trim(getenv('TELEGRAM_CHAT_ID'));
            
            if(!empty($token) && !empty($chat)) {
                $text = "🚖 *NEW BOOKING*\n*No:* $bookingNo\n*Name:* $name\n*Rate:* ₱$rate";
                $url = "https://api.telegram.org/bot$token/sendMessage?chat_id=$chat&parse_mode=markdown&text=" . urlencode($text);
                
                // The '@' and timeout ensure the script doesn't hang or show warnings
                $ctx = stream_context_create(['http' => ['timeout' => 3]]);
                @file_get_contents($url, false, $ctx);
            }

            // Always redirect to success page
            header('Location: https://natc-production.up.railway.app/bookingSuccess.php?bid='.$last_id);
            exit;
        }
    }
}
?>