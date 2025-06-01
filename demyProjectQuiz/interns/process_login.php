<?php
include('connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize user inputs
    $email = mysqli_real_escape_string($connection, $_POST['email']);
    $password = mysqli_real_escape_string($connection, $_POST['password']);

    // Validate the user in the database
    $query = "SELECT * FROM interns WHERE email = '$email'";
    $result = mysqli_query($connection, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        // Verify password
            // Start session and set user info
            session_start();
            $_SESSION['email'] = $user['email'];
            $_SESSION['student_id'] = $user['id'];


            // Redirect to a protected page
            header("Location: dashboard.php");
       
    } else {
        echo "<script>alert('No user found with this email.'); window.location.href='login.php';</script>";
    }
} else {
    echo "<p>Invalid request method.</p>";
}
?>
