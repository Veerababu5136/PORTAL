<?php
include('connection.php');
include('authentication.php');

if (isset($_POST['submit'])) {
    $schedule_date = mysqli_real_escape_string($connection, $_POST['schedule_date']);
    $schedule_morning = mysqli_real_escape_string($connection, $_POST['schedule_morning']);
    $schedule_evening = mysqli_real_escape_string($connection, $_POST['schedule_evening']);

    // Insert into the schedule table
    $query = "INSERT INTO schedule (schedule_date, schedule_morning, schedule_evening) 
              VALUES ('$schedule_date', '$schedule_morning', '$schedule_evening')";
    
    $query_run = mysqli_query($connection, $query);

    if ($query_run) {
        $_SESSION['status'] = "Schedule added successfully!";
        header("Location: home.php");
    } else {
        $_SESSION['status'] = "Failed to add schedule.";
        header("Location: home.php");
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link rel="stylesheet" href="style.css"/>
     <title>Add Schedule</title>
</head>
<body>
    <?php include('header2.php'); ?>

    <div class="container mt-5">
        <h1 class="text-center">Add Schedule</h1>
        
        <!-- Schedule form -->
        <form action="add_schedule.php" method="POST" class="mt-4">
            <div class="form-group mb-3">
                <label for="schedule_date">Schedule Date</label>
                <input type="date" name="schedule_date" class="form-control" required>
            </div>
            
            <div class="form-group mb-3">
                <label for="schedule_morning">Morning Schedule</label>
                <textarea name="schedule_morning" class="form-control" rows="4" placeholder="Enter morning schedule" required></textarea>
            </div>
            
            <div class="form-group mb-3">
                <label for="schedule_evening">Evening Schedule</label>
                <textarea name="schedule_evening" class="form-control" rows="4" placeholder="Enter evening schedule" required></textarea>
            </div>

            <button type="submit" name="submit" class="btn btn-primary">Add Schedule</button>
        </form>
    </div>

    <?php include('footer.php'); ?>
</body>
</html>
