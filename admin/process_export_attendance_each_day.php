<?php
// Include the necessary files
require 'vendor/autoload.php'; // PhpSpreadsheet autoload
include('connection.php'); // Database connection

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Get the selected date from the URL parameter
$date = isset($_GET['date']) ? $_GET['date'] : null;

if ($date) {
    $spreadsheet = new Spreadsheet();

    // Sheet 1 for present interns
    $presentSheet = $spreadsheet->getActiveSheet();
    $presentSheet->setTitle('Present');

    // SQL query to get present interns for the selected date
    $query_present = "
        SELECT a.dss_intern_id, i.name AS intern_name, a.date,a.time
        FROM attendance a
        LEFT JOIN interns i ON a.dss_intern_id = i.dss_id
        WHERE a.status = 'present' AND a.date = '$date'
    ";

    $present_result = mysqli_query($connection, $query_present);

    // Add headers
    $presentSheet->setCellValue('A1', 'Intern ID');
    $presentSheet->setCellValue('B1', 'Intern Name');
    $presentSheet->setCellValue('C1', 'Date');
    $presentSheet->setCellValue('D1', 'Time');


    // Fill data for present interns
    $rowNumber = 2;
    while ($row = mysqli_fetch_assoc($present_result)) {
        $presentSheet->setCellValue('A' . $rowNumber, $row['dss_intern_id']);
        $presentSheet->setCellValue('B' . $rowNumber, $row['intern_name']);
        $presentSheet->setCellValue('C' . $rowNumber, $row['date']);
        $presentSheet->setCellValue('D' . $rowNumber, $row['time']);

        $rowNumber++;
    }

    // Sheet 2 for absent interns
    $absentSheet = $spreadsheet->createSheet();
    $absentSheet->setTitle('Absent');

    // SQL query to get absent interns for the selected date
    $query_absent = "
        SELECT a.dss_intern_id, i.name AS intern_name, a.date,a.time
        FROM attendance a
        LEFT JOIN interns i ON a.dss_intern_id = i.dss_id
        WHERE a.status = 'absent' AND a.date = '$date'
    ";

    $absent_result = mysqli_query($connection, $query_absent);

    // Add headers
    $absentSheet->setCellValue('A1', 'Intern ID');
    $absentSheet->setCellValue('B1', 'Intern Name');
    $absentSheet->setCellValue('C1', 'Date');
    $absentSheet->setCellValue('D1', 'Time');


    // Fill data for absent interns
    $rowNumber = 2;
    while ($row = mysqli_fetch_assoc($absent_result)) {
        $absentSheet->setCellValue('A' . $rowNumber, $row['dss_intern_id']);
        $absentSheet->setCellValue('B' . $rowNumber, $row['intern_name']);
        $absentSheet->setCellValue('C' . $rowNumber, $row['date']);
        $absentSheet->setCellValue('D' . $rowNumber, $row['time']);

        $rowNumber++;
    }

    // Set the active sheet back to the first sheet
    $spreadsheet->setActiveSheetIndex(0);

    // Send the file to the browser for download
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="Attendance_Report_' . $date . '.xlsx"');
    header('Cache-Control: max-age=0');

    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
    exit;
} else {
    echo "Please provide a date to export attendance.";
}
?>
