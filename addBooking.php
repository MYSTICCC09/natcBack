<?php
if(isset($_POST)){
    // Use Railway environment variables
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
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

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

                $to = $_POST['email'];
                $subject = "NATC Booking";
                $message = "
                    <html><head><title>NATC BOOKING</title></head>
                    <body>
                    <p>You have booked a/an {$_POST['vehicle']}</p>
                    <table style='width:70%'>
                    <tr>
                        <th>Tracking No.</th><th>Name</th><th>Pickup</th>
                        <th>Destination</th><th>Locations</th><th>Schedule</th><th>Rate</th>
                    </tr>
                    <tr>
                        <td>{$bookingNo}</td>
                        <td>{$_POST['name']}</td>
                        <td>{$_POST['pickup']}</td>
                        <td>{$res['dr_destination']}</td>
                        <td>{$res['dr_locations']}</td>
                        <td>{$newDate}</td>
                        <td>{$rate} php</td>
                    </tr>
                    </table>
                    </body></html>
                ";

                $headers  = "MIME-Version: 1.0\r\n";
                $headers .= "Content-type:text/html;charset=UTF-8\r\n";
                $headers .= "From: <booking@natc.com>\r\n";
                mail($to, $subject, $message, $headers);

                // ✅ Fixed: redirect to your live Railway frontend URL
                header('Location: https://natc-production.up.railway.app/bookingSuccess.php?bid='.$last_id);
                exit;
            }
        }
    }
}