<?php
include('connection.php');
include('authentication.php');

// Check if the assignment ID and category ID are passed
if (isset($_POST['assignment_id']) && isset($_POST['category_id'])) {
    $assignment_id = intval($_POST['assignment_id']);
    $category_id = intval($_POST['category_id']);

    // Get current student intern ID (assumed to be from session or auth)
    $student_intern_id = $_SESSION['dss_id'];

   // echo $student_intern_id;
    
    // Fetch assignment details (if needed)
    $query = "SELECT * FROM assignments WHERE id = $assignment_id";
    $assignment_result = mysqli_query($connection, $query);
    
    // Check if assignment exists
    if (mysqli_num_rows($assignment_result) > 0) {
        $assignment = mysqli_fetch_assoc($assignment_result);
        $assignment_link = $assignment['assignment_question_link'];
    } else {
        echo "Assignment not found!";
        exit;
    }
} else {
    echo "Invalid Access!";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css"/>
    <title>Submit Assignment</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include('header2.php'); ?>

    <div class="container mt-5">
        <h3 class="text-center mb-5">Submit Assignment</h3>
        
        <form action="process_submit_assignments.php" method="POST">
            <div class="mb-3">
                <label for="assignment_link" class="form-label">Assignment Link</label>
                <input type="text" class="form-control" id="assignment_link" value="<?php echo $assignment_link; ?>" readonly>
            </div>

            <div class="mb-3">
                <label for="solution_link" class="form-label">Your Solution Link</label>
                <input type="text" class="form-control" id="solution_link" name="solution_link" required>
            </div>

            <input type="hidden" name="assignment_id" value="<?php echo $assignment_id; ?>">
            <input type="hidden" name="category_id" value="<?php echo $category_id; ?>">
            
            <button type="submit" class="btn btn-primary">Submit Assignment</button>
        </form>
    </div>

    <?php include('footer.php'); ?>
</body>
</html>
