<?php
// Include the connection file
include('connection.php');

// Get the quiz ID and student ID from the query parameters
$quiz_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$student_id = isset($_GET['student_id']) ? intval($_GET['student_id']) : 0;

// Prepare the delete query
$quiz_results_query = "DELETE FROM quiz_results WHERE quiz_id=? AND student_id=?";
$stmt = mysqli_prepare($connection, $quiz_results_query);

if ($stmt) {
    // Bind parameters
    mysqli_stmt_bind_param($stmt, "ii", $quiz_id, $student_id);
    
    // Execute the query
    if (mysqli_stmt_execute($stmt)) {
        echo "<script>
            alert('Submission deleted successfully...');
            window.location.href='quiz_results.php';
        </script>";
    } else {
        echo "<script>
            alert('Error deleting submission: " . mysqli_error($connection) . "');
            window.location.href='quiz_results.php';
        </script>";
    }
    
    // Close the statement
    mysqli_stmt_close($stmt);
} else {
    echo "<script>
        alert('Error preparing statement: " . mysqli_error($connection) . "');
        window.location.href='quiz_results.php';
    </script>";
}

// Close the connection
mysqli_close($connection);
?>
