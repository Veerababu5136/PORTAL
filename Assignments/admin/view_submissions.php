<?php
include('connection.php');
include('authentication.php');

// Check if both category_id and assignment_id are set in the URL
if (isset($_GET['category_id']) && isset($_GET['assignment_id'])) {
    $category_id = intval($_GET['category_id']);
    $assignment_id = intval($_GET['assignment_id']);

    // Fetch submissions for the specific category and assignment
    $query = "SELECT * FROM submissions WHERE category_id = $category_id AND assignment_id = $assignment_id ORDER BY post_date ASC";
    $query_runner = mysqli_query($connection, $query);
} else {
    // Redirect or show an error if category_id or assignment_id is not set
    header("Location: categories.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css"/>
    <title>View Submissions</title>
    <!-- Bootstrap CSS for styling -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include('header2.php'); ?>

    <div class="container mt-5">
        <h3 class='text-center mb-5'>View Submissions</h3>

        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">S.No</th>
                        <th scope="col">Student Intern ID</th>
                        <th scope="col">Assignment Link</th>
                        <th scope="col">Solution Link</th>
                        <th scope="col">Post Date</th>
                        <th scope="col">End Date</th>
                        <th scope="col">Submitted Date</th>

                        <th scope="col">Marks</th>

                        <th scope="col">Status</th>
                                                                                                <th scope="col">Comment</th>

                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (mysqli_num_rows($query_runner) > 0) {
                        $sno = 1;
                        while ($row = mysqli_fetch_assoc($query_runner)) {
                            // Get submission data
                            $submission_id = $row['id'];
                            $student_intern_id = $row['student_intern_id'];
                            $assignment_link = $row['assignment_link'];
                            $solution_link = $row['solution_link'];
                            $post_date = $row['post_date'];
                            $end_date = $row['end_date'];
                            $submitted_date = $row['submitted_date'];
                                                        $comment = $row['comment'];

                            $marks = $row['marks'];
                            $verified = $row['verified'];

                            // Display submission data in table
                            ?>
                            <tr>
                                <td><?php echo $sno++; ?></td>
                                <td><?php echo htmlspecialchars($student_intern_id); ?></td>
                                <td><a href="<?php echo htmlspecialchars($assignment_link); ?>" target="_blank">View Assignment</a></td>
                                <td><a href="<?php echo htmlspecialchars($solution_link); ?>" target="_blank">View Solution</a></td>
                                <td><?php echo htmlspecialchars($post_date); ?></td>
                                <td><?php echo htmlspecialchars($end_date); ?></td>
                                <td><?php echo htmlspecialchars($submitted_date); ?></td>
                                
                               
                                <td>
                                    <form action="update_marks.php" method="POST" style="display:inline;">
                                        <input type="hidden" name="submission_id" value="<?php echo $submission_id; ?>">
                                        <input type="hidden" name="category_id" value="<?php echo $category_id; ?>">
                                        <input type="hidden" name="assignment_id" value="<?php echo $assignment_id; ?>">

                                        <input type="number" name="marks" min="0" max="100" value="<?php echo htmlspecialchars($marks); ?>" required>
                                </td>
                                
                                <td>
                                        <select name="verified" required>
                                            <option value="0" <?php echo $verified == 0 ? 'selected' : ''; ?>>Not Verified</option>
                                            <option value="1" <?php echo $verified == 1 ? 'selected' : ''; ?>>Verified</option>
                                        </select>
                                </td>
                                
                                 <td><input type="text" name="comment" value="<?php echo htmlspecialchars($comment); ?>" placeholder="comments" required>
</td>
                                <td>
                                        <button type="submit" class="btn btn-primary btn-sm">Update</button>
                                    </form>
                                </td>
                            </tr>
                        <?php
                        }
                    } else {
                        echo "<tr><td colspan='10' class='text-center'>No Submissions Found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <?php include('footer.php'); ?>
</body>
</html>
