<?php
include('connection.php'); // Include the connection file

// Sanitize inputs
$date = mysqli_real_escape_string($connection, $_GET['date']);
$batch = mysqli_real_escape_string($connection, $_GET['batch']);

// Fetch today's data
$query_today = "SELECT * FROM daily_problem_stats WHERE date = '$date'";
$query_runner_today = mysqli_query($connection, $query_today);

if (!$query_runner_today) {
    die("Query Failed: " . mysqli_error($connection));
}

// Fetch previous day's data
$previous_date = date('Y-m-d', strtotime($date . ' -1 day'));
$query_previous = "SELECT * FROM daily_problem_stats WHERE date = '$previous_date'";
$query_runner_previous = mysqli_query($connection, $query_previous);

if (!$query_runner_previous) {
    die("Query Failed: " . mysqli_error($connection));
}

$indicator = mysqli_num_rows($query_runner_previous) > 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Interns & GFG Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
</head>
<body>
    <?php include('header.php'); ?>

    <div class="container mt-5">
        <h2 class="text-center">Interns Details for Batch <?php echo htmlspecialchars($batch); ?> on <?php echo htmlspecialchars($date); ?></h2>

        <!-- Display Today's Data -->
        <h4>Today's Data</h4>
        <?php if (mysqli_num_rows($query_runner_today) > 0): ?>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Batch</th>
                        <th>Score</th>
                        <th>Problems Solved</th>
                        <th>School</th>
                        <th>Basic</th>
                        <th>Easy</th>
                        <th>Medium</th>
                        <th>Hard</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row_today = mysqli_fetch_assoc($query_runner_today)): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row_today['geeks_name']); ?></td>
                            <td><?php echo htmlspecialchars($row_today['batch_no']); ?></td>
                            <td>
                                <?php 
                                if ($indicator && $row_pre = mysqli_fetch_assoc($query_runner_previous)) {
                                    echo htmlspecialchars($row_today['score'] - $row_pre['score']);
                                } else {
                                    echo htmlspecialchars($row_today['score']);
                                }
                                ?>
                            </td>
                            <td><?php echo htmlspecialchars($row_today['problems_solved']); ?></td>
                            <td><?php echo htmlspecialchars($row_today['school']); ?></td>
                            <td><?php echo htmlspecialchars($row_today['basic']); ?></td>
                            <td><?php echo htmlspecialchars($row_today['easy']); ?></td>
                            <td><?php echo htmlspecialchars($row_today['medium']); ?></td>
                            <td><?php echo htmlspecialchars($row_today['hard']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No data available for <?php echo htmlspecialchars($date); ?>.</p>
        <?php endif; ?>
    </div>

    <?php include('footer.php'); ?>
</body>
</html>
