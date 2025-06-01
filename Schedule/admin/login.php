<?php

session_start();

include 'connection.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';


    // Escape the input to prevent SQL injection
    $email = mysqli_real_escape_string($connection, $_POST['email']);

    // Select query to find the admin by email
    $query = "SELECT * FROM admins WHERE admin_email='$email'";
    $query_runner = mysqli_query($connection, $query);

    // Check if the email exists in the database
    if (mysqli_num_rows($query_runner) > 0) {
        // Generate OTP
        $otp = rand(1000, 9999);

        $mail = new PHPMailer(true);

        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
           $mail->Username = 'demysoftwaresolutions@gmail.com';
$mail->Password = 'wovtasshmvtxlquy';
            $mail->SMTPSecure = 'ssl';
            $mail->Port = 465;

            // Recipients
            $mail->setFrom('demysoftwaresolutions@gmail.com', 'DSS Schedlue System');
            $mail->addAddress($email); // Add a recipient

            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Your OTP Code from DSS Schedlue System';
            $mail->Body = "Your OTP code is: <b>$otp</b>";

            $mail->send();

            // Store OTP and email in session variables
            $_SESSION['v_otp'] = $otp;
            $_SESSION['v_email'] = $email;

            echo "<script>alert('OTP sent successfully to $email');</script>";
            // Redirect to OTP verification page
            header("Location: verify_otp.php");
            exit();
        } catch (Exception $e) {
            echo "<script>alert('Failed to send OTP. Error: {$mail->ErrorInfo}');</script>";
        }
    } else {
        echo "<script>alert('Wrong email...');
        window.location.href='index.php';
        </script>";
        exit();
    
}
?>
