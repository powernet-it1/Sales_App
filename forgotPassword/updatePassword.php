<?php
session_start();
$conn = new mysqli("localhost", "root", "", "sales_app");
if ($conn->connect_error) {
    die("DB Connection failed: " . $conn->connect_error);
}

if (!isset($_SESSION['uname'])) {
    die("Session 'uname' is not set.");
}

if (!isset($_POST['new_password']) || empty($_POST['new_password'])) {
    die("New password is missing.");
}

$uname = $_SESSION['uname'];
$rawPassword = $_POST['new_password'];
$newPassword = password_hash($rawPassword, PASSWORD_DEFAULT);

$stmt = $conn->prepare("UPDATE users SET pword = ? WHERE username = ?");
if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

$stmt->bind_param("ss", $newPassword, $uname);

if ($stmt->execute()) {
    if ($stmt->affected_rows === 0) {
        echo "Password not updated. Possibly same password or user not found.";
    } else {
        echo "Password updated successfully.<br><br> <a href='../index.php'>Login</a>";
        session_destroy();
    }
} else {
    echo "Error executing update: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
