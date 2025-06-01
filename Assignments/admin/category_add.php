<?php
include('connection.php');
include('authentication.php');

// Initialize error and success messages
$error_message = '';
$success_message = '';

// Handle form submission
if (isset($_POST['add_category'])) {
    $category_name = mysqli_real_escape_string($connection, $_POST['category_name']);

    // Check if category name is empty
    if (empty($category_name)) {
        $error_message = "Category name is required.";
    } else {
        // Insert category into the database
        $query = "INSERT INTO categories (category_name) VALUES ('$category_name')";
        $query_runner = mysqli_query($connection, $query);

        if ($query_runner) {
            $success_message = "Category added successfully!";
        } else {
            $error_message = "Failed to add category.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link rel="stylesheet" href="style.css"/>
     <title>Add Category</title>
</head>
<body>
     <?php include('header2.php'); ?>

     <div class="container mt-5">
          <h1 class="text-center">Add Category</h1>

          <div class="d-flex justify-content-center mt-3 mb-3">
              <a href="categories_list.php" class="btn btn-secondary">Back to Categories</a>
          </div>

          <!-- Display Success or Error Messages -->
          <?php if (!empty($error_message)): ?>
              <div class="alert alert-danger"><?php echo $error_message; ?></div>
          <?php elseif (!empty($success_message)): ?>
              <div class="alert alert-success"><?php echo $success_message; ?></div>
          <?php endif; ?>

          <!-- Category Add Form -->
          <form action="category_add.php" method="POST">
              <div class="mb-3">
                  <label for="category_name" class="form-label">Category Name</label>
                  <input type="text" name="category_name" class="form-control" id="category_name" required>
              </div>
              <div class="d-flex justify-content-center">
                  <button type="submit" name="add_category" class="btn btn-primary">Add Category</button>
              </div>
          </form>
     </div>

     <?php include('footer.php'); ?>

</body>
</html>
