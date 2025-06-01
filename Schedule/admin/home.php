<?php
include('connection.php');
include('authentication.php');

// Fetch data from the schedule table
$query = "
    SELECT * FROM schedule ORDER BY id ASC
";
$query_runner = mysqli_query($connection, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link rel="stylesheet" href="style.css"/>
     <title>Schedule</title>
</head>
<body>
     <?php include('header2.php'); ?>

     <div class="container mt-5">
          <h1 class='text-center'>Schedule List</h1>
          <div class="d-flex justify-content-center mt-3 mb-3">
              <a href="add_schedule.php" class="btn btn-primary">Add Schedule</a>
          </div>

          <div class="table-responsive">
              <table class="table table-striped table-bordered">
                  <thead class="table-dark">
                      <tr>
                          <th scope="col">S.No</th>
                          <th scope="col">Schedule Date</th>
                          <th scope="col">Morning Schedule</th>
                          <th scope="col">Evening Schedule</th>
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
                                      <td data-label='Schedule Date'>{$row['schedule_date']}</td>
                                      <td data-label='Morning Schedule'>{$row['schedule_morning']}</td>
                                      <td data-label='Evening Schedule'>{$row['schedule_evening']}</td>
                                      <td data-label='Edit'><a href='edit_schedule.php?id={$row['id']}' class='btn btn-secondary btn-sm'>Edit</a></td>
                                      <td data-label='Delete'><a href='delete_schedule.php?id={$row['id']}' class='btn btn-danger btn-sm'>Delete</a></td>
                                    </tr>";
                              $sno++;
                          }
                      } else {
                          echo "<tr><td colspan='6' class='text-center'>No Schedule Found</td></tr>";
                      }
                      ?>
                  </tbody>
              </table>
          </div>
     </div>

     <?php include('footer.php'); ?>

</body>
</html>
