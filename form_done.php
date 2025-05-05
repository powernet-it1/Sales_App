<?php 
    $cusname =$_POST['cusname'];
    $location=$_POST['location'];
    $description=$_POST['description'];
    $contactPerson=$_POST['contactPerson'];
    $email=$_POST['contactPersonEmail'];
    $phoneNumber=$_POST['contactPersonTel'];
    $expectedCost =$_POST['expectedCost'];
    $profit=$_POST['profit'];
    $date=$_POST['estimatedFinishDate'];
    $Status = isset($_POST['status']) ? $_POST['status'] : '';
    $salesPerson="Chinthaka";
    $lastUpdatedDate=date('Y-m-d');

    $formattedDate = !empty($date) ? date('Y-m-d', strtotime($date)) : null;

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

$sql = "INSERT INTO sales (cusname,location,description,contactPerson,contactPersonTel,contactPersonEmail,expectedCost
,profit,estimatedFinishDate,sts,salesPerson,lastUpdatedDate)
VALUES ('$cusname', '$location', '$description', '$contactPerson','$phoneNumber','$email','$expectedCost','$profit',
" . 
  ($formattedDate ? "'$formattedDate'" : "NULL") . ",'$Status','$salesPerson','$lastUpdatedDate')";

if ($conn->query($sql) === TRUE) {
    header("Location:table.html");
//   echo "New record created successfully";
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();

?>