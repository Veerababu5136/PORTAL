<?php
include('connection.php');

// Check database connection
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

// Safely get intern ID from POST request
if (!isset($_POST['intern_id']) || empty($_POST['intern_id'])) {
    die("<script>alert('Intern ID is required'); window.location.href='index.php';</script>");
}

$intern_id = mysqli_real_escape_string($connection, $_POST['intern_id']);

// Fetch intern details using normal query
$intern_query = "SELECT * FROM interns WHERE dss_id = '$intern_id'";
$intern_result = mysqli_query($connection, $intern_query);

if (!$intern_result) {
    die("SQL Error (Intern Query): " . mysqli_error($connection));
}

if (mysqli_num_rows($intern_result) > 0) {
    $intern = mysqli_fetch_assoc($intern_result);
    $name = $intern['name'];
    $id = $intern['dss_id'];
    $batch_no = $intern['batch_no'];
} else {
    echo "<script>
            alert('Wrong intern ID');
            window.location.href='index.php';
          </script>";
    mysqli_close($connection);
    exit();
}

// Free result set
mysqli_free_result($intern_result);

// Fetch attendance records using normal query
$attendance_query = "SELECT date, time, status FROM attendance WHERE dss_intern_id = '$intern_id' ORDER BY date ASC";
$attendance_result = mysqli_query($connection, $attendance_query);

if (!$attendance_result) {
    die("SQL Error (Attendance Query): " . mysqli_error($connection));
}

// Initialize counters
$total_classes = 0;
$attended = 0;
$attendance_records = [];

while ($record = mysqli_fetch_assoc($attendance_result)) {
    $attendance_records[] = $record;
    $total_classes++;
    if ($record['status'] === 'present') {
        $attended++;
    }
}

// Free result set
mysqli_free_result($attendance_result);

// Close database connection
mysqli_close($connection);

// Calculate attendance percentage
$attendance_percentage = ($total_classes > 0) ? ($attended / $total_classes) * 100 : 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Intern Attendance</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include('header.php'); ?>

    <div class="container mt-5">
        <h2 class="text-center mb-4">Your Attendance</h2>

        <!-- Intern Details -->
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title">Intern Details</h5>
                <p><strong>ID:</strong> <?php echo htmlspecialchars($id); ?></p>
                <p><strong>Name:</strong> <?php echo htmlspecialchars($name); ?></p>
                <p><strong>Batch:</strong> <?php echo htmlspecialchars($batch_no); ?></p>
            </div>
        </div>

        <!-- Attendance Table -->
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">S.No</th>
                        <th scope="col">Date</th>
                        <th scope="col">Time</th>
                        <th scope="col">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (count($attendance_records) > 0) {
                        $sno = 1;
                        foreach ($attendance_records as $row) {
                            echo "<tr>
                                    <td>{$sno}</td>
                                    <td>{$row['date']}</td>
                                    <td>{$row['time']}</td>
                                    <td>{$row['status']}</td>
                                  </tr>";
                            $sno++;
                        }
                    } else {
                        echo "<tr><td colspan='4' class='text-center'>No attendance records found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <!-- Attendance Summary -->
        <div class="card mb-4">
            <div class="card-body">
                <p><strong>Total Classes Conducted:</strong> <?php echo htmlspecialchars($total_classes); ?></p>
                <p><strong>Total Attended:</strong> <?php echo htmlspecialchars($attended); ?></p>
                <p><strong>Attendance Percentage:</strong> <?php echo htmlspecialchars(number_format($attendance_percentage, 2)); ?>%</p>
            </div>
        </div>
    </div>

    <?php include('footer.php'); ?>
</body>
</html>
