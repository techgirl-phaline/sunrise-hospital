<?php
// ==========================================
// VIEW, SEARCH & DELETE APPOINTMENTS (TASK 6)
// ==========================================

// connect database
$conn =  mysqli_connect("localhost", "root", "", "hospital_management");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

//  (Delete)
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM appointments WHERE id = $id");
    header("Location: view_appointments.php?msg=deleted");
    exit();
}
//  (Search)
$search = $_GET['search'] ?? '';
$sql = "SELECT * FROM appointments";
if (!empty($search)) {
    $sql .= " WHERE patient_name LIKE '%$search%' 
              OR national_id LIKE '%$search%' 
              OR phone LIKE '%$search%'";
}
$sql .= " ORDER BY id DESC";
$result = $conn->query($sql);

// 4. Angalia kama kuna ujumbe wa kufuta
$msg = $_GET['msg'] ?? '';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Appointments</title>
    <link rel="stylesheet" href="style.css">
     <style>
        body { font-family: Arial; background: #f4f9ff; padding: 20px; }
        .container { max-width: 1200px; margin: auto; background: white; padding: 25px; border-radius: 12px; }
        h2 { color: #0a2e5c; border-bottom: 3px solid #00a8b5; padding-bottom: 10px; }
        .search-box { display: flex; gap: 10px; margin-bottom: 20px; flex-wrap: wrap; }
        .search-box input { flex: 1; padding: 10px; border: 2px solid #ddd; border-radius: 8px; }
        .search-box button { padding: 10px 25px; background: #0a2e5c; color: white; border: none; border-radius: 8px; cursor: pointer; }
        .search-box button:hover { background: #00a8b5; }
        .search-box a { padding: 10px 20px; background: #e0e8f0; color: #0a2e5c; text-decoration: none; border-radius: 8px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; font-size: 14px; }
        th { background: #0a2e5c; color: white; padding: 12px; text-align: left; }
        td { padding: 10px; border-bottom: 1px solid #eee; }
        tr:hover { background: #f8fbff; }
        .btn-delete { background: #e74c3c; color: white; padding: 5px 12px; 
        border-radius: 6px; text-decoration: none; font-size: 13px; }
        .btn-delete:hover { background: #c0392b; }
        .btn-new { display: inline-block; margin-top: 20px; padding: 10px 25px; background: #0a2e5c; color: white; border-radius: 8px; text-decoration: none; }
        .btn-new:hover { background: #00a8b5; }
        .success { background: #d4edda; color: #155724; padding: 12px; border-radius: 8px; margin-bottom: 15px; border-left: 5px solid #28a745; }
        .no-records { text-align: center; padding: 30px; color: #888; }
        @media (max-width: 600px) { th, td { font-size: 12px; padding: 6px; } }
    </style>
</head>
<body>

<div class="container">

    <h2>📋 Appointment Records</h2>

    <?php if ($msg == 'deleted'): ?>
        <div class="success">✅ Record deleted successfully!</div>
    <?php endif; ?>

    <!-- Search Form -->
    <form class="search-box" method="GET">
        <input type="text" name="search" placeholder="Search by name, ID or phone..." value="<?php echo htmlspecialchars($search); ?>">
        <button type="submit">🔍 Search</button>
        <a href="view_appointments.php">Clear</a>
    </form>

    <!--------- Table----------------- -->
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Patient Name</th>
                <th>National ID</th>
                <th>Gender</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Department</th>
                <th>Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['patient_name']; ?></td>
                    <td><?php echo $row['national_id']; ?></td>
                    <td><?php echo $row['gender']; ?></td>
                    <td><?php echo $row['phone']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td><?php echo $row['department']; ?></td>
                    <td><?php echo $row['appointment_date']; ?></td>
                    <td>
                        <a href="view_appointments.php?delete=<?php echo $row['id']; ?>" 
                           onclick="return confirm('Delete this appointment?')" 
                           class="btn-delete">🗑️ Delete</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="9" class="no-records">No appointments found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <a href="book_appointment.html" class="btn-new">➕ Book New Appointment</a>

</div>

</body>
</html>
    
    
