<?php
session_start();
require_once '../backend/db.php';

if (!isset($_SESSION['otp_user'])) {
    echo "<script>alert('⏳ Session expired. Please register again.'); window.location.href='signup.html';</script>";
    exit();
}

$error = '';
$otp_data = $_SESSION['otp_user'];

// Handle resend
if (isset($_GET['resend'])) {
    $_SESSION['otp_user']['otp'] = rand(100000, 999999);
    $_SESSION['otp_user']['expires'] = time() + 300;
    echo "<script>alert('🔁 New OTP: {$_SESSION['otp_user']['otp']}'); window.location.href='verify-otp.php';</script>";
    exit();
}

// Handle verify
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $entered = trim($_POST['otp']);
    $expected = $otp_data['otp'];
    $expired = time() > $otp_data['expires'];

    if ($expired) {
        $error = "⏰ OTP expired. Please resend.";
    } elseif ($entered == $expected) {
        $uid = $otp_data['user_id'];
        $conn->query("UPDATE users SET is_verified = 1 WHERE id = $uid");

        unset($_SESSION['otp_user']);

        echo "<script>alert('✅ Email verified successfully! Please log in.'); window.location.href='index.html';</script>";
        exit();
    } else {
        $error = "❌ Incorrect OTP. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Verify OTP - Smart Feedback Analyzer</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
</head>
<body style="background:#f5f7fa;">
  <div class="container mt-5">
    <div class="card mx-auto shadow-lg" style="max-width:420px;">
      <div class="card-body">
        <h4 class="text-center text-primary mb-3">🔐 Verify Your Email</h4>

        <?php if ($error): ?>
          <div class="alert alert-danger text-center"><?= $error ?></div>
        <?php endif; ?>

        <div class="alert alert-info text-center">
          Demo OTP: <strong><?= $_SESSION['otp_user']['otp'] ?></strong><br>
          <small>Expires in <span id="countdown">300</span> seconds</small>
        </div>

        <form method="POST">
          <input type="text" name="otp" maxlength="6" class="form-control mb-3" placeholder="Enter OTP" required />
          <button class="btn btn-success btn-block">✅ Verify</button>
        </form>

        <div class="text-center mt-3">
          <a href="?resend=1" class="btn btn-link">🔁 Resend OTP</a>
        </div>
      </div>
    </div>
  </div>

  <script>
    let timeLeft = <?= $_SESSION['otp_user']['expires'] - time() ?>;
    const c = document.getElementById("countdown");
    const timer = setInterval(() => {
      if (timeLeft <= 0) {
        c.innerText = "expired";
        clearInterval(timer);
      } else {
        c.innerText = timeLeft--;
      }
    }, 1000);
  </script>
</body>
</html>
