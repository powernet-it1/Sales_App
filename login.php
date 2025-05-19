<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sales_app";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $uname = $_POST['uname'];
    $pword = $_POST['pword'];

    // Only select hashed password and ID by username
    $stmt = $conn->prepare("SELECT id, username, pword FROM users WHERE username = ?");
    $stmt->bind_param("s", $uname);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Verify entered password with hashed one
        if (password_verify($pword, $row['pword'])) {
            $_SESSION['username'] = $row['username'];
            $_SESSION['userid'] = $row['id'];
            $_SESSION['LAST_ACTIVITY'] = time();

            header("Location: table1.php");  
            exit();
        } else {
            echo "<script>
                    alert('Invalid Username or Password!');
                    window.location.href='index.php';
                  </script>";
        }
    } else {
        echo "<script>
                alert('Invalid Username or Password!');
                window.location.href='index.php';
              </script>";
    }

    $stmt->close();
}

$conn->close();
?>
