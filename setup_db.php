<?php
require_once 'db.php';

// 1. Table Create Karne Ka Logic
$sql = "CREATE TABLE IF NOT EXISTS students (
    id VARCHAR(50) PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    status VARCHAR(20) DEFAULT 'Absent',
    attendance_time DATETIME NULL
)";

if ($conn->query($sql) === TRUE) {
    echo "<h3>✅ Table 'students' Successfully Created!</h3>";
} else {
    die("Error creating table: " . $conn->error);
}

// 2. Sample Data Insert Karne Ka Logic (Aap apni IDs yahan badal sakte hain)
$students = [
    ['051', 'Student A'],
    ['052', 'Student B'],
    ['053', 'Student C'],
    ['054', 'Student D']
];

foreach ($students as $student) {
    $id = $student[0];
    $name = $student[1];
    
    $insertSql = "INSERT INTO students (id, name) VALUES ('$id', '$name') 
                  ON DUPLICATE KEY UPDATE name='$name'";
    $conn->query($insertSql);
}

echo "<h3>✅ Student Records Successfully Added!</h3>";
$conn->close();
?>