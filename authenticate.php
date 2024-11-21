<?php
session_start();
$conn = new mysqli("localhost", "root", "", "dalmia");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $sql = "SELECT ID, Password, Status FROM Employee WHERE MobileNumber = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if ($row['Status'] === 'Off') {
            die("Your account is inactive.");
        }
        if (password_verify($password, $row['Password'])) {
            $_SESSION['employee_id'] = $row['ID'];
            echo "Login successful!";
        } else {
            echo "Invalid credentials.";
        }
    } else {
        echo "User not found.";
    }
}

$conn->close();
?>
