<?php
// Include the connection file
include('connection.php');

// Set your local time zone (e.g., 'Asia/Kolkata' for IST which is UTC+5:30)
date_default_timezone_set('Asia/Kolkata');


//echo $_SESSION['email'];
// Get the current date and time in your local time zone
$current_date_time = date('Y-m-d H:i:s');

// Fetch all quizzes
$query = "SELECT * FROM quizzes";
$result = mysqli_query($connection, $query);

// Check if the query was successful
if (!$result) {
    echo "<p>Error fetching quizzes: " . mysqli_error($connection) . "</p>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <!-- Bootstrap 5.3 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .quiz-status.active {
            color: green;
            font-weight: bold;
        }
        .quiz-status.ended {
            color: red;
            font-weight: bold;
        }
        .quiz-status.coming {
            color: blue;
            font-weight: bold;
        }
    </style>
</head>
<body>

<?php include('header2.php'); ?>

<div class="container mt-5">
    <h2 class="mb-4">Quizzes Dashboard</h2>
    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Quiz Name</th>
                    <th>Quiz ID</th>
                    <th>Category</th>
                    <th>Date</th>
                    <th>Total Questions</th>
                    <th>Start Time</th>
                    <th>End Time</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <?php
                    // Extract quiz details
                    $quiz_id = htmlspecialchars($row['id']);
                    $quiz_name = htmlspecialchars($row['quiz_name']);
                    $quiz_code = htmlspecialchars($row['quiz_id']);
                    $quiz_category = htmlspecialchars($row['quiz_category']);
                    $quiz_date = $row['quiz_date'];
                    $total_questions = $row['total_questions'];
                    $start_time = $row['start_time'];
                    $end_time = $row['end_time'];

                    // Combine date and time
                    $start_date_time = $quiz_date . ' ' . $start_time;
                    $end_date_time = $quiz_date . ' ' . $end_time;

                    // Determine status
                    if ($current_date_time < $start_date_time) {
                        $status = 'Coming';
                        $status_class = 'coming';
                    } elseif ($current_date_time > $end_date_time) {
                        $status = 'Ended';
                        $status_class = 'ended';
                    } else {
                        $status = 'Active';
                        $status_class = 'active';
                    }
                    ?>
                    <tr>
                        <td><?php echo $quiz_id; ?></td>
                        <td><?php echo $quiz_name; ?></td>
                        <td><?php echo $quiz_code; ?></td>
                        <td><?php echo $quiz_category; ?></td>
                        <td><?php echo $quiz_date; ?></td>
                        <td><?php echo $total_questions; ?></td>
                        <td><?php echo $start_time; ?></td>
                        <td><?php echo $end_time; ?></td>
                        <td class="quiz-status <?php echo $status_class; ?>">
        <?php echo $status; ?>
        <?php if ($status == 'Active'): ?>
            <a href="take_quiz.php?id=<?php echo $quiz_id; ?>" class="btn btn-success btn-sm">Start Quiz</a>
        <?php endif; ?>
    </td>                    </tr>
                <?php endwhile; ?>
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
