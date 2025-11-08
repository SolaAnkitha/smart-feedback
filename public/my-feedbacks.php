<?php
session_start();

// Check if user is logged in and not admin
if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] == 0) {
    echo "<script>alert('Login required.'); window.location.href='index.html';</script>";
    exit();
}

require_once '../backend/db.php';

$user_id = $_SESSION['user_id'];

$query = "SELECT category, rating, sentiment, comment, created_at FROM feedbacks WHERE user_id = ? ORDER BY created_at DESC";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>My Feedbacks</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="../assets/style.css">
</head>
<body>

<nav class="navbar navbar-dark bg-primary">
  <div class="container d-flex justify-content-between">
    <span class="navbar-brand">📋 My Feedbacks</span>
    <a href="dashboard.php" class="btn btn-light btn-sm">← Back to Dashboard</a>
  </div>
</nav>

<div class="container mt-5 mb-5">
  <h4 class="text-center mb-4">Your Submitted Feedback</h4>

  <?php if ($result->num_rows > 0): ?>
    <div class="table-responsive">
      <table class="table table-bordered table-striped">
        <thead class="thead-dark">
          <tr>
            <th>Category</th>
            <th>Rating</th>
            <th>Sentiment</th>
            <th>Comment</th>
            <th>Date</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
              <td><?= htmlspecialchars($row['category']) ?></td>
              <td><?= $row['rating'] ?></td>
              <td>
                <span class="badge badge-<?= $row['sentiment'] === 'positive' ? 'success' : ($row['sentiment'] === 'negative' ? 'danger' : 'secondary') ?>">
                  <?= ucfirst($row['sentiment']) ?>
                </span>
              </td>
              <td><?= htmlspecialchars($row['comment']) ?></td>
              <td><?= $row['created_at'] ?></td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  <?php else: ?>
    <div class="alert alert-info text-center">You haven't submitted any feedback yet.</div>
  <?php endif; ?>
</div>

<footer class="text-center mt-5 mb-3">
  <p>© 2025 Smart Feedback System</p>
</footer>

</body>
</html>
