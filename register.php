


<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Page Title</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href='css/register.css'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

</head>
<body>
    <section class="vh-100">
  <div class="mask d-flex align-items-center h-100 gradient-custom-3">
    <div class="container h-100">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-12 col-md-9 col-lg-7 col-xl-6">
          <div class="card" style="border-radius: 15px;">
            <div class="card-body p-5">
              <h2 class="text-uppercase text-center mb-5">Create an account</h2>

              <form id="registerForm" name="registerForm" action="registerDone.php" method="POST">

                <div data-mdb-input-init class="form-outline mb-4">
                  <input 
                    type="text" 
                    id="uname" 
                    name="uname" 
                    class="form-control form-control-lg" 
                    placeholder="Enter a username" 
                    required
                  />
                  <label class="form-label" for="uname">Username</label>
                </div>

                <div data-mdb-input-init class="form-outline mb-4">
                  <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    class="form-control form-control-lg" 
                    placeholder="Enter a email" 
                    required
                  />
                  <label class="form-label" for="email">Email</label>
                </div>

                <div data-mdb-input-init class="form-outline mb-4">
                  <input 
                    type="password" 
                    id="pword" 
                    name="pword" 
                    class="form-control form-control-lg"
                    placeholder="Enter a password" 
                    required
                  />
                  <label class="form-label" for="pword">Password</label>
                  <div class="form-check mt-2">
                    <input class="form-check-input" type="checkbox" id="showPassword">
                    <label class="form-check-label" for="showPassword">Show Password</label>
                  </div>
                </div>

                <div data-mdb-input-init class="form-outline mb-4">
                  <input 
                    type="password" 
                    id="rePword" 
                    name="rePword" 
                    class="form-control form-control-lg"
                    placeholder="Re-Enter the password" 
                    required
                  />
                  <label class="form-label" for="rePword">Confirm your password</label>
                  <div class="form-check mt-2">
                    <input class="form-check-input" type="checkbox" id="showRePassword">
                    <label class="form-check-label" for="showRePassword">Show Password</label>
                  </div>
                </div>

                <div class="d-flex justify-content-center">
                  <button  
                    type="submit"
                    class="btn btn-success btn-block btn-lg gradient-custom-4 text-body"
                  >
                  Register
                </div>

                <p class="text-center text-muted mt-5 mb-0">Have already an account? <a href="index.php"
                    class="fw-bold text-body"><u>Login here</u></a></p>

              </form>

              <script>
                document.getElementById('registerForm').addEventListener('submit', function(e) {
                  const password = document.getElementById('pword').value;
                  const confirmPassword = document.getElementById('rePword').value;

                  if (password !== confirmPassword) {
                    alert("Passwords do not match!");
                    e.preventDefault(); 
                  }
                });
              </script>
              <script>
                document.getElementById('showPassword').addEventListener('change', function() {
                  const passwordField = document.getElementById('pword');
                  passwordField.type = this.checked ? 'text' : 'password';
                });

                document.getElementById('showRePassword').addEventListener('change', function() {
                  const confirmPasswordField = document.getElementById('rePword');
                  confirmPasswordField.type = this.checked ? 'text' : 'password';
                });
                </script>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- <div
    class="d-flex flex-column flex-md-row text-center text-md-start justify-content-between py-4 px-4 px-xl-5 bg-primary">
    
    <div class="text-white mb-3 mb-md-0">
      Copyright © 2025. All rights reserved.
    </div>
   
      
  </div> -->
</section>
</body>
</html>