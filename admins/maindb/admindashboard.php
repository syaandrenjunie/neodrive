<?php
include("../../include/auth.php"); 

check_role('admin');

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Main Dashboard</title>
    <link rel="stylesheet" href="../../css/style.css">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

</head>

<body>
    <header class="header-container">
        <div class="logo-title-container">
                <a class="link-offset-2 link-offset-3-hover link-underline link-underline-opacity-0 
                link-underline-opacity-75-hover" href="#">Admin Main Dashboard</a>
        </div>
        <div class="header-buttons">
            <a href="adminprofile.php" class="profile-icon">
                <i class="fa-solid fa-user-circle"></i>
            </a>
        </div>

    </header><br><br>

    <!-- Include Sidebar -->
    <?php include('../menus-sidebar.php'); ?>

    <!-- Bootstrap JS (with Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>


    <style>
        .equal-height {
            display: flex;
            flex-direction: column;
            height: 100%;
            width: 100%;
        }

        body {
            margin: 0;
            padding: 0;
            overflow-x: hidden;
            /* Prevent horizontal scroll */
        }

        .static-sidebar {
            width: 250px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background-color: rgb(243, 247, 237);
            padding: 20px 10px;
            overflow-y: auto;
            border-right: 1px solid #ddd;
            z-index: 1030;
        }

        .header-container {
            position: sticky;
            top: 0;
            left: 0;
            width: calc(100% - 250px); /* Fix overflow caused by sidebar */
            margin-left: 250px; /* Reserve space for sidebar */
            display: flex;
            justify-content: space-between;
            align-items: center;
            z-index: 1040;
        }

        .profile-icon {

            margin-left: 15px;
        }

        .header-buttons {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            min-width: 80px;
        }

        .main-content {
            margin-left: 250px;
            margin-top: 60px;
            padding: 20px;
        }
    </style>

</body>

</html>