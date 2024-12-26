<?php
include 'connection.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? OR name = ?");
    $stmt->bind_param("ss", $email, $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            session_start();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['name'] = $user['name'];
            header("Location: dashboard.php");
        } else {
            echo "Invalid email or password.";
        }
    } else {
        echo "User not found.";
    }
}

$title = 'Login';
ob_start();
?>
<div class="container mt-5" id="login">

    <div class="row d-flex justify-content-center">
        <div class="card text-center" style="width: 500px;">
            <div class="card-header h5 text-white bg-dark">Login</div>
            <div class="card-body px-5">
                <form class=" mx-auto" action="login.php" method="POST">

                    <div class="mb-2">
                        <label for="email" class="form-label">Email address</label>
                        <input type="email" name="email" class="form-control" id="email" placeholder="Enter email">
                    </div>
                    <div class="mb-2">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" id="password"
                            placeholder="Password">
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Login</button>

                </form>
                <div class="d-flex justify-content-between mt-4">
                    <a href="forgotpassword.php" class="btn btn-link">Forgot Password?</a>
                    <a href="register.php">Register</a>
                </div>
            </div>
        </div>
    </div>

</div>
<?php
$content = ob_get_clean();
include 'master.php';
?>