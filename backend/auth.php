<?php
session_start();
require_once 'db.php';

if (isset($_GET['action'])) {
    $action = $_GET['action'];

    // LOGIN
    if ($action === 'login' && $_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = trim($_POST['email']);
        $pass  = trim($_POST['pass']);

        // Admin shortcut (optional)
        if ($email === 'admin@example.com' && $pass === 'admin123') {
            $_SESSION['email']     = $email;
            $_SESSION['user_name'] = 'Admin';
            $_SESSION['user_id']   = 0;
            $_SESSION['role']      = 'admin';
            header("Location: ../public/dashboard.php");
            exit();
        }

        // Check if user exists
        $stmt = $conn->prepare("SELECT id, name, password, is_verified, role FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($id, $name, $hashed_password, $is_verified, $role);
            $stmt->fetch();

            if ($is_verified != 1) {
                echo "<script>alert('❌ Account not verified. Please check your email for OTP.'); window.location.href='../public/index.html';</script>";
                exit();
            }

            if (password_verify($pass, $hashed_password)) {
                $_SESSION['email']     = $email;
                $_SESSION['user_name'] = $name;
                $_SESSION['user_id']   = $id;
                $_SESSION['role']      = $role; // Store role in session

                header("Location: ../public/dashboard.php");
                exit();
            } else {
                echo "<script>alert('❌ Wrong password.'); window.location.href='../public/index.html';</script>";
                exit();
            }
        } else {
            echo "<script>alert('❌ Email not registered.'); window.location.href='../public/index.html';</script>";
            exit();
        }
    }

    // LOGOUT
    if ($action === 'logout') {
        session_destroy();
        header("Location: ../public/index.html");
        exit();
    }
}
?>
