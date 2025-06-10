<?php
include("../../include/auth.php");
check_role('admin');
include '../../database/dbconn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $member_type = mysqli_real_escape_string($conn, $_POST['member_type']);

    // Handle member name
    if ($member_type === 'NCT') {
        $member_name = mysqli_real_escape_string($conn, $_POST['member_name']);
        $subunit = mysqli_real_escape_string($conn, $_POST['subunit'] ?? '');
    } else {
        $member_name = mysqli_real_escape_string($conn, $_POST['other_member_name']);
        $subunit = 'None';
    }

    // Basic validation
    if (empty($member_name)) {
        echo "<script>
            alert('Please enter a member name.');
            window.history.back();
        </script>";
        exit;
    }

    // INSERT query
    $sql = "INSERT INTO member (member_name, member_type, subunit) 
            VALUES ('$member_name', '$member_type', '$subunit')";

    if (mysqli_query($conn, $sql)) {
        header("Location: a-add-member.php?success=1");
        exit;
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
