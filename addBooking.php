<?php
if(isset($_POST)){
    $servername = getenv('MYSQLHOST');
    $username   = getenv('MYSQLUSER');
    $password   = getenv('MYSQLPASSWORD');
    $dbname     = getenv('MYSQLDATABASE');
    $port       = getenv('MYSQLPORT');
    $conn = new mysqli($servername, $username, $password, $dbname, $port);
    if ($conn->connect_error) { die("Connection failed: " . $conn->connect_error); }
    else {
        $time = date('H:i:s');
        $originalDate = $_POST['date'];
        $newDate = date("Y-m-d", strtotime($originalDate));
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);
        $sql = "INSERT INTO natc_booking (booking_no, booking_date, booking_time, driver_id, vehicle_id, status, booking_fare, name, phone, email, pickup, vehicle_type, passengers, luggage, notes, dr_id) VALUES ('none', '{$newDate}', '{$time}', 0, 0, 1, 0, '{$_POST['name']}', '{$_POST['phone']}', '{$_POST['email']}', '{$_POST['pickup']}', '{$_POST['vehicle']}', '{$_POST['passengers']}', '{$_POST['luggage']}', '{$_POST['notes']}', '{$_POST['destination']}')";
        if (!mysqli_query($conn, $sql)) { echo "Error: " . mysqli_error($conn); }
        else {
            $last_id = $conn->insert_id;
            $bookingNo = strtoupper(substr(md5(base64_encode($last_id.$newDate."natc".$time)), 0, 10));
            $conn->query("UPDATE natc_booking SET booking_no='{$bookingNo}' WHERE booking_id=$last_id");
            $result = $conn->query("SELECT * FROM natc_destination_rates WHERE dr_id={$_POST['destination']} limit 1");
            $res = $result->fetch_assoc();
            $rate = 0;
            if($_POST['vehicle'] == 'Innova') $rate = $res['dr_rate_innova'];
            if($_POST['vehicle'] == 'Van') $rate = $res['dr_rate_van'];
            $confirmUrl = "https://natcback-production.up.railway.app/confirmBooking.php?bid={$last_id}";
            $apiKey = getenv('MAILJET_API_KEY');
            $apiSecret = getenv('MAILJET_SECRET_KEY');
            $postData = json_encode(['Messages' => [['From' => ['Email' => 'andreicapili4@gmail.com', 'Name' => 'NATC Booking'],'To' => [['Email' => 'andreicapili4@gmail.com'],['Email' => 'andreinituyacapili@gmail.com']],'Subject' => 'New Booking - ' . $bookingNo,'TextPart' => "Booking No: {$bookingNo}\nName: {$_POST['name']}\nPhone: {$_POST['phone']}\nVehicle: {$_POST['vehicle']}\nPickup: {$_POST['pickup']}\nDate: {$newDate}\nRate: {$rate} php\nCONFIRM: {$confirmUrl}"]]]);
            $opts = ['http' => ['method' => 'POST','header' => "Content-Type: application/json\r\nAuthorization: Basic " . base64_encode("{$apiKey}:{$apiSecret}"),'content' => $postData]];
            @file_get_contents('https://api.mailjet.com/v3.1/send', false, stream_context_create($opts));
            header('Location: https://natc-production.up.railway.app/bookingSuccess.php?bid='.$last_id);
            exit;
        }
    }
}
