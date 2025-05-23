<?php
include("../../include/auth.php"); // Include the authentication file

// Check if the user is an admin
check_role('admin');

include '../../database/dbconn.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Sanitize user inputs to prevent SQL injection
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $user_roles = mysqli_real_escape_string($conn, $_POST['user_roles']);
    
    // Hash the password for security
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
    // Profile picture (if any)
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] == 0) {
        $profile_picture = $_FILES['profile_picture']['name'];
        $target_dir = "../../uploads/";
        $target_file = $target_dir . basename($profile_picture);

        // Move uploaded file to the target directory
        if (!move_uploaded_file($_FILES['profile_picture']['tmp_name'], $target_file)) {
            echo "<script>alert('Sorry, there was an error uploading your file.');</script>";
            exit;
        }
    } else {
        $profile_picture = null; // No file uploaded
    }

    // SQL query to insert the new user into the database
    $sql = "INSERT INTO users (username, email, password, user_roles, profile_picture) 
            VALUES ('$username', '$email', '$hashed_password', '$user_roles', '$profile_picture')";

    // Execute the query
    if ($conn->query($sql) === TRUE) {
        echo "<script>
                alert('New user registered successfully!');
                window.location.href = '../maindb/admin-users-page.php';
              </script>";
        exit;
    } else {
        echo "<script>alert('Error: " . addslashes($conn->error) . "');</script>";
    }
}

// Close the database connection
$conn->close();
?>