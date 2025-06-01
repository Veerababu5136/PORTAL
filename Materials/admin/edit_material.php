<?php
include('connection.php');
include('authentication.php');

// Check if material ID is passed in the URL
if (isset($_GET['id'])) {
    $material_id = mysqli_real_escape_string($connection, $_GET['id']);

    // Fetch the material data
    $query = "SELECT * FROM materials WHERE id='$material_id'";
    $query_runner = mysqli_query($connection, $query);

    if (mysqli_num_rows($query_runner) > 0) {
        $material = mysqli_fetch_assoc($query_runner);
    } else {
        $_SESSION['error'] = "Material not found.";
        header('Location: home.php');
        exit(0);
    }
}

// Handle form submission for editing the material
if (isset($_POST['update_material'])) {
    $material_name = mysqli_real_escape_string($connection, $_POST['material_name']);
    $category_id = mysqli_real_escape_string($connection, $_POST['category_id']);
    $material_link = mysqli_real_escape_string($connection, $_POST['material_link']);

    // Check if required fields are filled
    if (empty($material_name) || empty($category_id) || empty($material_link)) {
        $error_message = "All fields are required.";
    } else {
        // Update material in the database
        $query = "UPDATE materials SET material_name='$material_name', category_id='$category_id', link='$material_link' WHERE id='$material_id'";
        $query_runner = mysqli_query($connection, $query);

        if ($query_runner) {
            $_SESSION['success'] = "Material updated successfully!";
            header('Location: home.php');
            exit(0);
        } else {
            $error_message = "Failed to update material.";
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
     <title>Edit Material</title>
</head>
<body>
     <?php include('header2.php'); ?>

     <div class="container mt-5">
          <h1 class="text-center">Edit Material</h1>

          <div class="d-flex justify-content-center mt-3 mb-3">
              <a href="materials.php" class="btn btn-secondary">Back to Materials</a>
          </div>

          <!-- Display Error or Success Messages -->
          <?php if (!empty($error_message)): ?>
              <div class="alert alert-danger"><?php echo $error_message; ?></div>
          <?php elseif (!empty($success_message)): ?>
              <div class="alert alert-success"><?php echo $success_message; ?></div>
          <?php endif; ?>

          <!-- Material Edit Form -->
          <form action="edit_material.php?id=<?php echo $material_id; ?>" method="POST">
              <div class="mb-3">
                  <label for="material_name" class="form-label">Material Name</label>
                  <input type="text" name="material_name" class="form-control" id="material_name" value="<?php echo $material['material_name']; ?>" required>
              </div>

              <div class="mb-3">
                  <label for="category_id" class="form-label">Category</label>
                  <select name="category_id" class="form-control" id="category_id" required>
                      <option value="">Select Category</option>
                      <?php
                      // Populate the dropdown with categories from the database
                      if (mysqli_num_rows($category_runner) > 0) {
                          while ($category = mysqli_fetch_assoc($category_runner)) {
                              $selected = ($material['category_id'] == $category['id']) ? 'selected' : '';
                              echo "<option value='{$category['id']}' $selected>{$category['category_name']}</option>";
                          }
                      } else {
                          echo "<option value=''>No Categories Found</option>";
                      }
                      ?>
                  </select>
              </div>

              <div class="mb-3">
                  <label for="material_link" class="form-label">Material Link</label>
                  <input type="url" name="material_link" class="form-control" id="material_link" value="<?php echo $material['link']; ?>" required>
              </div>

              <div class="d-flex justify-content-center">
                  <button type="submit" name="update_material" class="btn btn-primary">Update Material</button>
              </div>
          </form>
     </div>

     <?php include('footer.php'); ?>
</body>
</html>
