<?php
$conn = new mysqli("localhost", "root", "", "hospital_management");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

//  Get form data
$patient_name   = $_POST['patient_name'] ?? '';
$patient_id     = $_POST['patient_id'] ?? '';
$national_id    = $_POST['national_id'] ?? '';
$gender         = $_POST['gender'] ?? '';
$phone          = $_POST['phone'] ?? '';
$email          = $_POST['email'] ?? '';
$department     = $_POST['department'] ?? '';
$appointment_date = $_POST['appointment_date'] ?? '';
$notes          = $_POST['notes'] ?? '';
// auto-generate patient ID if empty
if (empty($patient_id)) {
    $prefix = "PAT-" . date("Y") . "-";
    $countResult = $conn->query("SELECT COUNT(*) as total FROM appointments WHERE DATE(created_at) = CURDATE()");
    $row = $countResult->fetch_assoc();
    $count = $row['total'] + 1;
    $patient_id = $prefix . str_pad($count, 3, "0", STR_PAD_LEFT);
}

//  Insert into database
$sql = "INSERT INTO appointments 
        (patient_id, patient_name, national_id, gender, phone, email, department, appointment_date, notes)
        VALUES 
        ('$patient_id', '$patient_name', '$national_id', '$gender', '$phone', '$email', '$department', '$appointment_date', '$notes')";

if ($conn->query($sql) === TRUE) {
    header("Location: thankyou.html");
    exit();
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>