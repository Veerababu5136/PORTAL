<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DSS Home Page</title>
    <!-- Include Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <!-- Include header -->
    <?php include('header.php') ?>

    <div class="container mt-5">
        <!-- Main heading -->
        <h1 class="text-center mb-5">DSS System</h1>

        <!-- Section for services -->
        <h2 class="text-center mb-4">Our Services</h2>
        
        <!-- Services as Cards -->
        <div class="row row-cols-1 row-cols-md-3 g-4">
            <!-- Card 1 -->
            <div class="col">
                <div class="card h-100 text-center">
                    <div class="card-body">
                        <h5 class="card-title">Attendance</h5>
                        <p class="card-text">Manage and track your attendance easily.</p>
                        <a href="login.php" class="btn btn-primary">Go to Attendance</a>
                    </div>
                </div>
            </div>
            
            <!-- Card 2 -->
            <div class="col">
                <div class="card h-100 text-center">
                    <div class="card-body">
                        <h5 class="card-title">MCQ Quiz</h5>
                        <p class="card-text">Take multiple choice quizzes to test your knowledge.</p>
                        <a href="/demyProjectQuiz/interns/index.php" class="btn btn-primary">Go to MCQ Quiz</a>
                    </div>
                </div>
            </div>
            
            <!-- Card 3 -->
            <div class="col">
                <div class="card h-100 text-center">
                    <div class="card-body">
                        <h5 class="card-title">Coding Test</h5>
                        <p class="card-text">Participate in coding challenges and improve your skills.</p>
                        <a href="service_developing.php" class="btn btn-primary">Go to Coding Test</a>
                    </div>
                </div>
            </div>

            <!-- Card 4 -->
            <div class="col">
                <div class="card h-100 text-center">
                    <div class="card-body">
                        <h5 class="card-title">Assignments</h5>
                        <p class="card-text">Submit and review your assignments.</p>
                        <a href="service_developing.php" class="btn btn-primary">Go to Assignments</a>
                    </div>
                </div>
            </div>
            
            <!-- Card 5 -->
            <div class="col">
                <div class="card h-100 text-center">
                    <div class="card-body">
                        <h5 class="card-title">Schedule</h5>
                        <p class="card-text">Check your schedule for upcoming events and deadlines.</p>
                        <a href="service_developing.php" class="btn btn-primary">Go to Schedule</a>
                    </div>
                </div>
            </div>

            <!-- Card 6 -->
            <div class="col">
                <div class="card h-100 text-center">
                    <div class="card-body">
                        <h5 class="card-title">Other Services</h5>
                        <p class="card-text">Explore more services offered by DSS.</p>
                        <a href="service_developing.php" class="btn btn-primary">Explore More</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Include footer -->
    <?php include('footer.php') ?>

    <!-- Include Bootstrap JS (Optional for interactivity like dropdowns, modals) -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
