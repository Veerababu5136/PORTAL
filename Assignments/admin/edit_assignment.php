<?php
// Include connection and authentication files
include('connection.php');
include('authentication.php');

// Set the correct timezone (adjust based on your location)
date_default_timezone_set('Asia/Kolkata');

// Check if the form for updating the assignment has been submitted
if (isset($_POST['update_assignment'])) {
    // Get values from the form
    $assignment_id = $_POST['assignment_id'];
    $category_id = $_POST['category_id'];
    $assignment_question_link = $_POST['assignment_question_link'];

    $assignment_name = $_POST['assignment_name'];

    $post_date = $_POST['post_date'];
    $end_date = $_POST['end_date'];
    $updated_date = date('Y-m-d H:i:s'); // Automatically set current date and time as updated date

    // SQL query to update the assignment record in the database
    $update_query = "
        UPDATE assignments 
        SET category_id='$category_id', 
            assignment_question_link='$assignment_question_link', 
            assignment_name='$assignment_name',
            post_date='$post_date', 
            end_date='$end_date', 
            updated_date='$updated_date' 
        WHERE id='$assignment_id'";

    // Execute the query and check if it was successful
    if (mysqli_query($connection, $update_query)) {
        // If the update was successful, set a success message and redirect
        $_SESSION['message'] = "Assignment updated successfully!";
        header('Location: home.php');
        exit(0);
    } else {
        // If there was an error, set an error message
        $_SESSION['message'] = "Failed to update assignment.";
    }
}

// Fetch the current assignment data to display in the form for editing
if (isset($_GET['id'])) {
    $assignment_id = $_GET['id'];

    // Query to get the assignment details based on the assignment ID
    $query = "SELECT * FROM assignments WHERE id='$assignment_id'";
    $query_runner = mysqli_query($connection, $query);

    if (mysqli_num_rows($query_runner) > 0) {
        $assignment = mysqli_fetch_assoc($query_runner);
    } else {
        $_SESSION['message'] = "No Assignment found!";
        header('Location: assignments.php');
        exit(0);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Assignment</title>
    <link rel="stylesheet" href="style.css"/>
</head>
<body>
    <?php include('header2.php'); ?>

    <div class="container mt-5">
        <h1 class='text-center'>Edit Assignment</h1>

        <form action="edit_assignment.php" method="POST">
            <!-- Hidden input to hold the assignment ID -->
            <input type="hidden" name="assignment_id" value="<?= $assignment['id']; ?>">

            <div class="form-group">
                <label for="category_id">Category</label>
                <select name="category_id" class="form-control" required>
                    <option value="">Select Category</option>
                    <?php
                    // Fetch all categories for the dropdown
                    $categories_query = "SELECT * FROM categories";
                    $categories_result = mysqli_query($connection, $categories_query);

                    while ($category = mysqli_fetch_assoc($categories_result)) {
                        $selected = ($assignment['category_id'] == $category['id']) ? 'selected' : '';
                        echo "<option value='{$category['id']}' {$selected}>{$category['category_name']}</option>";
                    }
                    ?>
                </select>
            </div>


            <div class="form-group">
                <label for="assignment_question_link">Assignment name</label>
                <input type="text" name="assignment_name" class="form-control" 
                       value="<?= $assignment['assignment_name']; ?>" required>
            </div>


            <div class="form-group">
                <label for="assignment_question_link">Assignment Question Link</label>
                <input type="url" name="assignment_question_link" class="form-control" 
                       value="<?= $assignment['assignment_question_link']; ?>" required>
            </div>



            <div class="form-group">
                <label for="post_date">Post Date</label>
                <input type="date" name="post_date" class="form-control" 
                       value="<?= $assignment['post_date']; ?>" required>
            </div>

            <div class="form-group">
                <label for="end_date">End Date</label>
                <input type="date" name="end_date" class="form-control" 
                       value="<?= $assignment['end_date']; ?>" required>
            </div>

            <!-- Update button -->
            <button type="submit" name="update_assignment" class="btn btn-success mt-3">Update Assignment</button>
        </form>
    </div>

    <?php include('footer.php'); ?>
</body>
</html>
