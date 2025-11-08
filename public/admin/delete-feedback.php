<?php
session_start();

// ✅ Admin-only access
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    echo "<script>alert('Admins only.'); window.location.href='../dashboard.php';</script>";
    exit();
}

require_once '../../backend/db.php';

// ✅ Check if feedback ID is provided
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = intval($_POST['id']);
    
    // ✅ Delete feedback by ID
    $stmt = $conn->prepare("DELETE FROM feedbacks WHERE id = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        header("Location: view-feedbacks.php?deleted=success");
        exit();
    } else {
        echo "<script>alert('❌ Failed to delete feedback.'); window.location.href='view-feedbacks.php';</script>";
    }
} else {
    header("Location: view-feedbacks.php");
    exit();
}
?>
