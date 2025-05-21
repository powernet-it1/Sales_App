<?php

session_start();

$timeout_duration = 600;

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

if (!isset($_SESSION['username'])) {
    header("Location: supplierTable.php");
    exit();
}

if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY']) > $timeout_duration) {
    session_unset();     
    session_destroy();   
    header("Location: index.php?expired=true");
    exit();
}

$_SESSION['LAST_ACTIVITY'] = time(); 


$servername = "localhost";
$userName = "powernet";
$password = "Power@#2587";
$dbname = "sales_app";

$conn = new mysqli($servername, $userName, $password, $dbname);

if ($conn->connect_error) {
die("Connection failed: " . $conn->connect_error);
}


$id = $_GET['id'];  

$sql = "SELECT * FROM supplier WHERE id = $id"; 
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
} else {
    echo "No record found.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Sale</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<section class="vh-100 gradient-custom">
    <div class="container py-5 h-100">
        <div class="row justify-content-center align-items-center h-100">
            <div class="col-12 col-lg-10 col-xl-10">
                <div class="card shadow-2-strong card-registration" style="border-radius: 15px;">
                    <div class="card-body p-4 p-md-5">
                        <h3 class="mb-4 pb-2 pb-md-0 mb-md-5">View Supplier</h3>
                        
                        <form name="supplierForm" id="supplierForm" action="#.php" method="post">
                            <!-- Hidden ID field -->
                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

                            <div class="row">
                      <div class="col-md-6 mb-4">
      
                        <div data-mdb-input-init class="form-outline">
                          <input type="text" name="supname" class="form-control form-control-lg" value="<?php echo $row['supname'];?>"  disabled/>
                          <label class="form-label" for="supplierName">Supplier Name</label>
                        </div>
                      </div>
                      <div class="col-md-6 mb-4">
      
                        <div data-mdb-input-init class="form-outline">
                          <input type="text" name="location" class="form-control form-control-lg" value="<?php echo $row['location'];?>" disabled />
                          <label class="form-label" for="location">Location</label>
                        </div>
      
                      </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 mb-4">
                            <textarea class="form-control form-control-lg" name="address" rows="3" disabled><?php echo $row['address'];?></textarea>
                            <label class="form-label" for="Address">Address</label>
        
                        </div>
                    </div>
      
                    <div class="row">
                      <div class="col-md-6 mb-4">
      
                        <div data-mdb-input-init class="form-outline">
                          <input type="text" class="form-control form-control-lg" name="businessRegistration" value="<?php echo $row['businessReg'];?>" disabled/>
                          <label for="businessRegistration" class="form-label">Business Registration</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-4">
                        <div data-mdb-input-init class="form-outline">
                        <select id="itemCategories" class="form-select" name="itemCategories" disabled>
                            <option value="">All</option>
                            <option value="Computers & Accessories" <?php if($row['category'] == 'Computers & Accessories') echo 'selected'; ?>>Computers & Accessories</option>
                            <option value="Electrical Items" <?php if($row['category'] == 'Electrical Items') echo 'selected'; ?>>Electrical Items</option>
                            <option value="Network Items" <?php if($row['category'] == 'Network Items') echo 'selected'; ?>>Network Items</option>
                            <option value="Cables" <?php if($row['category'] == 'Cables') echo 'selected'; ?>>Cables</option>
                        </select>
                        </div>
                        <label class="form-label select-label">Item Category</label>
                    </div>
                    
                        
      
                    </div>
                    <div class="row">
                      <div class="col-md-6 mb-4 pb-2">
      
                        <div data-mdb-input-init class="form-outline">
                          <input type="text" name="contactPersonEmail" class="form-control form-control-lg" value="<?php echo $row['email'];?>" disabled />
                          <label class="form-label" for="emailAddress">Email</label>
                          <!-- <p style="color: red;" id="emsgmail"> </p> -->
                        </div>
      
                      </div>
                      <div class="col-md-6 mb-4 pb-2">
      
                        <div data-mdb-input-init class="form-outline">
                          <input type="text" name="contactPersonTel" class="form-control form-control-lg" value="<?php echo $row['contactNo'];?>" disabled />
                          <label class="form-label" for="phoneNumber">Phone Number</label>
                          <!-- <p style="color: red;" id="emsg"> </p> -->
                        </div>
      
                      </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 mb-4 pb-2">
                            <textarea class="form-control form-control-lg" name="bankDetails" rows="3" disabled><?php echo $row['bankDetails'];?></textarea>
                            <label class="form-label" for="bankDetails">Bank Details</label>
        
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 mb-4 pb-2">
                            <textarea class="form-control form-control-lg" name="comments" rows="3" disabled><?php echo $row['comments'];?></textarea>
                            <label class="form-label" for="Comment">Comments</label>
        
                        </div>
                    </div>
      
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

</body>
</html>
