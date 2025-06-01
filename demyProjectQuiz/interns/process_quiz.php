<?php
// Include the connection file
include('connection.php');

// Ensure the student is logged in and has a valid session
// Check if session is already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['student_id'])) {
    header('Location: login.php');
    exit();
}

// Get the student ID from the session
$student_id = $_SESSION['student_id'];

// Get the quiz ID from the form submission
$quiz_id = isset($_POST['quiz_id']) ? intval($_POST['quiz_id']) : 0;
$answers = isset($_POST['answers']) ? $_POST['answers'] : [];

// Fetch all questions and correct answers for the quiz
$questions_query = "SELECT id, correct_option FROM quiz_questions WHERE quiz_id = $quiz_id";
$questions_result = mysqli_query($connection, $questions_query);

if (!$questions_result) {
    echo "<p>Error fetching questions: " . mysqli_error($connection) . "</p>";
    exit();
}

// Initialize variables to calculate score
$total_questions = mysqli_num_rows($questions_result);

// Check if there are any questions
if ($total_questions == 0) {
    echo "<h2>Quiz Not Found or No Questions Available</h2>";
    mysqli_close($connection);
    exit();
}

$correct_answers_count = 0;

// Process each question
while ($question = mysqli_fetch_assoc($questions_result)) {
    $question_id = $question['id'];
    $correct_option = $question['correct_option'];
    $selected_option = isset($answers[$question_id]) ? intval($answers[$question_id]) : 0;
    $is_correct = ($selected_option == $correct_option) ? 1 : 0;

    if ($is_correct) {
        $correct_answers_count++;
    }

    // Properly quote string values for SQL
    $student_id_escaped = mysqli_real_escape_string($connection, $student_id);
    $quiz_id_escaped = mysqli_real_escape_string($connection, $quiz_id);
    $question_id_escaped = mysqli_real_escape_string($connection, $question_id);
    $selected_option_escaped = mysqli_real_escape_string($connection, $selected_option);
    $correct_option_escaped = mysqli_real_escape_string($connection, $correct_option);
    $is_correct_escaped = mysqli_real_escape_string($connection, $is_correct);

    // Insert each answer into quiz_results table
    $insert_query = "INSERT INTO quiz_results (student_id, quiz_id, question_id, selected_option, correct_option, is_correct)
                     VALUES ('$student_id_escaped', '$quiz_id_escaped', '$question_id_escaped', '$selected_option_escaped', '$correct_option_escaped', '$is_correct_escaped')";

    if (!mysqli_query($connection, $insert_query)) {
        echo "<p>Error saving results: " . mysqli_error($connection) . "</p>";
        exit();
    }
}

// Calculate the final score
$score_percentage = ($correct_answers_count / $total_questions) * 100;

// Display the result to the student
echo "<script>
alert('quiz submitted successfully....');
window.location.href='dashboard.php';
</script>";


// Close the database connection
mysqli_close($connection);
?>
