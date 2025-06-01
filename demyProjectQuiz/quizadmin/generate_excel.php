<?php
ob_start(); // Start output buffering
require 'vendor/autoload.php'; // Include PhpSpreadsheet
include('connection.php');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Fetch quiz results
$id = $_GET['id'];
$results_query = "
SELECT 
    qr.student_id,
    s.name,
    q.quiz_name,
    q.quiz_id,
    qc.quiz_category,
    q.quiz_date,
    q.start_time,
    q.end_time,
    COUNT(qr.question_id) AS total_questions,
    SUM(qr.is_correct) AS correct_answers,
    (SUM(qr.is_correct) / COUNT(qr.question_id)) * 100 AS score_percentage
FROM quiz_results qr
JOIN quizzes q ON qr.quiz_id = q.id
JOIN quiz_category qc ON q.quiz_category = qc.id
JOIN interns s ON qr.student_id = s.id
WHERE q.id = '$id'
GROUP BY qr.student_id, q.quiz_id
ORDER BY score_percentage DESC
";

$result = mysqli_query($connection, $results_query);
if (!$result) {
    die("Query Failed: " . mysqli_error($connection));
}

// Create Spreadsheet
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Add column headers
$headers = ["S.No", "Student Name", "Quiz Name", "Quiz ID", "Category", "Date", "Start Time", "End Time", "Total Questions", "Correct Answers", "Score (%)"];
$col = 'A';

foreach ($headers as $header) {
    $sheet->setCellValue($col . '1', $header);
    $col++;
}

// Fill data
$row_number = 2;
$sno = 1;

while ($row = mysqli_fetch_assoc($result)) {
    $total_questions = (int)$row['total_questions'];
    $correct_answers = (int)$row['correct_answers'];
    $score_percentage = ($total_questions > 0) ? ($correct_answers / $total_questions) * 100 : 0;

    $sheet->setCellValue("A{$row_number}", $sno);
    $sheet->setCellValue("B{$row_number}", $row['name']);
    $sheet->setCellValue("C{$row_number}", $row['quiz_name']);
    $sheet->setCellValue("D{$row_number}", $row['quiz_id']);
    $sheet->setCellValue("E{$row_number}", $row['quiz_category']);
    $sheet->setCellValue("F{$row_number}", $row['quiz_date']);
    $sheet->setCellValue("G{$row_number}", $row['start_time']);
    $sheet->setCellValue("H{$row_number}", $row['end_time']);
    $sheet->setCellValue("I{$row_number}", $total_questions);
    $sheet->setCellValue("J{$row_number}", $correct_answers);
    $sheet->setCellValue("K{$row_number}", number_format($score_percentage, 2) . '%');

    $row_number++;
    $sno++;
}

// Set headers for download
ob_end_clean(); // Clean previous output
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="Quiz_Results.xlsx"');
header('Cache-Control: max-age=0');
header('Expires: 0');
header('Pragma: public');

// Save file and output to browser
$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit();
?>
