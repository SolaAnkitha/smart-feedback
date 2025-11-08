<?php
session_start();

// ✅ Admin-only access
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    echo "<script>alert('Admins only.'); window.location.href='../dashboard.php';</script>";
    exit();
}

require_once '../../backend/db.php';

// ✅ Handle delete confirmation message
$deleted = $_GET['deleted'] ?? null;

// ✅ Fetch all feedbacks (including guest ones)
$sql = "SELECT f.id, f.category, f.rating, f.sentiment, f.comment, f.created_at,
               u.name, u.email
        FROM feedbacks f
        LEFT JOIN users u ON f.user_id = u.id
        ORDER BY f.created_at DESC";

$result = $conn->query($sql);
if (!$result) {
    die("Database query failed: " . $conn->error);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>All Feedbacks - Admin View</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
  <link rel="stylesheet" href="../../assets/style.css" />
</head>
<body>
  <nav class="navbar navbar-dark bg-dark">
    <div class="container d-flex justify-content-between align-items-center">
      <span class="navbar-brand">📝 All Feedbacks</span>
      <a href="admin-dashboard.php" class="btn btn-light btn-sm">← Back to Analytics</a>
    </div>
  </nav>

  <div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h4 class="mb-0">User Feedback Log</h4>
      <a href="export-csv.php" class="btn btn-success btn-sm">📥 Export to CSV</a>
    </div>

    <?php if ($deleted === 'success'): ?>
      <div class="alert alert-success text-center">✅ Feedback deleted successfully!</div>
    <?php endif; ?>

    <?php if ($result->num_rows > 0): ?>
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
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
              <?php $is_guest = empty($row['name']); ?>
              <tr <?= $is_guest ? "style='background-color:#fff8e1;'" : "" ?>>
                <td><?= $row['name'] ? htmlspecialchars($row['name']) : 'Guest User' ?></td>
                <td><?= $row['email'] ? htmlspecialchars($row['email']) : 'N/A' ?></td>
                <td><?= htmlspecialchars($row['category']) ?></td>
                <td><?= (int)$row['rating'] ?></td>
                <td>
                  <?php
                  $s = strtolower($row['sentiment']);
                  $badge = $s === 'positive' ? 'success' : ($s === 'negative' ? 'danger' : 'secondary');
                  echo "<span class='badge badge-$badge text-uppercase'>$s</span>";
                  ?>
                </td>
                <td><?= htmlspecialchars($row['comment']) ?></td>
                <td><?= $row['created_at'] ?></td>
                <td>
                  <form method="POST" action="delete-feedback.php" onsubmit="return confirm('Are you sure you want to delete this feedback?');">
                    <input type="hidden" name="id" value="<?= $row['id'] ?>">
                    <button type="submit" class="btn btn-danger btn-sm">🗑 Delete</button>
                  </form>
                </td>
              </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      </div>
    <?php else: ?>
      <div class="alert alert-info text-center">No feedbacks found.</div>
    <?php endif; ?>
  </div>

  <footer class="text-center mt-5 mb-3">
    <p>© 2025 Smart Feedback System</p>
  </footer>
</body>
</html>
