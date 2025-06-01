<?php
include('connection.php');
include('authentication.php');

// Update contest details when form is submitted
if (isset($_POST['submit'])) 
{
    $contest_id = mysqli_real_escape_string($connection, $_POST['contest_id']);

    $contest_name = mysqli_real_escape_string($connection, $_POST['contest_name']);
    $date = mysqli_real_escape_string($connection, $_POST['date']);
    $start_time = mysqli_real_escape_string($connection, $_POST['start_time']);
    $end_time = mysqli_real_escape_string($connection, $_POST['end_time']);
    $link = mysqli_real_escape_string($connection, $_POST['link']);

    // Update query
    $update_query = "UPDATE contests SET contest_name='$contest_name', date='$date', start_time='$start_time', end_time='$end_time', link='$link' WHERE id='$contest_id'";
    
    $update_runner = mysqli_query($connection, $update_query);

    if ($update_runner) {
        echo "<script>alert('Contest updated successfully!'); window.location.href='home.php';</script>";
    } else {
        echo "<script>alert('Failed to update contest. Please try again.');</script>";
    }
}
?>