<?php
include '../../database/dbconn.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $task_id = $_POST['task_id'];
    $task_name = mysqli_real_escape_string($conn, $_POST['task_name']);
    $task_details = mysqli_real_escape_string($conn, $_POST['task_details']);
    $priority_id = $_POST['priority'];

    $updateQuery = "UPDATE to_do_list SET task_name='$task_name', task_details='$task_details', priority_id='$priority_id' WHERE task_id='$task_id'";
    
    if (mysqli_query($conn, $updateQuery)) {
        $_SESSION['task_update_success'] = true;
    } else {
        $_SESSION['task_update_error'] = "Error updating task: " . mysqli_error($conn);
    }

    // After successful update
header("Location: ../pomodoro/timer.php?edit_success=1");
exit();

}
?>
