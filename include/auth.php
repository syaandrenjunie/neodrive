<?php
// Start the session (if it's not already started)
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if the user is logged in and has the appropriate role
// Change 'admin' to 'user' or whatever role is required for the current page
function check_role($required_role) {
    // Check if the user is logged in and if the role matches
    if (!isset($_SESSION['user_roles']) || $_SESSION['user_roles'] !== $required_role) {
        // Redirect to the login page or another page if the user doesn't have the required role
        header("Location: ../../login.php");
        exit();
    }
}
?>
