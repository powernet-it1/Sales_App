<?php

session_start();

if (!isset($_SESSION['username'])) {
    http_response_code(401); 
    echo json_encode(['error' => 'Unauthorized access']);
    exit();
}

$loggedInUsername = $_SESSION['username'];

$servername = "localhost";
$userName = "root";
$password = "";
$dbname = "sales_app";

$conn = new mysqli($servername, $userName, $password, $dbname);

if ($conn->connect_error) {
die("Connection failed: " . $conn->connect_error);
}

$id = $_POST['id'];
$description = $_POST['description'];
$status = $_POST['sts'];
// $salesPerson = "Malaka";
$lastUpdatedDate = date('Y-m-d');

$sql = "UPDATE sales SET description = ?, sts = ?, salesPerson = ?, lastUpdatedDate = ?  WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssi", $description, $status, $loggedInUsername, $lastUpdatedDate, $id);

if ($stmt->execute()) {
    echo "<script>alert('Record updated successfully'); window.location.href='table1.php';</script>";
} else {
    echo "Error updating record: " . $conn->error;
}

$conn->close();
?>