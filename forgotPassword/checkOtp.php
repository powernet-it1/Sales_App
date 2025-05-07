<?php
session_start();
if ($_POST['otp'] == $_SESSION['otp']) {
    header("Location: resetPassword.php");
    exit();
} else {
    echo "Invalid OTP.";
}
?>
