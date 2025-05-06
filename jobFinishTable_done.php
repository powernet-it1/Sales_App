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

if($loggedInUsername == "Wimal"){

    $sql = "SELECT * FROM finish_sales WHERE sts = 'finished'";
    $result = $conn->query($sql);

    $data = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

$conn->close();

}else{
$sql = "SELECT * FROM finish_sales WHERE salesPerson = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $loggedInUsername);
$stmt->execute();

$result = $stmt->get_result();

$data = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

$stmt->close();
$conn->close();

}

// Return JSON
header('Content-Type: application/json');
echo json_encode($data);

?>

