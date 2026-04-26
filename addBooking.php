<?php
if(isset($_POST)){
    // Database connection using Railway variables
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

        // Insert into DB
        $sql = "INSERT INTO natc_booking (booking_no, booking_date, booking_time, driver_id, vehicle_id, status, booking_fare, name, phone, email, pickup, vehicle_type, passengers, luggage, notes, dr_id)
                VALUES ('none', '{$newDate}', '{$time}', 0, 0, 1, 0, '{$name}', '{$phone}', '{$_POST['email']}', '{$pickup}', '{$vehicle}', '{$_POST['passengers']}', '{$_POST['luggage']}', '{$_POST['notes']}', '{$dest_id}')";

        if ($conn->query($sql)) {
            $last_id = $conn->insert_id;
            $bookingNo = strtoupper(substr(md5($last_id . "natc"), 0, 10));
            $conn->query("UPDATE natc_booking SET booking_no='{$bookingNo}' WHERE booking_id=$last_id");

            // Get Rate details
            $res = $conn->query("SELECT * FROM natc_destination_rates WHERE dr_id='{$dest_id}' LIMIT 1")->fetch_assoc();
            $rate = ($vehicle == 'Innova') ? $res['dr_rate_innova'] : $res['dr_rate_van'];

            // --- TELEGRAM NOTIFICATION ---
            $botToken = getenv('TELEGRAM_BOT_TOKEN');
            $chatId = getenv('TELEGRAM_CHAT_ID');
            
            $msg = "🚕 *NEW NATC BOOKING*\n\n";
            $msg .= "🆔 *Booking No:* `$bookingNo` \n";
            $msg .= "👤 *Name:* $name\n";
            $msg .= "📞 *Phone:* $phone\n";
            $msg .= "📍 *Pickup:* $pickup\n";
            $msg .= "🏁 *To:* " . $res['dr_destination'] . "\n";
            $msg .= "💰 *Rate:* ₱$rate";

            $url = "https://api.telegram.org/bot$botToken/sendMessage?chat_id=$chatId&parse_mode=markdown&text=" . urlencode($msg);
            
            // Send the message
            file_get_contents($url);
            // --- END TELEGRAM ---

            header('Location: https://natc-production.up.railway.app/bookingSuccess.php?bid='.$last_id);
            exit;
        }
    }
}
?>