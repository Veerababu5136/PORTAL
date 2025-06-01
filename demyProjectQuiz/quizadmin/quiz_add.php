<?php
include('connection.php');
$query = "SELECT * FROM quiz_category";
$result = mysqli_query($connection, $query);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Quiz</title>
    <!-- Bootstrap 5.3 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css"> <!-- Your custom styles -->
</head>
<body>

<?php include('header.php'); ?>

<!-- Form for Quiz Creation -->
<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <div class="card mt-4">
                <div class="card-header">
                    <h4>Create New Quiz</h4>
                </div>
                <div class="card-body">
                    <form action="process_add_quiz.php" method="POST">
                        <div class="form-group">
                            <label for="quizName">Quiz Name:</label>
                            <input type="text" id="quizName" name="quiz_name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="quizId">Quiz ID:</label>
                            <input type="text" id="quizId" name="quiz_id" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="quizCategory">Quiz Category:</label>
                            <select id="quizCategory" name="quiz_category" class="form-control" required>
                                <option value="" disabled selected>Select a category</option>
                                <?php
                                // Fetch quiz categories from database
                                

                                if (mysqli_num_rows($result) > 0) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo "<option value='" . htmlspecialchars($row['id']) . "'>" . htmlspecialchars($row['quiz_category']) . "</option>";
                                    }
                                } else {
                                    echo "<option value='' disabled>No categories available</option>";
                                }
                                mysqli_close($connection);
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="quizDate">Date:</label>
                            <input type="date" id="quizDate" name="quiz_date" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="startTime">Start Time:</label>
                            <input type="time" id="startTime" name="start_time" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="endTime">End Time:</label>
                            <input type="time" id="endTime" name="end_time" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="totalQuestions">Number of Questions:</label>
                            <input type="number" id="totalQuestions" name="total_questions" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-success">Create Quiz</button>
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
