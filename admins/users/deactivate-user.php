<?php
include("../../include/auth.php"); // Include the authentication file

// Check if the user is an admin
check_role('admin');

include '../../database/dbconn.php';

if (isset($_GET['id'])) {
    $user_id = $_GET['id'];

    // Get current status
    $query = "SELECT user_status FROM users WHERE user_id = $user_id";
    $result = mysqli_query($conn, $query);

    if ($row = mysqli_fetch_assoc($result)) {
        $current_status = $row['user_status'];
        $new_status = ($current_status === 'active') ? 'inactive' : 'active';

        // Update status
        $update = "UPDATE users SET user_status = '$new_status' WHERE user_id = $user_id";
        if (mysqli_query($conn, $update)) {
header("Location: ../maindb/admin-users-page.php?status_changed=$new_status");
            exit();
        } else {
            echo "Error updating status.";
        }
    } else {
        echo "User not found.";
    }
} else {
    echo "No user ID provided.";
}
?>
