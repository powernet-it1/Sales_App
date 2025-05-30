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
$password = "1234";
$dbname = "sales_app";

$conn = new mysqli($servername, $userName, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$perPage = isset($_GET['perPage']) ? (int) $_GET['perPage'] : 5;
$offset = ($page - 1) * $perPage;

$searchCustomer = $_GET['customer'] ?? '';
$filterUser = $_GET['user'] ?? '';

$searchCustomer = "%" . $conn->real_escape_string($searchCustomer) . "%";

if ($loggedInUsername === "Wimal") {
    $sql = "SELECT * FROM sales WHERE cusname LIKE ? ";
    if (!empty($filterUser)) {
        $sql .= "AND salesPerson = ? ";
    }
    $sql .= "ORDER BY lastUpdatedDate DESC LIMIT ?, ?";
    $stmt = $conn->prepare($sql);
    
    if (!empty($filterUser)) {
        $stmt->bind_param("ssii", $searchCustomer, $filterUser, $offset, $perPage);
    } else {
        $stmt->bind_param("sii", $searchCustomer, $offset, $perPage);
    }
} else {
    $sql = "SELECT * FROM sales WHERE salesPerson = ? AND cusname LIKE ? ORDER BY lastUpdatedDate DESC LIMIT ?, ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssii", $loggedInUsername, $searchCustomer, $offset, $perPage);
}

$stmt->execute();
$result = $stmt->get_result();
$data = [];

while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

// Total count for pagination
$totalQuery = "SELECT COUNT(*) as total FROM sales WHERE cusname LIKE ?";
if ($loggedInUsername === "Wimal" && !empty($filterUser)) {
    $totalQuery .= " AND salesPerson = ?";
    $countStmt = $conn->prepare($totalQuery);
    $countStmt->bind_param("ss", $searchCustomer, $filterUser);
} else if ($loggedInUsername === "Wimal") {
    $countStmt = $conn->prepare($totalQuery);
    $countStmt->bind_param("s", $searchCustomer);
} else {
    $totalQuery .= " AND salesPerson = ?";
    $countStmt = $conn->prepare($totalQuery);
    $countStmt->bind_param("ss", $searchCustomer, $loggedInUsername);
}

$countStmt->execute();
$countResult = $countStmt->get_result();
$totalRow = $countResult->fetch_assoc();
$total = $totalRow['total'];

$stmt->close();
$conn->close();

header('Content-Type: application/json');
echo json_encode([
    'data' => $data,
    'total' => $total,
    'page' => $page,
    'perPage' => $perPage
]);
?>
