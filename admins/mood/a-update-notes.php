<?php

include("../../include/auth.php"); // Include the authentication file
include("../../database/dbconn.php"); // Include the authentication file


// Check if the user is an admin
check_role('admin');



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and fetch form inputs
    $mnotes_id = mysqli_real_escape_string($conn, $_POST['mnotes_id']);
    $m_notes = mysqli_real_escape_string($conn, $_POST['m_notes']);
    $mood_type = mysqli_real_escape_string($conn, $_POST['mood_type']);
    $mnotes_status = mysqli_real_escape_string($conn, $_POST['mnotes_status']);

    // Prepare the update query
    $query = "UPDATE mindful_notes 
              SET m_notes = '$m_notes', 
                  mood_type = '$mood_type', 
                  mnotes_status = '$mnotes_status',
                  updated_at = NOW()
              WHERE mnotes_id = '$mnotes_id'";

    // Execute the query
    if (mysqli_query($conn, $query)) {
        // On success, show a browser alert using JavaScript
        echo '<script type="text/javascript">
                alert("Note updated successfully");
                window.location.href = "a-list-notes.php"; // Redirect after alert
              </script>';
        exit();
    } else {
        // Handle error
        echo "Error updating note: " . mysqli_error($conn);
    }
} else {
    // If not POST method
    header("Location: a-list-notes.php");
    exit();
}
?>
