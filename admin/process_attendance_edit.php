<?php
// Include the database connection file
include('connection.php');

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve the date and time period from POST data
    $date = mysqli_real_escape_string($connection, $_POST['date']);
    $time_period = mysqli_real_escape_string($connection, $_POST['time_period']);
    
    // Loop through each intern's status
    foreach ($_POST['status'] as $intern_id => $status) {
        $status = mysqli_real_escape_string($connection, $status);
        
        // Check if the attendance record for the intern, date, and time period already exists
        $check_query = "SELECT * FROM attendance WHERE date = '$date' AND dss_intern_id = '$intern_id' AND time = '$time_period'";
        $check_result = mysqli_query($connection, $check_query);

        if (mysqli_num_rows($check_result) > 0) {
            // Update existing record for the specific time period
            $update_query = "UPDATE attendance SET status = '$status' WHERE date = '$date' AND dss_intern_id = '$intern_id' AND time = '$time_period'";
            mysqli_query($connection, $update_query);
        } else {
            // Insert new record with the specific time period
            $insert_query = "INSERT INTO attendance (date, dss_intern_id, status, time) VALUES ('$date', '$intern_id', '$status', '$time_period')";
            mysqli_query($connection, $insert_query);
        }
    }

    // Redirect to the attendance list page or display a success message
    echo "<script>alert('Attendance updated successfully!'); window.location.href='attendance.php';</script>";
} else {
    // If the form is not submitted, redirect to the add attendance page
    header('Location: add_attendance.php');
    exit();
}

// Close the database connection
mysqli_close($connection);
?>
