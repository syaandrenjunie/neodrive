<?php
include("../../include/auth.php");
check_role('admin');
include '../../database/dbconn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize quote and type
    $quotes_text = mysqli_real_escape_string($conn, $_POST['quotes_text']);
    $type = mysqli_real_escape_string($conn, $_POST['type']);

    // Get the selected member ID from either dropdown
    $member_id = '';
    if (!empty($_POST['nct_member_id'])) {
        $member_id = $_POST['nct_member_id'];
    } elseif (!empty($_POST['other_member_id'])) {
        $member_id = $_POST['other_member_id'];
    }

    // Check if member_id is still empty
    if (empty($member_id)) {
        echo "<script>
            alert('Please select a member.');
            window.history.back();
        </script>";
        exit;
    }

    $member_id = mysqli_real_escape_string($conn, $member_id);

    // Insert into database
    $sql = "INSERT INTO quotes_library (quotes_text, type, member_id) 
            VALUES ('$quotes_text', '$type', '$member_id')";

    if (mysqli_query($conn, $sql)) {
        header("Location: a-add-quotes.php?status=success");
        exit();
    } else {
        header("Location: a-add-quotes.php?status=error");
        exit();
    }

    mysqli_close($conn);
}
?>
