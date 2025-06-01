<!DOCTYPE html>
<html lang="en">
<head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Intern</title>
</head>
<body>
     <?php include('header.php') ?>

     <div class="container mt-5">
        <h2 class="text-center mb-4">Intern Login</h2>

        <!-- Login Form -->
        <form action="process_login.php" method="POST">
            <div class="mb-3">
                <label for="intern_id" class="form-label">DSS Intern ID</label>
                <input type="text" class="form-control" id="intern_id" name="intern_id" placeholder="Enter your DSS Intern ID" required>
            </div>
            
            <div class="d-grid">
                <button type="submit" class="btn btn-primary">Login</button>
            </div>
        </form>
    </div><br><br><br><br><br><br><br><br><br><br><br><br><br>

     <?php include('footer.php') ?>



</body>
</html>