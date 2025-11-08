<?php
session_start();

// ✅ Allow only admin
if (!isset($_SESSION['email']) || $_SESSION['email'] !== 'admin@example.com') {
    die("Access denied. Admins only.");
}

require_once '../../backend/db.php';

// Set headers to force file download
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=feedbacks.csv');

// Open output buffer
$output = fopen('php://output', 'w');

// Output column headings
fputcsv($output, ['Name', 'Email', 'Category', 'Rating', 'Sentiment', 'Comment', 'Date']);

// Fetch feedback records with user info
$sql = "SELECT u.name, u.email, f.category, f.rating, f.sentiment, f.comment, f.created_at
        FROM feedbacks f
        JOIN users u ON f.user_id = u.id
        ORDER BY f.created_at DESC";

$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        fputcsv($output, [
            $row['name'],
            $row['email'],
            $row['category'],
            $row['rating'],
            $row['sentiment'],
            $row['comment'],
            $row['created_at']
        ]);
    }
} else {
    // Output a single empty row if no results
    fputcsv($output, ['No records found.']);
}

fclose($output);
exit;
?>
