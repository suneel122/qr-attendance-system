<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

$host = 'localhost';
$user = 'root';
$pass = ''; 
$db   = 'attendance_db';

$data = json_decode(file_get_contents('php://input'), true);
$student_id = isset($data['student_id']) ? trim($data['student_id']) : '';

if (empty($student_id)) {
    echo json_encode(["status" => "error", "message" => "No Student ID received"]);
    exit();
}

try {
    $conn = new mysqli($host, $user, $pass, $db);
    if ($conn->connect_error) {
        throw new Exception("Local DB Connection Failed: " . $conn->connect_error);
    }

    // 1. Fetch Student Name from 'students' table
    $nameStmt = $conn->prepare("SELECT student_name FROM students WHERE student_id = ?");
    $nameStmt->bind_param("s", $student_id);
    $nameStmt->execute();
    $nameResult = $nameStmt->get_result();
    
    $student_name = "N/A";
    if ($row = $nameResult->fetch_assoc()) {
        $student_name = $row['student_name'];
    }
    $nameStmt->close();

    // 2. Duplicate check for today
    $checkStmt = $conn->prepare("SELECT id FROM attendance WHERE student_id = ? AND DATE(mark_time) = CURDATE()");
    $checkStmt->bind_param("s", $student_id);
    $checkStmt->execute();
    $result = $checkStmt->get_result();

    if ($result->num_rows > 0) {
        echo json_encode(["status" => "error", "message" => "⚠️ Attendance Already Marked Today for " . $student_id]);
    } else {
        // 3. Save attendance with fetched name
        $insertStmt = $conn->prepare("INSERT INTO attendance (student_id, student_name, mark_time) VALUES (?, ?, NOW())");
        $insertStmt->bind_param("ss", $student_id, $student_name);
        
        if ($insertStmt->execute()) {
            echo json_encode(["status" => "success", "message" => "✅ Attendance Marked for " . $student_name . " (" . $student_id . ")"]);
        } else {
            echo json_encode(["status" => "error", "message" => "DB Insert Error"]);
        }
        $insertStmt->close();
    }

    $checkStmt->close();
    $conn->close();
} catch (Exception $e) {
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
}
?>