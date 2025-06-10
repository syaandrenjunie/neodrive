<?php
include("../../include/auth.php"); 

check_role('admin');

include("../../database/dbconn.php");

// Fetch NCT members from the database
$members = [];
$query = "SELECT member_name FROM member WHERE member_type = 'NCT'";
$result = mysqli_query($conn, $query);

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $members[] = $row['member_name'];
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Photocards Main Dashboard</title>
    <link rel="stylesheet" href="../../css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body>
    <header class="header-container">
        <div class="logo-title-container">
            <img src="../../assets/image/clock.png" alt="Logo" class="timer-icon" data-bs-toggle="offcanvas"
                data-bs-target="#offcanvasWithBothOptions" aria-controls="offcanvasWithBothOptions">
            <a class="link-underline link-underline-opacity-0" href="../maindb/admin-photocards-page.php">New Photocards</a>
        </div>
        <div class="header-buttons">
            <a class="link-underline link-underline-opacity-0" href="../maindb/admin-photocards-page.php">Lists</a>
            <a class="link-underline link-underline-opacity-0" href="../pc/a-add-pc.php">New</a>
            <a href="adminprofile.php" class="profile-icon">
                <i class="fa-solid fa-user-circle"></i>
            </a>
        </div>
    </header><br>

    <!-- Include Sidebar -->
    <?php include('../menus-sidebar.php'); ?>

    <div class="container mt-2">
        <div class="new-user-container">
            <h3 class="mb-4">Create New Photocards</h3><br>

            <form class="row g-3 needs-validation" action="a-confirm-pc.php" method="POST" novalidate
                enctype="multipart/form-data">

                <!-- PC Picture Upload -->
                <div class="row mb-3">
                    <label for="inputGroupFile023" class="col-sm-2 col-form-label">PC's Picture</label>
                    <div class="col-sm-10">

                        <input type="file" class="form-control" id="inputGroupFile02" name="pc_filepath">
                    </div>
                </div>

                <!-- Member name input -->
                <div class="row mb-3">
                    <label for="inputMember3" class="col-sm-2 col-form-label">Member's Name</label>
                    <div class="col-sm-10">
                        <select class="form-select" id="inputGroupSelect01" name="member_name">
                            <option value="" disabled selected>Choose NCT member...</option>
                            <?php foreach ($members as $name): ?>
                                <option value="<?php echo htmlspecialchars($name); ?>"><?php echo htmlspecialchars($name); ?></option>
                            <?php endforeach; ?>
                        </select>

                    </div>
                </div>

                <!-- Subunit Input -->
                <div class="row mb-3">
                    <label for="inputUnit3" class="col-sm-2 col-form-label">Subunit</label>
                    <div class="col-sm-10">
                        <select class="form-select" id="inputGroupSelect01" name="subunit">
                            <option value="" disabled selected>Choose subunit..</option>
                            <option value="NCT">NCT</option>
                            <option value="NCT127">NCT 127</option>
                            <option value="NCTDREAM">NCT Dream</option>
                            <option value="NCTWISH">NCT Wish</option>
                            <option value="WAYV">WayV</option>

                        </select>
                    </div>
                </div>

                <!-- PC Type Input -->
                <div class="row mb-3">
                    <label for="inputType3" class="col-sm-2 col-form-label">PC Type</label>
                    <div class="col-sm-10">
                        <select class="form-select" id="inputGroupSelect01" name="pc_type">
                            <option value="" disabled selected>Choose PC type...</option>
                            <option value="1">Common</option>
                            <option value="2">Rare</option>
                            <option value="3">Exclusive</option>
                        </select>
                    </div>
                </div>


                <div class="row mb-3">
                    <label for="inputTitle3" class="col-sm-2 col-form-label">PC Title</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="inputTitle3" name="pc_title" required>
                    </div>
                </div>

                <!-- PC status Selection -->
                <fieldset class="row mb-3">
                    <legend class="col-form-label col-sm-2 pt-0">PC Status</legend>
                    <div class="col-sm-10">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="pc_status" value="Active" checked>
                            <label class="form-check-label" for="gridRadios1">
                                Active
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="pc_status" value="Inactive">
                            <label class="form-check-label" for="gridRadios2">
                                Inactive
                            </label>
                        </div>
                    </div>
                </fieldset>

                <!-- Submit Button -->
                <div class="col-12 text-end">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>

        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
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

            // Enable Bootstrap validation
            (function () {
                'use strict';
                var forms = document.querySelectorAll('.needs-validation');
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
    </script>


    <style>
        .container {
            max-width: 1000px;
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
    </style>
</body>

</html>