<?php

include("../../include/auth.php"); // Include the authentication file

// Check if the user is an admin
check_role('admin');


include '../../database/dbconn.php'; // Adjust path as necessary

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Sanitize and retrieve inputs
    $note = trim($_POST['m_notes']);
    $mood_type = $_POST['mood_type']; // Directly retrieve the mood type name
    $status = $_POST['mnotes_status'];

    // Check if all fields are valid
    if (!empty($note) && !empty($mood_type) && in_array($status, ['Active', 'Inactive'])) {
        try {
            // Prepare SQL insert statement
            $stmt = $conn->prepare("INSERT INTO mindful_notes (mood_type, m_notes, mnotes_status) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $mood_type, $note, $status);

            // Execute and check result
            if ($stmt->execute()) {
                echo "<script>alert('Mindful Note added successfully.'); window.location.href='../mood/a-list-notes.php';</script>";
            } else {
                echo "<script>alert('Error adding mindful note.'); window.history.back();</script>";
            }

            $stmt->close();
        } catch (Exception $e) {
            echo "<script>alert('Error: " . $e->getMessage() . "'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('Please fill in all fields correctly.'); window.history.back();</script>";
    }

    $conn->close();
} else {
    header("Location: a-add-notes.php");
    exit();
}
?>
