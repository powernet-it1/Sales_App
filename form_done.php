<?php 
    $cusname =$_POST['cusname'];
    $location=$_POST['location'];
    $description=$_POST['description'];
    $contactPerson=$_POST['contactPerson'];
    $email=$_POST['email'];
    $phoneNumber=$_POST['telNo'];
    $expectedCost =$_POST['expectedCost'];
    $profit=$_POST['profit'];
    $date=$_POST['date'];
    $Status=$_POST['Status'];

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "sales_app";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql = "INSERT INTO sales (cusname, location, description,contactPerson,email,phoneNumber,expectedCost
,profit,date,Status)
VALUES ('$cusname', '$location', '$description', '$contactPerson','$email','$phoneNumber','$expectedCost','$profit',
'$date','$Status')";

if ($conn->query($sql) === TRUE) {
    header("Location:table.html");
//   echo "New record created successfully";
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();

?>