<?php
include '../../database/dbconn.php';
session_start();

if (!isset($_SESSION['user_id'])) {
  header("Location: ../../login.php");
  exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Get and trim inputs
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
        mkdir($uploadFileDir, 0755, true);
      }

      // Get old image from DB
$get_old_query = $conn->prepare("SELECT profile_picture FROM users WHERE user_id = ?");
$get_old_query->bind_param("i", $user_id);
$get_old_query->execute();
$get_old_query->bind_result($old_profile_picture);
$get_old_query->fetch();
$get_old_query->close();

if (!empty($old_profile_picture) && file_exists('../../' . $old_profile_picture)) {
  unlink('../../' . $old_profile_picture); // delete the old file
}


      if (move_uploaded_file($fileTmpPath, $destPath)) {
        $profile_picture_path = 'assets/uploads/' . $newFileName;
      }
    }
  }

  // Dynamic SQL generation
  $fields = [];
  $params = [];
  $param_types = "";

  if (!empty($username)) {
    $fields[] = "username = ?";
    $params[] = $username;
    $param_types .= "s";
  }

  if (!empty($email)) {
    $fields[] = "email = ?";
    $params[] = $email;
    $param_types .= "s";
  }

  if (!empty($bias)) {
    $fields[] = "bias = ?";
    $params[] = $bias;
    $param_types .= "s";
  }

  if (!empty($profile_picture_path)) {
    $fields[] = "profile_picture = ?";
    $params[] = $profile_picture_path;
    $param_types .= "s";
  }

  if (count($fields) > 0) {
    $params[] = $user_id;
    $param_types .= "i";

    $query = "UPDATE users SET " . implode(", ", $fields) . " WHERE user_id = ?";
    $stmt = $conn->prepare($query);

    if ($stmt === false) {
      $_SESSION['error_message'] = "Prepare failed: " . $conn->error;
      header("Location: profile.php");
      exit();
    }

    $stmt->bind_param($param_types, ...$params);

    if ($stmt->execute()) {
      $_SESSION['success_message'] = "Profile updated successfully!";
    } else {
      $_SESSION['error_message'] = "Failed to update profile.";
    }

    $stmt->close();
  } else {
    $_SESSION['error_message'] = "No changes were made.";
  }

  header("Location: profile.php");
  exit();
} else {
  header("Location: profile.php");
  exit();
}
?>
