<?php
include("include/auth.php");
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Logout</title>
    <script>
        window.onload = function () {
            const firstConfirm = confirm("Are you sure you want to log out?");
            if (firstConfirm) {
                const secondConfirm = confirm("This will end your session. Proceed to log out?");
                if (secondConfirm) {
                    // Proceed to logout
                    window.location.href = "logout.php?confirm=yes";
                } else {
                    // Cancel second confirmation
                    window.history.back();
                }
            } else {
                // Cancel first confirmation
                window.history.back();
            }
        };
    </script>
</head>
<body>
<?php
if (isset($_GET['confirm']) && $_GET['confirm'] === 'yes') {
    session_unset();
    session_destroy();
    echo "<script>alert('Logged out successfully!'); window.location.href = 'login.php';</script>";
    exit();
}
?>
</body>
</html>
