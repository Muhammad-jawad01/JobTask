<?php
require 'vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

include 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']); // Sanitize input
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $token = bin2hex(random_bytes(50));
        $expiry = date("Y-m-d H:i:s", strtotime("+1 hour"));
        $stmt = $conn->prepare("UPDATE users SET reset_token = ?, reset_token_expiry = ? WHERE email = ?");
        $stmt->bind_param("sss", $token, $expiry, $email);
        $stmt->execute();
        $resetLink = "http://localhost/job_task/reset-password.php?token=$token";
        try {
            $mail = new PHPMailer();
            $mail->isSMTP();
            $mail->Host = 'sandbox.smtp.mailtrap.io';
            $mail->SMTPAuth = true;
            $mail->Port = 2525;
            $mail->Username = 'd7a11750451cca';
            $mail->Password = '18b5f6fc1ef8a3';
            $mail->setFrom('no-reply@JDDeveloper.com', 'Reset Password');
            $mail->addAddress($email);
            $mail->Subject = 'Password Reset Request';
            $mail->Body = "Click the following link to reset your password: $resetLink";
            $mail->send();
            echo "Password reset link has been sent to your email.";
        } catch (Exception $e) {
            echo "Mailer Error: " . $mail->ErrorInfo;
        }
    } else {
        echo "No account found with that email.";
    }
}

$title = 'Reset Password';
ob_start();
?>

<div class="row d-flex justify-content-center">
    <div class="card text-center" style="width: 500px;">
        <div class="card-header h5 text-white bg-dark">Password Reset</div>
        <div class="card-body px-5">
            <p class="card-text py-2">
                Enter your email address and we'll send you an email with instructions to reset your password.
            </p>
            <form action="forgotpassword.php" method="POST">
                <div data-mdb-input-init class="form-outline">
                    <input type="email" id="typeEmail" name="email" class="form-control my-3" required />
                    <label class="form-label" for="typeEmail">Email Address</label>
                </div>
                <button type="submit" class="btn btn-primary w-100">Reset Password</button>
            </form>
            <div class="d-flex justify-content-between mt-4">
                <a href="#">Login</a>
                <a href="#">Register</a>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include 'master.php';
?>