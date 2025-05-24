<?php
// u-delete-task.php
include '../../database/dbconn.php';
session_start();

// Check if the user is logged in by verifying session data
if (!isset($_SESSION['user_id'])) {
    // Redirect to login if the user is not logged in
    header("Location: ../../login.php");
    exit();
}

if (!isset($_POST['taskID'])) {
    die('Task ID is missing');
}

$task_id = intval($_POST['taskID']);

$user_id = $_SESSION['user_id']; // assuming user logged in and user_id stored in session

// Update task status to inactive (soft delete)
$query = "UPDATE to_do_list SET task_status = 'Inactive' WHERE task_id = ? AND user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('ii', $task_id, $user_id);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    $_SESSION['message'] = 'Task deleted successfully.';
} else {
    $_SESSION['message'] = 'Failed to delete task.';
}

$stmt->close();
$conn->close();

// Redirect back to task list or wherever
header('Location: ../pomodoro/timer.php');
exit;
?>
