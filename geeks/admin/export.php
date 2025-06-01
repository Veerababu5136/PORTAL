<?php
include('connection.php');

// Set headers to download the file as an Excel document
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=interns_data.xls");
header("Pragma: no-cache");
header("Expires: 0");

// Fetch interns data from the database
$intern_query = "SELECT * FROM interns";
$intern_stmt = $connection->prepare($intern_query);
$intern_stmt->execute();
$intern_result = $intern_stmt->get_result();

// Output the table headers
echo "ID\tName\tBatch\tGFG Name\n";

// Loop through and output the data
while ($intern = $intern_result->fetch_assoc()) {
    echo $intern['id'] . "\t" . $intern['name'] . "\t" . $intern['batch_no'] . "\t" . $intern['geeks_name'] . "\n";
}
?>
