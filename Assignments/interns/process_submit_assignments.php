<?php
include('connection.php');
include('authentication.php');


// Set the timezone to Asia/Kolkata
date_default_timezone_set('Asia/Kolkata');


// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $assignment_id = intval($_POST['assignment_id']);
    $category_id = intval($_POST['category_id']);
    $solution_link = mysqli_real_escape_string($connection, $_POST['solution_link']);
    $student_intern_id = $_SESSION['dss_id']; // Assume this is retrieved from session

    // Get current date and time for submitted_date
    $submitted_date = date('Y-m-d H:i:s');

    // Check if the student has already submitted an assignment for this category
    $check_query = "SELECT id FROM submissions WHERE student_intern_id = '$student_intern_id' AND assignment_link = 
                    (SELECT assignment_question_link FROM assignments WHERE id = $assignment_id) AND category_id = $category_id";

    $check_result = mysqli_query($connection, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        // Submission exists, update it
        $submission = mysqli_fetch_assoc($check_result);
        $submission_id = $submission['id'];

        $update_query = "UPDATE submissions 
                         SET solution_link = '$solution_link', submitted_date = '$submitted_date' 
                         WHERE id = $submission_id";

        if (mysqli_query($connection, $update_query)) {
            // Success alert for update
            echo "<script>
                    alert('Assignment updated successfully!');
                    window.location.href='submissions.php'; // Redirect as needed
                  </script>";
        } else {
            // Error alert for update failure
            echo "<script>
                    alert('Error updating the assignment: " . mysqli_error($connection) . "');
                    window.location.href='submissions.php'; // Redirect as needed
                  </script>";
        }
    } else {
        // No existing submission, insert a new one
        $insert_query = "INSERT INTO submissions (category_id, post_date, end_date, submitted_date, student_intern_id, assignment_link, solution_link, verified,assignment_id)
                         VALUES ($category_id, (SELECT post_date FROM assignments WHERE id = $assignment_id), 
                         (SELECT end_date FROM assignments WHERE id = $assignment_id), '$submitted_date', '$student_intern_id', 
                         (SELECT assignment_question_link FROM assignments WHERE id = $assignment_id), '$solution_link', 0,'$assignment_id')";

        if (mysqli_query($connection, $insert_query)) {
            // Success alert for insert
            echo "<script>
                    alert('Assignment submitted successfully!');
                    window.location.href='submissions.php'; // Redirect as needed
                  </script>";
        } else {
            // Error alert for insert failure
            echo "<script>
                    alert('Error submitting the assignment: " . mysqli_error($connection) . "');
                    window.location.href='submissions.php'; // Redirect as needed
                  </script>";
        }
    }
}
?>

<!-- HTML Form to submit assignment -->
<form method="POST" action="">
    <input type="hidden" name="assignment_id" value="<?php echo $assignment_id; ?>">
    <input type="hidden" name="category_id" value="<?php echo $category_id; ?>">
    <div class="form-group">
        <label for="solution_link">Solution Link:</label>
        <input type="url" name="solution_link" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-primary">Submit Assignment</button>
</form>
