<?php
 // Include the database connection file
 include('connection.php');

 
$query = "SELECT count(*) AS interns_count FROM interns";

// Execute the query
$query_runner = mysqli_query($connection, $query);

// Fetch the result as an associative array
$row = mysqli_fetch_assoc($query_runner);

// Access the count value
$interns_count = $row['interns_count'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Document</title>
</head>
<body>


<?php include('header.php'); ?>


<div class="container mt-5">
    <h1 class="text-center mb-4">Daily Attendance</h1>

    <!-- Button to add new attendance -->
    <div class="d-flex justify-content-center mb-3">
        <a href="add_attendance.php" class="btn btn-primary">Add Attendance</a>
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead class="table-dark">
                <tr>
                    <th scope="col">S.No</th>
                    <th scope="col">Date</th>
                    <th scope="col">Time</th>

                    <th scope="col">Registered Count</th>
                    <th scope="col">Attended</th>
                    <th scope="col">Attendance Percentage</th>
                    <th scope="col">Edit</th>

                    <th scope="col">Export to Excel</th> <!-- New column for the Export button -->
                </tr>
            </thead>
            <tbody>
            <?php
            // SQL query to fetch attendance data with total registered and attended counts per date
            $query = "
            SELECT 
                date,
                time,
                COUNT(dss_intern_id) AS total_interns, 
                SUM(CASE WHEN status = 'present' THEN 1 ELSE 0 END) AS present_count
            FROM 
                attendance
            GROUP BY 
                date, time
        ";
        

            $query_runner = mysqli_query($connection, $query);

            if (mysqli_num_rows($query_runner) > 0) {
                $sno = 1; // Initialize serial number
                while ($row = mysqli_fetch_assoc($query_runner)) {
                    $date = $row['date'];
                    $time = $row['time'];

                    $registered_count = $row['total_interns']; // Total interns for that date
                    $attended = $row['present_count']; // Count of present interns
                    $attendance_percentage = ($registered_count > 0) ? ($attended / $registered_count) * 100 : 0;

                    echo "<tr>
        <td data-label='S.No'>{$sno}</td>
        <td data-label='Date'>{$date}</td>
        <td data-label='Time'>{$time}</td>
        <td data-label='Registered'>{$registered_count}</td>
        <td data-label='Attended'>{$attended}</td>
        <td data-label='Present %'>" . number_format($attendance_percentage, 2) . "%</td>
        <td data-label='Edit'>
            <a href='edit_attendance.php?date={$row['date']}&time_period={$row['time']}' class='btn btn-warning btn-sm'>Edit</a>
        </td>
        
        
        <td data-label='Export to Excel'>
            <a href='process_export_attendance_each_day.php?date={$row['date']}' class='btn btn-success btn-sm'>Export</a>
        </td>
    </tr>";

                    $sno++;
                }
            } else {
                echo "<tr><td colspan='7' class='text-center'>No Attendance Records Found</td></tr>";
            }
            ?>
            </tbody>
        </table>
    </div>
</div>
<br><br><br><br><br><br>

<?php include('footer.php'); ?>

</body>
</html>