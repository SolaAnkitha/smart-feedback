<?php
session_start();
if (!isset($_SESSION['email']) || $_SESSION['email'] !== 'admin@example.com') {
  echo "<script>alert('Access Denied. Admins only.'); window.location.href='../dashboard.php';</script>";
  exit();
}
require_once '../../backend/db.php';

$sentiment = $_GET['sentiment'] ?? 'all';
$category = $_GET['category'] ?? 'all';

$query = "SELECT u.name, u.email, f.category, f.rating, f.sentiment, f.comment, f.created_at
          FROM feedbacks f
          JOIN users u ON f.user_id = u.id WHERE 1=1";

if ($sentiment !== 'all') {
  $query .= " AND f.sentiment = '" . $conn->real_escape_string($sentiment) . "'";
}
if ($category !== 'all') {
  $query .= " AND f.category = '" . $conn->real_escape_string($category) . "'";
}

$query .= " ORDER BY f.created_at DESC";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Filtered Feedbacks - Admin</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
  <link rel="stylesheet" href="../../assets/style.css" />
</head>
<body>

<nav class="navbar navbar-dark bg-dark">
  <div class="container">
    <span class="navbar-brand">🔍 Filtered Feedbacks</span>
    <a href="admin-dashboard.php" class="btn btn-light btn-sm">← Back to Dashboard</a>
  </div>
</nav>

<div class="container mt-4 mb-5">
  <h4 class="mb-3">Feedback Filter</h4>
  <form class="form-inline mb-3" method="GET">
    <label class="mr-2">Sentiment:</label>
    <select name="sentiment" class="form-control mr-3">
      <option value="all" <?= $sentiment === 'all' ? 'selected' : '' ?>>All</option>
      <option value="positive" <?= $sentiment === 'positive' ? 'selected' : '' ?>>Positive</option>
      <option value="neutral" <?= $sentiment === 'neutral' ? 'selected' : '' ?>>Neutral</option>
      <option value="negative" <?= $sentiment === 'negative' ? 'selected' : '' ?>>Negative</option>
    </select>

    <label class="mr-2">Category:</label>
    <select name="category" class="form-control mr-3">
      <option value="all" <?= $category === 'all' ? 'selected' : '' ?>>All</option>
      <option value="Website" <?= $category === 'Website' ? 'selected' : '' ?>>Website</option>
      <option value="Service" <?= $category === 'Service' ? 'selected' : '' ?>>Service</option>
      <option value="Support" <?= $category === 'Support' ? 'selected' : '' ?>>Support</option>
      <option value="Other" <?= $category === 'Other' ? 'selected' : '' ?>>Other</option>
    </select>

    <button type="submit" class="btn btn-primary">Apply Filter</button>
  </form>

  <?php if ($result->num_rows > 0): ?>
    <table class="table table-bordered table-striped">
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
  <?php else: ?>
    <p>No feedbacks found for selected filters.</p>
  <?php endif; ?>
</div>

<footer class="text-center mt-4 mb-3">
  <p>© 2025 Smart Feedback System</p>
</footer>

</body>
</html>
