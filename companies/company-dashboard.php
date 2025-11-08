<?php
session_start();

// ✅ Only company users allowed
if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] == 0 || $_SESSION['role'] !== 'company') {
    echo "<script>alert('Access denied. Company login required.'); window.location.href='../public/index.html';</script>";
    exit();
}

require_once '../backend/db.php';

$company_id = $_SESSION['company_id'];

// ✅ Get company details
$company = $conn->query("SELECT * FROM companies WHERE id = $company_id")->fetch_assoc();

// ✅ Get feedbacks from users in this company
$sql = "SELECT u.name, u.email, f.category, f.rating, f.sentiment, f.comment, f.created_at
        FROM feedbacks f
        JOIN users u ON f.user_id = u.id
        WHERE u.company_id = $company_id
        ORDER BY f.created_at DESC";

$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title><?= htmlspecialchars($company['name']) ?> - Company Dashboard</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="../assets/style.css" />
</head>
<body>
<nav class="navbar navbar-dark bg-dark">
  <div class="container">
    <span class="navbar-brand">🏢 <?= htmlspecialchars($company['name']) ?> Feedback Dashboard</span>
    <a href="../public/dashboard.php" class="btn btn-light btn-sm">← Back to Dashboard</a>
  </div>
</nav>

<div class="container mt-4">
  <div class="mb-4">
    <h4><?= htmlspecialchars($company['name']) ?> - Feedback Overview</h4>
    <p><?= htmlspecialchars($company['description']) ?></p>
  </div>

  <div class="table-responsive">
    <table class="table table-striped table-bordered">
      <thead class="thead-dark">
        <tr>
          <th>Name</th>
          <th>Email</th>
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
            <td><?= htmlspecialchars($row['name']) ?></td>
            <td><?= htmlspecialchars($row['email']) ?></td>
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
</div>

<footer class="text-center mt-5 mb-3">
  <p>© 2025 Smart Feedback System</p>
</footer>
</body>
</html>
