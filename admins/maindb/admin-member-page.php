<?php
include("../../include/auth.php"); // Include the authentication file

// Check if the user is an admin
check_role('admin');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Member Main Dashboard</title>
    <link rel="stylesheet" href="../../css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body>
    <header class="header-container">
        <div class="logo-title-container">
            <!-- Image will trigger the sidebar -->
            <img src="../../assets/image/clock.png" alt="Logo" class="timer-icon" data-bs-toggle="offcanvas"
            data-bs-target="#offcanvasWithBothOptions" aria-controls="offcanvasWithBothOptions">            <a class="link-offset-2 link-offset-3-hover link-underline link-underline-opacity-0 link-underline-opacity-75-hover" 
            href="#">Member Management Dashboard</a></div>
            <div class="header-buttons">
            
            <a class="link-offset-2 link-offset-3-hover link-underline link-underline-opacity-0 
     link-underline-opacity-75-hover" href="#">List</a>
            <a class="link-offset-2 link-offset-3-hover link-underline link-underline-opacity-0 
     link-underline-opacity-75-hover" href="../member/a-add-member.php">New</a>
            <a href="profile.php" class="profile-icon">
                <i class="fa-solid fa-user-circle"></i>
            </a>

        </div>
    </header><br>

    <!-- Include Sidebar -->
    <?php include('../menus-sidebar.php'); ?>

    <!-- Bootstrap JS (with Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom JavaScript for Sidebar Toggle -->
    <script>
        // Get the image element that will trigger the sidebar
        const sidebarToggle = document.getElementById('sidebarToggle');
        
        // Add click event to trigger sidebar
        sidebarToggle.addEventListener('click', function() {
            const sidebar = new bootstrap.Offcanvas(document.getElementById('offcanvasWithBothOptions'));
            sidebar.show(); // Show the sidebar when the image is clicked
        });
    </script>
</body>
</html>
