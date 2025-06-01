<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coding Admin Page</title>
   
</head>
<body>
    <!-- Include header -->
    <?php include('header.php') ?>

   

    <br><br><br><br><br><br>

   <!-- Main Content -->
<div class="container">
    <div class="row justify-content-center">
        <!-- Login Card -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Login</h5>
                    <form action="login.php" method="POST">
                        <!-- Email Input -->
                        <div class="form-group mb-3">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
                        </div>

                        
                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-primary w-100">Login</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div><br><br><br><br><br><br><br>



    <!-- Include footer -->
    <?php include('footer.php') ?>

</body>
</html>
