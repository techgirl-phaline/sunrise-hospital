<?php
$conn = new mysqli("localhost", "root", "", "hospital_management");

// Delete
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM appointments WHERE id = $id");
    header("Location: view_appointments.php");
    exit();
    
}

// Search
$search = $_GET['search'] ?? '';
$sql = "SELECT * FROM appointments";
if (!empty($search)) {
    $sql .= " WHERE patient_name LIKE '%$search%' OR national_id LIKE '%$search%'";
}
$sql .= " ORDER BY id DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Appointments</title>
    <link rel="stylesheet" href="style.css"> 

</head>
<body>

<h2>Appointment Records</h2>

<!-- Search -->
<form method="GET">
    <input type="text" name="search" placeholder="Search..." value="<?php echo $search; ?>">
    <button type="submit">Search</button>
    <a href="view_appointments.php">Clear</a>

</form>

<br>

<table border="1" cellpadding="8">
    <tr>
        <th>ID</th>
        <th>Patient ID</th>
        <th>Name</th>
        <th>National ID</th>
        <th>Gender</th>
        <th>Phone</th>
        <th>Email</th>
        <th>Department</th>
        <th>Date</th>
        <th>Action</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()): ?>
    <tr>
        <td><?php echo $row['id']; ?></td>
        <td><?php echo $row['patient_id']; ?></td>
        <td><?php echo $row['patient_name']; ?></td>
        <td><?php echo $row['national_id']; ?></td>
        <td><?php echo $row['gender']; ?></td>
        <td><?php echo $row['phone']; ?></td>
        <td><?php echo $row['email']; ?></td>
        <td><?php echo $row['department']; ?></td>
        <td><?php echo $row['appointment_date']; ?></td>
        <td>
            <a href="edit_appointment.php?id=<?php echo $row['id']; ?>">Edit</a> |
            <a href="view_appointments.php?delete=<?php echo $row['id']; ?>" onclick="return confirm('Delete?')">Delete</a>
        </td>
    </tr>
    <?php endwhile; ?>
</table>

<br>
<a href="appointment.html">Book New Appointment</a>

</body>
</html>