<?php
session_start();

// ✅ Only admin should access
if (!isset($_SESSION['email']) || $_SESSION['email'] !== 'admin@example.com') {
    echo "<script>alert('Access denied.'); window.location.href='../dashboard.php';</script>";
    exit();
}

require_once '../../backend/db.php';

// ✅ Stats
$total    = $conn->query("SELECT COUNT(*) AS total FROM feedbacks")->fetch_assoc()['total'];
$positive = $conn->query("SELECT COUNT(*) AS count FROM feedbacks WHERE sentiment = 'positive'")->fetch_assoc()['count'];
$negative = $conn->query("SELECT COUNT(*) AS count FROM feedbacks WHERE sentiment = 'negative'")->fetch_assoc()['count'];
$neutral  = $conn->query("SELECT COUNT(*) AS count FROM feedbacks WHERE sentiment = 'neutral'")->fetch_assoc()['count'];
$avg_rating = $conn->query("SELECT AVG(rating) AS avg FROM feedbacks")->fetch_assoc()['avg'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Emotion Insights - Admin</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
  <link rel="stylesheet" href="../../assets/style.css" />
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

<nav class="navbar navbar-dark bg-dark">
  <div class="container">
    <span class="navbar-brand">🧠 Sentiment Insights</span>
    <a href="admin-dashboard.php" class="btn btn-light btn-sm">← Back to Dashboard</a>
  </div>
</nav>

<div class="container mt-4">
  <!-- Summary -->
  <div class="row text-center mb-4">
    <div class="col-md-3"><div class="alert alert-primary">Total Feedbacks<br><strong><?= $total ?></strong></div></div>
    <div class="col-md-3"><div class="alert alert-success">Positive<br><strong><?= $positive ?></strong></div></div>
    <div class="col-md-3"><div class="alert alert-warning">Neutral<br><strong><?= $neutral ?></strong></div></div>
    <div class="col-md-3"><div class="alert alert-danger">Negative<br><strong><?= $negative ?></strong></div></div>
  </div>

  <div class="row mb-5">
    <div class="col-md-6">
      <h5 class="text-center">Sentiment Pie</h5>
      <canvas id="sentimentChart" height="200"></canvas>
    </div>
    <div class="col-md-6">
      <h5 class="text-center">Average Rating</h5>
      <div class="alert alert-info text-center" style="font-size: 1.5rem;">
        ⭐ <?= number_format($avg_rating, 2) ?> / 5.00
      </div>
    </div>
  </div>
</div>

<footer class="text-center mt-5">
  <p>© 2025 Smart Feedback System</p>
</footer>

<script>
  const sentimentChart = new Chart(document.getElementById('sentimentChart'), {
    type: 'doughnut',
    data: {
      labels: ['Positive', 'Neutral', 'Negative'],
      datasets: [{
        data: [<?= $positive ?>, <?= $neutral ?>, <?= $negative ?>],
        backgroundColor: [
          'rgba(40, 167, 69, 0.7)',  // green
          'rgba(255, 193, 7, 0.7)',  // yellow
          'rgba(220, 53, 69, 0.7)'   // red
        ],
        borderColor: [
          'rgba(40, 167, 69, 1)',
          'rgba(255, 193, 7, 1)',
          'rgba(220, 53, 69, 1)'
        ],
        borderWidth: 1
      }]
    },
    options: {
      responsive: true
    }
  });
</script>

</body>
</html>
