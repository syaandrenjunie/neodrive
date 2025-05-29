<?php
// Include DB connection and session start
include '../../database/dbconn.php';
session_start();

// Check if the user is logged in by verifying session data
if (!isset($_SESSION['user_id'])) {
    // Redirect to login if the user is not logged in
    header("Location: ../../login.php");
    exit();
}

// Retrieve the user ID from the session
$user_id = $_SESSION['user_id'];

$show_unmarked_alert = false;

if (isset($_SESSION['unmarked_task']) && $_SESSION['unmarked_task'] === true) {
    $show_unmarked_alert = true;
    unset($_SESSION['unmarked_task']);
}

// Fetch priority levels from the database
$priorityQuery = "SELECT * FROM priority_levels";
$priorityResult = mysqli_query($conn, $priorityQuery);
if (!$priorityResult) {
    die('Error fetching priority levels: ' . mysqli_error($conn));
}

$priorityLevels = [];
while ($row = mysqli_fetch_assoc($priorityResult)) {
    $priorityLevels[] = $row;
}

// Handle task creation (POST request)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['task_name'])) {
    $task_name = mysqli_real_escape_string($conn, $_POST['task_name']);
    $task_details = mysqli_real_escape_string($conn, $_POST['task_details']);
    $priority_id = $_POST['priority']; // Priority ID selected from dropdown

    // Insert the new task into the to_do_list table
    $sql = "INSERT INTO to_do_list (user_id, task_name, task_details, priority_id) VALUES ('$user_id', '$task_name', '$task_details', '$priority_id')";
    if (mysqli_query($conn, $sql)) {
        // Set session flag to indicate success
        $_SESSION['task_success'] = true; // set flag
        header("Location: " . $_SERVER['PHP_SELF']); // redirect to avoid form resubmission
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

?>