<?php
session_start();

// ✅ Ensure user is logged in and is not admin (admin user_id = 0)
if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] == 0) {
    echo "<script>alert('Login required.'); window.location.href='../public/index.html';</script>";
    exit();
}

// ✅ Connect to DB
require_once 'db.php';  // Assuming this file is in /backend/

// ✅ Collect and sanitize inputs
$user_id = $_SESSION['user_id'];
$category = trim($_POST['category']);
$rating = (int) $_POST['rating'];
$raw_comment = trim($_POST['feedback']);
$comment_lower = strtolower($raw_comment);
$sanitized_comment = htmlspecialchars($raw_comment, ENT_QUOTES);

// ✅ Sentiment detection (simple keywords)
$positive_keywords = ['good', 'great', 'like', 'love', 'excellent', 'happy', 'awesome'];
$negative_keywords = ['bad', 'worst', 'poor', 'hate', 'terrible', 'awful', 'disappointed'];
$sentiment = 'neutral';

foreach ($positive_keywords as $word) {
    if (strpos($comment_lower, $word) !== false) {
        $sentiment = 'positive';
        break;
    }
}
foreach ($negative_keywords as $word) {
    if (strpos($comment_lower, $word) !== false) {
        $sentiment = 'negative';
        break;
    }
}

// ✅ Insert feedback into database
$stmt = $conn->prepare("INSERT INTO feedbacks (user_id, category, rating, comment, sentiment) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("isiss", $user_id, $category, $rating, $sanitized_comment, $sentiment);

if ($stmt->execute()) {
    echo "<script>alert('✅ Feedback submitted successfully!'); window.location.href='../public/dashboard.php';</script>";
} else {
    echo "<script>alert('❌ Failed to submit feedback. Please try again.'); window.location.href='../public/feedback.html';</script>";
}

$stmt->close();
$conn->close();
?>
