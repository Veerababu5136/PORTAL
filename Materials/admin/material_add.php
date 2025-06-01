<?php
include('connection.php');
include('authentication.php');

// Initialize error and success messages
$error_message = '';
$success_message = '';

// Handle form submission for adding material
if (isset($_POST['add_material'])) {
    $material_name = mysqli_real_escape_string($connection, $_POST['material_name']);
    $category_id = mysqli_real_escape_string($connection, $_POST['category_id']);
    $material_link = mysqli_real_escape_string($connection, $_POST['material_link']);

    // Check if required fields are filled
    if (empty($material_name) || empty($category_id) || empty($material_link)) {
        $error_message = "All fields are required.";
    } else {
        // Insert material into the database
        $query = "INSERT INTO materials (material_name, category_id, link) VALUES ('$material_name', '$category_id', '$material_link')";
        $query_runner = mysqli_query($connection, $query);

        if ($query_runner) {
            $success_message = "Material added successfully!";
        } else {
            $error_message = "Failed to add material.";
        }
    }
}

// Fetch categories for the dropdown list
$category_query = "SELECT * FROM categories";
$category_runner = mysqli_query($connection, $category_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link rel="stylesheet" href="style.css"/>
     <title>Add Material</title>
</head>
<body>
     <?php include('header2.php'); ?>

     <div class="container mt-5">
          <h1 class="text-center">Add Material</h1>

          <div class="d-flex justify-content-center mt-3 mb-3">
              <a href="home.php" class="btn btn-secondary">Back to Materials</a>
          </div>

          <!-- Display Success or Error Messages -->
          <?php if (!empty($error_message)): ?>
              <div class="alert alert-danger"><?php echo $error_message; ?></div>
          <?php elseif (!empty($success_message)): ?>
              <div class="alert alert-success"><?php echo $success_message; ?></div>
          <?php endif; ?>

          <!-- Material Add Form -->
          <form action="material_add.php" method="POST">
              <div class="mb-3">
                  <label for="material_name" class="form-label">Material Name</label>
                  <input type="text" name="material_name" class="form-control" id="material_name" required>
              </div>

              <div class="mb-3">
                  <label for="category_id" class="form-label">Category</label>
                  <select name="category_id" class="form-control" id="category_id" required>
                      <option value="">Select Category</option>
                      <?php
                      // Populate the dropdown with categories from the database
                      if (mysqli_num_rows($category_runner) > 0) {
                          while ($category = mysqli_fetch_assoc($category_runner)) {
                              echo "<option value='{$category['id']}'>{$category['category_name']}</option>";
                          }
                      } else {
                          echo "<option value=''>No Categories Found</option>";
                      }
                      ?>
                  </select>
              </div>

              <div class="mb-3">
                  <label for="material_link" class="form-label">Material Link</label>
                  <input type="url" name="material_link" class="form-control" id="material_link" required>
              </div>

              <div class="d-flex justify-content-center">
                  <button type="submit" name="add_material" class="btn btn-primary">Add Material</button>
              </div>
          </form>
     </div>

     <?php include('footer.php'); ?>
</body>
</html>
