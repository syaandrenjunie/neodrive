<?php
include '../../database/dbconn.php';
session_start();

if (!isset($_SESSION['user_id']) || !isset($_POST['quote_id']) || !isset($_POST['action'])) {
    http_response_code(400);
    echo "Missing parameters.";
    exit();
}

$user_id = $_SESSION['user_id'];
$quote_id = intval($_POST['quote_id']);
$action = $_POST['action'];

if ($action === 'pin') {
    $stmt = $conn->prepare("INSERT IGNORE INTO user_quotes (user_id, quotes_id) VALUES (?, ?)");
    $stmt->bind_param("ii", $user_id, $quote_id);
    $stmt->execute();
    echo "Pinned!";
} elseif ($action === 'unpin') {
    $stmt = $conn->prepare("DELETE FROM user_quotes WHERE user_id = ? AND quotes_id = ?");
    $stmt->bind_param("ii", $user_id, $quote_id);
    $stmt->execute();
    echo "Unpinned!";
} else {
    http_response_code(400);
    echo "Invalid action.";
}
?>
