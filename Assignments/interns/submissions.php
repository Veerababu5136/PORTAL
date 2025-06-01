<?php
include('connection.php');
include('authentication.php');

// Get the student intern ID from the session
$student_intern_id = $_SESSION['dss_id']; // Ensure this is the correct session variable for student ID

// Fetch submissions for the logged-in student with category name and assignment name
$query = "
    SELECT DISTINCT s.*, c.category_name, a.assignment_name,a.post_date,a.end_date 
    FROM submissions s
    JOIN assignments a ON s.assignment_id = a.id
    JOIN categories c ON a.category_id = c.id 
    WHERE s.student_intern_id = '$student_intern_id' 
    ORDER BY s.post_date ASC";

$query_runner = mysqli_query($connection, $query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css"/>
    <title>Your Submissions</title>
    <!-- Bootstrap CSS for styling -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include('header2.php'); ?>

    <div class="container-fluid mt-5">
        <h3 class='text-center mb-5'>Your Submissions</h3>

        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">S.No</th>
                        <th scope="col">Student Intern ID</th>
                        
                                                                        <th scope="col">Assignment Name</th>

                        <th scope="col">Category Name</th>

                        <th scope="col">Assignment Link</th>
                        <th scope="col">Solution Link</th>
                        <th scope="col">Post Date</th>
                        <th scope="col">End Date</th>
                        <th scope="col">Submitted Date</th>
                        <th scope="col">Marks</th>
                        <th scope="col">Verified</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (mysqli_num_rows($query_runner) > 0) {
                        $sno = 1;
                        while ($row = mysqli_fetch_assoc($query_runner)) {
                            // Get submission data
                            $submission_id = $row['id'];
                            
                                                                                    $assignment_name = $row['assignment_name'];

                            $category_name = $row['category_name'];

                            $assignment_link = $row['assignment_link'];
                            $solution_link = $row['solution_link'];
                            $post_date = $row['post_date'];
                            $end_date = $row['end_date'];
                            $submitted_date = $row['submitted_date'];
                            $marks = $row['marks'];
                            $verified = $row['verified'];

                            // Display submission data in table
                            ?>
                           <tr>
    <td data-label="S.No"><?php echo $sno++; ?></td>
    <td data-label="Student Intern ID"><?php echo htmlspecialchars($student_intern_id); ?></td>
    <td data-label="Assignment Name"><?php echo htmlspecialchars($assignment_name); ?></td>
    <td data-label="Category Name"><?php echo htmlspecialchars($category_name); ?></td>
    <td data-label="Assignment Link">
        <a href="<?php echo htmlspecialchars($assignment_link); ?>" target="_blank">View Assignment</a>
    </td>
    <td data-label="Solution Link">
        <a href="<?php echo htmlspecialchars($solution_link); ?>" target="_blank">View Solution</a>
    </td>
    <td data-label="Post Date"><?php echo htmlspecialchars($post_date); ?></td>
    <td data-label="End Date"><?php echo htmlspecialchars($end_date); ?></td>
    <td data-label="Submitted Date"><?php echo htmlspecialchars($submitted_date); ?></td>
    <td data-label="Marks"><?php echo htmlspecialchars($marks); ?></td>
    <td data-label="Verification Status">
        <?php echo $verified == 1 ? 'Verified' : 'Not Verified'; ?>
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
