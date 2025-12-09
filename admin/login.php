<?php
session_start();
require "db.php"; // koneksi DB

if (isset($_POST['login'])) {

    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // prepared statement untuk keamanan
    $stmt = $conn->prepare("SELECT id, username, password_hash, role FROM admin_users WHERE username = ? LIMIT 1");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {

        $admin = $result->fetch_assoc();

        if (password_verify($password, $admin['password_hash'])) {

            // SET SESSION LENGKAP
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_username'] = $admin['username'];
            $_SESSION['admin_role'] = $admin['role'];

            header("Location: dashboard.php");
            exit;
        }
    }

    $error = "Username atau password salah!";
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #3b82f6, #1e3a8a);
            font-family: Arial, sans-serif;
            margin: 0;
        }

        .login-card {
            width: 380px;
            padding: 35px;
            border-radius: 15px;
            background: rgba(255, 255, 255, 0.12);
            backdrop-filter: blur(15px);
            color: white;
            box-shadow: 0 8px 25px rgba(0,0,0,0.25);
            animation: fadeIn .5s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .login-card input {
            background: rgba(255,255,255,0.2);
            color: white;
            border: none;
        }

        .login-card input::placeholder {
            color: #eee;
        }

        .login-card input:focus {
            outline: 2px solid #60a5fa;
            box-shadow: none;
        }

        .btn-primary {
            background: #1d4ed8;
            border: none;
        }
        .btn-primary:hover {
            background: #2563eb;
        }
    </style>
</head>
<body>

<div class="login-card">
    <h3 class="text-center mb-4">🔐 Admin Login</h3>

    <?php if (isset($error)) : ?>
        <div class="alert alert-danger py-2"><?= $error ?></div>
    <?php endif; ?>

    <form method="POST">
        <label>Username</label>
        <input type="text" class="form-control mb-3" name="username" required>

        <label>Password</label>
        <input type="password" class="form-control mb-4" name="password" required>

        <button class="btn btn-primary w-100 py-2" name="login">Login</button>
    </form>
</div>

</body>
</html>
