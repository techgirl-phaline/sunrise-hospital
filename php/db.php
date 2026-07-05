<?php
$servername="localhost";
$username ="root";
$password = "";
$dbname = "hospital_management";

$conn = new mysqli("localhost", "root", "", "hospital_management");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>