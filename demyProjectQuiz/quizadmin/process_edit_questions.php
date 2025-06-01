<?php
// Include the connection file
include('connection.php');

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve and sanitize quiz ID
    $quiz_id = mysqli_real_escape_string($connection, $_POST['quiz_id']);
    
    // Retrieve questions, options, and correct answers from the form
    $questions = $_POST['question'];
    $options = $_POST['options'];
    $correct_answers = $_POST['correct_answer'];

    // Loop through each question to handle updates or inserts
    foreach ($questions as $question_id => $question) {
        $question_text = mysqli_real_escape_string($connection, $question);
        $option1 = mysqli_real_escape_string($connection, $options[$question_id]['option1']);
        $option2 = mysqli_real_escape_string($connection, $options[$question_id]['option2']);
        $option3 = mysqli_real_escape_string($connection, $options[$question_id]['option3']);
        $option4 = mysqli_real_escape_string($connection, $options[$question_id]['option4']);
        $correct_option = (int) $correct_answers[$question_id];

        if ($question_id) {
            // If question ID exists, update the question
            $update_query = "UPDATE quiz_questions 
                             SET question_text = ?, option1 = ?, option2 = ?, option3 = ?, option4 = ?, correct_option = ? 
                             WHERE id = ?";
            $update_stmt = mysqli_prepare($connection, $update_query);
            mysqli_stmt_bind_param($update_stmt, 'ssssssi', $question_text, $option1, $option2, $option3, $option4, $correct_option, $question_id);
            if (!mysqli_stmt_execute($update_stmt)) {
                echo "<script>
                        alert('Error updating question: " . mysqli_stmt_error($update_stmt) . "');
                        window.location.href = 'quiz_list.php';
                      </script>";
                exit;
            }
            mysqli_stmt_close($update_stmt);
        } else {
            // If no question ID, insert new question
            $insert_question_query = "INSERT INTO quiz_questions (quiz_id, question_text, option1, option2, option3, option4, correct_option) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $insert_stmt = mysqli_prepare($connection, $insert_question_query);
            mysqli_stmt_bind_param($insert_stmt, 'issssss', $quiz_id, $question_text, $option1, $option2, $option3, $option4, $correct_option);
            if (!mysqli_stmt_execute($insert_stmt)) {
                echo "<script>
                        alert('Error inserting question: " . mysqli_stmt_error($insert_stmt) . "');
                        window.location.href = 'quiz_list.php';
                      </script>";
                exit;
            }
            mysqli_stmt_close($insert_stmt);
        }
    }

    // Close the database connection
    mysqli_close($connection);

    echo "<script>
            alert('Questions have been successfully updated.');
            window.location.href = 'quiz_list.php';
          </script>";
} else {
    // Not a POST request
    echo "<p>Invalid request method.</p>";
}
?>
