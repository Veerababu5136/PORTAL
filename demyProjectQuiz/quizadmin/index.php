<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php include('header.php'); ?>

<div class="container mt-5">
    <div class="row">
        <!-- Card 1: Quizzes Conducted -->
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Quizzes Conducted</h5>
                    <?php
                    // Hardcoded value for demonstration
                    $totalQuizzes = 10; // Example number of quizzes conducted
                    ?>
                    <p class="card-text"><?php echo $totalQuizzes; ?></p>
                    <a href="view_quizzes.php" class="btn btn-primary">Go to Quizzes</a>
                </div>
            </div>
        </div>

        <!-- Card 2: Quiz Categories -->
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Quiz Categories</h5>
                    <?php
                    // Hardcoded value for demonstration
                    $totalCategories = 5; // Example number of quiz categories
                    ?>
                    <p class="card-text"><?php echo $totalCategories; ?></p>
                    <a href="view_categories.php" class="btn btn-primary">Go to Categories</a>
                </div>
            </div>
        </div>

        <!-- Card 3: Quiz Percentage -->
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Quiz Percentage</h5>
                    <?php
                    // Hardcoded value for demonstration
                    $averagePercentage = 85.75; // Example average quiz percentage
                    ?>
                    <p class="card-text"><?php echo number_format($averagePercentage, 2); ?>%</p>
                    <a href="view_results.php" class="btn btn-primary">Go to Results</a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include('footer.php'); ?>

</body>
</html>