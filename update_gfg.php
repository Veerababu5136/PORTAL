<?php
include('connection.php');

// Safely get intern ID and GFG name from the POST request
$intern_id = mysqli_real_escape_string($connection, $_POST['intern_id']);
$gfg_name = mysqli_real_escape_string($connection, $_POST['gfg_name']);

// Prepare the update query
$update_query = "UPDATE interns SET geeks_name = ? WHERE id = ?";

// Prepare the statement
$stmt = $connection->prepare($update_query);

// Bind parameters
$stmt->bind_param("si", $gfg_name, $intern_id);  // "si" means string and integer

// Execute the statement
if ($stmt->execute()) {
    // Redirect to index.php with success flag
    header("Location: index.php?status=success");
    exit(); // Don't forget to call exit() after the redirect
} else {
    // Redirect to index.php with error flag
    header("Location: index.php?status=error");
    exit(); // Don't forget to call exit() after the redirect
}

// Close the statement and connection
$stmt->close();
$connection->close();
?>
