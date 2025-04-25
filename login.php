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

    $sql = "SELECT * FROM users WHERE username = '$uname' AND pword = '$pword'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $_SESSION['username'] = $uname; 
        header("Location: table.html");  
        exit();
    } else {
        echo "<script>
                alert('Invalid Username or Password!');
                window.location.href='index.html';
             </script>"; 
        
    }
}

$conn->close();
?>
