<?php
session_start();

// ✅ Only admin can add companies
if (!isset($_SESSION['email']) || $_SESSION['email'] !== 'admin@example.com') {
    echo "<script>alert('Only admins can add companies.'); window.location.href='../dashboard.php';</script>";
    exit();
}

require_once '../backend/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $desc = trim($_POST['description']);
    $logo = '';

    // ✅ Handle logo upload
    if (!empty($_FILES['logo']['name'])) {
        $target_dir = "../uploads/";
        $logo = basename($_FILES['logo']['name']);
        $target_file = $target_dir . $logo;

        if (move_uploaded_file($_FILES['logo']['tmp_name'], $target_file)) {
            // Logo uploaded
        } else {
            echo "<script>alert('Logo upload failed.');</script>";
            $logo = '';
        }
    }

    $stmt = $conn->prepare("INSERT INTO companies (name, description, logo_path) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $desc, $logo);

    if ($stmt->execute()) {
        echo "<script>alert('✅ Company added successfully.'); window.location.href='company-dashboard.php';</script>";
    } else {
        echo "<script>alert('❌ Failed to add company.'); window.location.href='add-company.php';</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Add Company - Smart Feedback</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
  <div class="container mt-5">
    <h3 class="mb-4">➕ Add New Company</h3>
    <form method="POST" enctype="multipart/form-data">
      <div class="form-group">
        <label>Company Name</label>
        <input type="text" name="name" class="form-control" required>
      </div>
      <div class="form-group">
        <label>Description</label>
        <textarea name="description" class="form-control" required></textarea>
      </div>
      <div class="form-group">
        <label>Upload Logo (optional)</label>
        <input type="file" name="logo" class="form-control-file">
      </div>
      <button type="submit" class="btn btn-primary">Create Company</button>
    </form>
  </div>
</body>
</html>
