<?php
// Include the connection file
include('connection.php');

// Fetch the most recent quiz
$query = "SELECT * FROM quizzes ORDER BY id DESC LIMIT 1";
$quiz_result = mysqli_query($connection, $query);

// Check if the query was successful and a record was found
if ($quiz_result && mysqli_num_rows($quiz_result) > 0) {
    // Fetch the quiz details
    $quiz = mysqli_fetch_assoc($quiz_result);

    // Store quiz details in variables
    $quiz_id = $quiz['id'];
    $quiz_name = $quiz['quiz_name'];

    // Fetch existing questions for the quiz
    $question_query = "SELECT * FROM quiz_questions WHERE quiz_id = $quiz_id";
    $question_result = mysqli_query($connection, $question_query);
} else {
    echo "<p>No quizzes found.</p>";
    exit;
}

// Close the database connection
mysqli_close($connection);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Questions to Quiz</title>
    <style>
        .question-form { display: none; }
    </style>
</head>
<body>

<?php include('header.php'); ?>

<!-- Form for Adding/Updating Questions -->
<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <div class="card mt-4">
                <div class="card-header">
                    <h4>Add Questions to Quiz: <?php echo htmlspecialchars($quiz_name); ?></h4>
                </div>
                <div class="card-body">
                    <form id="questionsForm" action="process_edit_questions.php" method="POST">
                        <input type="hidden" name="quiz_id" value="<?php echo htmlspecialchars($quiz_id); ?>">
                        <div id="questionContainer">
                            <?php if ($question_result && mysqli_num_rows($question_result) > 0): ?>
                                <?php while ($question = mysqli_fetch_assoc($question_result)): ?>
                                    <div class="question-form" id="question-form-<?php echo $question['id']; ?>">
                                        <h5>Question:</h5>
                                        <div class="form-group">
                                            <label for="question<?php echo $question['id']; ?>">Question:</label>
                                            <input type="text" id="question<?php echo $question['id']; ?>" name="question[<?php echo $question['id']; ?>]" class="form-control mb-2" value="<?php echo htmlspecialchars($question['question_text']); ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Options:</label>
                                            <input type="text" name="options[<?php echo $question['id']; ?>][option1]" class="form-control mb-2" value="<?php echo htmlspecialchars($question['option1']); ?>" required>
                                            <input type="text" name="options[<?php echo $question['id']; ?>][option2]" class="form-control mb-2" value="<?php echo htmlspecialchars($question['option2']); ?>" required>
                                            <input type="text" name="options[<?php echo $question['id']; ?>][option3]" class="form-control mb-2" value="<?php echo htmlspecialchars($question['option3']); ?>" required>
                                            <input type="text" name="options[<?php echo $question['id']; ?>][option4]" class="form-control mb-2" value="<?php echo htmlspecialchars($question['option4']); ?>" required>
                                            <input type="number" name="correct_answer[<?php echo $question['id']; ?>]" class="form-control mb-2" value="<?php echo htmlspecialchars($question['correct_option']); ?>" min="1" max="4" required>
                                        </div>
                                        <hr>
                                    </div>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <p>No existing questions found. Add new questions below.</p>
                            <?php endif; ?>
                        </div>
                        <div class="text-center">
                            <button type="button" id="prevBtn" class="btn btn-primary" onclick="showPreviousQuestion()">Previous</button>
                            <button type="button" id="nextBtn" class="btn btn-primary" onclick="showNextQuestion()">Next</button>
                            <button type="submit" id="submitBtn" class="btn btn-success" style="display: none;">Submit All Questions</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('footer.php'); ?>

<script>
    let currentQuestionIndex = 0;
    const totalQuestions = document.querySelectorAll('.question-form').length;

    document.addEventListener('DOMContentLoaded', () => {
        loadQuestions();
    });

    function loadQuestions() {
        showQuestion(currentQuestionIndex);
    }

    function showQuestion(index) {
        document.querySelectorAll('.question-form').forEach((form, idx) => {
            form.style.display = (idx === index) ? 'block' : 'none';
        });

        document.getElementById('prevBtn').style.display = (index === 0) ? 'none' : 'inline-block';
        document.getElementById('nextBtn').style.display = (index === totalQuestions - 1) ? 'none' : 'inline-block';
        document.getElementById('submitBtn').style.display = (index === totalQuestions - 1) ? 'inline-block' : 'none';
    }

    function showNextQuestion() {
        if (currentQuestionIndex < totalQuestions - 1) {
            currentQuestionIndex++;
            showQuestion(currentQuestionIndex);
        }
    }

    function showPreviousQuestion() {
        if (currentQuestionIndex > 0) {
            currentQuestionIndex--;
            showQuestion(currentQuestionIndex);
        }
    }
</script>

</body>
</html>
