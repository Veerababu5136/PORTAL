<?php
include('connection.php');

// Ensure the student_id is set in the session
if (!isset($_SESSION['student_id'])) {
    die("Student ID is not set in session.");
}

// Escape the student_id to prevent SQL injection
$student_id = mysqli_real_escape_string($connection, $_SESSION['student_id']);

// Fetch all quiz results for the logged-in student
$results_query = "
    SELECT 
        qr.student_id,
        s.name,
        q.quiz_name,
        q.quiz_id,
        qc.quiz_category,
        q.quiz_date,
        q.start_time,
        q.end_time,
        COUNT(qr.question_id) AS total_questions,
        SUM(qr.is_correct) AS correct_answers
    FROM quiz_results qr
    JOIN quizzes q ON qr.quiz_id = q.id
    JOIN quiz_category qc ON q.quiz_category = qc.id
    JOIN interns s ON qr.student_id = s.id
    WHERE qr.student_id = '$student_id'
    GROUP BY qr.student_id, q.quiz_id
";

$results_result = mysqli_query($connection, $results_query);

if (!$results_result) {
    die("Database query failed: " . mysqli_error($connection));
}
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
    
    
     <style>
          /* Make the table responsive */
.table-responsive {
     
    overflow-x: auto;
}

@media (max-width: 767.98px) {
    /* Apply to screens smaller than 768px (Bootstrap's md breakpoint) */
    
    .table thead {
        display: none; /* Hide table header */
    }
    
    .table, .table tbody, .table tr, .table td {
        display: block; /* Make everything block-level */
        width: 100%; /* Full width */
    }
    
    .table tr {
        margin-bottom: 1rem; /* Add space between rows */
        border: 1px solid #dee2e6; /* Optional: Add a border around each row */
        border-radius: 0.5rem; /* Optional: Add rounded corners */
        padding: 1rem; /* Optional: Add padding for spacing */
    }
    
    .table td {
        display: flex; /* Flexbox layout */
        justify-content: space-between; /* Space between label and content */
        align-items: center; /* Vertically align items */
        padding: 0.5rem 1rem; /* Padding inside each cell */
        border: none; /* Remove default table cell borders */
        border-bottom: 1px solid #dee2e6; /* Add border between items */
    }

    .table td:last-child {
        border-bottom: none; /* Remove border from the last item */
    }
    
    .table td::before {
        content: attr(data-label); /* Use the data-label attribute for labels */
        font-weight: bold; /* Make labels bold */
        flex-basis: 50%; /* Set label width */
        text-align: left; /* Align labels to the left */
        padding-right: 1rem; /* Space between label and content */
        color: #495057; /* Label text color */
    }
}

     </style>
</head>
<body>

<?php include('header2.php'); ?>

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
                        echo "<td data-label='S.No'>" . $count . "</td>";
                        echo "<td data-label='name'>" . htmlspecialchars($row['name']) . "</td>";
                        echo "<td data-label='quiz name'>" . htmlspecialchars($row['quiz_name']) . "</td>";
                        echo "<td data-label='quiz id'>" . htmlspecialchars($row['quiz_id']) . "</td>";
                        echo "<td data-label='category'>" . htmlspecialchars($row['quiz_category']) . "</td>";
                        echo "<td data-label='date'>" . htmlspecialchars($row['quiz_date']) . "</td>";
                        echo "<td data-label='start time'>" . htmlspecialchars($row['start_time']) . "</td>";
                        echo "<td data-label='end time'>" . htmlspecialchars($row['end_time']) . "</td>";
                        echo "<td data-label='total questions'>" . htmlspecialchars($total_questions) . "</td>";
                        echo "<td data-label='correct answers'>" . htmlspecialchars($correct_answers) . "</td>";
                        echo "<td data-label='Score(%)'>" . number_format($score_percentage, 2) . "%</td>";
                       
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
