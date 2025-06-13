<?php
include '../../database/dbconn.php';
session_start();

if (!isset($_SESSION['user_id'])) {
  header("Location: ../../login.php");
  exit();
}

$user_id = $_SESSION['user_id'];

// Check if the form was submitted via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = trim($_POST['username']);
  $email = trim($_POST['email']);
  $bias = trim($_POST['bias']);

  // Initialize profile picture path
  $profile_picture_path = null;

  // Handle profile picture upload
  if (isset($_FILES['profilePic']) && $_FILES['profilePic']['error'] === UPLOAD_ERR_OK) {
    $fileTmpPath = $_FILES['profilePic']['tmp_name'];
    $fileName = basename($_FILES['profilePic']['name']);
    $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];

    if (in_array($fileExtension, $allowedExtensions)) {
      $newFileName = 'profile_' . $user_id . '_' . time() . '.' . $fileExtension;
      $uploadFileDir = '../../assets/uploads/';
      $destPath = $uploadFileDir . $newFileName;

      if (!is_dir($uploadFileDir)) {
        mkdir($uploadFileDir, 0755, true); // Create the directory if not exists
      }

      if (move_uploaded_file($fileTmpPath, $destPath)) {
        $profile_picture_path = 'assets/uploads/' . $newFileName; // relative path for DB
      }
    }
  }

  // Update query with conditional profile picture update
  $query = "UPDATE users SET username = ?, email = ?, bias = ?" .
           ($profile_picture_path ? ", profile_picture = ?" : "") .
           " WHERE user_id = ?";

  $stmt = $conn->prepare($query);

  if ($profile_picture_path) {
    $stmt->bind_param("ssssi", $username, $email, $bias, $profile_picture_path, $user_id);
  } else {
    $stmt->bind_param("sssi", $username, $email, $bias, $user_id);
  }

  if ($stmt->execute()) {
    $_SESSION['success_message'] = "Profile updated successfully!";
  } else {
    $_SESSION['error_message'] = "Failed to update profile.";
  }

  $stmt->close();
  header("Location: u-profile.php");
  exit();
} else {
  header("Location: u-profile.php");
  exit();
}
?>
