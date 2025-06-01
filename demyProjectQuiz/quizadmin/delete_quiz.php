<?php
// Include the connection file
include('connection.php');

// Check if the ID parameter is present in the URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $quiz_id = mysqli_real_escape_string($connection, $_GET['id']);

    // Begin a transaction
    mysqli_begin_transaction($connection);
    try {
        // Delete quiz results associated with the quiz questions
        $delete_results_query = "
            DELETE qr FROM quiz_results qr
            JOIN quiz_questions qq ON qr.question_id = qq.id
            WHERE qq.quiz_id = $quiz_id
        ";
        mysqli_query($connection, $delete_results_query);

        // Delete questions associated with the quiz
        $delete_questions_query = "DELETE FROM quiz_questions WHERE quiz_id = $quiz_id";
        mysqli_query($connection, $delete_questions_query);

        // Delete the quiz
        $delete_quiz_query = "DELETE FROM quizzes WHERE id = $quiz_id";
        if (mysqli_query($connection, $delete_quiz_query)) {
            // Commit the transaction
            mysqli_commit($connection);
            echo "<script>
                    alert('Quiz has been successfully deleted.');
                    window.location.href = 'quiz_list.php';
                  </script>";
        } else {
            throw new Exception("Error deleting quiz: " . mysqli_error($connection));
        }
    } catch (Exception $e) {
        // Rollback the transaction in case of an error
        mysqli_rollback($connection);
        echo "<script>
                alert('Error: " . $e->getMessage() . "');
                window.location.href = 'quiz_list.php';
              </script>";
    }
} else {
    echo "<script>
            alert('Invalid quiz ID.');
            window.location.href = 'quiz_list.php';
          </script>";
}

// Close the database connection
mysqli_close($connection);
?>
