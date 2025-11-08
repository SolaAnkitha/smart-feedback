<?php
session_start();

// ✅ Check if user is logged in
if (!isset($_SESSION['email']) || !isset($_SESSION['user_name'])) {
    header("Location: index.html");
    exit();
}

// ✅ Use role for conditional display (default to 'user')
$role = $_SESSION['role'] ?? 'user';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Dashboard - Smart Feedback Analyzer</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <!-- Bootstrap & Custom CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
  <link rel="stylesheet" href="../assets/style.css" />
  <style>
    .page-container {
      min-height: 70vh;
      display: flex;
      justify-content: center;
      align-items: center;
    }
    .form-box {
      background-color: #fff;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 4px 15px rgba(0,0,0,0.1);
      max-width: 500px;
      width: 100%;
    }
    .btn-block + .btn-block {
      margin-top: 10px;
    }
  </style>
</head>
<body>

  <!-- Navbar -->
  <nav class="navbar navbar-dark bg-success">
    <div class="container d-flex justify-content-between align-items-center">
      <span class="navbar-brand font-weight-bold">📊 Dashboard</span>
      <span class="text-white">Welcome, <?= htmlspecialchars($_SESSION['user_name']) ?>!</span>
      <a href="../backend/auth.php?action=logout" class="btn btn-light btn-sm">Logout</a>
    </div>
  </nav>

  <!-- Dashboard Options -->
  <div class="page-container">
    <div class="form-box text-center">
      <h4 class="mb-4">What would you like to do?</h4>

      <!-- Common: Submit Feedback -->
      <a href="feedback.html" class="btn btn-primary btn-block">📩 Submit Feedback</a>

      <!-- Admin Dashboard Shortcuts -->
      <?php if ($role === 'admin'): ?>
        <a href="admin/view-feedbacks.php" class="btn btn-outline-primary btn-block">📝 View All Feedbacks</a>
        <a href="admin/admin-dashboard.php" class="btn btn-outline-success btn-block">📊 Basic Charts</a>
        <a href="admin/emotion-insights.php" class="btn btn-outline-info btn-block">🧠 Sentiment Insights</a>
        <a href="admin/filtered-feedbacks.php" class="btn btn-outline-dark btn-block">🔍 Filtered Feedbacks</a>
      <?php else: ?>
        <a href="my-feedbacks.php" class="btn btn-outline-secondary btn-block">📋 View My Feedbacks</a>
      <?php endif; ?>

    </div>
  </div>

  <!-- Footer -->
  <footer class="text-center mt-5">
    <p>© 2025 Smart Feedback System</p>
  </footer>

</body>
</html>
