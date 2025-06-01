<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DSS Admin Page</title>
    <!-- Include Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body>
    <!-- Include header -->

<!-- Header as a Navbar with Responsive Menu Icon -->
<header class="bg-primary text-white p-3 mb-4">
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">DSS</a>
        </div>
    </nav>
</header>

    <div class="container mt-5">
        <!-- Main heading -->
        <h1 class="text-center mb-5">DSS Admin Dashboard</h1>

        <!-- Section for services -->
        <h2 class="text-center mb-4">Admin Controls</h2>
        
        <!-- Admin Controls as Cards -->
        <div class="row row-cols-1 row-cols-md-3 g-4">
            <!-- Card 1 -->
            <div class="col">
                <div class="card h-100 text-center">
                    <div class="card-body">
                        <h5 class="card-title">Manage Attendance</h5>
                        <p class="card-text">Monitor and update attendance records for all users.</p>
                        <a href="admin_login.php" class="btn btn-primary">Go to Manage Attendance</a>
                    </div>
                </div>
            </div>
            
            <!-- Card 2 -->
            <div class="col">
                <div class="card h-100 text-center">
                    <div class="card-body">
                        <h5 class="card-title">Manage MCQ Quiz</h5>
                        <p class="card-text">Create, edit, or delete MCQ quizzes and view results.</p>
                        <a href="../demyProjectQuiz/quizadmin/index.php" class="btn btn-primary">Go to Manage MCQ Quiz</a>
                    </div>
                </div>
            </div>
            
            <!-- Card 3 -->
            <div class="col">
                <div class="card h-100 text-center">
                    <div class="card-body">
                        <h5 class="card-title">Manage Coding Tests</h5>
                        <p class="card-text">Set up coding tests, view submissions, and grade them.</p>
                        <a href="../CodingConsole/admin/index.php" class="btn btn-primary">Go to Manage Coding Tests</a>
                    </div>
                </div>
            </div>

            <!-- Card 4 -->
           <!-- Card for Materials -->
<div class="col">
    <div class="card h-100 text-center">
        <div class="card-body">
            <h5 class="card-title">Materials</h5>
            <p class="card-text">Discover the variety of materials available for your projects.</p>
            <a href="../Materials/admin/index.php" class="btn btn-primary">Explore Materials</a>
        </div>
    </div>
</div>

            
            <!-- Card 5 -->
            <div class="col">
                <div class="card h-100 text-center">
                    <div class="card-body">
                        <h5 class="card-title">View Schedules</h5>
                        <p class="card-text">Create or modify schedules and check event deadlines.</p>
                        <a href="../Schedule/admin/index.php" class="btn btn-primary">Go to View Schedules</a>
                    </div>
                </div>
            </div>

           <!-- Card 6 -->
<div class="col">
    <div class="card h-100 text-center">
        <div class="card-body">
            <h5 class="card-title">Manage Assignments</h5>
            <p class="card-text">Oversee and manage assignments for students, track submissions, and provide feedback.</p>
            <a href="../Assignments/admin/index.php" class="btn btn-primary">Go to Manage Assignments</a>
        </div>
    </div>
</div>

   <div class="col">
                <div class="card h-100 text-center">
                    <div class="card-body">
                        <h5 class="card-title">Manage Geeks</h5>
                        <p class="card-text">Monitor Geeks records for all users.</p>
                        <a href="../geeks/admin/index.php" class="btn btn-primary">Go to Manage Geeks</a>
                    </div>
                </div>
            </div>
            

        </div>
    </div>

    <!-- Include footer -->
    <?php include('footer.php') ?>

<!-- Bootstrap 5.3 JS and Popper.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
