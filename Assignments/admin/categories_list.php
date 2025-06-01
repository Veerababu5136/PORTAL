<?php
include('connection.php');
include('authentication.php');

// Fetch data from the categories table
$query = "SELECT * FROM categories ORDER BY id ASC";
$query_runner = mysqli_query($connection, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link rel="stylesheet" href="style.css"/>
     <title>Categories</title>
</head>
<body>
     <?php include('header2.php'); ?>

     <div class="container mt-5">
          <h1 class='text-center'>Category List</h1>
          <div class="d-flex justify-content-center mt-3 mb-3">
              <a href="category_add.php" class="btn btn-primary">Add Category</a>
          </div>

          <div class="table-responsive">
              <table class="table table-striped table-bordered">
                  <thead class="table-dark">
                      <tr>
                          <th scope="col">S.No</th>
                          <th scope="col">Category Name</th>
                          <th scope="col">Edit</th>
                          <th scope="col">Delete</th>
                      </tr>
                  </thead>
                  <tbody>
                      <?php
                      if (mysqli_num_rows($query_runner) > 0) {
                          $sno = 1;
                          while ($row = mysqli_fetch_assoc($query_runner)) {
                              echo "<tr>
                                      <td data-label='S.No'>{$sno}</td>
                                      <td data-label='Category Name'>{$row['category_name']}</td>
                                      <td data-label='Edit'><a href='edit_category.php?id={$row['id']}' class='btn btn-secondary btn-sm'>Edit</a></td>
                                      <td data-label='Delete'><a href='delete_category.php?id={$row['id']}' class='btn btn-danger btn-sm'>Delete</a></td>
                                    </tr>";
                              $sno++;
                          }
                      } else {
                          echo "<tr><td colspan='4' class='text-center'>No Categories Found</td></tr>";
                      }
                      ?>
                  </tbody>
              </table>
          </div>
     </div>

     <?php include('footer.php'); ?>

</body>
</html>
