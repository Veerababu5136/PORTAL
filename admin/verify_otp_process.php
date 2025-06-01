<?php
session_start();

// Check if OTP is set in the session
if (isset($_SESSION['v_otp']) && isset($_POST['otp'])) 
{
    $session_otp = $_SESSION['v_otp'];
    $entered_otp = $_POST['otp'];

    // Verify the OTP
    if ($entered_otp == $session_otp) 
    {
        
        // OTP is correct
        echo "<script>alert('OTP verified successfully.');</script>";
        // You can redirect to a success page or dashboard here
        header("Location: home.php"); // Replace with your desired page
        exit();
    } else {
        // OTP is incorrect
        echo "<script>alert('Invalid OTP. Please try again.');</script>";
        header("Location: verify_otp.php"); // Redirect back to OTP verification page
        exit();
    }
} else {
    // OTP or input is missing
    echo "<script>alert('Invalid request. Please try again.');</script>";
    header("Location: index.php"); // Redirect to the login page or another appropriate page
    exit();
}
?>
