<?php
include 'connection.php';

if (isset($_GET['token'])) {
    $token = $_GET['token'];
    $stmt = $conn->prepare("SELECT * FROM users WHERE reset_token = ?");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $newPassword = trim($_POST['new_password']);
            $confirmPassword = trim($_POST['confirm_password']);

            if ($newPassword === $confirmPassword) {
                $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                $stmt = $conn->prepare("UPDATE users SET password = ?, reset_token = NULL, reset_token_expiry = NULL WHERE reset_token = ?");
                $stmt->bind_param("ss", $hashedPassword, $token);
                $stmt->execute();

                echo "Your password has been successfully reset!";
            } else {
                echo "Passwords do not match. Please try again.";
            }
        }

        ?>

        <?php
    } else {
        echo "Invalid or expired token.";
    }
} else {
    header('Location: forgotpassword.php');
    exit;
}

$title = 'Reset Password';
ob_start();
?>




<div class="row d-flex justify-content-center">
    <div class="card text-center" style="width: 500px;">
        <div class="card-header h5 text-white bg-dark">Password Reset</div>
        <div class="card-body px-5">
            <form action="" method="POST">
                <div data-mdb-input-init class="form-outline">
                    <label class="form-label" for="typeEmail"> New Password</label>
                    <input type="password" name="new_password" class="form-control my-3"
                        placeholder="Enter new password" required>
                </div>
                <div data-mdb-input-init class="form-outline">
                    <label class="form-label" for="typeEmail"> Confirm Password</label>
                    <input type="password" name="confirm_password" class="form-control my-3"
                        placeholder="Confirm new password" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Update Password</button>
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