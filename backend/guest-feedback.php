<?php
require_once 'db.php';

// ✅ Get form data
$category = trim($_POST['category']);
$rating   = (int) $_POST['rating'];
$comment  = trim($_POST['comment']);
$comment_lower = strtolower($comment);

// ✅ Sentiment analysis (basic keyword detection)
$positive = ['good', 'great', 'excellent', 'happy', 'love', 'like', 'awesome'];
$negative = ['bad', 'worst', 'poor', 'hate', 'terrible', 'awful', 'disappointed'];
$sentiment = 'neutral';

foreach ($positive as $word) {
    if (strpos($comment_lower, $word) !== false) {
        $sentiment = 'positive';
        break;
    }
}
foreach ($negative as $word) {
    if (strpos($comment_lower, $word) !== false) {
        $sentiment = 'negative';
        break;
    }
}

// ✅ Insert as Guest feedback (no user_id)
$stmt = $conn->prepare("INSERT INTO feedbacks (user_id, category, rating, comment, sentiment) VALUES (NULL, ?, ?, ?, ?)");
$stmt->bind_param("siss", $category, $rating, $comment, $sentiment);

if ($stmt->execute()) {
    echo "<script>alert('✅ Thank you! Your feedback has been submitted anonymously.'); window.location.href='../public/guest-feedback.html';</script>";
} else {
    echo "<script>alert('❌ Failed to submit feedback. Please try again.'); window.location.href='../public/guest-feedback.html';</script>";
}

$stmt->close();
$conn->close();
?>
