<?php
session_start();
include '../../database/dbconn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $report_id = $_POST['report_id'];
    $filepath = $_POST['filepath'];

    // First, delete the file if it exists
    if (file_exists($filepath)) {
        unlink($filepath); // delete the file from the server
    }

    // Then, delete the record from the database
    $deleteQuery = "DELETE FROM report WHERE report_id = ?";
    $stmt = mysqli_prepare($conn, $deleteQuery);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $report_id);
        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['success'] = "Report deleted successfully.";
        } else {
            $_SESSION['success'] = "Failed to delete report from database.";
        }
        mysqli_stmt_close($stmt);
    } else {
        $_SESSION['success'] = "Failed to prepare delete statement.";
    }

    mysqli_close($conn);
    header("Location: ../maindb/admin-report-page.php");
    exit();
}
?>
