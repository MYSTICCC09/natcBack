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
        die("Connection failed: " . $conn->connect_error);
    } else {
        $time = date('H:i:s');
        $originalDate = $_POST['date'];
        $newDate = date("Y-m-d", strtotime($originalDate));
        
        // Escape data for SQL safety
        $name = $conn->real_escape_string($_POST['name']);
        $email = $conn->real_escape_string($_POST['email']);
        $phone = $conn->real_escape_string($_POST['phone']);
        $pickup = $conn->real_escape_string($_POST['pickup']);
        $vehicle = $conn->real_escape_string($_POST['vehicle']);
        $dest_id = $conn->real_escape_string($_POST['destination']);

        // Insert booking into database
        $sql = "INSERT INTO natc_booking (booking_no, booking_date, booking_time, driver_id, vehicle_id, status, booking_fare, name, phone, email, pickup, vehicle_type, passengers, luggage, notes, dr_id)
                VALUES ('none', '{$newDate}', '{$time}', 0, 0, 1, 0, '{$name}', '{$phone}', '{$email}', '{$pickup}', '{$vehicle}', '{$_POST['passengers']}', '{$_POST['luggage']}', '{$_POST['notes']}', '{$dest_id}')";

        if ($conn->query($sql)) {
            $last_id = $conn->insert_id;
            
            // Generate tracking number
            $bookingNo = strtoupper(substr(md5($last_id . "natc" . $time), 0, 10));
            $conn->query("UPDATE natc_booking SET booking_no='{$bookingNo}' WHERE booking_id=$last_id");

            // Fetch destination rate
            $res = $conn->query("SELECT * FROM natc_destination_rates WHERE dr_id='{$dest_id}' LIMIT 1")->fetch_assoc();
            $rate = ($vehicle == 'Innova') ? $res['dr_rate_innova'] : $res['dr_rate_van'];

            // --- FAIL-PROOF MAILTO LOGIC ---
            // This bypasses all server blocks by using the user's local email app
            $subject = "NATC Booking Confirmation - $bookingNo";
            $body = "Hello,\n\nYour booking has been recorded!\n\nDetails:\n" .
                    "Booking No: $bookingNo\n" .
                    "Name: $name\n" .
                    "Vehicle: $vehicle\n" .
                    "Pickup: $pickup\n" .
                    "Date: $newDate\n" .
                    "Rate: $rate php\n\n" .
                    "Please click send to finalize this email.";

            $mailtoUrl = "mailto:andreicapili4@gmail.com" . 
                         "?subject=" . rawurlencode($subject) . 
                         "&body=" . rawurlencode($body);

            // Redirect user to the mailto link
            header("Location: " . $mailtoUrl);
            
            // Note: After the user sends/closes the email, they will still 
            // be at your site, but we should suggest they go to the success page.
            // For a school project, this is the most reliable way to show "Email" works.
            exit;
        }
    }
}
?>