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

$total_rounds = (int) $row['total_rounds'];
$current_completed = (int) $row['completed_rounds'];

if ($round > $current_completed) {
    // Update session progress
    if ($round >= $total_rounds) {
        $stmt = $conn->prepare("
            UPDATE timer_sessions 
            SET completed_rounds = ?, status = 'completed', ended_at = NOW() 
            WHERE session_id = ? AND user_id = ?
        ");
    } else {
        $stmt = $conn->prepare("
            UPDATE timer_sessions 
            SET completed_rounds = ? 
            WHERE session_id = ? AND user_id = ?
        ");
    }

    $stmt->bind_param("iii", $round, $session_id, $user_id);
    $stmt->execute();
    $stmt->close();

    // 🧃 If it's the final round, reward a photocard
    if ($round >= $total_rounds) {
        // Get a random active photocard the user DOES NOT own yet
        $pcQuery = $conn->prepare("
            SELECT pc_id, pc_filepath, pc_title 
            FROM photocard_library 
            WHERE pc_status = 'active' 
            AND pc_id NOT IN (
                SELECT pc_id FROM user_pccollection WHERE user_id = ?
            )
            ORDER BY RAND()
            LIMIT 1
        ");
        $pcQuery->bind_param("i", $user_id);
        $pcQuery->execute();
        $pcResult = $pcQuery->get_result();
        $pcRow = $pcResult->fetch_assoc();
        $pcQuery->close();

        if ($pcRow) {
            // Insert into user collection
            $insert = $conn->prepare("
                INSERT INTO user_pccollection (user_id, pc_id, rewarded_at) 
                VALUES (?, ?, NOW())
            ");
            $insert->bind_param("ii", $user_id, $pcRow['pc_id']);
            $insert->execute();
            $insert->close();

            // Output the photocard as image
            $img_src = '../../' . $pcRow['pc_filepath'];

            echo "<img src='" . htmlspecialchars($img_src) . "' alt='" . htmlspecialchars($pcRow['pc_title']) . "' style='max-width:60%; border-radius:8px;'>";

        } else {
            echo "No new photocard available to reward.";
        }
    } else {
        echo "Work round recorded successfully.";
    }
} else {
    echo "No update needed. Current round already recorded.";
}

$conn->close();
?>