<?php
include('connection.php');
?>
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
    <h2 class="text-center mb-4">Add New Intern</h2>
    
    <form action="process_intern_add.php" method="POST">
        <div class="mb-3">
            <label for="dss_intern_id" class="form-label">DSS Intern ID</label>
            <input type="text" class="form-control" id="dss_intern_id" name="dss_id" required>
        </div>
        
        <div class="mb-3">
            <label for="intern_name" class="form-label">Intern Name</label>
            <input type="text" class="form-control" id="intern_name" name="name" required>
        </div>
        
        <div class="mb-3">
            <label for="intern_name" class="form-label">Intern Email</label>
            <input type="text" class="form-control" id="intern_name" name="email" required>
        </div>
        <div class="mb-3">
            <label for="intern_name" class="form-label">Intern Password</label>
            <input type="text" class="form-control" id="intern_name" name="password" required>
        </div>
        
        
        <div class="mb-3">
            <label for="batch_id" class="form-label">Batch Name</label>
            <select class="form-select" id="batch_id" name="batch_no" required>
                <option value="">Select Batch</option>
                <?php
                // Fetch batch names from database
                
                $query = "SELECT id, batch_name FROM batches";
                $result = mysqli_query($connection, $query);
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<option value='{$row['id']}'>{$row['batch_name']}</option>";
                }
                ?>
            </select>
        </div>
        
        <div class="d-grid">
            <button type="submit" class="btn btn-primary">Add Intern</button>
        </div>
    </form>
</div><br><br><br><br><br><br><br><br><br><br><br><br><br>

<?php include('footer.php'); ?>


</body>
</html>