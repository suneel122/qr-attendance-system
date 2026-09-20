<?php
$host = "mysql-28f2100b-your-aiven-host.aivencloud.com";
$port = "25232";
$user = "avnadmin";
$pass = "your_aiven_password";
$dbname = "defaultdb";

$conn = new mysqli($host, $user, $pass, $dbname, $port);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>