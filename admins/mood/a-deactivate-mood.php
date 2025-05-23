<?php

include("../../include/auth.php"); // Include the authentication file

// Check if the user is an admin
check_role('admin');

include '../../database/dbconn.php';

if (isset($_GET['id'])) {
    $mood_id = $_GET['id'];

    // Get current status
    $query = "SELECT mood_status FROM mood_checkin WHERE mood_id = $mood_id";
    $result = mysqli_query($conn, $query);

    if ($row = mysqli_fetch_assoc($result)) {
        $current_status = $row['mood_status'];
        $new_status = ($current_status === 'Active') ? 'Inactive' : 'Active';

        // Update status
        $update = "UPDATE mood_checkin SET mood_status = '$new_status' WHERE mood_id = $mood_id";
        if (mysqli_query($conn, $update)) {
            header("Location: ../maindb/admin-moods-page.php?status_changed=success");
            exit();
        } else {
            echo "Error updating status.";
        }
    } else {
        echo "Mood Check-In not found.";
    }
} else {
    echo "No mood ID provided.";
}
?>
