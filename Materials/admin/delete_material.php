<?php
include('connection.php');
include('authentication.php');

// Check if material ID is passed in the URL
if (isset($_GET['id'])) {
    $material_id = mysqli_real_escape_string($connection, $_GET['id']);

    // Check if the material exists
    $query = "SELECT * FROM materials WHERE id='$material_id'";
    $query_runner = mysqli_query($connection, $query);

    if (mysqli_num_rows($query_runner) > 0) {
        // Delete the material from the database
        $delete_query = "DELETE FROM materials WHERE id='$material_id'";
        $delete_query_runner = mysqli_query($connection, $delete_query);

        if ($delete_query_runner) {
            $_SESSION['success'] = "Material deleted successfully!";
        } else {
            $_SESSION['error'] = "Failed to delete material. Please try again.";
        }
    } else {
        $_SESSION['error'] = "Material not found.";
    }
} else {
    $_SESSION['error'] = "No material ID provided.";
}

// Redirect back to the materials list
header('Location: home.php');
exit(0);
?>
