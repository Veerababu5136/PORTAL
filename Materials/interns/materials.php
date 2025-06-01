<?php
include('connection.php');
include('authentication.php');

// Check if category ID is passed in the URL
if (isset($_GET['id'])) {
    $category_id = mysqli_real_escape_string($connection, $_GET['id']);

    // Fetch materials for the selected category
    $query = "SELECT * FROM materials WHERE category_id='$category_id' ORDER BY id ASC";
    $query_runner = mysqli_query($connection, $query);
} else {
    $_SESSION['error'] = "No category ID provided.";
    header('Location: categories.php');
    exit(0);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link rel="stylesheet" href="style.css"/>
     <title>Materials</title>
</head>
<body>
     <?php include('header2.php'); ?>

     <div class="container mt-5">
          <h1 class='text-center'>Materials</h1>
         

          <div class="table-responsive">
              <table class="table table-striped table-bordered">
                  <thead class="table-dark">
                      <tr>
                          <th scope="col">S.No</th>
                          <th scope="col">Material Name</th>
                          <th scope="col">Link</th>                        
                      </tr>
                  </thead>
                  <tbody>
                      <?php
                      if (mysqli_num_rows($query_runner) > 0) {
                          $sno = 1;
                          while ($row = mysqli_fetch_assoc($query_runner)) {
                              echo "<tr>
                                      <td data-label='S.No'>{$sno}</td>
                                      <td data-label='Material Name'>{$row['material_name']}</td>
                                      <td data-label='Link'><a href='{$row['link']}' target='_blank' class='btn btn-primary btn-sm'>View Material</a></td>
                                    </tr>";
                              $sno++;
                          }
                      } else {
                          echo "<tr><td colspan='3' class='text-center'>No Materials Found for this Category</td></tr>";
                      }
                      ?>
                  </tbody>
              </table>
          </div>
     </div>

     <?php include('footer.php'); ?>

</body>
</html>
