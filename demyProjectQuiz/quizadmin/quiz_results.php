<?php
// Include the connection file
include('connection.php');

$id=$_GET['id'];
// Fetch all quiz results for all students
$results_query = "
SELECT 
    qr.student_id,
    s.name,
    q.quiz_name,
    q.id,
    q.id AS quiz_db_id,
    q.quiz_id,
    qc.quiz_category,
    q.quiz_date,
    q.start_time,
    q.end_time,
    COUNT(qr.question_id) AS total_questions,
    SUM(qr.is_correct) AS correct_answers,
    (SUM(qr.is_correct) / COUNT(qr.question_id)) * 100 AS score_percentage
FROM quiz_results qr
JOIN quizzes q ON qr.quiz_id = q.id
JOIN quiz_category qc ON q.quiz_category = qc.id
JOIN interns s ON qr.student_id = s.id
WHERE q.id = '$id'
GROUP BY qr.student_id, q.quiz_id
ORDER BY score_percentage DESC
";

$results_result = mysqli_query($connection, $results_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Results</title>
    <!-- Bootstrap 5.3 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css"> <!-- Your custom styles -->
</head>
<body>

<?php include('header.php'); ?>

<div class="text-end mb-3">
    <a href="generate_excel.php?id=<?php echo htmlspecialchars($id); ?>" class="btn btn-success">
        Generate Excel
    </a>
</div>


<!-- Quiz Results Table -->
<div class="container mt-5">
    <h2 class="mb-4">Quiz Results</h2>
    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Student Name</th>
                    <th>Quiz Name</th>
                    <th>Quiz ID</th>
                    <th>Category</th>
                    <th>Date</th>
                    <th>Start Time</th>
                    <th>End Time</th>
                    <th>Total Questions</th>
                    <th>Correct Answers</th>
                    <th>Score (%)</th>
                    <th>Results</th>
                                        <th>Delete</th>

                </tr>
            </thead>
            <tbody>
                <?php
                if (mysqli_num_rows($results_result) > 0) {
                    $count = 1;
                    while ($row = mysqli_fetch_assoc($results_result)) {
                        // Calculate the score as a percentage
                        $total_questions = (int)$row['total_questions'];
                        $correct_answers = (int)$row['correct_answers'];
                        $score_percentage = ($total_questions > 0) ? ($correct_answers / $total_questions) * 100 : 0;

                        echo "<tr>";
                        echo "<td>" . $count . "</td>";
                        echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['quiz_name']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['quiz_id']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['quiz_category']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['quiz_date']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['start_time']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['end_time']) . "</td>";
                        echo "<td>" . htmlspecialchars($total_questions) . "</td>";
                        echo "<td>" . htmlspecialchars($correct_answers) . "</td>";
                        echo "<td>" . number_format($score_percentage, 2) . "%</td>";
                        echo "<td>
                        <a href='view_quiz_details.php?id=" . htmlspecialchars($row['id']) . "&student_id=" . htmlspecialchars($row['student_id']) . "' class='btn btn-info btn-sm'>View Details</a>
                      </td>";
                      
                       echo "<td>
                        <a href='delete.php?id=" . htmlspecialchars($row['id']) . "&student_id=" . htmlspecialchars($row['student_id']) . "' class='btn btn-danger btn-sm'>Delete</a>
                      </td>";
                
                        echo "</tr>";

                        $count++;
                    }
                } else {
                    echo "<tr><td colspan='12' class='text-center'>No quiz results found</td></tr>";
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
