<?php
include('connection.php');
include('authentication.php');

if (isset($_GET['id'])) {
    $assignment_id = $_GET['id'];

    // Delete the assignment based on the ID
    $delete_query = "DELETE FROM assignments WHERE id='$assignment_id'";

    if (mysqli_query($connection, $delete_query)) {
        $_SESSION['message'] = "Assignment deleted successfully!";
        header('Location: home.php');
        exit(0);
    } else {
        $_SESSION['message'] = "Failed to delete assignment.";
    }
} else {
    $_SESSION['message'] = "No assignment ID provided!";
    header('Location: home.php');
    exit(0);
}
?>
