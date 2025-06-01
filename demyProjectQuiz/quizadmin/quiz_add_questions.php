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
    $quiz_category = $quiz['quiz_category'];
    $quiz_date = $quiz['quiz_date'];
    $start_time = $quiz['start_time'];
    $end_time = $quiz['end_time'];
    $total_questions = $quiz['total_questions'];
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
    <!-- Bootstrap 5.3 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css"> <!-- Your custom styles -->
    <style>
        .question-form { display: none; }
    </style>
</head>
<body>

<?php include('header.php'); ?>

<!-- Form for Adding Questions -->
<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <div class="card mt-4">
                <div class="card-header">
                    <h4>Add Questions to Quiz: <?php echo htmlspecialchars($quiz_name); ?></h4>
                </div>
                <div class="card-body">
                    <form id="questionsForm" action="add_questions.php" method="POST">
                        <input type="hidden" name="quiz_id" value="<?php echo htmlspecialchars($quiz_id); ?>">
                        <div id="questionContainer"></div>
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

<!-- Bootstrap 5.3 JS and Popper.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>

<script>
    let currentQuestionIndex = 0;
    const totalQuestions = <?php echo $total_questions; ?>;

    document.addEventListener('DOMContentLoaded', () => {
        loadQuestions();
    });

    function loadQuestions() {
        let questionContainer = document.getElementById('questionContainer');
        let formHtml = '';

        for (let i = 0; i < totalQuestions; i++) {
            formHtml += `
                <div class="question-form" id="question-form-${i}">
                    <h5>Question ${i + 1}:</h5>
                    <div class="form-group">
                        <label for="question${i}">Question:</label>
                        <input type="text" id="question${i}" name="question[]" class="form-control mb-2" required>
                    </div>
                    <div class="form-group">
                        <label>Options:</label>
                        <input type="text" name="options[${i}][option1]" class="form-control mb-2" placeholder="Option 1" required>
                        <input type="text" name="options[${i}][option2]" class="form-control mb-2" placeholder="Option 2" required>
                        <input type="text" name="options[${i}][option3]" class="form-control mb-2" placeholder="Option 3" required>
                        <input type="text" name="options[${i}][option4]" class="form-control mb-2" placeholder="Option 4" required>
                        <input type="number" name="correct_answer[]" class="form-control mb-2" placeholder="Correct Answer (1-4)" min="1" max="4" required>
                    </div>
                    <hr>
                </div>
            `;
        }

        questionContainer.innerHTML = formHtml;
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
