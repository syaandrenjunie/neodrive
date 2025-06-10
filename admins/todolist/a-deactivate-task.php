<?php
include("../../include/auth.php");
include("../../database/dbconn.php");

check_role('admin');

if (isset($_GET['id'])) {
    $task_id = $_GET['id'];

    // Get current task status
    $query = "SELECT task_status FROM task WHERE task_id = '$task_id'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        $currentStatus = $row['task_status'];

        // Toggle status
        $newStatus = ($currentStatus === 'Active') ? 'Incomplete' : 'Completed';

        // Update task status
        $updateQuery = "UPDATE task SET task_status = '$newStatus' WHERE task_id = '$task_id'";
        
        if (mysqli_query($conn, $updateQuery)) {
            header("Location: ../maindb/admin-task-page.php?status=success");
            exit();
        } else {
            echo "Error updating task status: " . mysqli_error($conn);
        }
    } else {
        echo "Task not found.";
    }
} else {
    echo "No task ID provided.";
}
?>
