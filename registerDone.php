<?php

$username = $_POST['uname'];
$email = $_POST['email'];
$pword = $_POST['pword'];
$conPword = $_POST['rePword'];

$servername = "localhost";
    $userName = "root";
    $password = "";
    $dbname = "sales_app";

$conn = new mysqli($servername, $userName, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql = "INSERT INTO users (username,email,pword)
VALUES ('$username', '$email', '$pword')";

if ($conn->query($sql) === TRUE) {
    header("Location:table.html");
//   echo "New record created successfully";
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();

?>