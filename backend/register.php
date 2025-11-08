<?php
session_start();
require_once 'db.php'; // db.php is in same backend folder

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name  = trim($_POST['name']);
    $email = trim($_POST['email']);
    $pass  = password_hash(trim($_POST['password']), PASSWORD_DEFAULT);

    // Check if email already exists
    $check = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        echo "<script>alert('❌ Email already registered. Please log in.'); window.location.href='../public/index.html';</script>";
        exit();
    }

    // Insert user (unverified)
    $stmt = $conn->prepare("INSERT INTO users (name, email, password, is_verified) VALUES (?, ?, ?, 0)");
    $stmt->bind_param("sss", $name, $email, $pass);

    if ($stmt->execute()) {
        $user_id = $conn->insert_id;

        // Generate OTP
        $otp = rand(100000, 999999);
        $_SESSION['otp_user'] = [
            'user_id' => $user_id,
            'otp'     => $otp,
            'expires' => time() + 300
        ];

        // ✅ Redirect to OTP page inside public/
        echo "<script>
            alert('🔐 OTP for verification: $otp');
            window.location.href='../public/verify-otp.php';
        </script>";
        exit();
    } else {
        echo "<script>alert('❌ Registration failed. Please try again.'); window.location.href='../public/signup.html';</script>";
    }
}
?>
