<?php
session_start();

// ✅ Only admin can assign users
if (!isset($_SESSION['email']) || $_SESSION['email'] !== 'admin@example.com') {
    echo "<script>alert('Access denied.'); window.location.href='../public/dashboard.php';</script>";
    exit();
}

require_once '../backend/db.php';

// ✅ Assign user on form submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = (int)$_POST['user_id'];
    $company_id = (int)$_POST['company_id'];

    $stmt = $conn->prepare("UPDATE users SET company_id = ? WHERE id = ?");
    $stmt->bind_param("ii", $company_id, $user_id);
    
    if ($stmt->execute()) {
        echo "<script>alert('✅ User assigned successfully.'); window.location.href='assign-user-to-company.php';</script>";
    } else {
        echo "<script>alert('❌ Failed to assign user.');</script>";
    }
}

// ✅ Get all users and companies
$users = $conn->query("SELECT id, name, email FROM users WHERE company_id IS NULL");
$companies = $conn->query("SELECT id, name FROM companies");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Assign User to Company</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
  <h3 class="mb-4">Assign User to a Company</h3>
  <form method="POST">
    <div class="form-group">
      <label>Select User</label>
      <select name="user_id" class="form-control" required>
        <option value="">-- Select User --</option>
        <?php while ($user = $users->fetch_assoc()): ?>
          <option value="<?= $user['id'] ?>"><?= $user['name'] ?> (<?= $user['email'] ?>)</option>
        <?php endwhile; ?>
      </select>
    </div>

    <div class="form-group">
      <label>Select Company</label>
      <select name="company_id" class="form-control" required>
        <option value="">-- Select Company --</option>
        <?php while ($company = $companies->fetch_assoc()): ?>
          <option value="<?= $company['id'] ?>"><?= $company['name'] ?></option>
        <?php endwhile; ?>
      </select>
    </div>

    <button type="submit" class="btn btn-primary">Assign</button>
  </form>
</div>
</body>
</html>
