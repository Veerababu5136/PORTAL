<?php
// Include the database connection file
include('connection.php');

// Fetch the date and time period from the GET request (when editing)
$selected_date = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d');
$selected_time_period = isset($_GET['time_period']) ? $_GET['time_period'] : 'am';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Attendance</title>
</head>
<body>
<?php include('header.php'); ?>

<div class="container mt-5">
    <h2 class="text-center mb-4">Edit Attendance for <?php echo date('d-m-Y', strtotime($selected_date)); ?></h2>

    <!-- Form for selecting time period -->
    <form action="process_attendance_edit.php" method="POST">
        <input type="hidden" name="date" value="<?php echo $selected_date; ?>">

        <div class="mb-3">
            <label for="time_period" class="form-label">Time Period</label>
            <select class="form-select" id="time_period" name="time_period" required>
                <option value="AM" <?php echo ($selected_time_period == 'AM') ? 'selected' : ''; ?>>AM</option>
                <option value="PM" <?php echo ($selected_time_period == 'PM') ? 'selected' : ''; ?>>PM</option>
                <option value="FULL_DAY" <?php echo ($selected_time_period == 'full_day') ? 'selected' : ''; ?>>Full Day</option>
            </select>
        </div>

        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">S.No</th>
                        <th scope="col">DSS Intern ID</th>
                        <th scope="col">Status</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                // Query to fetch attendance for the selected date and time period
                $query = "SELECT * FROM attendance WHERE date='$selected_date' AND time='$selected_time_period'";
                $query_runner = mysqli_query($connection, $query);

                if (mysqli_num_rows($query_runner) > 0) {
                    $sno = 1; // Initialize serial number
                    while ($row = mysqli_fetch_assoc($query_runner)) {
                        $intern_id = $row['dss_intern_id'];
                        $status = $row['status']; // Fetch the attendance status

                        echo "<tr>
                                <td data-label='S.No'>{$sno}</td>
                                <td data-label='id'>{$intern_id}</td>
                                <td data-label='Status'>
                                    <div class='form-check'>
                                        <input class='form-check-input' type='radio' id='present_{$intern_id}' name='status[{$intern_id}]' value='present' ".($status == 'present' ? 'checked' : '')." required>
                                        <label class='form-check-label' for='present_{$intern_id}'>Present</label>
                                    </div>
                                    <div class='form-check'>
                                        <input class='form-check-input' type='radio' id='absent_{$intern_id}' name='status[{$intern_id}]' value='absent' ".($status == 'absent' ? 'checked' : '')." required>
                                        <label class='form-check-label' for='absent_{$intern_id}'>Absent</label>
                                    </div>
                                </td>
                            </tr>";
                        $sno++;
                    }
                } else {
                    echo "<tr><td colspan='3' class='text-center'>No records found for this date and time period.</td></tr>";
                }

                // Close the database connection
                mysqli_close($connection);
                ?>
                </tbody>
            </table>
        </div>

        <div class="d-grid mt-3">
            <button type="submit" class="btn btn-primary">Update Attendance</button>
        </div>
    </form>
</div><br><br><br><br><br><br><br><br>

<?php include('footer.php'); ?>
</body>
</html>
