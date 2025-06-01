<?php
include('connection.php');

//echo $_SESSION['v_email'];

$query = "SELECT count(*) AS total_batches FROM batches";

// Execute the query
$query_runner = mysqli_query($connection, $query);

// Fetch the result as an associative array
$row = mysqli_fetch_assoc($query_runner);

// Access the count value
$batches = $row['total_batches'];



$query = "SELECT count(*) AS total_interns FROM interns";

// Execute the query
$query_runner = mysqli_query($connection, $query);

// Fetch the result as an associative array
$row = mysqli_fetch_assoc($query_runner);

// Access the count value
$interns = $row['total_interns'];




$query = "SELECT count(distinct(date)) AS total_days FROM attendance";

// Execute the query
$query_runner = mysqli_query($connection, $query);

// Fetch the result as an associative array
$row = mysqli_fetch_assoc($query_runner);

// Access the count value
$days = $row['total_days'];


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance Landing Page</title>
   
</head>
<body>

<?php
include('header.php');
?>
   
    <!-- Main Content -->
    <div class="container">
        <div class="row">
            <!-- Card 1: Registered -->
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Registered</h5>
                        <p class="card-text"><?php echo $interns; ?></p>
                        <a href="#" class="btn btn-primary">Go to Registered</a>
                    </div>
                </div>
            </div>

            <!-- Card 2: Batches -->
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Batches</h5>
                        <p class="card-text"><?php echo $batches; ?></p>
                        <a href="#" class="btn btn-primary">Go to Batches</a>
                    </div>
                </div>
            </div>

            <!-- Card 3: Days -->
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Days</h5>
                        <p class="card-text"><?php echo $days; ?></p>
                        <a href="track_sheet.php" class="btn btn-primary">Go to Days</a>
                    </div>
                </div>
            </div>
        </div>
    </div><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>

   
    <?php

    include('footer.php');
    ?>
    
</body>
</html>
