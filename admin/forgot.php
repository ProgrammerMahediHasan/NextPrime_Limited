<?php
session_start();
include_once(__DIR__ . "/configs/db_config.php");
include_once(__DIR__ . "/configs/config.php");

$mode = isset($_GET['token']) ? 'reset' : 'request';
$message = "";
$error = "";

// Ensure password_resets table exists
try {
    $db->query("
        CREATE TABLE IF NOT EXISTS {$tx}password_resets (
            id INT AUTO_INCREMENT PRIMARY KEY,
            user_id INT NOT NULL,
            token VARCHAR(64) NOT NULL,
            expires_at DATETIME NOT NULL,
            created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
            INDEX(user_id),
            INDEX(token)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
    ");
} catch (Throwable $e) {}

function generateToken() {
    return bin2hex(random_bytes(32));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($mode === 'request') {
        $identifier = trim($_POST['identifier'] ?? '');
        if ($identifier === '') {
            $error = "Please enter your username or email.";
        } else {
            $stmt = $db->prepare("SELECT id, name, email FROM {$tx}users WHERE (name = ? OR email = ?) AND status='Active' LIMIT 1");
            $stmt->bind_param("ss", $identifier, $identifier);
            $stmt->execute();
            $res = $stmt->get_result();
            if ($res->num_rows === 1) {
                $u = $res->fetch_assoc();
                $token = generateToken();
                $expires = date("Y-m-d H:i:s", time() + 1800); // 30 minutes
                $ins = $db->prepare("INSERT INTO {$tx}password_resets (user_id, token, expires_at) VALUES (?,?,?)");
                $ins->bind_param("iss", $u['id'], $token, $expires);
                $ins->execute();
                $reset_link = "{$base_url}/forgot.php?token={$token}";
                $message = "Password reset link has been generated.";
                $message .= " For testing, use this link: <a href=\"{$reset_link}\">Reset Password</a>";
            } else {
                $message = "If the account exists, a reset link has been generated.";
            }
            $stmt->close();
        }
    } else if ($mode === 'reset') {
        $token = $_GET['token'] ?? '';
        $pwd = trim($_POST['password'] ?? '');
        $confirm = trim($_POST['confirm'] ?? '');
        if ($pwd === '' || $confirm === '') {
            $error = "Please enter and confirm new password.";
        } elseif (strlen($pwd) < 6) {
            $error = "Password must be at least 6 characters.";
        } elseif ($pwd !== $confirm) {
            $error = "Passwords do not match.";
        } else {
            $stmt = $db->prepare("SELECT user_id, expires_at FROM {$tx}password_resets WHERE token = ? LIMIT 1");
            $stmt->bind_param("s", $token);
            $stmt->execute();
            $res = $stmt->get_result();
            if ($res->num_rows === 1) {
                $row = $res->fetch_assoc();
                if (strtotime($row['expires_at']) < time()) {
                    $error = "Reset link has expired. Please request again.";
                } else {
                    $hash = password_hash($pwd, PASSWORD_DEFAULT);
                    $uid = intval($row['user_id']);
                    $up = $db->prepare("UPDATE {$tx}users SET password=? WHERE id=?");
                    $up->bind_param("si", $hash, $uid);
                    $up->execute();
                    $db->query("DELETE FROM {$tx}password_resets WHERE user_id={$uid}");
                    $message = "Password updated successfully. You can now login.";
                }
            } else {
                $error = "Invalid reset token.";
            }
            $stmt->close();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $mode === 'reset' ? 'Reset Password' : 'Forgot Password' ?> | NextPrime</title>
  <base href="<?= $base_url ?>/">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
        margin:0; padding:0; min-height:100vh;
        background: linear-gradient(135deg, #667eea, #764ba2);
        display:flex; justify-content:center; align-items:center;
        font-family:'Poppins', sans-serif;
    }
    .card {
        background: rgba(255,255,255,0.92);
        border-radius: 16px;
        padding: 22px 24px;
        width: 360px;
        box-shadow: 0 20px 40px rgba(0,0,0,0.2);
        text-align: center;
    }
    .form-group { position:relative; margin-bottom:14px; }
    .form-control {
        padding-left:36px; height:40px; border-radius:10px;
        font-size:14px; background:rgba(255,255,255,0.9);
    }
    .form-group i { position:absolute; top:11px; left:12px; color:#9aa3b2; }
    .btn-primary {
        background: linear-gradient(to right, #667eea, #764ba2);
        border:none; width:100%; padding:11px; border-radius:12px; font-weight:bold;
    }
    .small-link a { color:#764ba2; text-decoration:none; }
    .small-link a:hover { text-decoration:underline; }
  </style>
</head>
<body>
  <div class="card">
    <img src="assets/images/nextprime-logo-pro.svg" alt="NextPrime" style="width:140px; margin-bottom:10px;">
    <h5><?= $mode === 'reset' ? 'Reset Password' : 'Forgot Password' ?></h5>
    <p class="text-muted"><?= $mode === 'reset' ? 'Set a new password for your account' : 'Enter your username or email to receive a reset link' ?></p>

    <?php if(!empty($error)): ?>
      <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <?php if(!empty($message)): ?>
      <div class="alert alert-success"><?= $message ?></div>
    <?php endif; ?>

    <form method="post">
      <?php if($mode === 'request'): ?>
        <div class="form-group">
          <i class="fas fa-user"></i>
          <input type="text" name="identifier" class="form-control" placeholder="Username or Email" required>
        </div>
        <button type="submit" class="btn btn-primary">Send Reset Link</button>
        <div class="small-link mt-2"><a href="index.php">Back to Login</a></div>
      <?php else: ?>
        <div class="form-group">
          <i class="fas fa-lock"></i>
          <input type="password" name="password" class="form-control" placeholder="New Password" required>
        </div>
        <div class="form-group">
          <i class="fas fa-lock"></i>
          <input type="password" name="confirm" class="form-control" placeholder="Confirm Password" required>
        </div>
        <button type="submit" class="btn btn-primary">Update Password</button>
        <div class="small-link mt-2"><a href="index.php">Back to Login</a></div>
      <?php endif; ?>
    </form>
  </div>
</body>
</html>
