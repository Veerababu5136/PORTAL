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

    // Prepare to insert questions into the database
    $insert_question_query = "INSERT INTO quiz_questions (quiz_id, question_text, option1, option2, option3, option4, correct_option) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($connection, $insert_question_query);

    if ($stmt) {
        foreach ($questions as $index => $question) {
            $question_text = mysqli_real_escape_string($connection, $question);
            $option1 = mysqli_real_escape_string($connection, $options[$index]['option1']);
            $option2 = mysqli_real_escape_string($connection, $options[$index]['option2']);
            $option3 = mysqli_real_escape_string($connection, $options[$index]['option3']);
            $option4 = mysqli_real_escape_string($connection, $options[$index]['option4']);
            $correct_option = (int) $correct_answers[$index];

            // Bind parameters and execute the statement
            mysqli_stmt_bind_param($stmt, 'issssss', $quiz_id, $question_text, $option1, $option2, $option3, $option4, $correct_option);
            if (!mysqli_stmt_execute($stmt)) {
                echo "<script>
                        alert('Error: " . mysqli_stmt_error($stmt) . "');
                        window.location.href = 'quiz_list.php';
                      </script>";
                exit;
            }
        }

        // Close the statement and connection
        mysqli_stmt_close($stmt);
        mysqli_close($connection);

        echo "<script>
                alert('Questions have been successfully added.');
                window.location.href = 'quiz_list.php';
              </script>";
    } else {
        echo "<script>
                alert('Error preparing the statement: " . mysqli_error($connection) . "');
                window.location.href = 'quiz_list.php';
              </script>";
    }
} else {
    // Not a POST request
    echo "<p>Invalid request method.</p>";
}
?>
