<?php
include('connection.php');
include('authentication.php');

// Check if the 'id' is provided in the URL and fetch the contest details
if (isset($_GET['id'])) {
    $contest_id = mysqli_real_escape_string($connection, $_GET['id']);

    // Fetch contest data based on the provided ID
    $query = "SELECT * FROM contests WHERE id = '$contest_id'";
    $query_runner = mysqli_query($connection, $query);

    if (mysqli_num_rows($query_runner) > 0) {
        $contest = mysqli_fetch_assoc($query_runner);
    } else {
        echo "<script>alert('Contest not found.'); window.location.href='home.php';</script>";
        exit();
    }
} else {
    echo "<script>alert('Invalid request.'); window.location.href='home.php';</script>";
    exit();
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Contest</title>
 
</head>
<body>

<?php include('header2.php'); ?>

<div class="container mt-5">
    <h2 class="text-center">Edit Contest</h2>
    <form action="edit_contest_process.php" method="POST">


    <div class="form-group">
            <label for="contest_name">Contest Id</label>
            <input type="text" class="form-control" id="contest_name" name="contest_id" value="<?php echo $contest['id']; ?>" required readonly>
        </div>
        

        <div class="form-group">
            <label for="contest_name">Contest Name</label>
            <input type="text" class="form-control" id="contest_name" name="contest_name" value="<?php echo $contest['contest_name']; ?>" required>
        </div>

        <div class="form-group">
            <label for="date">Contest Date</label>
            <input type="date" class="form-control" id="date" name="date" value="<?php echo $contest['date']; ?>" required>
        </div>
        <div class="form-group">
            <label for="start_time">Start Time</label>
            <input type="time" class="form-control" id="start_time" name="start_time" value="<?php echo $contest['start_time']; ?>" required>
        </div>
        <div class="form-group">
            <label for="end_time">End Time</label>
            <input type="time" class="form-control" id="end_time" name="end_time" value="<?php echo $contest['end_time']; ?>" required>
        </div>
        <div class="form-group">
            <label for="link">Contest Link</label>
            <input type="url" class="form-control" id="link" name="link" value="<?php echo $contest['link']; ?>" required>
        </div>

        <div class="d-flex justify-content-center mt-3 mb-3 mx-5">
        <button type="submit" name="submit" class="btn btn-primary">Update Contest</button>
        <a href="contests_list.php" class="btn btn-secondary">Cancel</a>

          </div>


    </form>
</div>

<?php include('footer.php'); ?>

</body>
</html>
