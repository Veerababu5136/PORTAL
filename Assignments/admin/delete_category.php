<?php
include('connection.php');
include('authentication.php');

// Check if 'id' parameter is present in the URL
if (isset($_GET['id'])) {
    $category_id = mysqli_real_escape_string($connection, $_GET['id']);

    // SQL query to delete the category
    $query = "DELETE FROM categories WHERE id = '$category_id'";
    $query_runner = mysqli_query($connection, $query);

    if ($query_runner) {
        // Redirect to categories page with success message
        header("Location: categories_list.php?message=Category deleted successfully");
        exit(0);
    } else {
        // Redirect to categories page with error message
        header("Location: categories_list.php?message=Failed to delete category");
        exit(0);
    }
} else {
    // Redirect to categories page if no id is found in the URL
    header("Location: categories_list.php?message=Invalid request");
    exit(0);
}
?>
