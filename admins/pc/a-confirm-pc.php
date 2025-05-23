<?php
// Start session and include database connection
session_start();
include '../../database/dbconn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 1. Sanitize form inputs
    $member_name = trim($_POST['member_name']);
    $subunit = trim($_POST['subunit']);
    $pc_type = intval($_POST['pc_type']);
    $pc_title = trim($_POST['pc_title']);
    $pc_status = trim($_POST['pc_status']);

    // 2. Handle file upload
    $targetDir = "../../assets/photocards/"; // Updated path to correct folder location

    // Create folder if it doesn't exist
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true);
    }

    $fileName = basename($_FILES["pc_filepath"]["name"]);
    $targetFilePath = $targetDir . $fileName;
    $uploadOk = 1;

    $imageFileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));

    // Check if image file is an actual image
    $check = getimagesize($_FILES["pc_filepath"]["tmp_name"]);
    if ($check === false) {
        echo "<script>alert('File is not an image.'); window.history.back();</script>";
        $uploadOk = 0;
    }

    // Check file size (e.g., max 5MB)
    if ($_FILES["pc_filepath"]["size"] > 5000000) {
        echo "<script>alert('Sorry, your file is too large.'); window.history.back();</script>";
        $uploadOk = 0;
    }

    // Allow certain file formats
    $allowedTypes = ['jpg', 'png', 'jpeg', 'webp'];
    if (!in_array($imageFileType, $allowedTypes)) {
        echo "<script>alert('Sorry, only JPG, JPEG, PNG & WEBP files are allowed.'); window.history.back();</script>";
        $uploadOk = 0;
    }

    // Final check and move file
    if ($uploadOk) {
        if (move_uploaded_file($_FILES["pc_filepath"]["tmp_name"], $targetFilePath)) {
            // File uploaded successfully
            $dbFilePath = "assets/photocards/" . $fileName; // Save relative path to DB, this one beinng updated

            // 3. Insert into database
            $sql = "INSERT INTO photocard_library (member_name, subunit, pc_type, pc_title, pc_status, pc_filepath)
                    VALUES (?, ?, ?, ?, ?, ?)";

            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssss", $member_name, $subunit, $pc_type, $pc_title, $pc_status, $dbFilePath);

            if ($stmt->execute()) {
                echo "<script>alert('Photocard successfully added!'); window.location.href='../maindb/admin-photocards-page.php';</script>";
            } else {
                echo "<script>alert('Error inserting data: " . addslashes($stmt->error) . "'); window.history.back();</script>";
            }

            $stmt->close();
        } else {
            echo "<script>alert('Sorry, there was an error uploading your file.'); window.history.back();</script>";
        }
    }

    $conn->close();
} else {
    echo "<script>alert('Invalid request.'); window.history.back();</script>";
}
?>
