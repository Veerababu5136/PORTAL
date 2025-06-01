<?php
include('connection.php');
include('authentication.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Contest</title>
</head>
<body>

<?php include('header2.php'); ?>

<div class="container mt-5">
    <h2 class="text-center">Add New Contest</h2>
    <form action="contest_add_process.php" method="POST">
        <div class="form-group">
            <label for="contest_name">Contest Name</label>
            <input type="text" class="form-control" id="contest_name" name="contest_name" required>
        </div>
        <div class="form-group">
            <label for="date">Contest Date</label>
            <input type="date" class="form-control" id="date" name="date" required>
        </div>
        <div class="form-group">
            <label for="start_time">Start Time</label>
            <input type="time" class="form-control" id="start_time" name="start_time" required>
        </div>
        <div class="form-group">
            <label for="end_time">End Time</label>
            <input type="time" class="form-control" id="end_time" name="end_time" required>
        </div>
        <div class="form-group">
            <label for="link">Contest Link</label>
            <input type="url" class="form-control" id="link" name="link" placeholder="https://dsscodingcontest.com" required>
        </div>

        <div class="d-flex justify-content-center mt-3 mb-3">
        <button type="submit" name="submit" class="btn btn-primary">Add Contest</button>
          </div>
    </form>
</div>

<?php include('footer.php'); ?>

</body>
</html>
