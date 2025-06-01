<?php
include('connection.php');
include('authentication.php');

// Fetch the schedule details based on the provided schedule ID
if (isset($_GET['id'])) {
    $schedule_id = mysqli_real_escape_string($connection, $_GET['id']);
    $query = "SELECT * FROM schedule WHERE id='$schedule_id'";
    $query_run = mysqli_query($connection, $query);
    
    if (mysqli_num_rows($query_run) > 0) {
        $schedule_data = mysqli_fetch_assoc($query_run);
    } else {
        $_SESSION['status'] = "No record found with the given ID.";
        header("Location: home.php");
        exit();
    }
}

// Update schedule details when the form is submitted
if (isset($_POST['update'])) {
    $schedule_id = mysqli_real_escape_string($connection, $_POST['schedule_id']);
    $schedule_date = mysqli_real_escape_string($connection, $_POST['schedule_date']);
    $schedule_morning = mysqli_real_escape_string($connection, $_POST['schedule_morning']);
    $schedule_evening = mysqli_real_escape_string($connection, $_POST['schedule_evening']);

    $update_query = "UPDATE schedule SET 
                        schedule_date='$schedule_date', 
                        schedule_morning='$schedule_morning', 
                        schedule_evening='$schedule_evening' 
                    WHERE id='$schedule_id'";

    $update_run = mysqli_query($connection, $update_query);

    if ($update_run) {
        $_SESSION['status'] = "Schedule updated successfully!";
        header("Location: home.php");
    } else {
        $_SESSION['status'] = "Failed to update the schedule.";
        header("Location: edit_schedule.php?id=$schedule_id");
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link rel="stylesheet" href="style.css"/>
     <title>Edit Schedule</title>
</head>
<body>
    <?php include('header2.php'); ?>

    <div class="container mt-5">
        <h1 class="text-center">Edit Schedule</h1>

        <!-- Check if schedule data is available -->
        <?php if (isset($schedule_data)) { ?>

        <!-- Schedule edit form -->
        <form action="edit_schedule.php?id=<?php echo $schedule_data['id']; ?>" method="POST" class="mt-4">
            <input type="hidden" name="schedule_id" value="<?php echo $schedule_data['id']; ?>">

            <div class="form-group mb-3">
                <label for="schedule_date">Schedule Date</label>
                <input type="date" name="schedule_date" class="form-control" value="<?php echo $schedule_data['schedule_date']; ?>" required>
            </div>

            <div class="form-group mb-3">
                <label for="schedule_morning">Morning Schedule</label>
                <textarea name="schedule_morning" class="form-control" rows="4" required><?php echo $schedule_data['schedule_morning']; ?></textarea>
            </div>

            <div class="form-group mb-3">
                <label for="schedule_evening">Evening Schedule</label>
                <textarea name="schedule_evening" class="form-control" rows="4" required><?php echo $schedule_data['schedule_evening']; ?></textarea>
            </div>

            <button type="submit" name="update" class="btn btn-primary">Update Schedule</button>
        </form>

        <?php } else { ?>
            <p class="text-center">No schedule found to edit.</p>
        <?php } ?>
    </div>

    <?php include('footer.php'); ?>
</body>
</html>
