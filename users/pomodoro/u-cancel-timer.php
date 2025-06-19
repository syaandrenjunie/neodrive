<?php
session_start();
require '../../database/dbconn.php';

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    exit("Unauthorized");
}

$user_id = $_SESSION['user_id'];
$session_id = isset($_POST['session_id']) ? (int) $_POST['session_id'] : 0;

if ($session_id === 0) {
    http_response_code(400);
    exit("Missing session ID.");
}

// ✅ Update status only if session exists and not completed yet
$stmt = $conn->prepare("
    UPDATE timer_sessions 
    SET status = 'cancelled', ended_at = NOW() 
    WHERE session_id = ? AND user_id = ? AND status != 'completed'
");
$stmt->bind_param("ii", $session_id, $user_id);
$stmt->execute();
$stmt->close();

echo "Timer session cancelled.";
?>
