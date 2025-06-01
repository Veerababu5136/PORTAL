<?php
include('connection.php');
include('authentication.php');

// Set your local time zone (e.g., 'Asia/Kolkata' for IST which is UTC+5:30)
date_default_timezone_set('Asia/Kolkata');

// Get the current date and time
$current_date_time = date('Y-m-d H:i:s');

// Check if category_id is set in the URL
if (isset($_GET['category_id'])) {
    $category_id = intval($_GET['category_id']);

    // Fetch assignments for the specific category
    $query = "SELECT * FROM assignments WHERE category_id = $category_id ORDER BY post_date ASC";
    $query_runner = mysqli_query($connection, $query);
} else {
    // Redirect or show an error if category_id is not set
    header("Location: categories.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css"/>
    <title>Assignments</title>
    <!-- Bootstrap CSS for styling -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include('header2.php'); ?>

    <div class="container mt-5">
        <h3 class='text-center mb-5'>Assignments</h3>

        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">S.No</th>
                        <th scope="col">Assignment Name</th>
                        <th scope="col">Assignment Link</th>
                        <th scope="col">Post Date</th>
                        <th scope="col">End Date</th>
                        <th scope="col">Action</th> <!-- New Column for Action -->
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (mysqli_num_rows($query_runner) > 0) {
                        $sno = 1;
                        while ($row = mysqli_fetch_assoc($query_runner)) {
                            // Get assignment data
                            $assignment_id = $row['id'];
                            $assignment_name = $row['assignment_name'];

                            $assignment_link = $row['assignment_question_link'];
                            $post_date = $row['post_date'];
                            $end_date = $row['end_date'] . ' 23:59:59';  // Append time to end date

                            // Convert both dates into DateTime objects for accurate comparison
                            $current_date_time_obj = new DateTime($current_date_time);
                            $end_date_time_obj = new DateTime($end_date);

                            // Debugging: Check the current and end date formats
                            //echo "Current Date: $current_date_time <br>";
                            //echo "End Date: $end_date <br>";

                            // Determine status based on current time

                          

                            if ($current_date_time_obj < $end_date_time_obj) {
                                $status = 'Active';
                                $status_class = 'btn-success';
                                $button_text = 'Submit Assignment';
                                $disabled = '';  // Button enabled
                            } else {
                                $status = 'Ended';
                                $status_class = 'btn-danger';
                                $button_text = 'Ended';
                                $disabled = 'disabled';  // Button disabled
                            }
                            ?>
                            <tr>
                                <td  data-label='S.No'><?php echo $sno++; ?></td>
                                <td  data-label='Name'><?php echo $assignment_name; ?></td>

                                <td  data-label='View'><a href="<?php echo $assignment_link; ?>" target="_blank" class="btn btn-primary">View Assignment</a></td>
                                <td  data-label='post date'><?php echo $post_date; ?></td>
                                <td  data-label='end date'><?php echo $end_date_time_obj->format('Y-m-d'); ?></td>
                                <td>
                                    <form action="submit_assignments.php" method="POST" style="display:inline;">
                                        <input type="hidden" name="assignment_id" value="<?php echo $assignment_id; ?>">
                                        <input type="hidden" name="category_id" value="<?php echo $category_id; ?>">
                                        <button type="submit" class="btn <?php echo $status_class; ?> btn-sm" <?php echo $disabled; ?>>
                                            <?php echo $button_text; ?>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php
                        }
                    } else {
                        echo "<tr><td colspan='5' class='text-center'>No Assignments Found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <?php include('footer.php'); ?>
</body>
</html>
