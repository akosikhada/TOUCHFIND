<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>TOUCHFIND | Admin Login</title>
    <!-- Bootstrap CSS -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Admin CSS -->
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
            
            <form action="product_list.php" method="post">
                <div class="mb-3">
                    <label for="email" class="form-label">EMAIL</label>
                    <input type="email" class="form-control" id="email" placeholder="Enter your email" required>
                </div>
                
                <div class="mb-3">
                    <label for="password" class="form-label">PASSWORD</label>
                    <div class="input-group password-input-group">
                        <input type="password" class="form-control" id="password" placeholder="Enter your password" required>
                        <button class="btn btn-outline-secondary password-toggle" type="button" aria-label="Toggle password visibility">
                            <i class="bi bi-eye password-icon"></i>
                        </button>
                    </div>
                </div>
                
                <div class="d-flex align-items-center mb-4 mt-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="remember">
                        <label class="form-check-label" for="remember">Remember me</label>
                    </div>
                    <a href="#" class="forgot-password ms-auto">Forgot Password?</a>
                </div>
                
                <button type="submit" class="btn btn-login w-100">Login</button>
            </form>
            
            <div class="text-center mt-3">
                <p class="admin-footer">Don't have an account? <a href="#" class="contact-admin">Contact Administrator</a></p>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script>
        // Toggle password visibility
        document.querySelector('.password-toggle').addEventListener('click', function() {
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

        // Fix for mobile viewport height issues (iOS Safari)
        function setVH() {
            let vh = window.innerHeight * 0.01;
            document.documentElement.style.setProperty('--vh', `${vh}px`);
        }
        window.addEventListener('resize', setVH);
        setVH();
    </script>
</body>
</html>