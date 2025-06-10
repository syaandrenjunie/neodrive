<?php
include("../../include/auth.php");
include("../../database/dbconn.php");

check_role('admin');

if (isset($_GET['id'])) {
    $member_id = $_GET['id'];

    // Get current status
    $query = "SELECT member_status FROM member WHERE member_id = '$member_id'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        $currentStatus = $row['member_status'];

        // Toggle status
        $newStatus = ($currentStatus === 'Active') ? 'Inactive' : 'Active';

        // ✅ Fixed: Removed extra comma
        $updateQuery = "UPDATE member SET member_status = '$newStatus' WHERE member_id = '$member_id'";
        
        if (mysqli_query($conn, $updateQuery)) {
            header("Location: ../maindb/admin-member-page.php?status=success");
            exit();
        } else {
            echo "Error updating status: " . mysqli_error($conn);
        }
    } else {
        echo "Member not found.";
    }
} else {
    echo "No member ID provided.";
}
?>
