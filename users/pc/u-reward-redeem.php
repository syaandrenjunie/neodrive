<?php
session_start();
include '../../database/dbconn.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'Not logged in']);
    exit;
}

$user_id = $_SESSION['user_id'];
$session_id = isset($_GET['session_id']) ? (int) $_GET['session_id'] : 0;

if ($session_id > 0) {
    $stmt = $conn->prepare("INSERT INTO user_pccollection (user_id, session_id, reward_type) VALUES (?, ?, 'photocard')");
    $stmt->bind_param("ii", $user_id, $session_id);
    $stmt->execute();
    $stmt->close();

    echo json_encode(['success' => true]);
} else {
    echo json_encode(['error' => 'Invalid session ID']);
}
