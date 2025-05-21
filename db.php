<?php
$servername = "localhost";
$username = "powernet";
$password = "Power@#2587";
$dbname = "sales_app";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql = "INSERT INTO sales (cusname, location, description,contactPerson,email,phoneNumber,expectedCost
,profit,date,Status)
VALUES ('John', 'Doe', 'john@example.com')";

if ($conn->query($sql) === TRUE) {
  echo "New record created successfully";
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>