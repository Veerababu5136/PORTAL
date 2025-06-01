<?php
require 'vendor/autoload.php'; // Include PhpSpreadsheet's autoload file
include('connection.php');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

// Fetch interns with their attendance details
$query = "
    SELECT 
        i.dss_id,
        i.name,
        i.batch_no,
        COUNT(a.date) AS total_classes,
        SUM(CASE WHEN a.status = 'present' THEN 1 ELSE 0 END) AS present_count,
        (SUM(CASE WHEN a.status = 'present' THEN 1 ELSE 0 END) / COUNT(a.date)) * 100 AS attendance_percentage
    FROM interns i
    LEFT JOIN attendance a ON i.dss_id = a.dss_intern_id
    GROUP BY i.dss_id, i.name, i.batch_no
    ORDER BY i.batch_no, i.dss_id
";

$result = mysqli_query($connection, $query);
if (!$result) {
    die("Query Failed: " . mysqli_error($connection));
}

// Create a new Spreadsheet object
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Add column headers
$sheet->setCellValue('A1', 'S.No');
$sheet->setCellValue('B1', 'Name');
$sheet->setCellValue('C1', 'Intern ID');
$sheet->setCellValue('D1', 'Batch Number');
$sheet->setCellValue('E1', 'Total Classes Conducted');
$sheet->setCellValue('F1', 'Total Present');
$sheet->setCellValue('G1', 'Attendance Percentage');

$row_number = 2; // Start from the second row (after headers)
$sno = 1; // Serial number for each intern

while ($row = mysqli_fetch_assoc($result)) {
    // Add intern data
    $sheet->setCellValue("A{$row_number}", $sno);
    $sheet->setCellValue("B{$row_number}", $row['name']);
    $sheet->setCellValue("C{$row_number}", $row['dss_id']);
    $sheet->setCellValue("D{$row_number}", $row['batch_no']);
    $sheet->setCellValue("E{$row_number}", $row['total_classes'] ?: 0);
    $sheet->setCellValue("F{$row_number}", $row['present_count'] ?: 0);
    $sheet->setCellValue("G{$row_number}", number_format(($row['attendance_percentage'] ?: 0), 2) . '%');
    
    $row_number++;
    $sno++;
}

// Set header for download
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="Interns_Attendance.xlsx"');
header('Cache-Control: max-age=0');

// Save to php://output
$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit();
?>
