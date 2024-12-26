<?php
require 'vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include database connection
include 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $gender = $_POST['gender'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Hash password

    // Initialize the statement variable to prevent undefined variable error
    $stmt = null;

    try {
        // Ensure the connection is open
        if ($conn->connect_error) {
            throw new Exception('Database connection failed: ' . $conn->connect_error);
        }
        $stmt = $conn->prepare("INSERT INTO users (name, email, gender, password) VALUES (?, ?, ?, ?)");

        if ($stmt) {
            $stmt->bind_param("ssss", $name, $email, $gender, $password);
            $stmt->execute();
        } else {
            throw new Exception('Failed to prepare the statement.');
        }

        // Send welcome email
        $phpmailer = new PHPMailer();
        $phpmailer->isSMTP();
        $phpmailer->Host = 'sandbox.smtp.mailtrap.io';
        $phpmailer->SMTPAuth = true;
        $phpmailer->Port = 2525;
        $phpmailer->Username = 'd7a11750451cca';
        $phpmailer->Password = '18b5f6fc1ef8a3';
        $phpmailer->setFrom('no-reply@JDDeveloper.com', 'Welcome');
        $phpmailer->addAddress($email);
        $phpmailer->Subject = 'Welcome to Our Platform';
        $phpmailer->Body = 'Thank you for registering!';


        // Looking to send emails in production? Check out our Email API/SMTP product!

        if (!$phpmailer->send()) {
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        } else {
            // echo 'Registration successful. Welcome email sent.';
        }
    } catch (Exception $e) {
        echo 'Error: ' . $e->getMessage();
    } finally {
        // Close statement if it was created
        if ($stmt) {
            $stmt->close();
        }

        // Close the connection if it's open
        if ($conn) {
            $conn->close();
        }
    }
}

$title = 'Register';
ob_start();
?>

<div class="row d-flex justify-content-center">
    <div class="card text-center" style="width: 550px;">
        <div class="card-header h5 text-white bg-dark">Register</div>
        <div class="card-body px-5">
            <form class=" mx-auto" action="register.php" method="POST" id="registration-form">
                <div class="mb-2">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" name="name" id="name" placeholder="Enter name" required>
                </div>
                <div class="mb-2">
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" class="form-control" name="email" id="email" placeholder="Enter email" required>
                </div>
                <div class="mb-2">
                    <label for="gender" class="form-label">Gender</label>
                    <select name="gender" class="form-control" id="gender" required>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                        <option value="other">Other</option>
                    </select>
                </div>
                <div class="mb-2">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" name="password" id="password" placeholder="Password"
                        required>
                </div>
                <div class="mb-2">
                    <label for="confirm_password" class="form-label">Confirm Password</label>
                    <input type="password" class="form-control" name="confirm_password" id="confirm_password"
                        placeholder="Confirm Password" required>
                </div>
                <button type="submit" class="btn btn-success w-100">Register</button>
            </form>
            <div class="d-flex justify-content-between mt-4">
                <a href="forgotpassword.php" class="btn btn-link">Forgot Password?</a>
                <a href="login.php" class="btn btn-link">Already have an account? Login</a>
            </div>
        </div>
    </div>
</div>


<script>
    document.getElementById("registration-form").addEventListener("submit", function (event) {
        var password = document.getElementById("password").value;
        var confirmPassword = document.getElementById("confirm_password").value;

        // Check if passwords match
        if (password !== confirmPassword) {
            alert("Passwords do not match.");
            event.preventDefault();
        }

        // Validate email format
        var email = document.getElementById("email").value;
        var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
        if (!email.match(emailPattern)) {
            alert("Invalid email format.");
            event.preventDefault();
        }
    });
</script>
<?php
$content = ob_get_clean();
include 'master.php';
?>