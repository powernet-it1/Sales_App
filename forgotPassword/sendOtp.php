<?php
session_start();

require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';
require '../PHPMailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $uname = $_POST['uname'];
    $otp = rand(100000, 999999);
    $_SESSION['otp'] = $otp;
    $_SESSION['uname'] = $uname;

    $conn = new mysqli("localhost", "powernet", "Power@#2587", "sales_app");
    if ($conn->connect_error) {
        die("DB Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT email FROM users WHERE username = '$uname'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $email = $row['email'];

        $mail = new PHPMailer(true);

        try {
            $mail->SMTPDebug = 2; // Show detailed debug output
            $mail->Debugoutput = 'html';

            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'salesapplication8@gmail.com';
            $mail->Password = 'begv kaif ekjh phjl'; // Use App Password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom('salesapplication8@gmail.com', 'SalesApp');
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = 'Your OTP Code';
            $mail->Body    = "<p>Your OTP is: <strong>$otp</strong></p>";

            if ($mail->send()) {
                header("Location: verifyOtp.php");
                exit();
            } else {
                echo "Mailer Error: " . $mail->ErrorInfo;
            }
        } catch (Exception $e) {
            echo "Exception Caught: {$mail->ErrorInfo}";
        }
    } else {
        echo "No such user found!";
    }
}
?>

