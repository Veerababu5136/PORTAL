<?php
// Include the connection file
include('connection.php');

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve and sanitize form inputs
    $quiz_id = mysqli_real_escape_string($connection, $_POST['quiz_id']);
    $quiz_name = mysqli_real_escape_string($connection, $_POST['quiz_name']);
    $quiz_category = mysqli_real_escape_string($connection, $_POST['quiz_category']);
    $quiz_date = mysqli_real_escape_string($connection, $_POST['quiz_date']);
    $start_time = mysqli_real_escape_string($connection, $_POST['start_time']);
    $end_time = mysqli_real_escape_string($connection, $_POST['end_time']);
    $total_questions = mysqli_real_escape_string($connection, $_POST['total_questions']);

    // Prepare the SQL query
    $query = "UPDATE quizzes 
              SET quiz_name='$quiz_name', quiz_category='$quiz_category', quiz_date='$quiz_date', start_time='$start_time', end_time='$end_time', total_questions='$total_questions'
              WHERE id='$quiz_id'";

    // Execute the query
    if (mysqli_query($connection, $query)) {
        // Success
        echo "<script>
                alert('Quiz has been successfully updated.');
                window.location.href = 'quiz_list.php';
              </script>";
    } else {
        // Error
        echo "<script>
                alert('Error: " . mysqli_error($connection) . "');
                window.location.href = 'quiz_list.php';
              </script>";
    }

    // Close the database connection
    mysqli_close($connection);
} else {
    echo "<p>Invalid request.</p>";
}
?>
