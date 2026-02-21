<?php
session_start();
include_once("configs/db_config.php");
include_once(__DIR__ . "/configs/config.php");
$login_error = "";
$roles = [];
try {
    $res = $db->query("SELECT id,name FROM {$tx}roles ORDER BY name ASC");
    while ($r = $res->fetch_assoc()) {
        $roles[] = $r;
    }
} catch (Throwable $e) {}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['txtUsername'] ?? '');
    $password = trim($_POST['txtPassword'] ?? '');

    if (!empty($username) && !empty($password)) {
        $stmt = $db->prepare("
            SELECT u.id, u.name, u.email, u.password, u.role_id, r.name AS role_name
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
            $stored = $user['password'] ?? '';

            $isHashed = is_string($stored) && str_starts_with($stored, '$2y$');
            $match = $isHashed ? password_verify($password, $stored) : ($password === $stored);

            if ($match) {
                if (!$isHashed) {
                    $newHash = password_hash($password, PASSWORD_DEFAULT);
                    $up = $db->prepare("UPDATE {$tx}users SET password=? WHERE id=?");
                    $up->bind_param("si", $newHash, $user['id']);
                    $up->execute();
                    $up->close();
                    $stored = $newHash;
                }

                session_regenerate_id(true);
                $_SESSION["uid"] = (int)$user['id'];
                $_SESSION["name"] = $user['name'];
                $_SESSION["role_id"] = (int)$user['role_id'];
                $_SESSION["role_name"] = $user['role_name'];
                $_SESSION["email"] = $user['email'] ?? '';

                $target = $_SESSION['return_to'] ?? '';
                if (!empty($target)) {
                    unset($_SESSION['return_to']);
                    header("Location: " . $target);
                } else {
                    header("Location: " . $base_url . "/home");
                }
                exit;
            }

            $login_error = "Incorrect username or password.";
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
    <title>Login | NextPrime Limited</title>
    <base href="<?= $base_url ?>/">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
    body {
        margin: 0;
        padding: 0;
        min-height: 100vh;
        background: linear-gradient(135deg, #667eea, #764ba2);
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
        display: flex;
        justify-content: center;
        align-items: center;
        font-family: 'Poppins', sans-serif;
        overflow: hidden;
        position: relative;
    }

    body::before,
    body::after {
        content: "";
        position: absolute;
        width: 300px;
        height: 300px;
        border-radius: 50%;
        filter: blur(70px);
        opacity: 0.35;
        animation: float 9s ease-in-out infinite;
    }

    body::before {
        background: #7c3aed;
        top: -60px;
        left: -60px;
    }

    body::after {
        background: #06b6d4;
        bottom: -60px;
        right: -60px;
        animation-delay: 1.8s;
    }

    .login-card {
        background: rgba(255, 255, 255, 0.9);
        border-radius: 18px;
        padding: 24px 26px;
        max-width: 360px;
        width: 100%;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.35);
        text-align: center;
        position: relative;
        z-index: 1;
        transition: transform 0.25s ease, box-shadow 0.25s ease;
    }

    .login-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 26px 56px rgba(0, 0, 0, 0.28);
    }

    .login-card img {
        width: 150px;
        margin-bottom: 12px;
    }

    .login-card h4 {
        font-weight: 700;
        margin-bottom: 4px;
    }

    .login-card p {
        color: #666;
        font-size: 13px;
        margin-bottom: 16px;
    }

    .form-group {
        position: relative;
        margin-bottom: 14px;
    }

    .form-control {
        padding-left: 36px;
        height: 40px;
        border-radius: 10px;
        font-size: 14px;
        background: rgba(255, 255, 255, 0.85);
        border: 1px solid rgba(0, 0, 0, 0.08);
        transition: box-shadow 0.2s ease, border-color 0.2s ease;
    }

    .form-control::placeholder {
        color: #9aa3b2;
    }

    .form-control:focus {
        border-color: #7c3aed;
        box-shadow: 0 0 0 3px rgba(124, 58, 237, 0.15);
    }

    .form-group i {
        position: absolute;
        top: 11px;
        left: 12px;
        color: #9aa3b2;
        transition: color 0.2s ease;
    }

    .form-group:focus-within i {
        color: #7c3aed;
    }

    .toggle-password {
        position: absolute;
        right: 10px;
        top: 8px;
        width: 28px;
        height: 28px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: none;
        background: transparent;
        color: #7c8496;
        cursor: pointer;
        transition: background 0.2s ease, color 0.2s ease;
    }

    .toggle-password:hover {
        background: rgba(0, 0, 0, 0.06);
        color: #111827;
    }

    .btn-primary {
        background: linear-gradient(to right, #667eea, #764ba2);
        border: none;
        width: 100%;
        padding: 11px;
        border-radius: 12px;
        font-weight: bold;
        transition: background 0.3s ease;
        box-shadow: 0 10px 18px rgba(118, 75, 162, 0.35);
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
        width: 38px;
        height: 38px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 15px;
        transition: transform 0.3s ease;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.18);
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

    .brand-subtitle {
        font-size: 12px;
        color: #8b8fa3;
    }

    .form-footnote {
        font-size: 12px;
    }

    @keyframes float {
        0% { transform: translateY(0) translateX(0); }
        50% { transform: translateY(18px) translateX(-12px); }
        100% { transform: translateY(0) translateX(0); }
    }


    </style>
</head>

<body>

    <div class="login-card">
        <a href="home" aria-label="Go to Dashboard">
            <img src="assets/images/nextprime-logo-pro.svg" alt="NextPrime Logo">
        </a>
        <!-- <h4>NextPrime Limited</h4> -->
        <p class="brand-subtitle">Welcome back! Please sign in to continue</p>

        <?php if (!empty($login_error)) : ?>
        <div class="alert alert-danger"><?= htmlspecialchars($login_error) ?></div>
        <?php endif; ?>

        <form method="post">
            <div class="form-group">
                <i class="fas fa-user-shield"></i>
                <select id="cmbRole" class="form-control">
                    <option value="" selected disabled>Select Role</option>
                    <?php foreach ($roles as $role): ?>
                        <option value="<?= intval($role['id']) ?>"><?= htmlspecialchars($role['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <i class="fas fa-user"></i>
                <input type="text" name="txtUsername" class="form-control" placeholder="Username or Email" required>
            </div>

            <div class="form-group">
                <i class="fas fa-lock"></i>
                <input type="password" name="txtPassword" class="form-control" placeholder="Password" required>
                <button type="button" class="toggle-password" aria-label="Toggle password visibility">
                    <i class="far fa-eye"></i>
                </button>
            </div>

            <div class="d-flex justify-content-between align-items-center mb-2">
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="rememberMe">
                    <label for="rememberMe" class="form-check-label">Remember Me</label>
                </div>
                <a href="forgot.php">Forgot?</a>
            </div>

            <button type="submit" name="btnSignIn" class="btn btn-primary">Login</button>

            <p class="mt-2 text-muted form-footnote">Don't have an account? <a href="register.php">Sign Up</a></p>

            <div class="mt-3">
                <small class="text-muted form-footnote">Or Continue With</small>
                <div class="social-btns mt-1">
                    <a href="#" class="btn-facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="btn-twitter"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="btn-github"><i class="fab fa-github"></i></a>
                </div>
            </div>
        </form>
    </div>



    <script>
      (function () {
        const toggleBtn = document.querySelector('.toggle-password');
        const pwdInput = document.querySelector('input[name="txtPassword"]');
        if (toggleBtn && pwdInput) {
          toggleBtn.addEventListener('click', function () {
            const isText = pwdInput.type === 'text';
            pwdInput.type = isText ? 'password' : 'text';
            const icon = this.querySelector('i');
            if (icon) {
              icon.classList.toggle('fa-eye');
              icon.classList.toggle('fa-eye-slash');
            }
          });
        }
        const roleSelect = document.getElementById('cmbRole');
        const usernameInput = document.querySelector('input[name="txtUsername"]');
        if (roleSelect && usernameInput) {
          roleSelect.addEventListener('change', async function () {
            const roleId = this.value;
            usernameInput.value = '';
            if (!roleId) return;
            try {
              const res = await fetch(`api/Auth/usernameByRole/${roleId}`, { method: 'GET' });
              if (!res.ok) return;
              const data = await res.json();
              if (data && data.success === 1 && data.username) {
                usernameInput.value = data.username;
              }
            } catch (e) {}
          });
        }
      })();
    </script>
</body>

</html>
