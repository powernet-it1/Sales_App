<?php 

session_start();

if (!isset($_SESSION['username'])) {
    http_response_code(401); 
    echo json_encode(['error' => 'Unauthorized access']);
    exit();
}

    $supname =$_POST['supname'];
    $location=$_POST['location'];
    $address=$_POST['address'];
    $br=$_POST['businessRegistration'];
    $category=$_POST['itemCategories'];
    $email=$_POST['contactPersonEmail'];
    $phoneNumber=$_POST['contactPersonTel'];
    $bankDetails=$_POST['bankDetails'];
    $comments=$_POST['comments'];



    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "sales_app";

    
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "INSERT INTO supplier (supname,location,address,businessReg,category,email,contactNo,bankDetails,comments)
        VALUES ('$supname', '$location', '$address', '$br','$category','$email','$phoneNumber','$bankDetails','$comments');";


    if ($conn->query($sql) === TRUE) {
        header("Location:supplierTable.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();


?>