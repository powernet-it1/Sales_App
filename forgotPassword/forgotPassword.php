<!DOCTYPE html>
<html>
<head>
    <title>Forgot Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card p-4">
                    <h3 class="text-center mb-4">Forgot Password</h3>
                    <form action="sendOtp.php" method="POST">
                        <div class="mb-3">
                            <label>Username</label>
                            <input type="text" class="form-control" name="uname" placeholder="Enter your username" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Send OTP</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
