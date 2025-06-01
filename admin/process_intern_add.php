<?php
// Include the database connection file
include('connection.php');

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $dss_intern_id = mysqli_real_escape_string($connection, $_POST['dss_id']);
    $intern_name = mysqli_real_escape_string($connection, $_POST['name']);
    $batch_id = mysqli_real_escape_string($connection, $_POST['batch_no']);
        $email = mysqli_real_escape_string($connection, $_POST['email']);
    $password = mysqli_real_escape_string($connection, $_POST['password']);


    // SQL query to insert data into the interns table
    $query = "INSERT INTO interns (dss_id, name, batch_no,email,password) VALUES ('$dss_intern_id', '$intern_name', '$batch_id','$email','$password')";

    // Execute the query
    if (mysqli_query($connection, $query)) {
        // If insertion is successful, redirect to the interns list page or display a success message
        echo "<script>alert('Intern added successfully!'); window.location.href='interns.php';</script>";
    } else {
        // If there is an error, display an error message
        echo "<script>alert('Error: Could not add intern.'); window.location.href='intern_add.php';</script>";
    }
} else {
    // If the form is not submitted, redirect to the add intern page
    header('Location: intern_add.php');
    exit();
}

// Close the database connection
mysqli_close($connection);
?>
