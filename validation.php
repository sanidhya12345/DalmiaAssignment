<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Submit</title>
</head>
<body>
<?php
$servername="localhost";
$username="root";
$password="";
$dbname="dalmia";

$conn=new mysqli($servername,$username,$password,$dbname);

if($conn->connect_error){
    die("Connection Failed ".$conn->connect_error);
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Process form data
    $name = trim($_POST['name']);
    $mobileNumber=trim($_POST['mobileNumber']);
    $password=trim($_POST['password']);
    $status=trim($_POST['status']);
    
    if(!preg_match("/^[A-Za-z\s]+$/",$name)){
        die("Invalid name.");
    }
    if (!preg_match("/^\d{10}$/", $mobileNumber)) {
        die("Invalid mobile number.");
    }
    if (!preg_match("/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/", $password)) {
        die("Invalid password.");
    }
    $hashedPassword=password_hash($password,PASSWORD_BCRYPT);

    $sql="INSERT INTO Employee (Name,MobileNumber,Password,Status) VALUES('$name','$mobileNumber','$hashedPassword','$status')";

    if($conn->query($sql)===TRUE){
        header("Location: login.html");
        exit(); 
    }
    else{
        echo "Error: ".$sql."<br>".$conn->error;
    }
} 
$conn->close();
?>
</body>
</html>