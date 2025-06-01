<?php
// Include the connection file
include('connection.php');

// Get the quiz ID and student ID from the query parameters
$quiz_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$student_id = isset($_GET['student_id']) ? intval($_GET['student_id']) : 0;

// Fetch quiz details
$quiz_details_query = "
    SELECT DISTINCT 
        q.quiz_name,
        q.quiz_id,
        qc.quiz_category,
        q.quiz_date,
        q.start_time,
        q.end_time
    FROM quizzes q
    JOIN quiz_category qc ON q.quiz_category = qc.id
    WHERE q.id = $quiz_id
";


$quiz_details_result = mysqli_query($connection, $quiz_details_query);
$quiz_details = mysqli_fetch_assoc($quiz_details_result);

// Fetch detailed quiz results for the student
$quiz_results_query = "
    SELECT DISTINCT 
        qq.question_text,
        qq.option1,
        qq.option2,
        qq.option3,
        qq.option4,
        qq.correct_option,
        qr.selected_option,
        qr.is_correct
    FROM quiz_results qr
    JOIN quiz_questions qq ON qr.question_id = qq.id
    WHERE qr.student_id = $student_id AND qr.quiz_id = $quiz_id
";

$quiz_results_result = mysqli_query($connection, $quiz_results_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Details</title>
    <!-- Bootstrap 5.3 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css"> <!-- Your custom styles -->
</head>
<body>

<?php include('header.php'); ?>

<div class="container mt-5">
    <h2 class="mb-4">Quiz Details: <?php echo htmlspecialchars($quiz_details['quiz_name']); ?></h2>
    <p><strong>Category:</strong> <?php echo htmlspecialchars($quiz_details['quiz_category']); ?></p>
    <p><strong>Date:</strong> <?php echo htmlspecialchars($quiz_details['quiz_date']); ?></p>
    <p><strong>Start Time:</strong> <?php echo htmlspecialchars($quiz_details['start_time']); ?></p>
    <p><strong>End Time:</strong> <?php echo htmlspecialchars($quiz_details['end_time']); ?></p>

    <div class="table-responsive mt-4">
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Question</th>
                    <th>Option 1</th>
                    <th>Option 2</th>
                    <th>Option 3</th>
                    <th>Option 4</th>
                    <th>Selected Option</th>
                    <th>Correct Option</th>
                    <th>Result</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (mysqli_num_rows($quiz_results_result) > 0) {
                    $count = 1;
                    while ($row = mysqli_fetch_assoc($quiz_results_result)) {
                        echo "<tr>";
                        echo "<td>" . $count . "</td>";
                        echo "<td>" . htmlspecialchars($row['question_text']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['option1']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['option2']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['option3']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['option4']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['selected_option']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['correct_option']) . "</td>";
                        echo "<td>" . ($row['is_correct'] ? "<span class='text-success'>Correct</span>" : "<span class='text-danger'>Incorrect</span>") . "</td>";
                        echo "</tr>";

                        $count++;
                    }
                } else {
                    echo "<tr><td colspan='9' class='text-center'>No results found for this quiz.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<?php include('footer.php'); ?>

</body>
</html>

<?php
// Close the database connection
mysqli_close($connection);
?>
