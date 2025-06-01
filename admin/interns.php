<?php
include('connection.php');
require 'vendor/autoload.php'; // Include PhpSpreadsheet's autoload file

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

if (isset($_GET['download_excel'])) {
    // Turn off output buffering to avoid accidental whitespace
    ob_end_clean();

    // Create a new Spreadsheet object
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Set headers for Excel columns
    $sheet->setCellValue('A1', 'S.No')
          ->setCellValue('B1', 'DSS_Intern_ID')
          ->setCellValue('C1', 'Intern Name');

    // Query to fetch data
    $query = "SELECT dss_id, name FROM interns ORDER BY dss_id ASC";
    $query_runner = mysqli_query($connection, $query);

    // Populate Excel rows with data
    $row_num = 2; // Start from the second row
    $sno = 1;
    while ($row = mysqli_fetch_assoc($query_runner)) {
        $sheet->setCellValue('A' . $row_num, $sno)
              ->setCellValue('B' . $row_num, $row['dss_id'])
              ->setCellValue('C' . $row_num, $row['name']);
        $sno++;
        $row_num++;
    }

    // Set headers for file download
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="Interns_Data.xlsx"');
    header('Cache-Control: max-age=0');
    header('Expires: 0');
    header('Pragma: public');

    // Write file to output
    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Interns</title>

     <style>
          /* Make the table responsive */
          .table-responsive {
              overflow-x: auto;
          }

          @media (max-width: 767.98px) {
              .table thead {
                  display: none; /* Hide table header */
              }
              .table, .table tbody, .table tr, .table td {
                  display: block; /* Make everything block-level */
                  width: 100%; /* Full width */
              }
              .table tr {
                  margin-bottom: 1rem;
                  border: 1px solid #dee2e6;
                  border-radius: 0.5rem;
                  padding: 1rem;
              }
              .table td {
                  display: flex;
                  justify-content: space-between;
                  align-items: center;
                  padding: 0.5rem 1rem;
                  border: none;
                  border-bottom: 1px solid #dee2e6;
              }
              .table td:last-child {
                  border-bottom: none;
              }
              .table td::before {
                  content: attr(data-label);
                  font-weight: bold;
                  flex-basis: 50%;
                  text-align: left;
                  padding-right: 1rem;
                  color: #495057;
              }
          }
     </style>
</head>
<body>
     <?php include('header.php'); ?>

     <div class="container mt-5">
          <h1 class='text-center'>Interns Data</h1>
          <div class="d-flex justify-content-center mt-3 mb-3">
              <a href="intern_add.php" class="btn btn-primary">Add Intern</a>
              <a href="?download_excel=1" class="btn btn-success ml-3">Download Excel</a>
          </div>
          <div class="table-responsive">
              <table class="table table-striped table-bordered">
                  <thead class="table-dark">
                      <tr>
                          <th scope="col">S.No</th>
                          <th scope="col">DSS_Intern_ID</th>
                          <th scope="col">Intern Name</th>
                          <th scope="col">Batch Name</th>
                          <th scope="col">Edit</th>
                          <th scope="col">Delete</th>
                      </tr>
                  </thead>
                  <tbody>
                      <?php
                      $query = "SELECT * FROM interns ORDER BY dss_id ASC";
                      $query_runner = mysqli_query($connection, $query);

                      if (mysqli_num_rows($query_runner) > 0) {
                          $sno = 1;
                          while ($row = mysqli_fetch_assoc($query_runner)) {
                              echo "<tr>
                                      <td data-label='S.No'>{$sno}</td>
                                      <td data-label='DSS_Intern_ID'>{$row['dss_id']}</td>
                                      <td data-label='Intern Name'>{$row['name']}</td>
                                      <td data-label='Batch Name'>{$row['batch_no']}</td>
                                      <td data-label='Edit'><a href='edit_intern.php?id={$row['id']}' class='btn btn-secondary btn-sm'>Edit</a></td>
                                      <td data-label='Delete'><a href='delete_intern.php?id={$row['id']}' class='btn btn-danger btn-sm'>Delete</a></td>
                                    </tr>";
                              $sno++;
                          }
                      } else {
                          echo "<tr><td colspan='6' class='text-center'>No Interns Found</td></tr>";
                      }
                      ?>
                  </tbody>
              </table>
          </div>
     </div><br><br><br><br><br><br><br><br><br><br>

     <?php include('footer.php'); ?>

</body>
</html>
