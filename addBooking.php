<?php
if(isset($_POST)){
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

                while($row = $result->fetch_assoc()) {
                    $res = $row;
                }

                $rate = 0;
                if($_POST['vehicle'] == 'Innova') $rate = $res['dr_rate_innova'];
                if($_POST['vehicle'] == 'Van') $rate = $res['dr_rate_van'];

                // Send notification to admin
                $confirmUrl = "https://natcback-production.up.railway.app/confirmBooking.php?bid={$last_id}";
                $emailData = http_build_query([
                    'name'     => 'NATC Admin',
                    'email'    => 'andreicapili4@gmail.com',
                    '_subject' => 'New Booking - ' . $bookingNo,
                    'message'  => "New booking received!
                Booking No: {$bookingNo}
                Name: {$_POST['name']}
                Phone: {$_POST['phone']}
                Email: {$_POST['email']}
                Vehicle: {$_POST['vehicle']}
                Pickup: {$_POST['pickup']}
                Date: {$newDate}
                Rate: {$rate} php

                CLICK TO CONFIRM: {$confirmUrl}"
                ]);
                $ch = curl_init('https://formsubmit.co/andreicapili4@gmail.com');
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $emailData);
                curl_exec($ch);
                curl_close($ch);

                header('Location: https://natc-production.up.railway.app/bookingSuccess.php?bid='.$last_id);
                exit;
            }
        }
    }
}