<?php
// Include DB connection
include '../../database/dbconn.php';
session_start();

// Check if the user is logged in by verifying session data
if (!isset($_SESSION['user_id'])) {
    // Redirect to login if the user is not logged in
    header("Location: ../../login.php");
    exit();
}

$user_id = $_SESSION['user_id']; // Get user ID from session
$taskID = $_POST['taskID']; // Get task ID from the form
$is_completed = isset($_POST['is_completed']) ? 1 : 0; // Check if the checkbox is checked or unchecked

// Update task completion status in the database
$updateQuery = "UPDATE to_do_list SET is_completed = '$is_completed' WHERE task_id = '$taskID' AND user_id = '$user_id'";

if (mysqli_query($conn, $updateQuery)) {
    // Only set the session flag when the task is marked as completed (checked)
    if ($is_completed) {
        $_SESSION['task_completed'] = true;
    } else {
        unset($_SESSION['task_completed']);
    }

    // Redirect to the previous page
    header("Location: " . $_SERVER['HTTP_REFERER']); 
    exit();
} else {
    echo "Error: " . mysqli_error($conn);
}
?>
