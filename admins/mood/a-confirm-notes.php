<?php
include("../../include/auth.php"); 
check_role('admin'); 

include '../../database/dbconn.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Sanitize and retrieve inputs
    $note = trim($_POST['m_notes']);
    $mood_type = $_POST['mood_type'];
    $status = $_POST['mnotes_status'];

    // Validate input
    if (!empty($note) && !empty($mood_type) && in_array($status, ['Active', 'Inactive'])) {
        try {
            $stmt = $conn->prepare("INSERT INTO mindful_notes (mood_type, m_notes, mnotes_status) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $mood_type, $note, $status);

            if ($stmt->execute()) {
                // Redirect with success flag
                header("Location: a-list-notes.php?success=1");
                exit;
            } else {
                // Redirect with error flag
                header("Location: a-list-notes.php?error=1");
                exit;
            }

            $stmt->close();
        } catch (Exception $e) {
            header("Location: a-list-notes.php?error=1");
            exit;
        }
    } else {
        header("Location: a-list-notes.php?error=1");
        exit;
    }

    $conn->close();
} else {
    // Redirect if accessed without POST
    header("Location: ../mood/a-list-notes.php");
    exit;
}
?>
