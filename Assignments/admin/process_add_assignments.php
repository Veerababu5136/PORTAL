<?php
include('connection.php');
include('authentication.php');

// Check if the form was submitted
if (isset($_POST['add_assignment'])) 
{
    // Get form data
    $category_id = $_POST['category_id'];
    $assignment_question_link = $_POST['assignment_question_link'];
    $post_date = $_POST['post_date'];
    $end_date = $_POST['end_date'];
    $assignment_name = $_POST['assignment_name'];

    // Insert assignment data into the database
    $insert_query = "
        INSERT INTO assignments (category_id, assignment_question_link, post_date, end_date, updated_date, assignment_name)
        VALUES ('$category_id', '$assignment_question_link', '$post_date', '$end_date', NOW(), '$assignment_name')
    ";

    if (mysqli_query($connection, $insert_query)) {
        $_SESSION['message'] = "Assignment added successfully!";
    } else {
        $_SESSION['message'] = "Assignment could not be added! Error: " . mysqli_error($connection);
    }

    // No need for a PHP redirect, we'll handle it with JavaScript
}
?>

<!-- Add this PHP block in your HTML page (add_assignment.php) where you want to show the alert -->
<?php if(isset($_SESSION['message'])): ?>
    <script>
        alert('<?php echo $_SESSION['message']; ?>');
        // Redirect to any desired page after showing the alert
        window.location.href = 'add_assignment.php'; // Change this to the page you want to redirect to
    </script>
    <?php unset($_SESSION['message']); // Clear the message after displaying it ?>
<?php endif; ?>
