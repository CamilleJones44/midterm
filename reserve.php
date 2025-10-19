<?php
require 'database.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $room_number = trim($_POST['room_number']);
    $s_t = trim($_POST['start_time']);
    $end_time = trim($_POST['end_time']);
    $user_id = $_SESSION['user_id'];


    
    // Validate input  
    $b_h_s = "09:00:00";
    $b_h_e = "17:00:00";
    $start_date = new DateTime($s_t);
    $e_d = new DateTime($end_time);
    if ($start_date < new DateTime() || $e_d < new DateTime()) {
        $error = "Cannot reserve in the past!";

    } elseif ($start_date >= $e_d) {
        $error = "End time must be after start time!";

    } elseif ($start_date->format('N') >= 6 || $e_d->format('N') >= 6) {
        $error = "Reservations cannot be made on weekends!";



    } elseif ($start_date->format('H:i:s') < $b_h_s || $e_d->format('H:i:s') > $b_h_e) {
        $error = "Reservations must be within business hours (9 AM - 5 PM)!";


    } else {        // Check for conflicts   
        $soon = $pdo->prepare("SELECT * FROM reservations WHERE room_number = ? AND (        
                                                             (start_time <= ? AND end_time >= ?) OR     
                                                                    (start_time <= ? AND end_time >= ?)        )");
        $soon->execute([$room_number, $end_time, $s_t, $s_t, $end_time]);

            
        if ($soon->rowCount() > 0) {
            $error = "Room is already reserved during this time!";

            
        } else {
            // Insert reservation into the database     
            $soon = $pdo->prepare("INSERT INTO reservations (user_id, room_number, start_time, end_time) VALUES (?, ?, ?, ?)");
            if ($soon->execute([$user_id, $room_number, $s_t, $end_time])) {


                
                $success = "Room reserved successfully!";
            } else {
                $error = "Error reserving room!";
            }
        }
    }
} ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Reserve Room</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <h2><a href="index.php" style="text-decoration: none; color: #fb00ffff;">Register</a></h2>

    
    <form method="POST" action="">

        
        <input type="number" name="room_number" placeholder="Room Number" required>
        <input type="datetime-local" name="start_time" required>
        
        <input type="datetime-local" name="end_time" required>
        <input type="submit" value="Reserve">

        
    </form>
    <p><?php echo $error ?? '';
        ?></p>
    <p><?php echo $success ?? '';
        ?></p>
</body>

</html>
