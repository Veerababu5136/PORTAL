<?php
// Include the connection file
include('connection.php');

// Fetch quizzes from the database
$query = "SELECT * FROM quizzes";
$result = mysqli_query($connection, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz List</title>
    <!-- Bootstrap 5.3 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css"> <!-- Your custom styles -->
</head>
<body>

<?php include('header.php'); ?>

<!-- Quiz List Table -->
<div class="container mt-5">

<div class="container mt-5">
<h2 class="mb-4 text-center">Quiz List</h2>
<div class="d-flex justify-content-center mt-3 mb-3">
<a href="quiz_add.php" class="btn btn-primary mb-3 text-center">Add New Quiz</a>
</div>



    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Quiz Name</th>
                    <th>Quiz ID</th>
                    <th>Category</th>
                    <th>Date</th>
                    <th>Start Time</th>
                    <th>End Time</th>
                    <th>Questions</th>
                    <th>Actions</th>
                    <th>Questions</th>
                    <th>Result</th>


                </tr>
            </thead>
            <tbody>
                <?php
                if (mysqli_num_rows($result) > 0) {
                    $count = 1;
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . $count . "</td>";
                        echo "<td>" . htmlspecialchars($row['quiz_name']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['quiz_id']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['quiz_category']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['quiz_date']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['start_time']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['end_time']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['total_questions']) . "</td>";
                        echo "<td>
                                <a href='edit_quiz.php?id=" . htmlspecialchars($row['id']) . "' class='btn btn-warning btn-sm'>Edit</a>
                                <a href='delete_quiz.php?id=" . htmlspecialchars($row['id']) . "' class='btn btn-danger btn-sm'>Delete</a>
                              </td>";

                        echo "<td>
                        <a href='quiz_edit_questions.php?id=" . htmlspecialchars($row['id']) . "' class='btn btn-warning btn-sm'>Update</a>
                      </td>";

                      echo "<td>
                      <a href='quiz_results.php?id=" . htmlspecialchars($row['id']) . "' class='btn btn-success btn-sm'>View Result</a>
                    </td>";
                      
                echo "</tr>";

                        $count++;
                    }
                } else {
                    echo "<tr><td colspan='9' class='text-center'>No quizzes found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
            </div>

<?php include('footer.php'); ?>

</body>
</html>

<?php
// Close the database connection
mysqli_close($connection);
?>
