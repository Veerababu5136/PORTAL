<?php
// Include the connection file
include('connection.php');

// Check if the ID parameter is present in the URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $quiz_id = mysqli_real_escape_string($connection, $_GET['id']);

    // Fetch quiz details from the database
    $query = "SELECT * FROM quizzes WHERE id = $quiz_id";
    $quiz_result = mysqli_query($connection, $query);

    if ($quiz_result && mysqli_num_rows($quiz_result) > 0) {
        $quiz = mysqli_fetch_assoc($quiz_result);
    } else {
        echo "<p>No quiz found with this ID.</p>";
        exit;
    }
} else {
    echo "<p>Invalid quiz ID.</p>";
    exit;
}

// Fetch quiz categories for the dropdown
$categories_query = "SELECT * FROM quiz_category";
$categories_result = mysqli_query($connection, $categories_query);

// Close the database connection
mysqli_close($connection);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Quiz</title>
    <!-- Bootstrap 5.3 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css"> <!-- Your custom styles -->
</head>
<body>

<?php include('header.php'); ?>

<!-- Form for Editing Quiz -->
<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <div class="card mt-4">
                <div class="card-header">
                    <h4>Edit Quiz</h4>
                </div>
                <div class="card-body">
                    <form action="process_edit_quiz.php" method="POST">
                        <input type="hidden" name="quiz_id" value="<?php echo htmlspecialchars($quiz['id']); ?>">
                        <div class="form-group">
                            <label for="quizName">Quiz Name:</label>
                            <input type="text" id="quizName" name="quiz_name" class="form-control" value="<?php echo htmlspecialchars($quiz['quiz_name']); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="quizCategory">Quiz Category:</label>
                            <select id="quizCategory" name="quiz_category" class="form-control" required>
                                <option value="" disabled>Select a category</option>
                                <?php
                                if (mysqli_num_rows($categories_result) > 0) {
                                    while ($row = mysqli_fetch_assoc($categories_result)) {
                                        $selected = ($row['id'] == $quiz['quiz_category']) ? 'selected' : '';
                                        echo "<option value='" . htmlspecialchars($row['id']) . "' $selected>" . htmlspecialchars($row['quiz_category']) . "</option>";
                                    }
                                } else {
                                    echo "<option value='' disabled>No categories available</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="quizDate">Date:</label>
                            <input type="date" id="quizDate" name="quiz_date" class="form-control" value="<?php echo htmlspecialchars($quiz['quiz_date']); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="startTime">Start Time:</label>
                            <input type="time" id="startTime" name="start_time" class="form-control" value="<?php echo htmlspecialchars($quiz['start_time']); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="endTime">End Time:</label>
                            <input type="time" id="endTime" name="end_time" class="form-control" value="<?php echo htmlspecialchars($quiz['end_time']); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="totalQuestions">Number of Questions:</label>
                            <input type="number" id="totalQuestions" name="total_questions" class="form-control" value="<?php echo htmlspecialchars($quiz['total_questions']); ?>" required readonly>
                        </div>
                        <button type="submit" class="btn btn-success">Update Quiz</button>
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

</body>
</html>
