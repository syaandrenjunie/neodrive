<?php
session_start();
require '../../database/dbconn.php';

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo "Unauthorized";
    exit;
}

$user_id = (int) $_SESSION['user_id'];
$round = isset($_POST['round']) ? (int) $_POST['round'] : 0;
$session_id = isset($_POST['session_id']) ? (int) $_POST['session_id'] : 0;

if ($round === 0 || $session_id === 0) {
    http_response_code(400);
    echo "Missing round number or session ID.";
    exit;
}

// Check the total_rounds for the session
$check = $conn->prepare("SELECT total_rounds FROM timer_sessions WHERE session_id = ? AND user_id = ?");
$check->bind_param("ii", $session_id, $user_id);
$check->execute();
$result = $check->get_result();
$row = $result->fetch_assoc();
$check->close();

if (!$row) {
    http_response_code(404);
    echo "Session not found.";
    exit;
}

if ($round >= (int)$row['total_rounds']) {
    // All rounds completed - update status and ended_at
    $stmt = $conn->prepare("
        UPDATE timer_sessions 
        SET completed_rounds = ?, status = 'completed', ended_at = NOW() 
        WHERE session_id = ? AND user_id = ?
    ");
} else {
    // Still in progress
    $stmt = $conn->prepare("
        UPDATE timer_sessions 
        SET completed_rounds = ? 
        WHERE session_id = ? AND user_id = ?
    ");
}

$stmt->bind_param("iii", $round, $session_id, $user_id);

if ($stmt->execute()) {
    echo "Session updated successfully.";
} else {
    echo "Error updating session: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
