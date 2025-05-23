<?php
include("../../include/auth.php");
check_role('admin');
include '../../database/dbconn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $member_name = mysqli_real_escape_string($conn, $_POST['quotes_text']); // Assuming 'quotes_text' is actually the member's name
    $member_type = mysqli_real_escape_string($conn, $_POST['type']);

    // Determine which member_id is selected
    $member_id = '';
    if (isset($_POST['nct_member_id']) && !empty($_POST['nct_member_id'])) {
        $member_id = $_POST['nct_member_id'];
    } elseif (isset($_POST['other_member_id']) && !empty($_POST['other_member_id'])) {
        $member_id = $_POST['other_member_id'];
    }

    // Validation
    if (empty($member_id)) {
        echo "<script>
            alert('Please select a member.');
            window.history.back();
        </script>";
        exit;
    }

    $member_id = mysqli_real_escape_string($conn, $member_id);

    // You may need to define subunit from form input if applicable
    $subunit = mysqli_real_escape_string($conn, $_POST['subunit'] ?? '');

    // Insert into member table
    $sql = "INSERT INTO member (member_name, member_type, subunit, member_id) 
            VALUES ('$member_name', '$member_type', '$subunit', '$member_id')";

    if (mysqli_query($conn, $sql)) {
        echo "<script>
            alert('Member added successfully!');
            window.location.href = '../maindb/admin-member-page.php';
        </script>";
    } else {
        echo "<script>
            alert('Failed to add member: " . mysqli_error($conn) . "');
            window.history.back();
        </script>";
    }

    mysqli_close($conn);
}
?>
