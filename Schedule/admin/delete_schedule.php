<?php
include('connection.php');
include('authentication.php');

if (isset($_GET['id'])) {
    $schedule_id = mysqli_real_escape_string($connection, $_GET['id']);

    // Delete query
    $delete_query = "DELETE FROM schedule WHERE id='$schedule_id'";
    $delete_run = mysqli_query($connection, $delete_query);

    if ($delete_run) {
        $_SESSION['status'] = "Schedule deleted successfully!";
        header("Location: home.php");
        exit();
    } else {
        $_SESSION['status'] = "Failed to delete the schedule.";
        header("Location: home.php");
        exit();
    }
} else {
    $_SESSION['status'] = "No ID provided to delete.";
    header("Location: home.php");
    exit();
}
?>
