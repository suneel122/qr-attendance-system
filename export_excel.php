<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$db   = 'attendance_db';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=Attendance_Report_' . date('Y-m-d') . '.csv');

$output = fopen('php://output', 'w');

// Excel Column Headers me Name add kar diya gaya hai
fputcsv($output, array('S.No', 'Student ID', 'Student Name', 'Date', 'Time'));

$query = "SELECT id, student_id, student_name, DATE(mark_time) as date, TIME(mark_time) as time FROM attendance ORDER BY student_id ASC";
$result = $conn->query($query);

$sno = 1;
while ($row = $result->fetch_assoc()) {
    fputcsv($output, array($sno++, $row['student_id'], $row['student_name'], $row['date'], $row['time']));
}

fclose($output);
$conn->close();
exit();
?>