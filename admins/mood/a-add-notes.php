<?php
include("../../include/auth.php"); 

check_role('admin');

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> New Mindful Mood</title>
    <link rel="stylesheet" href="../../css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body>
    <header class="header-container">
        <div class="logo-title-container">
            <img src="../../assets/image/clock.png" alt="Logo" class="timer-icon" data-bs-toggle="offcanvas"
                data-bs-target="#offcanvasWithBothOptions" aria-controls="offcanvasWithBothOptions">
            <a class="link-underline link-underline-opacity-0" href="../maindb/admin-moods-page.php">New Mindful
                Notes</a>
        </div>
        <div class="header-buttons">
            <a class="link-underline link-underline-opacity-0" href="../maindb/admin-moods-page.php">List</a>
            <a class="link-underline link-underline-opacity-0" href="../mood/a-list-notes.php">Notes</a>
            <a class="link-underline link-underline-opacity-0" href="#">New</a>
            <a href="../maindb/adminprofile.php" class="profile-icon">
                <i class="fa-solid fa-user-circle"></i>
            </a>
        </div>
    </header><br><br>

    <!-- Include Sidebar -->
    <?php include('../menus-sidebar.php'); ?>

    <!-- Bootstrap JS (with Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <div class="container mt-2">
        <div class="new-user-container">
            <h3 class="mb-4" style="color:rgb(142, 196, 92);">Create New Mindful Notes</h3><br>

            <form class="row g-3 needs-validation" action="a-confirm-notes.php" method="POST" novalidate
                enctype="multipart/form-data">

                <!-- notes text input -->
                <div class="row mb-3">
                    <label for="inputNotes3" class="col-sm-2 col-form-label">Mindful Notes</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" id="exampleFormControlTextarea1" name="m_notes"
                            rows="3"></textarea>
                    </div>
                </div>

                <!-- Mood Type Input -->
                <div class="row mb-3">
                    <label for="inputType3" class="col-sm-2 col-form-label">Mood's Type</label>
                    <div class="col-sm-10">
                        <select class="form-select" id="inputGroupSelect01" name="mood_type">
                            <option selected>Choose mood's type...</option>
                            <option value="Happy">Happy</option>
                            <option value="Motivated">Motivated</option>
                            <option value="Relieved">Relieved</option>
                            <option value="Scared">Scared</option>
                            <option value="Stressed">Stressed</option>
                            <option value="Sad">Sad</option>

                        </select>
                    </div>
                </div>

                <!-- MNotes  Status Selection -->
                <fieldset class="row mb-3">
                    <legend class="col-form-label col-sm-2 pt-0">Status</legend>
                    <div class="col-sm-10">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="mnotes_status" value="Active" checked>
                            <label class="form-check-label" for="gridRadios1">
                                Active
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="mnotes_status" value="Inactive">
                            <label class="form-check-label" for="gridRadios2">
                                Inacive
                            </label>
                        </div>
                    </div>
                </fieldset>

                <!-- Submit Button -->
                <div class="col-12 text-end">
                    <button type="submit" class="btn custom-save-btn">Add New</button>
                </div>
            </form>

        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>

        document.addEventListener('DOMContentLoaded', function () {
            const sidebarToggle = document.getElementById('sidebarToggle');

            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', function () {
                    const sidebar = new bootstrap.Offcanvas(document.getElementById('offcanvasWithBothOptions'));
                    sidebar.show();
                });
            }


    </script>

    <style>
        .container {
            max-width: 700px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-top: 20px;
        }

        .new-user-container h3 {
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

        .custom-save-btn {
            padding: 8px 16px;
            font-size: 1rem;
            background-color: rgb(172, 236, 134);
            color: black;
            border: none;
            transition: background-color 0.3s ease;
        }
    </style>

</body>

</html>