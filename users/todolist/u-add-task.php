<?php
session_start();
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['error' => 'Invalid request method']);
    exit;
}

include '../../database/dbconn.php'; // Make sure this sets up $conn

$data = json_decode(file_get_contents("php://input"), true);

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'User not logged in']);
    exit;
}

$user_id = $_SESSION['user_id'];
$task_name = trim($data['task_name'] ?? '');
$task_details = trim($data['task_details'] ?? '');
$priority_id = intval($data['priority_id'] ?? 0);

// Basic validation
if (empty($task_name) || $priority_id === 0) {
    echo json_encode(['error' => 'Missing task name or priority']);
    exit;
}

// Insert into database
$stmt = $conn->prepare("INSERT INTO to_do_list (user_id, task_name, task_details, priority_id) VALUES (?, ?, ?, ?)");
$stmt->bind_param("issi", $user_id, $task_name, $task_details, $priority_id);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'task_id' => $stmt->insert_id]);
} else {
    echo json_encode(['error' => 'Insert failed', 'details' => $stmt->error]);
}

$stmt->close();
$conn->close();
?>
