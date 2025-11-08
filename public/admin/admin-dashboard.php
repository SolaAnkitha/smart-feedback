<?php
session_start();

// ✅ Only admin allowed
if (!isset($_SESSION['email']) || $_SESSION['email'] !== 'admin@example.com') {
    echo "<script>alert('Access denied. Admins only.'); window.location.href='../dashboard.php';</script>";
    exit();
}

require_once '../../backend/db.php';

// ✅ Category breakdown
$cat_result = $conn->query("SELECT category, COUNT(*) as count FROM feedbacks GROUP BY category");
$cat_labels = $cat_counts = [];
while ($row = $cat_result->fetch_assoc()) {
    $cat_labels[] = $row['category'];
    $cat_counts[] = $row['count'];
}

// ✅ Rating breakdown
$rating_result = $conn->query("SELECT rating, COUNT(*) as count FROM feedbacks GROUP BY rating");
$rating_labels = $rating_counts = [];
while ($row = $rating_result->fetch_assoc()) {
    $rating_labels[] = "Rating " . $row['rating'];
    $rating_counts[] = $row['count'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard - Smart Feedback</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
  <link rel="stylesheet" href="../../assets/style.css" />
</head>
<body>

  <nav class="navbar navbar-dark bg-dark">
    <div class="container">
      <span class="navbar-brand">📊 Admin Dashboard</span>
      <a href="../dashboard.php" class="btn btn-light btn-sm">← Back to Dashboard</a>
    </div>
  </nav>

  <div class="container mt-5">
    <h3 class="text-center mb-4">Smart Feedback System - Admin Overview</h3>

    <div class="mb-5">
      <h5 class="text-center">Feedback by Category</h5>
      <canvas id="catChart" height="150"></canvas>
    </div>

    <div class="mb-5">
      <h5 class="text-center">Rating Distribution</h5>
      <canvas id="ratingChart" height="150"></canvas>
    </div>
  </div>

  <footer class="text-center mt-5 mb-3">
    <p>© 2025 Smart Feedback System</p>
  </footer>

  <script>
    const catChart = new Chart(document.getElementById('catChart'), {
      type: 'bar',
      data: {
        labels: <?= json_encode($cat_labels) ?>,
        datasets: [{
          label: 'Category-wise Feedback',
          data: <?= json_encode($cat_counts) ?>,
          backgroundColor: 'rgba(54, 162, 235, 0.6)',
          borderColor: 'rgba(54, 162, 235, 1)',
          borderWidth: 1
        }]
      },
      options: {
        responsive: true,
        scales: {
          y: { beginAtZero: true }
        }
      }
    });

    const ratingChart = new Chart(document.getElementById('ratingChart'), {
      type: 'pie',
      data: {
        labels: <?= json_encode($rating_labels) ?>,
        datasets: [{
          label: 'Rating Count',
          data: <?= json_encode($rating_counts) ?>,
          backgroundColor: ['#ff4c4c', '#ffa500', '#ffe600', '#9acd32', '#00bfff']
        }]
      },
      options: {
        responsive: true
      }
    });
  </script>
</body>
</html>
