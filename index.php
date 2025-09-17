<?php
session_start();
require 'db.php';

$error = "";
$success = "";

// ================== REGISTER ==================
if (isset($_POST['register'])) {
    $name     = trim($_POST['name']);
    $email    = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (!empty($name) && !empty($email) && !empty($password)) {
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        if (!$stmt) { die("Prepare failed: " . $conn->error); }
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $error = "Email already exists.";
        } else {
            // Insert user in plain text password
            $stmt = $conn->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, 'customer')");
            if (!$stmt) { die("Prepare failed: " . $conn->error); }
            $stmt->bind_param("sss", $name, $email, $password);
            if ($stmt->execute()) {
                $success = "Registration successful. Please login.";
            } else {
                $error = "Registration failed: " . $stmt->error;
            }
        }
    } else {
        $error = "All fields are required.";
    }
}

// ================== LOGIN ==================
if (isset($_POST['login'])) {
    $email    = trim($_POST['email']);
    $password = trim($_POST['password']);

    $stmt = $conn->prepare("SELECT id, name, password, role FROM users WHERE email = ?");
    if (!$stmt) { die("Prepare failed: " . $conn->error); }
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($id, $name, $dbPassword, $role);

    if ($stmt->fetch()) {
        // Plain text comparison
        if ($password === $dbPassword) {
            $_SESSION['user'] = [
                'id'   => $id,
                'name' => $name,
                'role' => $role
            ];
            if ($role === 'admin') {
                header("Location: adminpanel.php");
            } else {
                header("Location: home.php");
            }
            exit;
        } else {
            $error = "Invalid email or password.";
        }
    } else {
        $error = "Invalid email or password.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>C MOTOR PARTS - Login & Register</title>
<link rel="stylesheet" href="css/index.css">
</head>
<body>
<div class="container">
    <?php if ($error): ?>
        <div class="error-box"><?= $error ?></div>
    <?php endif; ?>
    <?php if ($success): ?>
        <div class="success-box"><?= $success ?></div>
    <?php endif; ?>

    <!-- Login Form -->
    <form method="post" class="form">
        <h2>LOGIN</h2>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit" name="login">Login</button>
    </form>

    <!-- Register Form -->
    <form method="post" class="form">
        <h2>REGISTER</h2>
        <input type="text" name="name" placeholder="Full Name" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit" name="register">Register</button>
    </form>
</div>
</body>
</html>
