<?php
session_start();
include '../../database/dbconn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $member_name = trim($_POST['member_name']);
    $subunit = trim($_POST['subunit']);
    $pc_type = intval($_POST['pc_type']);
    $pc_title = trim($_POST['pc_title']);
    $pc_status = trim($_POST['pc_status']);

    $targetDir = "../../assets/photocards/";

    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true);
    }

    $fileName = basename($_FILES["pc_filepath"]["name"]);
    $targetFilePath = $targetDir . $fileName;
    $uploadOk = 1;

    $imageFileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));

    $check = getimagesize($_FILES["pc_filepath"]["tmp_name"]);
    if ($check === false) {
        $_SESSION['swal'] = ['type' => 'error', 'title' => 'Oops...', 'text' => 'File is not an image.'];
        header("Location: ../maindb/admin-photocards-page.php");
        exit;
    }

    if ($_FILES["pc_filepath"]["size"] > 5000000) {
        $_SESSION['swal'] = ['type' => 'error', 'title' => 'Too Large', 'text' => 'Your file is too large.'];
        header("Location: ../maindb/admin-photocards-page.php");
        exit;
    }

    $allowedTypes = ['jpg', 'png', 'jpeg', 'webp'];
    if (!in_array($imageFileType, $allowedTypes)) {
        $_SESSION['swal'] = ['type' => 'error', 'title' => 'Invalid File Type', 'text' => 'Only JPG, JPEG, PNG & WEBP files are allowed.'];
        header("Location: ../maindb/admin-photocards-page.php");
        exit;
    }

    if ($uploadOk && move_uploaded_file($_FILES["pc_filepath"]["tmp_name"], $targetFilePath)) {
        $dbFilePath = "assets/photocards/" . $fileName;

        $sql = "INSERT INTO photocard_library (member_name, subunit, pc_type, pc_title, pc_status, pc_filepath)
                VALUES (?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssisss", $member_name, $subunit, $pc_type, $pc_title, $pc_status, $dbFilePath);

        if ($stmt->execute()) {
            $_SESSION['swal'] = ['type' => 'success', 'title' => 'Success!', 'text' => 'Photocard successfully added!'];
        } else {
            $_SESSION['swal'] = ['type' => 'error', 'title' => 'Database Error', 'text' => 'Error inserting data: ' . $stmt->error];
        }
        $stmt->close();
    } else {
        $_SESSION['swal'] = ['type' => 'error', 'title' => 'Upload Failed', 'text' => 'There was an error uploading your file.'];
    }

    $conn->close();
    header("Location: ../maindb/admin-photocards-page.php");
    exit;
} else {
    $_SESSION['swal'] = ['type' => 'error', 'title' => 'Invalid Request', 'text' => 'This request is not allowed.'];
    header("Location: ../maindb/admin-photocards-page.php");
    exit;
}
?>
