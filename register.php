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

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Registration Page</title>
</head>
<body>
  <h2>Registration Form</h2>
  <form action="register.php" method="post">
    <label>Matric:</label>
    <input type="text" name="matric" required><br><br>

    <label>Name:</label>
    <input type="text" name="name" required><br><br>

    <label>Password:</label>
    <input type="password" name="password" required><br><br>

    <label>Role:</label>
    <select name="role" required>
      <option value="">Please select</option>
      <option value="student">Student</option>
      <option value="lecturer">Lecturer</option>
    </select><br><br>

    <input type="submit" value="Submit">
  </form>

</body>
</html>

