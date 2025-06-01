<?php
include('connection.php');
include('authentication.php');
// Check if the form is submitted
if (isset($_POST['submit'])) {
    // Get form input values
    $contest_name = mysqli_real_escape_string($connection, $_POST['contest_name']);
    $date = mysqli_real_escape_string($connection, $_POST['date']);
    $start_time = mysqli_real_escape_string($connection, $_POST['start_time']);
    $end_time = mysqli_real_escape_string($connection, $_POST['end_time']);
    $link = mysqli_real_escape_string($connection, $_POST['link']);

    // Insert data into the contests table
    $query = "INSERT INTO contests (contest_name, date, start_time, end_time, link) 
              VALUES ('$contest_name', '$date', '$start_time', '$end_time', '$link')";
    
    $query_runner = mysqli_query($connection, $query);

    // Check if data is inserted successfully
    if ($query_runner) {
        echo "<script>alert('Contest added successfully!'); window.location.href='home.php';</script>";
    } else {
        echo "<script>alert('Failed to add contest. Please try again.');window.location.href='home.php';</script>";
    }
}
?>
