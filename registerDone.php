<?php

$username = $_POST['uname'];
$email = $_POST['email'];
$pword = $_POST['pword'];
$conPword = $_POST['rePword'];

    $servername = "localhost";
    $username = "powernet";
    $password = "Power@#2587";
    $dbname = "sales_app";

    $hashedPassword = password_hash($pword, PASSWORD_DEFAULT);

$conn = new mysqli($servername, $userName, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql = "INSERT INTO users (username,email,pword)
VALUES ('$username', '$email', '$hashedPassword')";

if ($conn->query($sql) === TRUE) {
    header("Location:index.php");
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();

?>