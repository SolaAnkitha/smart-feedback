<?php
require_once 'db.php';

// Category Data
$catResult = $conn->query("SELECT category, COUNT(*) as count FROM feedbacks GROUP BY category");
$categories = [];
while ($row = $catResult->fetch_assoc()) {
  $categories[] = $row;
}

// Rating Data
$ratingResult = $conn->query("SELECT rating, COUNT(*) as count FROM feedbacks GROUP BY rating");
$ratings = [];
while ($row = $ratingResult->fetch_assoc()) {
  $ratings[] = $row;
}

// Sentiment Data
$sentimentResult = $conn->query("SELECT sentiment, COUNT(*) as count FROM feedbacks GROUP BY sentiment");
$sentiments = [];
while ($row = $sentimentResult->fetch_assoc()) {
  $sentiments[] = $row;
}

// Output JSON
echo json_encode([
  'categories' => $categories,
  'ratings' => $ratings,
  'sentiments' => $sentiments
]);
?>
