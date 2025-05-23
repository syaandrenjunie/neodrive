<?php
include '../../database/dbconn.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $task_id = $_POST['task_id'];
    $task_name = mysqli_real_escape_string($conn, $_POST['task_name']);
    $task_details = mysqli_real_escape_string($conn, $_POST['task_details']);
    $priority_id = $_POST['priority_id'];

    $updateQuery = "UPDATE to_do_list SET task_name = ?, task_details = ?, priority_id = ? WHERE task_id = ?";
    $stmt = mysqli_prepare($conn, $updateQuery);
    mysqli_stmt_bind_param($stmt, "ssii", $task_name, $task_details, $priority_id, $task_id);

    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['update_success'] = true;
        header("Location: timer.php"); // redirect after update
        exit();
    } else {
        echo "Error updating task: " . mysqli_error($conn);
    }
}
?>
