<?php
include('connection.php');

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') 
{
    // Retrieve form data
    $id = $_GET['id']; // Assuming the ID is passed in the URL
    $dss_id = mysqli_real_escape_string($connection, $_POST['dss_id']);
    $name = mysqli_real_escape_string($connection, $_POST['name']);
    $batch_no = mysqli_real_escape_string($connection, $_POST['batch_no']);
        $email = mysqli_real_escape_string($connection, $_POST['email']);
    $password = mysqli_real_escape_string($connection, $_POST['password']);


    // Prepare and execute the update query
    $query = "UPDATE interns SET dss_id = '$dss_id', name = '$name', batch_no = '$batch_no',email='$email',password='$password' WHERE id = '$id'";
    $query_runner = mysqli_query($connection, $query);

    if ($query_runner) {
        // Update successful
        echo "<script>
                alert('Intern details updated successfully!');
                window.location.href='interns.php'; // Redirect to intern list or any desired page
              </script>";
    } else {
        // Update failed
        echo "<script>
                alert('Failed to update intern details. Please try again.');
                window.location.href='edit_interns.php?id=$id'; // Redirect back to the edit page
              </script>";
    }
} else {
    // If the request method is not POST
    echo "<script>
            alert('Invalid request.');
            window.location.href='interns.php'; // Redirect to intern list or any desired page
          </script>";
}
?>
