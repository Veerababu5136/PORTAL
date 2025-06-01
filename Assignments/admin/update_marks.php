<?php
session_start();
include('connection.php');
include('authentication.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

// Check if the form data is set
if (isset($_POST['submission_id'], $_POST['marks'], $_POST['verified'], $_POST['category_id'],$_POST['assignment_id'])) 
{
    
    $submission_id = intval($_POST['submission_id']);
    $comment=$_POST['comment'];
    $marks = intval($_POST['marks']);
    $verified = intval($_POST['verified']);
    $category_id = intval($_POST['category_id']);
    
        $id = intval($_POST['assignment_id']);

    
    
    $query="select assignment_name from assignments where id='$id'";
    $query_runner=mysqli_query($connection,$query);
    
    while($row=mysqli_fetch_assoc($query_runner))
    {
        $an=$row['assignment_name'];
    }

    // Fetch student_intern_id based on the submission ID
    $student_query = "SELECT student_intern_id FROM submissions WHERE id = ?";
    $stmt = mysqli_prepare($connection, $student_query);
    mysqli_stmt_bind_param($stmt, 'i', $submission_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $student_intern_id);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    // Fetch the student's email and name from the interns table using student_intern_id
$email_query = "SELECT email, name FROM interns WHERE dss_id = ?";
$stmt = mysqli_prepare($connection, $email_query);
mysqli_stmt_bind_param($stmt, 's', $student_intern_id); // Assuming student_intern_id is a string
mysqli_stmt_execute($stmt);

// Bind both email and name to variables
mysqli_stmt_bind_result($stmt, $student_email, $student_name);

// Fetch the result
mysqli_stmt_fetch($stmt);

// Close the statement
mysqli_stmt_close($stmt);


    // Prepare the update query
    $update_query = "UPDATE submissions SET marks = ?, verified = ?,comment=? WHERE id = ?";
    $stmt = mysqli_prepare($connection, $update_query);

    // Bind parameters
    mysqli_stmt_bind_param($stmt, 'iisi', $marks, $verified,$comment,$submission_id);

    // Execute the query
    if (mysqli_stmt_execute($stmt)) {
        // Prepare to send an email to the student regarding assignment correction
        $mail = new PHPMailer(true);
        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; // Set the SMTP server to send through
            $mail->SMTPAuth = true; // Enable SMTP authentication
            $mail->Username = 'demysoftwaresolutions@gmail.com'; // Your SMTP username
            $mail->Password = 'wovtasshmvtxlquy'; // Your SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // Enable TLS encryption
            $mail->Port = 465; // TCP port to connect to

            // Recipients
            $mail->setFrom('demysoftwaresolutions@gmail.com', 'DSS Assignment System');
            $mail->addAddress($student_email); // Add the student's email

            // Content
            $mail->isHTML(true);
$mail->Subject = 'Your ' . $an . ' Assignment Correction Notification';
            $mail->Body = "Dear $student_name,<br><br>Your $an assignment submission has been reviewed. The following updates have been made:<br><br>" .
                                      "Comment: $comment<br>" .

                          "Marks: $marks<br>" .
                          "Verification Status: " . ($verified ? "Verified" : "Not Verified") . "<br><br>" .
                          "Please check your submission for more details.<br><br>Best regards,<br>Your Instructor";

            // Send the email
            $mail->send();

            // Success alert and redirection
            echo "<script>
                    alert('Marks updated and email sent to the student successfully.');
                    window.history.back();
                  </script>";
            exit();
        } catch (Exception $e) {
            // Warning alert for email failure
            echo "<script>
                    alert('Marks updated, but failed to send email: {$mail->ErrorInfo}.');
                    window.location.href='view_submissions.php?category_id=$category_id';
                  </script>";
            exit();
        }
    } else {
        // Error alert for query failure
        echo "<script>
                alert('Failed to update marks.');
                window.location.href='view_submissions.php?category_id=$category_id';
              </script>";
        exit();
    }

    // Close the statement
    mysqli_stmt_close($stmt);
} else {
    // Redirect if the required data is not set
    echo "<script>
            alert('Invalid submission.');
            window.location.href='view_submissions.php?error=Invalid submission.';
          </script>";
    exit();
}

// Close the database connection
mysqli_close($connection);
?>
