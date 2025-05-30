<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "1234";
$dbname = "sales_app";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
} 

header('Content-Type: application/json');

if (!isset($_SESSION['username'])) {
    echo json_encode(['error' => 'Not logged in']);
    exit();
}

$user = $_GET['user'] ?? $_SESSION['username'];

$sql = "SELECT sts, COUNT(*) as count FROM sales WHERE salesPerson = ? GROUP BY sts";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $user);
$stmt->execute();

$result = $stmt->get_result();
$data = [];

while ($row = $result->fetch_assoc()) {
    $data[$row['sts']] = (int)$row['count'];
}

echo json_encode($data);
?>

