<?php

$host = "localhost";
$user = "hobbyuser";
$password = "Vishnu*2011";
$database = "hobbyhub";

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>

#yoyo