<?php
include('connection.php');
include('authentication.php');

// Initialize error and success messages
$error_message = '';
$success_message = '';

// Check if category id is passed via GET request
if (isset($_GET['id'])) {
    $category_id = mysqli_real_escape_string($connection, $_GET['id']);

    // Fetch the current category data from the database
    $query = "SELECT * FROM categories WHERE id = '$category_id'";
    $query_runner = mysqli_query($connection, $query);

    if (mysqli_num_rows($query_runner) > 0) {
        $category = mysqli_fetch_assoc($query_runner);
    } else {
        header("Location: categories_list.php?message=Category not found");
        exit(0);
    }
} else {
    header("Location: categories_list.php?message=Invalid request");
    exit(0);
}

// Handle form submission to update category
if (isset($_POST['update_category'])) {
    $category_name = mysqli_real_escape_string($connection, $_POST['category_name']);

    // Check if category name is empty
    if (empty($category_name)) {
        $error_message = "Category name is required.";
    } else {
        // Update category in the database
        $update_query = "UPDATE categories SET category_name = '$category_name' WHERE id = '$category_id'";
        $update_runner = mysqli_query($connection, $update_query);

        if ($update_runner) {
            $success_message = "Category updated successfully!";
            // Redirect to categories page
            header("Location: categories_list.php?message=Category updated successfully");
            exit(0);
        } else {
            $error_message = "Failed to update category.";
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
     <title>Edit Category</title>
</head>
<body>
     <?php include('header2.php'); ?>

     <div class="container mt-5">
          <h1 class="text-center">Edit Category</h1>

          <div class="d-flex justify-content-center mt-3 mb-3">
              <a href="categories.php" class="btn btn-secondary">Back to Categories</a>
          </div>

          <!-- Display Success or Error Messages -->
          <?php if (!empty($error_message)): ?>
              <div class="alert alert-danger"><?php echo $error_message; ?></div>
          <?php elseif (!empty($success_message)): ?>
              <div class="alert alert-success"><?php echo $success_message; ?></div>
          <?php endif; ?>

          <!-- Category Edit Form -->
          <form action="edit_category.php?id=<?php echo $category_id; ?>" method="POST">
              <div class="mb-3">
                  <label for="category_name" class="form-label">Category Name</label>
                  <input type="text" name="category_name" class="form-control" id="category_name" value="<?php echo $category['category_name']; ?>" required>
              </div>
              <div class="d-flex justify-content-center">
                  <button type="submit" name="update_category" class="btn btn-primary">Update Category</button>
              </div>
          </form>
     </div>

     <?php include('footer.php'); ?>
</body>
</html>
