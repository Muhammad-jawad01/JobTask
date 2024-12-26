<?php
include 'connection.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $user_id = (int) $_GET['id'];
    $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if (!$user) {
        die("User not found.");
    }
} else {
    die("Invalid user ID.");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['user_id']) && is_numeric($_POST['user_id'])) {
        $user_id = (int) $_POST['user_id'];
    } else {
        die("Invalid user ID.");
    }

    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $gender = $_POST['gender'] ?? '';
    $address = $_POST['address'] ?? '';
    $status = $_POST['status'] ?? '';
    $query = "UPDATE users SET name = ?, email = ?, username = ?, phone = ?, gender = ?, address = ?, status = ?";
    $params = [$name, $email, $username, $phone, $gender, $address, $status];
    $types = "sssssss";

    if (!empty($password)) {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $query .= ", password = ?";
        $params[] = $hashedPassword;
        $types .= "s";
    }

    $query .= " WHERE id = ?";
    $params[] = $user_id;
    $types .= "i";

    $updateStmt = $conn->prepare($query);
    $updateStmt->bind_param($types, ...$params);

    if ($updateStmt->execute()) {
        echo "<script>alert('User updated successfully');</script>";
        header("Location: dashboard.php");
        exit();

    } else {
        echo "<script>alert('Error updating user');</script>";
    }
}

$title = 'Edit User';
ob_start();
?>

<div class="row">
    <!-- Sidebar -->
    <?php include 'sidebar.php'; ?>

    <div class="col-md-10 mt-4">
        <div class="card bg-light m-3 p-2">
            <h2>Edit Profile</h2>
            <form method="POST" action="edit_user.php?id=<?= htmlspecialchars($user['id']) ?>">
                <div class="row p-3">

                    <input type="hidden" name="user_id" value="<?= htmlspecialchars($user['id']) ?>">
                    <div class="col-md-6">
                        <div class="form-group p-2">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name"
                                value="<?= htmlspecialchars($user['name'] ?? '') ?>" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group p-2">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username"
                                value="<?= htmlspecialchars($user['username'] ?? '') ?>" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group p-2">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email"
                                value="<?= htmlspecialchars($user['email'] ?? '') ?>" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group p-2">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group p-2">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="tel" class="form-control" id="phone" name="phone"
                                value="<?= htmlspecialchars($user['phone'] ?? '') ?>" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group p-2">
                            <label for="gender" class="form-label">Gender</label>
                            <select class="form-control" id="gender" name="gender">
                                <option value="Male" <?= ($user['gender'] ?? '') == 'Male' ? 'selected' : '' ?>>Male
                                </option>
                                <option value="Female" <?= ($user['gender'] ?? '') == 'Female' ? 'selected' : '' ?>>
                                    Female</option>
                                <option value="Other" <?= ($user['gender'] ?? '') == 'Other' ? 'selected' : '' ?>>Other
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group p-2">
                            <label for="address" class="form-label">Address</label>
                            <textarea class="form-control" id="address" name="address"
                                required><?= htmlspecialchars($user['address'] ?? '') ?></textarea>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group p-2">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-control" id="status" name="status">
                                <option value="Active" <?= ($user['status'] ?? '') == 'Active' ? 'selected' : '' ?>>
                                    Active</option>
                                <option value="Inactive" <?= ($user['status'] ?? '') == 'Inactive' ? 'selected' : '' ?>>
                                    Inactive</option>
                            </select>
                        </div>
                    </div>

                </div>

                <button type="submit" class="btn btn-primary mt-4">Save Changes</button>
            </form>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include 'master.php';
?>