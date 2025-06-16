<?php
session_start();
include '../../database/dbconn.php';

$report_id = $_POST['report_id'];
$new_status = $_POST['new_status'];

$update = "UPDATE report SET report_status = '$new_status' WHERE report_id = $report_id";
if (mysqli_query($conn, $update)) {
    $_SESSION['success'] = "Status updated successfully.";
} else {
    $_SESSION['success'] = "Failed to update status.";
}
header("Location: ../maindb/admin-report-page.php");
exit();
?>
