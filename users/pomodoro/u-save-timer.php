<?php
include '../../database/dbconn.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'error' => 'User not logged in']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and validate inputs
    $user_id = (int) $_SESSION['user_id'];
    $total_rounds = isset($_POST['total_rounds']) ? (int) $_POST['total_rounds'] : 1;
    $round_duration = isset($_POST['round_duration']) ? (int) $_POST['round_duration'] : 1500;
    $break_duration = isset($_POST['break_duration']) ? (int) $_POST['break_duration'] : 300;
    $started_at = date('Y-m-d H:i:s');

    // Prepare SQL statement
    $sql = "INSERT INTO timer_sessions 
            (user_id, total_rounds, round_duration, break_duration, completed_rounds, status, started_at)
            VALUES (?, ?, ?, ?, 0, 'in_progress', ?)";
    
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        // Debug prepare error
        die("Prepare failed: " . htmlspecialchars($conn->error));
    }

    $stmt->bind_param("iiiis", $user_id, $total_rounds, $round_duration, $break_duration, $started_at);

    if ($stmt->execute()) {
    // Get insert_id from the connection, not the statement
    $session_id = $conn->insert_id;

    // Redirect to timer page with session_id
    header("Location: timer.php?add_success=1&session_id=$session_id");
    exit;
} else {
    header("Location: timer.php?add_success=0");
    exit;
}

}
?>
