<?php
    session_start();
    require_once 'components/db_connection.php';

    $login_error = '';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);

        $stmt = $conn->prepare("SELECT * FROM admins WHERE admin_email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $admin = $result->fetch_assoc();
            if ($password === $admin["admin_password"]) {
                $_SESSION['admin_id'] = $admin['admin_id'];
                $_SESSION['admin_email'] = $admin['admin_email'];
                header("Location: product_list.php");
                exit();
            } else {
                $login_error = "Invalid password.";
            }
        } else {
            $login_error = "No account found with that email.";
        }

        $stmt->close();
        $conn->close();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>TOUCHFIND | Admin Login</title>
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="css/admin.css" rel="stylesheet">
</head>
<body class="admin-login">
    <div class="container-fluid vh-100 d-flex justify-content-center align-items-center p-0" style="height: calc(var(--vh, 1vh) * 100);">
        <div class="login-card">
            <div class="text-center mb-4">
                <img src="../assets/login-icon.png" alt="Login Icon" class="admin-logo">
                <h2 class="admin-title">Admin Dashboard</h2>
                <p class="admin-subtitle">Welcome back! Please login to your account</p>
            </div>

            <?php if (!empty($login_error)): ?>
                <div class="alert alert-danger"><?= $login_error ?></div>
            <?php endif; ?>
            
            <form action="login.php" method="post">
                <div class="mb-3">
                    <label for="email" class="form-label">EMAIL</label>
                    <input type="email" autocomplete="off" class="form-control" name="email" id="email" placeholder="Enter your email" required>
                </div>
                
                <div class="mb-4">
                    <label for="password" class="form-label">PASSWORD</label>
                    <div class="password-input-group">
                        <input type="password" class="form-control" name="password" id="password" placeholder="Enter your password" required>
                        <button type="button" class="password-toggle" aria-label="Toggle password visibility">
                            <i class="bi bi-eye password-icon"></i>
                        </button>
                    </div>
                </div>
                
                <button type="submit" class="btn btn-login w-100">Login</button>
            </form>
        </div>
    </div>

    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script>
        document.querySelector('.password-toggle').addEventListener('click', function () {
            const passwordInput = document.getElementById('password');
            const eyeIcon = this.querySelector('i');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.classList.remove('bi-eye');
                eyeIcon.classList.add('bi-eye-slash');
            } else {
                passwordInput.type = 'password';
                eyeIcon.classList.remove('bi-eye-slash');
                eyeIcon.classList.add('bi-eye');
            }
        });

        function setVH() {
            let vh = window.innerHeight * 0.01;
            document.documentElement.style.setProperty('--vh', `${vh}px`);
        }
        window.addEventListener('resize', setVH);
        setVH();
    </script>
</body>
</html>
