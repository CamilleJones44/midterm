<?php
require 'database.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
$show_future = isset($_GET['future']);
$query = $show_future ?
    "SELECT * FROM reservations WHERE start_time > NOW() ORDER BY start_time" : "SELECT * FROM reservations ORDER BY start_time";
$soon = $pdo->prepare($query);
$soon->execute();
$reservations = $soon->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Reservations</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
       <h2><a href="index.php" style="text-decoration: none; color: #007bff;">Registration List</a></h2>

    <form method="GET" action="">
        <button type="submit" name="all">Show All</button>
        <button type="submit" name="future">Show Future Reservations</button>
    </form>
    <table>
        <tr>
            <th>Room Number</th>
            <th>Start Time</th>
            <th>End Time</th>
        </tr>
        <?php foreach ($reservations as $reservation): ?>
            <tr>
                <td><?php echo htmlspecialchars($reservation['room_number']);
                    ?>
                </td>
                <td><?php echo htmlspecialchars($reservation['start_time']);
                    ?></td>
                <td>
                    <?php echo htmlspecialchars($reservation['end_time']);
                    ?></td>
            </tr> <?php endforeach;
                    ?>
    </table>
</body>

</html>
