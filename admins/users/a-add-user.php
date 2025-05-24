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
    <title>Users Management Main Dashboard</title>
    <link rel="stylesheet" href="../../css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.5/dist/sweetalert2.min.css">

</head>

<body>
    <header class="header-container">
        <div class="logo-title-container">
            <!-- Image will trigger the sidebar -->
            <img src="../../assets/image/clock.png" alt="Logo" class="timer-icon" data-bs-toggle="offcanvas"
                data-bs-target="#offcanvasWithBothOptions" aria-controls="offcanvasWithBothOptions"> <a
                class="link-offset-2 link-offset-3-hover link-underline link-underline-opacity-0 link-underline-opacity-75-hover"
                href="../maindb/admin-users-page.php">Add New User</a>
        </div>
        <div class="header-buttons">
            <a class="link-offset-2 link-offset-3-hover link-underline link-underline-opacity-0 
     link-underline-opacity-75-hover" href="../maindb/admin-users-page.php">Lists</a>
            <a class="link-offset-2 link-offset-3-hover link-underline link-underline-opacity-0 
     link-underline-opacity-75-hover" href="../users/a-add-pc.php">New</a>

            <a href="adminprofile.php" class="profile-icon">
                <i class="fa-solid fa-user-circle"></i>
            </a>

        </div>
    </header><br>

    <!-- Include Sidebar -->
    <?php include('../menus-sidebar.php'); ?>

    <div class="container mt-2">
        <div class="new-user-container">
            <h2 class="mb-4">New User Registration</h2><br>
            <form class="row g-3 needs-validation" action="a-confirm-user.php" method="POST" novalidate
                enctype="multipart/form-data">

                <div class="row mb-3">
                    <label for="inputUsername3" class="col-sm-2 col-form-label">Username</label>
                    <div class="col-sm-10">
                        <input type="email" class="form-control" id="inputUsername3" name="username" required>
                    </div>
                </div>

                <!-- Email Input -->
                <div class="row mb-3">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">Email</label>
                    <div class="col-sm-10">
                        <input type="email" class="form-control" id="inputEmail3" name="email" required>
                    </div>
                </div>

                <!-- Password Input -->
                <div class="row mb-3">
                    <label for="inputPassword3" class="col-sm-2 col-form-label">Password</label>
                    <div class="col-sm-10 position-relative">
                        <input type="password" class="form-control" id="inputPassword3" name="password" required>
                        <i class="fa-solid fa-eye-slash position-absolute" id="togglePassword"
                            style="right: 20px; top: 12px; cursor: pointer;"></i>
                    </div>
                </div>


                <!-- User Role Selection -->
                <fieldset class="row mb-3">
                    <legend class="col-form-label col-sm-2 pt-0">User Role</legend>
                    <div class="col-sm-10">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="user_roles" value="admin" checked>
                            <label class="form-check-label" for="gridRadios1">
                                Admin
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="user_roles" value="user">
                            <label class="form-check-label" for="gridRadios2">
                                User
                            </label>
                        </div>
                    </div>
                </fieldset>

                <!-- Profile Picture Upload -->
                <div class="input-group mb-3">
                    <label for="inputGroupFile023" class="col-sm-2 col-form-label">Profile Picture</label>
                    <input type="file" class="form-control" id="inputGroupFile02" name="profile_picture">
                </div>

                <!-- Submit Button -->
                <div class="col-12 text-end">
                    <button type="submit" class="btn btn-primary">Sign up</button>
                </div>
            </form>

        </div>
    </div>





    <!-- Bootstrap JS (with Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.5/dist/sweetalert2.all.min.js"></script>


    <!-- Custom JavaScript for Sidebar Toggle -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            // Get the image element that will trigger the sidebar
            const sidebarToggle = document.getElementById('sidebarToggle');

            // Add click event to trigger sidebar
            sidebarToggle.addEventListener('click', function () {
                const sidebar = new bootstrap.Offcanvas(document.getElementById('offcanvasWithBothOptions'));
                sidebar.show(); // Show the sidebar when the image is clicked
            });

            // Enable client-side validation
            (function () {
                'use strict';
                // Fetch all the forms we want to apply custom Bootstrap validation styles to
                var forms = document.querySelectorAll('.needs-validation');

                // Loop over them and prevent submission if form is invalid
                Array.prototype.slice.call(forms)
                    .forEach(function (form) {
                        form.addEventListener('submit', function (event) {
                            if (!form.checkValidity()) {
                                event.preventDefault();
                                event.stopPropagation();
                            }
                            form.classList.add('was-validated');
                        }, false);
                    });
            })();

        });

        //password toggle
        document.addEventListener('DOMContentLoaded', function () {
            const togglePassword = document.getElementById("togglePassword");
            const password = document.getElementById("inputPassword3");

            if (togglePassword && password) {
                togglePassword.addEventListener("click", function () {
                    const type = password.getAttribute("type") === "password" ? "text" : "password";
                    password.setAttribute("type", type);

                    // Toggle icon
                    this.classList.toggle("fa-eye");
                    this.classList.toggle("fa-eye-slash");
                });
            }
        });

    </script>

    <style>
        .container {
            max-width: 800px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-top: 20px;
        }

        .new-user-container h2 {
            text-align: center;
            margin-bottom: 30px;
            color: rgb(0, 0, 0);
        }

        .form-control {
            border-radius: 5px;
            box-shadow: none;
        }

        .input-group-text {
            border-radius: 5px;
            background-color: #f0f0f0;
        }



        .form-check-input {
            margin-left: 10px;
        }

        .form-check-label {
            font-size: 16px;
            color: #555;
        }

        .form-check {
            margin-bottom: 15px;
        }

        .input-group {
            margin-bottom: 15px;
        }

        .input-group-text {
            font-size: 14px;
        }

        label {
            font-size: 16px;
        }
    </style>
</body>

</html>