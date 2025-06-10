<?php
session_start();
include '../../database/dbconn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['pc_id']; // Photocard ID for updating

    // 1. Get current image path from DB
    $query = "SELECT pc_filepath FROM photocard_library WHERE pc_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($currentImagePath);
    $stmt->fetch();
    $stmt->close();

    // 2. Prepare new data
    $member_name = trim($_POST['member_name']);
    $subunit = trim($_POST['subunit']);
    $pc_type = intval($_POST['pc_type']);
    $pc_title = trim($_POST['pc_title']);
    $pc_status = trim($_POST['pc_status']);

    $newImageUploaded = isset($_FILES["pc_filepath"]["name"]) && $_FILES["pc_filepath"]["name"] !== "";

    if ($newImageUploaded) {
        // 3. File upload handling
        $targetDir = "../../assets/photocards/";
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        $fileName = basename($_FILES["pc_filepath"]["name"]);
        $targetFilePath = $targetDir . $fileName;
        $imageFileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));

        // Validate image
        $check = getimagesize($_FILES["pc_filepath"]["tmp_name"]);
        if ($check === false || $_FILES["pc_filepath"]["size"] > 5000000 || !in_array($imageFileType, ['jpg', 'jpeg', 'png', 'webp'])) {
            echo "<script>alert('Invalid image file.'); window.history.back();</script>";
            exit;
        }

        // 4. Delete old image file
        $fullOldPath = "../../" . $currentImagePath;
        if (file_exists($fullOldPath)) {
            unlink($fullOldPath);
        }

        // 5. Move new image
        if (move_uploaded_file($_FILES["pc_filepath"]["tmp_name"], $targetFilePath)) {
            $dbFilePath = "assets/photocards/" . $fileName;
        } else {
            echo "<script>alert('Failed to upload new image.'); window.history.back();</script>";
            exit;
        }
    } else {
        $dbFilePath = $currentImagePath; // No new image, use current path
    }

    // 6. Update record in DB
    $sql = "UPDATE photocard_library 
            SET member_name = ?, subunit = ?, pc_type = ?, pc_title = ?, pc_status = ?, pc_filepath = ? 
            WHERE pc_id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssi", $member_name, $subunit, $pc_type, $pc_title, $pc_status, $dbFilePath, $id);

     if ($stmt->execute()) {
        header("Location: ../maindb/admin-photocards-page.php?status=success");
    } else {
        header("Location: ../maindb/admin-photocards-page.php?status=error");
    }

    $stmt->close();
    $conn->close();
}
?>
