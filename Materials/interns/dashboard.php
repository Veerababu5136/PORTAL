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
          <h3 class='text-center mb-5'>Category List</h3>
         

          <div class="table-responsive">
              <table class="table table-striped table-bordered">
                  <thead class="table-dark">
                      <tr>
                          <th scope="col">S.No</th>
                          <th scope="col">Category Name</th>
                          <th scope="col">Action</th>                        
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
                                      <td data-label='Explore'><a href='materials.php?id={$row['id']}' class='btn btn-warning btn-sm'>Explore</a></td>
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
