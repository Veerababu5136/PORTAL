<?php
include('connection.php');
include('authentication.php');

// Fetch data from the schedule table
$query = "SELECT * FROM schedule ORDER BY id ASC";  // Replace 'schedule' with your actual table name
$query_runner = mysqli_query($connection, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link rel="stylesheet" href="style.css"/>
     <title>Schedule List</title>
</head>
<body>
     <?php include('header2.php'); ?>

     <div class="container mt-5">
          <h3 class='text-center mb-5'>Schedule List</h3>
          <div class="table-responsive">
              <table class="table table-striped table-bordered">
                  <thead class="table-dark">
                      <tr>
                          <th scope="col">S.No</th>
                          <th scope="col">Schedule Date</th>
                          <th scope="col">Morning Schedule</th>
                          <th scope="col">Evening Schedule</th>
                       
                      </tr>
                  </thead>
                  <tbody>
                      <?php
                      if (mysqli_num_rows($query_runner) > 0) {
                          $sno = 1;
                          while ($row = mysqli_fetch_assoc($query_runner)) {
                              echo "<tr>
                                      <td data-label='S.No'>{$sno}</td>
                                      <td data-label='Date'>{$row['schedule_date']}</td>
                                      <td data-label='Morning'>{$row['schedule_morning']}</td>
                                      <td data-label='Evening'>{$row['schedule_evening']}</td>
                                     
                                    </tr>";
                              $sno++;
                          }
                      } else {
                          echo "<tr><td colspan='5' class='text-center'>No Schedules Found</td></tr>";
                      }
                      ?>
                  </tbody>
              </table>
          </div>
     </div>

     <?php include('footer.php'); ?>

</body>
</html>
