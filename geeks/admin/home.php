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
        <h2 class="text-center mb-4">Interns and GFG User Details</h2>

        <div class="row">
            <!-- Four cards -->
            <?php for ($i = 1; $i <= 4; $i++): ?>
                <div class="col-md-3">
                    <div class="card text-center">
                        <div class="card-body">
                            <h5 class="card-title">Batch <?= $i ?></h5>
                            <button class="btn btn-primary load-data-btn" data-batch="<?= $i ?>">Load Batch <?= $i ?></button>
                            <a href="load.php?batch=<?php echo $i; ?>" class="btn btn-primary">Load</a>
                        </div>
                    </div>
                </div>
            <?php endfor; ?>
        </div>

        <div class="mt-5 text-center">
            <!-- Loading spinner -->
            <div id="loading-spinner" class="d-none">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        </div>

        <div class="mt-5">
            <h4 class="text-center">Interns Data</h4>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Intern Name</th>
                        <th>Batch</th>
                        <th>GFG Name</th>
                        <th>GFG Score</th>
                        <th>Total Problems Solved</th>
                        <th>School</th>
                        <th>Basic</th>
                        <th>Easy</th>
                        <th>Medium</th>
                        <th>Hard</th>
                    </tr>
                </thead>
                <tbody id="interns-data">
                    <!-- Data will be loaded here -->
                </tbody>
            </table>
        </div>
    </div>

    <?php include('footer.php'); ?>

    <script>
        $(document).ready(function () {
            $('.load-data-btn').on('click', function () {
                const batch = $(this).data('batch');
                
                // Show loading spinner
                $('#loading-spinner').removeClass('d-none');
                
                $.ajax({
                    url: `fetch_data.php`, // File to handle data fetching
                    method: 'POST',
                    data: { batch: batch },
                    success: function (response) {
                        // Hide loading spinner
                        $('#loading-spinner').addClass('d-none');
                        
                        // Update table with response data
                        $('#interns-data').html(response);
                    },
                    error: function () {
                        // Hide loading spinner
                        $('#loading-spinner').addClass('d-none');
                        
                        alert('Failed to load data.');
                    }
                });
            });
        });
    </script>
</body>
</html>
