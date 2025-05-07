<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card p-4">
                    <h3 class="text-center mb-4">Reset Your Password</h3>
                    <form action="updatePassword.php" method="POST">
                        <div class="mb-3">
                            <label>New Password</label>
                            <input type="password" class="form-control" name="new_password" placeholder="Enter new password" required>
                        </div>
                        <button type="submit" class="btn btn-warning w-100">Update Password</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
