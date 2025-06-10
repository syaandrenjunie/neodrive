<?php
session_start(); 
include("../../database/dbconn.php"); 
include("../../include/auth.php"); 
check_role('admin');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $member_id = $_POST['member_id'];
    $member_name = $_POST['member_name'];
    $member_type = $_POST['member_type'];
    $subunit = $_POST['subunit'];

    // Automatically set subunit to 'None' if member_type is 'Other'
    if ($member_type === 'Other') {
        $subunit = 'None';
    }

    // Update query
    $query = "UPDATE member 
              SET member_name = ?, member_type = ?, subunit = ?
              WHERE member_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssi", $member_name, $member_type, $subunit, $member_id);

    if ($stmt->execute()) {
        $_SESSION['success'] = "Member details updated successfully!";
        header("Location: ../maindb/admin-member-page.php");
        exit();
    } else {
        echo "Error updating record: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
