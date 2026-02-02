<?php
session_start();
include_once("configs/db_config.php");
$login_error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['txtUsername'] ?? '');
    $password = trim($_POST['txtPassword'] ?? '');

    if (!empty($username) && !empty($password)) {
        $stmt = $db->prepare("
            SELECT u.id,  u.name, u.password, u.role_id, r.name AS role_name
            FROM {$tx}users u
            LEFT JOIN {$tx}roles r ON u.role_id = r.id
            WHERE u.name = ? AND u.status = 'Active'
            LIMIT 1
        ");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            if ($password === $user['password']) {
                $_SESSION["uid"] = $user['id'];
        
                $_SESSION["name"] = $user['username'];
                $_SESSION["role_id"] = $user['role_id'];
                $_SESSION["role_name"] = $user['role_name'];
                header("Location: home");
                exit;
            } else {
                $login_error = "Incorrect username or password.";
            }
        } else {
            $login_error = "Incorrect username or password.";
        }
        $stmt->close();
    } else {
        $login_error = "Please enter username and password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | NextPrime HRMS</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
    body {
        margin: 0;
        padding: 0;
        min-height: 100vh;
        background: linear-gradient(135deg, #667eea, #764ba2);
        display: flex;
        justify-content: center;
        align-items: center;
        font-family: 'Poppins', sans-serif;
        overflow: hidden;
    }

    .login-card {
        background: rgba(255, 255, 255, 0.95);
        border-radius: 20px;
        padding: 20px 25px;
        max-width: 360px;
        width: 100%;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
        text-align: center;
    }

    .login-card img {
        width: 45px;
        margin-bottom: 12px;
    }

    .login-card h4 {
        font-weight: 700;
        margin-bottom: 6px;
    }

    .login-card p {
        color: #666;
        font-size: 13px;
        margin-bottom: 15px;
    }

    .form-group {
        position: relative;
        margin-bottom: 12px;
    }

    .form-control {
        padding-left: 35px;
        height: 38px;
        border-radius: 8px;
        font-size: 14px;
    }

    .form-group i {
        position: absolute;
        top: 10px;
        left: 10px;
        color: #aaa;
    }

    .btn-primary {
        background: linear-gradient(to right, #667eea, #764ba2);
        border: none;
        width: 100%;
        padding: 9px;
        border-radius: 10px;
        font-weight: bold;
        transition: background 0.3s ease;
    }

    .btn-primary:hover {
        background: linear-gradient(to right, #5a67d8, #6b46c1);
    }

    .login-card a {
        color: #764ba2;
        text-decoration: none;
        font-weight: 500;
    }

    .login-card a:hover {
        text-decoration: underline;
    }

    .social-btns {
        display: flex;
        flex-direction: row;
        /* horizontal */
        justify-content: center;
        align-items: center;
        gap: 10px;
        margin-top: 12px;
    }

    .social-btns a {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 14px;
        transition: transform 0.3s ease;
    }

    .btn-facebook {
        background: #3b5998;
    }

    .btn-twitter {
        background: #1da1f2;
    }

    .btn-github {
        background: #333;
    }

    .social-btns a:hover {
        transform: scale(1.1);
    }

    .alert {
        font-size: 12px;
        padding: 6px 10px;
        border-radius: 6px;
    }
    </style>
</head>

<body>

    <div class="login-card">
        <img src="assets/images/HRMS_Icon.png" alt="NextPrime Logo">
        <h4>NextPrime HRMS</h4>
        <p>Log in to access the Admin Dashboard</p>

        <?php if (!empty($login_error)) : ?>
        <div class="alert alert-danger"><?= htmlspecialchars($login_error) ?></div>
        <?php endif; ?>

        <form method="post">
            <div class="form-group">
                <i class="fas fa-user"></i>
                <input type="text" name="txtUsername" class="form-control" placeholder="Username or Email" required>
            </div>

            <div class="form-group">
                <i class="fas fa-lock"></i>
                <input type="password" name="txtPassword" class="form-control" placeholder="Password" required>
            </div>

            <div class="d-flex justify-content-between align-items-center mb-2">
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="rememberMe">
                    <label for="rememberMe" class="form-check-label">Remember Me</label>
                </div>
                <a href="#">Forgot?</a>
            </div>

            <button type="submit" name="btnSignIn" class="btn btn-primary">Login</button>

            <p class="mt-2 text-muted" style="font-size:12px;">Don't have an account? <a href="#">Sign Up</a></p>

            <div class="mt-3">
                <small class="text-muted" style="font-size:12px;">Or Continue With</small>
                <div class="social-btns mt-1">
                    <a href="#" class="btn-facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="btn-twitter"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="btn-github"><i class="fab fa-github"></i></a>
                </div>
            </div>
        </form>
    </div>

</body>

</html>