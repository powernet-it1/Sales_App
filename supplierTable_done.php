<?php

session_start();

if (!isset($_SESSION['username'])) {
    http_response_code(401); 
    echo json_encode(['error' => 'Unauthorized access']);
    exit();
}


$servername = "localhost";
$userName = "powernet";
$password = "Power@#2587";
$dbname = "sales_app";

$conn = new mysqli($servername, $userName, $password, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}


    $sql = "SELECT * FROM supplier";
    $result = $conn->query($sql);

    $data = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

$conn->close();



// Return JSON
header('Content-Type: application/json');
echo json_encode($data);

?>

