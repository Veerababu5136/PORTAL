<?php
include('connection.php');
include('authentication.php');

// Check if submission_id and category_id are set in the POST request
if (isset($_POST['submission_id']) && isset($_POST['category_id'])) {
    $submission_id = intval($_POST['submission_id']);
    $category_id = intval($_POST['category_id']);
    
    // Fetch the current verified status of the submission
    $query = "SELECT verified FROM submissions WHERE id = $submission_id";
    $result = mysqli_query($connection, $query);
    
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $current_verified_status = $row['verified'];
        
        // Toggle the verified status
        $new_verified_status = $current_verified_status ? 0 : 1;
        
        // Update the verified status in the submissions table
        $update_query = "UPDATE submissions SET verified = $new_verified_status WHERE id = $submission_id";
        
        if (mysqli_query($connection, $update_query)) {
            // Redirect back to the view_submissions.php page with the selected category
            header("Location: view_submissions.php?category_id=$category_id");
            exit;
        } else {
            echo "Failed to update verification status.";
        }
    } else {
        echo "Submission not found.";
    }
} else {
    echo "Invalid request.";
}
?>
