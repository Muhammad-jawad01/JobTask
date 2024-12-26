<?php
include 'connection.php';

session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

$title = 'Dashboard';
ob_start();
?>


<div class="comtainer">
    <div class="row">
        <div class="col-md-2 sidebar ">
            <ul style="list-style: none;">
                <li>
                    <a href="dashboard.ph " class="text-decoration-none ">
                        <i class="fa fa-home"></i>
                        Home
                    </a>

                </li>
                <li>
                    <a href="logout.php" class="text-decoration-none ">
                        <i class="fa fa-sign-out" aria-hidden="true"></i>
                        Logout
                    </a>

                </li>
            </ul>

        </div>
        <div class="col-md-10">
            <div class="container mt-5" id="dashboard">
                <h2 class="text-center">Welcome, <?php echo $user['name']; ?></h2>

                <div class="row p-1">
                    <h3 class="mt-4">Registered Users</h3>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <!-- <th>Actions</th> -->
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $userQuery = "SELECT * FROM users";
                            $result = $conn->query($userQuery);
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>" . $row['id'] . "</td>";
                                    echo "<td>" . $row['name'] . "</td>";
                                    echo "<td>" . $row['email'] . "</td>";
                                    // echo "<td><a href='edit_user.php?id=" . $row['id'] . "' class='btn btn-primary btn-sm'>Edit</a></td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='4' class='text-center'>No users found</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$content = ob_get_clean();
include 'master.php';
?>