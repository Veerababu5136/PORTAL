<?php
include('connection.php');

// Fetch interns with their attendance details
$query = "
    SELECT 
        i.dss_id,
        i.name,
        i.batch_no,
        COUNT(a.date) AS total_classes,
        SUM(CASE WHEN a.status = 'present' THEN 1 ELSE 0 END) AS present_count,
        (SUM(CASE WHEN a.status = 'present' THEN 1 ELSE 0 END) / COUNT(a.date)) * 100 AS attendance_percentage
    FROM interns i
    LEFT JOIN attendance a ON i.dss_id = a.dss_intern_id
    GROUP BY i.dss_id, i.name, i.batch_no
";

$result = mysqli_query($connection, $query);

if (!$result) {
    die("Query Failed: " . mysqli_error($connection));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Interns Attendance Overview</title>
</head>
<body>
    <?php include('header.php') ?>

    <div class="container mt-5">
        
        
         <div class="container mt-5">
          <h1 class='text-center'>Interns Attendance Overview</h1>
          <div class="d-flex justify-content-center mt-3 mb-3">
        <a href="track_sheet_report_download.php" class="btn btn-success">Report</a>
    </div>
        
        
        
      

        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">S.No</th>
                        <th scope="col">Name</th>
                        <th scope="col">Intern ID</th>
                        <th scope="col">Batch Number</th>
                        <th scope="col">Total Classes Conducted</th>
                        <th scope="col">Total Present</th>
                        <th scope="col">Attendance Percentage</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sno = 1;
                    while ($row = mysqli_fetch_assoc($result)) {
                        $total_classes = $row['total_classes'] ?: 0; // To avoid division by zero
                        $present_count = $row['present_count'] ?: 0;
                        $attendance_percentage = $total_classes > 0 ? ($present_count / $total_classes) * 100 : 0;

                        echo "<tr>
                                <td data-label='Sno'>{$sno}</td>
                                <td data-label='Name'>" . htmlspecialchars($row['name']) . "</td>
                                <td data-label='Id'>" . htmlspecialchars($row['dss_id']) . "</td>
                                <td data-label='Batch No'>" . htmlspecialchars($row['batch_no']) . "</td>
                                <td data-label='Total Classes'>{$total_classes}</td>
                                <td data-label='Attended'>{$present_count}</td>
                                <td data-label='Attendance %'>" . htmlspecialchars(number_format($attendance_percentage, 2)) . "%</td>
                              </tr>";
                        $sno++;
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <?php include('footer.php') ?>
</body>
</html>
