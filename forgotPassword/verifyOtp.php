<!DOCTYPE html>
<html>
<head>
    <title>Verify OTP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card p-4">
                    <h3 class="text-center mb-4">Enter OTP</h3>
                    <form action="checkOtp.php" method="POST">
                        <div class="mb-3">
                            <label>OTP</label>
                            <input type="text" class="form-control" name="otp" placeholder="Enter the OTP" required>
                        </div>
                        <button type="submit" class="btn btn-success w-100">Verify</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
