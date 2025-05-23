<?php
include("../../include/auth.php"); // Include the authentication file

check_role('admin');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include '../../database/dbconn.php';

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    $quotes_id = $_POST['quotes_id'];
    $member_id = $_POST['member_id'];
    $type = trim($_POST['type']);
    $quotes_text = trim($_POST['quotes_text']);
    $quotes_status = trim($_POST['quotes_status']);

    if (empty($quotes_id) || empty($member_id) || empty($type) || empty($quotes_text) || empty($quotes_status)) {
        $_SESSION['quote_update_error'] = "All fields are required.";
        header("Location: ../maindb/admin-quotes-page.php");
        exit();
    }

    // Validate member_id
    $check_member = mysqli_query($conn, "SELECT member_id FROM member WHERE member_id = '$member_id'");
    if (mysqli_num_rows($check_member) == 0) {
        $_SESSION['quote_update_error'] = "Invalid member selected.";
        header("Location: ../maindb/admin-quotes-page.php");
        exit();
    }

    // Escape special characters in the quotes_text
    $quotes_text = mysqli_real_escape_string($conn, $quotes_text);

    // Prepare the SQL statement using placeholders
    $query = "UPDATE quotes_library SET 
                quotes_text = ?, 
                member_id = ?, 
                type = ?, 
                quotes_status = ?, 
                updated_at = NOW() 
              WHERE quotes_id = ?";

    if ($stmt = mysqli_prepare($conn, $query)) {
        // Bind parameters to the prepared statement
        mysqli_stmt_bind_param($stmt, "ssssi", $quotes_text, $member_id, $type, $quotes_status, $quotes_id);

        // Execute the prepared statement
        if (mysqli_stmt_execute($stmt)) {
            // ✅ SUCCESS: Redirect with status
            header("Location: ../maindb/admin-quotes-page.php?status=success");
            exit();
        } else {
            // ❌ ERROR: Redirect with error message
            header("Location: ../maindb/admin-quotes-page.php?status=error");
            exit();
        }

        // Close the prepared statement
        mysqli_stmt_close($stmt);
    } else {
        // ❌ ERROR: Query preparation failed
        header("Location: ../maindb/admin-quotes-page.php?status=error");
        exit();
    }

    mysqli_close($conn);
    header("Location: ../maindb/admin-quotes-page.php");
    exit();
}
?>
