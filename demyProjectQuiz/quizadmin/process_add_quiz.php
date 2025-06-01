<?php
// Include the connection file
include('connection.php');

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve and sanitize form inputs
    $quiz_name = mysqli_real_escape_string($connection, $_POST['quiz_name']);
    $quiz_id = mysqli_real_escape_string($connection, $_POST['quiz_id']);
    $quiz_category = mysqli_real_escape_string($connection, $_POST['quiz_category']);
    $quiz_date = mysqli_real_escape_string($connection, $_POST['quiz_date']);
    $start_time = mysqli_real_escape_string($connection, $_POST['start_time']);
    $end_time = mysqli_real_escape_string($connection, $_POST['end_time']);
    $total_questions = mysqli_real_escape_string($connection, $_POST['total_questions']);

    // Prepare the SQL query
    $query = "INSERT INTO `quizzes` (quiz_name, quiz_id, quiz_category, quiz_date, start_time, end_time, total_questions) 
              VALUES ('$quiz_name', '$quiz_id', '$quiz_category', '$quiz_date', '$start_time', '$end_time', '$total_questions')";

    // Execute the query
    if (mysqli_query($connection, $query)) {
        // Success - Get the last inserted quiz ID
        $quiz_id = mysqli_insert_id($connection);
        echo "<script>
                alert('Quiz has been successfully added.');
                window.location.href = 'quiz_add_questions.php?quiz_id=" . $quiz_id . "';
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
}
?>
