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

// Get total_rounds and current completed_rounds
$query = $conn->prepare("SELECT total_rounds, completed_rounds FROM timer_sessions WHERE session_id = ? AND user_id = ?");
$query->bind_param("ii", $session_id, $user_id);
$query->execute();
$result = $query->get_result();
$row = $result->fetch_assoc();
$query->close();

if (!$row) {
    http_response_code(404);
    echo "Session not found.";
    exit;
}

$total_rounds = (int)$row['total_rounds'];
$current_completed = (int)$row['completed_rounds'];

// Only update if this is a new work round (greater than current completed_rounds)
if ($round > $current_completed) {
    if ($round >= $total_rounds) {
        // Final work round completed — mark session completed
        $stmt = $conn->prepare("
            UPDATE timer_sessions 
            SET completed_rounds = ?, status = 'completed', ended_at = NOW() 
            WHERE session_id = ? AND user_id = ?
        ");
    } else {
        // Ongoing session — update completed_rounds only
        $stmt = $conn->prepare("
            UPDATE timer_sessions 
            SET completed_rounds = ? 
            WHERE session_id = ? AND user_id = ?
        ");
    }

    $stmt->bind_param("iii", $round, $session_id, $user_id);

    if ($stmt->execute()) {
        echo "Work round recorded successfully.";
    } else {
        echo "Error updating session: " . $stmt->error;
    }

    $stmt->close();
} else {
    // No new round — don't update
    echo "No update needed. Current round already recorded.";
}

$conn->close();
?>
