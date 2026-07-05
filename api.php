<?php
include  "db.php";
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

$conn = new mysqli("localhost", "root", "", "hospital_management");

if ($conn->connect_error) {
    echo json_encode(["error" => "Database connection failed"]);
    exit();
}

$sql = "SELECT id, patient_id, patient_name, national_id, gender, phone, email, department, appointment_date, notes, created_at 
        FROM appointments 
        ORDER BY id DESC";

$result = $conn->query($sql);

$appointments = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $appointments[] = $row;
    }
}

echo json_encode([
    "status" => "success",
    "count" => count($appointments),
    "data" => $appointments
]);

$conn->close();
?>