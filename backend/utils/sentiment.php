<?php
function detectSentiment($comment) {
  $positive = ['good', 'great', 'excellent', 'happy', 'love', 'like', 'awesome'];
  $negative = ['bad', 'worst', 'poor', 'terrible', 'hate', 'awful', 'disappointed'];

  $text = strtolower($comment);

  foreach ($positive as $word) {
    if (strpos($text, $word) !== false) return 'positive';
  }

  foreach ($negative as $word) {
    if (strpos($text, $word) !== false) return 'negative';
  }

  return 'neutral';
}
?>

