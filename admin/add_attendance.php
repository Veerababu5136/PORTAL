<?php
 // Include the database connection file
 include('connection.php');

 ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Attendance</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Custom styles for the table */
        .table-responsive {
            margin-top: 20px;
        }
    </style>
</head>
<body>

<?php include('header.php'); ?>

<div class="container mt-5">
    <h2 class="text-center mb-4">Add Attendance</h2>

    <form action="process_attendance_add.php" method="POST">

        <div class="mb-3">
            <label for="date" class="form-label">Date</label>
            <input type="date" class="form-control" id="date" name="date" value="<?php echo date('Y-m-d'); ?>" required>
        </div>

        <div class="mb-3">
    <label for="time_period" class="form-label">Time Period</label>
    <select class="form-select" id="time_period" name="time_period" required>
        <option value="AM">AM</option>
        <option value="PM">PM</option>
        <option value="FULL_DAY">Full Day</option>
    </select>
</div>

        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th scope="col" data-label="S.No" class='text-dark'>S.No</th>
                        <th scope="col" data-label='ID'>DSS Intern ID</th>
                        <th scope="col" data-label='Name'>Intern Name</th>
                        <th scope="col" data-label='Status'>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                   

                    // SQL query to fetch all interns
                    $query = "SELECT * FROM interns order by dss_id asc";
                    $query_runner = mysqli_query($connection, $query);

                    if (mysqli_num_rows($query_runner) > 0) {
                        $sno = 1; // Initialize serial number
                        while ($row = mysqli_fetch_assoc($query_runner)) {
                            $intern_id = $row['dss_id'];
                            $intern_name = $row['name'];

                            echo "<tr>
                                    <td data-label='S.No'>{$sno}</td>
                                    <td data-label='id'>{$intern_id}</td>
                                    <td data-label='name'>{$intern_name}</td>
                                    <td data-label='Status'>
                                        <div class='form-check'>
                                            <input class='form-check-input' type='radio' id='present_{$intern_id}' name='status[{$intern_id}]' value='present' required>
                                            <label class='form-check-label' for='present_{$intern_id}'>
                                                Present
                                            </label>
                                        </div>
                                        <div class='form-check'>
                                            <input class='form-check-input' type='radio' id='absent_{$intern_id}' name='status[{$intern_id}]' value='absent' checked required>
                                            <label class='form-check-label' for='absent_{$intern_id}'>
                                                Absent
                                            </label>
                                        </div>
                                    </td>
                                  </tr>";
                            $sno++;
                        }
                    } else {
                        echo "<tr><td colspan='4' class='text-center'>No Interns Found</td></tr>";
                    }

                    // Close the database connection
                    mysqli_close($connection);
                    ?>
                </tbody>
            </table>
        </div>

        <div class="d-grid mt-3">
            <button type="submit" class="btn btn-primary">Add Attendance</button>
        </div>
    </form>
</div>

<?php include('footer.php'); ?>

<!-- Bootstrap JS and dependencies -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
