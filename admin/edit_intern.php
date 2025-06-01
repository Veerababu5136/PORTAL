<?php
include('connection.php');

$id = $_GET['id']; // Get the intern ID from the URL

$query = "SELECT * FROM interns WHERE id='$id'";
$query_runner = mysqli_query($connection, $query);

while ($row = mysqli_fetch_assoc($query_runner)) {
    $dss_intern_id = $row['dss_id'];
    $name = $row['name'];
    $batch_no = $row['batch_no'];
        $email = $row['email'];
    $password = $row['password'];

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Intern</title>
</head>
<body>
<?php include('header.php'); ?>

<div class="container mt-5">
    <h2 class="text-center mb-4">Update Intern</h2>
    
    <!-- Corrected form action with dynamic ID -->
    <form action="process_intern_edit.php?id=<?php echo $id; ?>" method="POST">
        <div class="mb-3">
            <label for="dss_intern_id" class="form-label">DSS Intern ID</label>
            <input type="text" class="form-control" id="dss_intern_id" name="dss_id" value="<?php echo $dss_intern_id; ?>" required>
        </div>
        
        <div class="mb-3">
            <label for="intern_name" class="form-label">Intern Name</label>
            <input type="text" class="form-control" id="intern_name" name="name" value="<?php echo $name; ?>" required>
        </div>
        
         <div class="mb-3">
            <label for="intern_name" class="form-label">Intern Email</label>
            <input type="text" class="form-control" id="intern_name" name="email" value="<?php echo $email; ?>" required>
        </div>
        
         <div class="mb-3">
            <label for="intern_name" class="form-label">Intern Password</label>
            <input type="text" class="form-control" id="intern_name" name="password" value="<?php echo $password; ?>" required>
        </div>
        
        <div class="mb-3">
            <label for="batch_id" class="form-label">Batch Name</label>
            <select class="form-select" id="batch_id" name="batch_no" required>
                <option value="" selected><?php echo $batch_no; ?></option>
                <?php
                // Fetch batch names from the database
                $query = "SELECT id, batch_name FROM batches";
                $result = mysqli_query($connection, $query);
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<option value='{$row['id']}'>{$row['batch_name']}</option>";
                }
                ?>
            </select>
        </div>
        
        <div class="d-grid">
            <button type="submit" class="btn btn-primary">Update Intern</button>
        </div>
    </form>
</div><br><br><br><br><br><br><br><br><br><br><br><br><br>

<?php include('footer.php'); ?>
</body>
</html>
