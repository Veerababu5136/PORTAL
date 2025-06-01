<?php
// Include the database connection file
include('connection.php');

// Check if the 'id' parameter is present in the query string
if (isset($_GET['id'])) {
    // Retrieve the intern ID from the query string and sanitize it
    $intern_id = mysqli_real_escape_string($connection, $_GET['id']);

    // SQL query to delete the intern from the database
    $query = "DELETE FROM interns WHERE id = '$intern_id'";

    // Execute the query
    if (mysqli_query($connection, $query)) {
        // If deletion is successful, redirect to the interns list page or display a success message
        echo "<script>alert('Intern deleted successfully!'); window.location.href='interns.php';</script>";
    } else {
        // If there is an error, display an error message
        echo "<script>alert('Error: Could not delete intern.'); window.location.href='interns.php';</script>";
    }
} else {
    // If the 'id' parameter is not present, redirect to the interns list page
    header('Location: interns.php');
    exit();
}

// Close the database connection
mysqli_close($connection);
?>
