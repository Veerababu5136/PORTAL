<?php
include('connection.php');
include('authentication.php');

// Fetch data from the assignments and categories tables
$query = "
 SELECT 
    a.id AS assignment_id, 
    a.assignment_question_link, 
    a.post_date, 
    a.end_date,
    a.assignment_name,  
    a.updated_date, 
    c.category_name, 
    c.id AS category_id
FROM 
    assignments a
JOIN 
    categories c ON a.category_id = c.id
ORDER BY 
    a.id ASC;

";
$query_runner = mysqli_query($connection, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link rel="stylesheet" href="style.css"/>
     <title>Assignments</title>
</head>
<body>
     <?php include('header2.php'); ?>

     <div class="container mt-5">
          <h1 class='text-center'>Assignment List</h1>
          <div class="d-flex justify-content-center mt-3 mb-3">
              <a href="add_assignment.php" class="btn btn-primary">Add Assignment</a>
          </div>

          <div class="table-responsive">
              <table class="table table-striped table-bordered">
                  <thead class="table-dark">
                      <tr>
                          <th scope="col">S.No</th>
                          <th scope="col">Category Name</th>
                          <th scope="col">Assignment Name</th>
                          <th scope="col">Assignment Link</th>
                          <th scope="col">Post Date</th>
                          <th scope="col">End Date</th>
                          <th scope="col">Updated Date</th>
                          <th scope="col">Edit</th>
                          <th scope="col">Delete</th>
                          <th scope="col">Submissions</th>

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
                                                        <td data-label='Assignment Name'>{$row['assignment_name']}</td>

                            <td data-label='Assignment Link'><a href='{$row['assignment_question_link']}' class='btn btn-success btn-sm' target='_blank'>Go to Assignment</a></td>
                            <td data-label='Post Date'>{$row['post_date']}</td>
                            <td data-label='End Date'>{$row['end_date']}</td>
                            <td data-label='Updated Date'>{$row['updated_date']}</td>
                            <td data-label='Edit'><a href='edit_assignment.php?id={$row['assignment_id']}' class='btn btn-secondary btn-sm'>Edit</a></td>
                            <td data-label='Delete'><a href='delete_assignment.php?id={$row['assignment_id']}' class='btn btn-danger btn-sm'>Delete</a></td>
                            <td data-label='Submissions'>
                                <a href='view_submissions.php?category_id={$row['category_id']}&assignment_id={$row['assignment_id']}' class='btn btn-primary btn-sm'>Submissions</a>
                            </td>
                        </tr>";
                    
                              $sno++;
                          }
                      } else {
                          echo "<tr><td colspan='8' class='text-center'>No Assignments Found</td></tr>";
                      }
                      ?>
                  </tbody>
              </table>
          </div>
     </div>

     <?php include('footer.php'); ?>

</body>
</html>
