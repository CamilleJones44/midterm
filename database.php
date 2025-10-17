<?php
$host = 'localhost'; 
// Database host
$db = 'conference_room_scheduler'; 
// Database name
$user = 'root'; // Database username
$passing = ''; 
// Database password
try {    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $passing);    
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {    
    die("Could not connect to the database $db :" . $e->getMessage());}?>