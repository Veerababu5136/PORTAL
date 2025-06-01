<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify OTP</title>
    
    <link rel="stylesheet" href="style.css">

    <!-- Bootstrap 5.3 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php include 'header.php'; ?>

<br><br><br><br><br><br><br>

<!-- Main Content -->
<div class="container">
    <div class="row justify-content-center">
        <!-- OTP Verification Card -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Verify OTP</h5>
                    <form action="verify_otp_process.php" method="POST">
                        <!-- OTP Input -->
                        <div class="form-group mb-3">
                            <label for="otp">OTP</label>
                            <input type="text" class="form-control" id="otp" name="otp" placeholder="Enter the OTP sent to your email" required>
                        </div>
                        
                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-primary w-100">Verify OTP</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
    include('footer.php');
?>
    
</body>
</html>
