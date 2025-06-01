<?php
// Include the connection file
include('connection.php');

// Ensure the student is logged in and has a valid session
session_start();
if (!isset($_SESSION['email'])) 
{
    header('Location: login.php');
    exit();
}

// Get quiz ID from URL
$quiz_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
// Check if the quiz was already attempted
$query = "SELECT COUNT(*) AS attempt_count FROM quiz_results WHERE student_id='$_SESSION[student_id]' AND quiz_id='$quiz_id'";
$result = mysqli_query($connection, $query);

if ($result) {
    $row = mysqli_fetch_assoc($result); // Fetch the result as an associative array

    // Check if the attempt count is greater than 0
    if ($row['attempt_count'] > 0) {
        echo "<script>
        alert('You have already attempted this quiz.');
        window.location.href='dashboard.php';
        </script>";
        exit(); // Exit to prevent further code execution
    }
} else {
    // Handle the case when the query fails
    echo "Error: " . mysqli_error($connection);
}

// Debugging: Print the fetched result
print_r($row);


// Fetch quiz details
$quiz_query = "SELECT * FROM quizzes WHERE id = $quiz_id";
$quiz_result = mysqli_query($connection, $quiz_query);
$quiz = mysqli_fetch_assoc($quiz_result);

// Check if quiz exists
if (!$quiz) {
    echo "<p>Quiz not found.</p>";
    exit();
}

// Fetch quiz questions
$questions_query = "SELECT * FROM quiz_questions WHERE quiz_id = $quiz_id";
$questions_result = mysqli_query($connection, $questions_query);

// Check if there are questions
if (!$questions_result || mysqli_num_rows($questions_result) == 0) {
    echo "<p>No questions found for this quiz.</p>";
    exit();
}

// Count the total number of questions
$total_questions = mysqli_num_rows($questions_result);
mysqli_data_seek($questions_result, 0); // Reset result pointer for later use

// Get start and end times for the quiz
$start_datetime = $quiz['quiz_date'] . ' ' . $quiz['start_time'];
$end_datetime = $quiz['quiz_date'] . ' ' . $quiz['end_time'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Take Quiz</title>
    <!-- Bootstrap 5.3 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .card-container {
            margin-bottom: 20px;
        }
        .question-number {
            font-weight: bold;
        }
        .timer {
            font-size: 1.2rem;
            font-weight: bold;
        }
    </style>
</head>
<body>

<?php include('header.php'); ?>

<div class="container mt-5">
    <h2><?php echo htmlspecialchars($quiz['quiz_name']); ?></h2>
    <p>Total Questions: <?php echo $total_questions; ?></p>
    <p class="timer" id="timer">Loading timer...</p>
    <form id="quizForm" action="process_quiz.php" method="POST">
        <input type="hidden" name="quiz_id" value="<?php echo $quiz_id; ?>">
        <?php
        $question_number = 1; // Initialize question number
        while ($question = mysqli_fetch_assoc($questions_result)): ?>
            <div class="card card-container">
                <div class="card-body">
                    <h5 class="card-title">Question <?php echo $question_number; ?>: <?php echo htmlspecialchars($question['question_text']); ?></h5>
                    <input type="hidden" name="questions[]" value="<?php echo $question['id']; ?>">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="answers[<?php echo $question['id']; ?>]" value="1" id="option1-<?php echo $question['id']; ?>">
                        <label class="form-check-label" for="option1-<?php echo $question['id']; ?>">
                            <?php echo htmlspecialchars($question['option1']); ?>
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="answers[<?php echo $question['id']; ?>]" value="2" id="option2-<?php echo $question['id']; ?>">
                        <label class="form-check-label" for="option2-<?php echo $question['id']; ?>">
                            <?php echo htmlspecialchars($question['option2']); ?>
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="answers[<?php echo $question['id']; ?>]" value="3" id="option3-<?php echo $question['id']; ?>">
                        <label class="form-check-label" for="option3-<?php echo $question['id']; ?>">
                            <?php echo htmlspecialchars($question['option3']); ?>
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="answers[<?php echo $question['id']; ?>]" value="4" id="option4-<?php echo $question['id']; ?>">
                        <label class="form-check-label" for="option4-<?php echo $question['id']; ?>">
                            <?php echo htmlspecialchars($question['option4']); ?>
                        </label>
                    </div>
                </div>
            </div>
            <?php $question_number++; // Increment question number ?>
        <?php endwhile; ?>
        <div class="text-center">
            <button type="submit" class="btn btn-success">Submit Quiz</button>
        </div>
    </form>
</div>

<?php include('footer.php'); ?>

<!-- JavaScript for Countdown Timer -->
<script>
    // Convert PHP date and time to JavaScript Date objects
    var startDateTime = new Date("<?php echo $start_datetime; ?>").getTime();
    var endDateTime = new Date("<?php echo $end_datetime; ?>").getTime();

    function updateTimer() {
        var now = new Date().getTime();
        var timeLeft = endDateTime - now;

        if (timeLeft < 0) {
            document.getElementById("timer").innerHTML = "Time's up!";
            document.getElementById("quizForm").submit(); // Automatically submit the form when time is up
            return;
        }

        var hours = Math.floor((timeLeft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);

        document.getElementById("timer").innerHTML = 
            hours + "h " + 
            minutes + "m " + 
            seconds + "s ";
    }

    // Update timer every second
    setInterval(updateTimer, 1000);
</script>

</body>
</html>

<?php
// Close the database connection
mysqli_close($connection);
?>
