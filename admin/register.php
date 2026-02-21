<?php
session_start();
include_once("configs/db_config.php");
include_once(__DIR__ . "/configs/config.php");
$register_error = "";
$register_success = "";
$roles = [];
try {
    $res = $db->query("SELECT id,name FROM {$tx}roles ORDER BY name ASC");
    while ($r = $res->fetch_assoc()) {
        $roles[] = $r;
    }
} catch (Throwable $e) {}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $confirm = trim($_POST['confirm'] ?? '');
    $role_id = intval($_POST['role_id'] ?? 0);

    if ($name === '' || $email === '' || $password === '' || $confirm === '' || $role_id <= 0) {
        $register_error = "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $register_error = "Invalid email address.";
    } elseif ($password !== $confirm) {
        $register_error = "Passwords do not match.";
    } else {
        $stmt = $db->prepare("SELECT id FROM {$tx}users WHERE name=? OR email=? LIMIT 1");
        $stmt->bind_param("ss", $name, $email);
        $stmt->execute();
        $dup = $stmt->get_result();
        if ($dup->num_rows > 0) {
            $register_error = "User already exists.";
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $ins = $db->prepare("INSERT INTO {$tx}users (name,email,password,role_id,status) VALUES (?,?,?,?,?)");
            $status = "Active";
            $ins->bind_param("sssis", $name, $email, $hash, $role_id, $status);
            if ($ins->execute()) {
                $register_success = "Registration successful. You can now login.";
            } else {
                $register_error = "Registration failed.";
            }
            $ins->close();
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | NextPrime Limited</title>
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
    body::before { background: #7c3aed; top: -60px; left: -60px; }
    body::after { background: #06b6d4; bottom: -60px; right: -60px; animation-delay: 1.8s; }
    .bg-hrms {
        position: absolute;
        inset: 0;
        pointer-events: none;
        opacity: 0.35;
        mix-blend-mode: soft-light;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='320' height='320' viewBox='0 0 320 320'%3E%3Crect width='320' height='320' fill='none'/%3E%3Cg fill='none' stroke='rgba(255,255,255,0.15)' stroke-width='1'%3E%3Cpath d='M0 0h320M0 64h320M0 128h320M0 192h320M0 256h320'/%3E%3Cpath d='M0 0v320M64 0v320M128 0v320M192 0v320M256 0v320'/%3E%3C/g%3E%3Cg fill='rgba(255,255,255,0.14)'%3E%3Ctext x='20' y='34' font-size='14' font-family='Poppins,Arial'>HRMS%3C/text%3E%3Ctext x='92' y='98' font-size='14' font-family='Poppins,Arial'>PAYROLL%3C/text%3E%3Ccircle cx='204' cy='60' r='6'/%3E%3Crect x='246' y='206' width='12' height='12' rx='3'/%3E%3Ctext x='30' y='220' font-size='12' font-family='Poppins,Arial'>EMPLOYEE%3C/text%3E%3Ctext x='180' y='280' font-size='12' font-family='Poppins,Arial'>SALARY%3C/text%3E%3C/g%3E%3C/svg%3E");
        background-size: 320px 320px;
    }
    .login-card {
        background: rgba(255, 255, 255, 0.9);
        border-radius: 18px;
        padding: 24px 26px;
        max-width: 400px;
        width: 100%;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.35);
        text-align: center;
        position: relative;
        z-index: 1;
        transition: transform 0.25s ease, box-shadow 0.25s ease;
    }
    .login-card:hover { transform: translateY(-2px); box-shadow: 0 26px 56px rgba(0, 0, 0, 0.28); }
    .login-card img { width: 150px; margin-bottom: 12px; }
    .login-card h4 { font-weight: 700; margin-bottom: 4px; }
    .brand-subtitle { color: #666; font-size: 13px; margin-bottom: 16px; }
    .form-group { position: relative; margin-bottom: 14px; }
    .form-control {
        padding-left: 36px;
        height: 40px;
        border-radius: 10px;
        font-size: 14px;
        background: rgba(255, 255, 255, 0.85);
        border: 1px solid rgba(0, 0, 0, 0.08);
        transition: box-shadow 0.2s ease, border-color 0.2s ease;
    }
    .form-select {
        padding-left: 36px;
        height: 40px;
        border-radius: 10px;
        font-size: 14px;
        background: rgba(255, 255, 255, 0.85);
        border: 1px solid rgba(0, 0, 0, 0.08);
        transition: box-shadow 0.2s ease, border-color 0.2s ease;
    }
    .form-control::placeholder { color: #9aa3b2; }
    .form-control:focus, .form-select:focus {
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
    .form-group:focus-within i { color: #7c3aed; }
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
    .toggle-password:hover { background: rgba(0, 0, 0, 0.06); color: #111827; }
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
    .btn-primary:hover { background: linear-gradient(to right, #5a67d8, #6b46c1); }
    .login-card a { color: #764ba2; text-decoration: none; font-weight: 500; }
    .login-card a:hover { text-decoration: underline; }
    .alert { font-size: 12px; padding: 6px 10px; border-radius: 6px; }
    .form-footnote { font-size: 12px; }
    @keyframes float { 0% { transform: translateY(0) translateX(0); } 50% { transform: translateY(18px) translateX(-12px); } 100% { transform: translateY(0) translateX(0); } }
    </style>
</head>
<body>
    <div class="bg-hrms"></div>
    <div class="login-card">
        <a href="home" aria-label="Go to Dashboard">
            <img src="assets/images/nextprime-logo-pro.svg" alt="NextPrime Logo">
        </a>
        <!-- <h4>NextPrime Limited</h4> -->
        <p class="brand-subtitle">Create your account to access HRMS & Payroll</p>

        <?php if (!empty($register_error)) : ?>
        <div class="alert alert-danger"><?= htmlspecialchars($register_error) ?></div>
        <?php endif; ?>
        <?php if (!empty($register_success)) : ?>
        <div class="alert alert-success"><?= htmlspecialchars($register_success) ?></div>
        <?php endif; ?>

        <form method="post">
            <div class="form-group">
                <i class="fas fa-user"></i>
                <input type="text" name="name" class="form-control" placeholder="Full Name" required>
            </div>
            <div class="form-group">
                <i class="fas fa-envelope"></i>
                <input type="email" name="email" class="form-control" placeholder="Email" required>
            </div>
            <div class="form-group">
                <i class="fas fa-user-shield"></i>
                <select name="role_id" class="form-select" required>
                    <option value="" disabled selected>Select Role</option>
                    <?php foreach ($roles as $role): ?>
                        <option value="<?= intval($role['id']) ?>"><?= htmlspecialchars($role['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <i class="fas fa-lock"></i>
                <input type="password" name="password" class="form-control" placeholder="Password" required>
                <button type="button" class="toggle-password" data-target="password" aria-label="Toggle password visibility">
                    <i class="far fa-eye"></i>
                </button>
            </div>
            <div class="form-group">
                <i class="fas fa-lock"></i>
                <input type="password" name="confirm" class="form-control" placeholder="Confirm Password" required>
                <button type="button" class="toggle-password" data-target="confirm" aria-label="Toggle password visibility">
                    <i class="far fa-eye"></i>
                </button>
            </div>
            <button type="submit" class="btn btn-primary">Create Account</button>
            <p class="mt-2 text-muted form-footnote">Already have an account? <a href="index.php">Login</a></p>
        </form>
    </div>
    <script>
    (function () {
        document.querySelectorAll('.toggle-password').forEach(function(btn){
            btn.addEventListener('click', function(){
                var target = btn.getAttribute('data-target');
                var input = document.querySelector('input[name="'+target+'"]');
                if (!input) return;
                var icon = btn.querySelector('i');
                if (input.type === 'password') {
                    input.type = 'text';
                    if (icon) { icon.classList.remove('fa-eye'); icon.classList.add('fa-eye-slash'); }
                } else {
                    input.type = 'password';
                    if (icon) { icon.classList.remove('fa-eye-slash'); icon.classList.add('fa-eye'); }
                }
            });
        });
    })();
    </script>
</body>
</html>
