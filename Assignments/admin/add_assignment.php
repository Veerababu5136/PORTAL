<?php
include('connection.php');
include('authentication.php');

// Fetch categories to populate the category dropdown
$category_query = "SELECT * FROM categories ORDER BY id ASC";
$category_query_runner = mysqli_query($connection, $category_query);

// Display message if set
$message = '';
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    unset($_SESSION['message']); // Clear message after displaying
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css"/>
    <title>Add Assignment</title>
    <script>
        // Show alert if there is a message
        function showAlert(message) {
            if (message) {
                alert(message);
            }
        }
    </script>
</head>
<body onload="showAlert('<?php echo htmlspecialchars($message); ?>')">
    <?php include('header2.php'); ?>

    <div class="container mt-5">
        <h1 class='text-center'>Add New Assignment</h1>

        <form action="process_add_assignments.php" method="POST" class="mt-5">
            <div class="form-group">
                <label for="category_id">Category</label>
                <select name="category_id" class="form-control" required>
                    <option value="">Select Category</option>
                    <?php
                    if (mysqli_num_rows($category_query_runner) > 0) {
                        while ($category_row = mysqli_fetch_assoc($category_query_runner)) {
                            echo "<option value='{$category_row['id']}'>{$category_row['category_name']}</option>";
                        }
                    } else {
                        echo "<option value=''>No Categories Found</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="form-group mt-3">
                <label for="assignment_question_link">Assignment Name</label>
                <input type="text" name="assignment_name" class="form-control" placeholder="Enter Assignment Name" required>
            </div>

            <div class="form-group mt-3">
                <label for="assignment_question_link">Assignment Question Link</label>
                <input type="text" name="assignment_question_link" class="form-control" placeholder="Enter the link to the assignment" required>
            </div>

            <div class="form-group mt-3">
                <label for="post_date">Post Date</label>
                <input type="date" name="post_date" class="form-control" required>
            </div>

            <div class="form-group mt-3">
                <label for="end_date">End Date</label>
                <input type="date" name="end_date" class="form-control" required>
            </div>

            <div class="form-group text-center mt-4">
                <button type="submit" name="add_assignment" class="btn btn-primary">Add Assignment</button>
            </div>
        </form>
    </div>

    <?php include('footer.php'); ?>
</body>
</html>
