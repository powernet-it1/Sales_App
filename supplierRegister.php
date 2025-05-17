<?php
session_start();

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

$timeout_duration = 600;

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY']) > $timeout_duration) {
    session_unset();     
    session_destroy();   
    header("Location: index.php?expired=true");
    exit();
}

$_SESSION['LAST_ACTIVITY'] = time(); 
?>


<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Supplier Registration</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href='css/supplierForm.css'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

</head>
<body>

    <section class="vh-100 gradient-custom">
        <div class="container py-5 h-100">
          <div class="row justify-content-center align-items-center h-100">
            <div class="col-12 col-lg-10 col-xl-10">
              <div class="col-12 col-lg-20 col-xl-20">
              <div class="card shadow-2-strong card-registration" style="border-radius: 15px;">
                <div class="card-body p-4 p-md-5">
                  <h3 class="mb-4 pb-2 pb-md-0 mb-md-5">New Supplier Registration</h3>
                  <form name="supplierForm" id="supplierForm" action="supplierRegister_done.php" method="post" >
      
                    <div class="row">
                      <div class="col-md-6 mb-4">
      
                        <div data-mdb-input-init class="form-outline">
                          <input type="text" id="SupplierName" name="supname" class="form-control form-control-lg"  required/>
                          <label class="form-label" for="supplierName">Supplier Name</label>
                        </div>
                      </div>
                      <div class="col-md-6 mb-4">
      
                        <div data-mdb-input-init class="form-outline">
                          <input type="text" id="location" name="location" class="form-control form-control-lg" required />
                          <label class="form-label" for="location">Location</label>
                        </div>
      
                      </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 mb-4">
                            <textarea class="form-control form-control-lg" name="address" rows="3" required></textarea>
                            <label class="form-label" for="Address">Address</label>
        
                        </div>
                    </div>
      
                    <div class="row">
                      <div class="col-md-6 mb-4">
      
                        <div data-mdb-input-init class="form-outline">
                          <input type="text" class="form-control form-control-lg" name="businessRegistration" id="businessRegistration" required />
                          <label for="businessRegistration" class="form-label">Business Registration</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-4">
                        <div data-mdb-input-init class="form-outline">
                        <select id="itemCategories" class="form-select" name="itemCategories">
                            <option value="">All</option>
                            <option value="Computers & Accessories">Computers & Accessories</option>
                            <option value="Electrical Items">Electrical Items</option>
                            <option value="Network Items">Network Accessories</option>
                            <option value="Cables">Cables</option>
                        </select>
                        </div>
                        <label class="form-label select-label">Item Category</label>
                    </div>
                    
                        
      
                    </div>
                    <div class="row">
                      <div class="col-md-6 mb-4 pb-2">
      
                        <div data-mdb-input-init class="form-outline">
                          <input type="text" id="email" name="contactPersonEmail" class="form-control form-control-lg" required />
                          <label class="form-label" for="emailAddress">Email</label>
                          <!-- <p style="color: red;" id="emsgmail"> </p> -->
                        </div>
      
                      </div>
                      <div class="col-md-6 mb-4 pb-2">
      
                        <div data-mdb-input-init class="form-outline">
                          <input type="text" id="phoneNumber" name="contactPersonTel" class="form-control form-control-lg" />
                          <label class="form-label" for="phoneNumber">Phone Number</label>
                          <!-- <p style="color: red;" id="emsg"> </p> -->
                        </div>
      
                      </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 mb-4 pb-2">
                            <textarea class="form-control form-control-lg" name="bankDetails" rows="3" required></textarea>
                            <label class="form-label" for="bankDetails">Bank Details</label>
        
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 mb-4 pb-2">
                            <textarea class="form-control form-control-lg" name="comments" rows="3" required></textarea>
                            <label class="form-label" for="Comment">Comments</label>
        
                        </div>
                    </div>
      
                    <div class="mt-4 pt-2 d-flex" style="gap: 10px; width: fit-content;">
                      <button data-mdb-ripple-init class="btn btn-success" id="sub" name="sub" style="width: 120px;">Submit</button>
                      <input class="btn btn-outline-danger" type="reset" value="Clear" style="width: 120px;">
                    </div>
      
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
      <script>
        function checkEmail() {
          const email = document.getElementById("email").value;
          const emailError = document.getElementById("emailError");
      
          // Simple email pattern check
          const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      
          if (!email) {
            emailError.textContent = "Email is required.";
          } else if (!emailPattern.test(email)) {
            emailError.textContent = "Invalid email format. Must contain '@' and a domain.";
          } else {
            emailError.textContent = "";
            alert("Email format is valid!");
          }
        }
      </script>
      
</body>
</html>
