<?php

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);


$host = 'localhost';
$username = 'root';         
$password = '';             
$database = 'lab_7'; 

$conn = new mysqli($host, $username, $password, $database);


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $matric = $conn->real_escape_string(trim($_POST['matric']));
    $name = $conn->real_escape_string(trim($_POST['name']));
    $password = $_POST['password']; 
    $role = $conn->real_escape_string(trim($_POST['role']));

    
    if (!in_array($role, ['student', 'lecturer'])) {
        die("Invalid role selected.");
    }

 
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users (matric, name, password, role) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $matric, $name, $hashed_password, $role);

    if ($stmt->execute()) {
        echo "<p>Registration successful!</p>";
    } else {
        echo "<p>Error: Could not register.</p>";
    }

    $stmt->close();
}
$conn->close();
?>
