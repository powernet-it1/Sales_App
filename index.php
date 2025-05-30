<?php

session_start();
session_unset();
session_destroy();

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

if (isset($_GET['expired']) && $_GET['expired'] == 'true') {
    echo "<script>alert('Session expired. Please log in again.');</script>";
}


?>


<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Page Title</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href='css/login.css'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

</head>
<body>
    <section class="vh-100">
        <div class="container-fluid h-custom">
          <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-md-9 col-lg-6 col-xl-5">
              <img src="js/draw2.png"
                class="img-fluid" alt="Sample image">
            </div>
            <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
              <form action="login.php" method="POST">
                <div class="divider d-flex align-items-center my-4">
                  <h2 class="text-center fw-bold mx-3 mb-0">Log In</h2>
                </div>
      
                <!-- Email input -->
                <div data-mdb-input-init class="form-outline mb-4">
                  <input 
                    type="text" 
                    id="uname" 
                    name="uname" 
                    class="form-control form-control-lg"
                    placeholder="Enter User Name" 
                  />
                  <label class="form-label" for="form3Example3">User Name</label>
                </div>
      
                <!-- Password input -->
                <div data-mdb-input-init class="form-outline mb-3">
                  <input 
                    type="password" 
                    id="pword" 
                    name="pword" 
                    class="form-control form-control-lg"
                    placeholder="Enter password" 
                  />
                  <label class="form-label" for="form3Example4">Password</label>
                </div>
      
                <div class="d-flex justify-content-between align-items-center">
                  <a href="forgotPassword/forgotPassword.php" class="text-body">Forgot password?</a>
                </div>

                <!-- <div class="divider d-flex align-items-center my-4">
                    <p class="text-center fw-bold mx-3 mb-0">Don't have an Account</p>
                  </div>  

                <div class="d-flex justify-content-between align-items-center">
                    <a href="register.php" class="text-body">Create an Account</a>
                  </div> -->
                
      
                <div class="text-center text-lg-start mt-4 pt-2">
                  <button 
                    class="button" 
                    type="submit" 
                    data-mdb-button-init data-mdb-ripple-init class="btn btn-lg"
                    style=" color:white; padding-left: 2.5rem; padding-right: 2.5rem; background-color:#320303; "
                    onMouseOver="this.style.background='white';this.style.color='black'"          
                    onMouseOut="this.style.background='#320303';this.style.color='white'">Login</button>
                </div>
            
              </form>
              
            </div>
          </div>
        </div>
        <footer style="background-color:#320303;display:fixed;" class="mt-auto d-flex flex-column flex-md-row text-center text-md-start justify-content-between align-items-center py-4 px-4 px-xl-5 ">
  <div class="text-white mb-3 mb-md-0">
    Copyright © 2025. All rights reserved.
  </div>
  <div class="text-white text-end" id="footer-datetime"></div>
</footer>

<script>
  function getFormattedDate() {
    const date = new Date();
    const day = date.getDate();
    const month = date.toLocaleString('default', { month: 'long' });
    const year = date.getFullYear();

    // Get day suffix (st, nd, rd, th)
    const suffix = (d) => {
      if (d > 3 && d < 21) return 'th';
      switch (d % 10) {
        case 1: return 'st';
        case 2: return 'nd';
        case 3: return 'rd';
        default: return 'th';
      }
    };

    return `${day}${suffix(day)} ${month} ${year}`;
  }

  function getFormattedTime() {
    const date = new Date();
    return date.toLocaleTimeString(); // Customize if needed
  }

  function updateFooterDateTime() {
    document.getElementById('footer-datetime').innerHTML =
      `${getFormattedDate()}<br>${getFormattedTime()}`;
  }

  updateFooterDateTime();
  setInterval(updateFooterDateTime, 1000);
</script>

      </section>
    
</body>

<script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }

    window.addEventListener('pageshow', function (event) {
        if (event.persisted || (window.performance && window.performance.navigation.type === 2)) {
            window.location.reload();
        }
    });
</script>
</html>