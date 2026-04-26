<?php
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

            // --- NATIVE PHP MAIL ---
            $to = "andreicapili4@gmail.com";
            $subject = "NATC BOOKING SUCCESS - $bookingNo";
            
            $message = "
            New Booking Received:
            Booking No: $bookingNo
            Name: $name
            Vehicle: $vehicle
            Pickup: $pickup
            Rate: $rate php
            ";

            $headers = "From: webmaster@natc-production.up.railway.app" . "\r\n" .
                       "Reply-To: $email" . "\r\n" .
                       "X-Mailer: PHP/" . phpversion();

            // Attempt to send
            mail($to, $subject, $message, $headers);
            // --- END MAIL ---

            header('Location: https://natc-production.up.railway.app/bookingSuccess.php?bid='.$last_id);
            exit;
        }
    }
}
?>