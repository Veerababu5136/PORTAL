<?php
include('connection.php');
include('authentication.php');


// Check if the 'id' is provided in the URL
if (isset($_GET['id'])) {
    $contest_id = mysqli_real_escape_string($connection, $_GET['id']);

    // Delete query
    $query = "DELETE FROM contests WHERE id = '$contest_id'";
    $query_runner = mysqli_query($connection, $query);

    // Check if deletion was successful
    if ($query_runner) {
        echo "<script>alert('Contest deleted successfully!'); window.location.href='home.php';</script>";
    } else {
        echo "<script>alert('Failed to delete contest. Please try again.'); window.location.href='home.php';</script>";
    }
} else {
    echo "<script>alert('Invalid request.'); window.location.href='home.php';</script>";
}
?>
