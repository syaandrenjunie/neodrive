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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body>
    <header class="header-container">
        <div class="logo-title-container">
            <!-- Image will trigger the sidebar -->
            <img src="../../assets/image/timer2.png" alt="Logo" class="timer-icon" data-bs-toggle="offcanvas"
                data-bs-target="#offcanvasWithBothOptions" aria-controls="offcanvasWithBothOptions"> <a
                class="link-offset-2 link-offset-3-hover link-underline link-underline-opacity-0 link-underline-opacity-75-hover"
                href="#">Add New Member</a>
        </div>
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
    <?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
<script>
    Swal.fire({
        icon: 'success',
        title: 'Success!',
        text: 'New member registered successfully.',
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'OK'
    });
</script>
<?php endif; ?>

    <div class="container mt-2">
        <div class="new-user-container">
            <h3 class="mb-4">Create New Member</h3><br>

            <form class="row g-3 needs-validation" action="a-confirm-member.php" method="POST" novalidate
                enctype="multipart/form-data">

                <!-- User Role Selection -->
                <fieldset class="row mb-3">
                    <legend class="col-form-label col-sm-2 pt-0">Member Type</legend>
                    <div class="col-sm-10">
                        <div class="form-check">
                        <input class="form-check-input" type="radio" name="member_type" value="NCT" checked onclick="toggleMemberAndSubunit()">
                        <label class="form-check-label" for="gridRadios1">
                                NCT 
                            </label>
                        </div>
                        <div class="form-check">
                        <input class="form-check-input" type="radio" name="member_type" value="Other" onclick="toggleMemberAndSubunit()">
                        <label class="form-check-label" for="gridRadios2">
                                Other
                            </label>
                        </div>
                    </div>
                </fieldset>

                <!-- Member Name Dropdown -->
<div class="row mb-3" id="nctMemberRow" style="display: none;">
  <label for="inputType3" class="col-sm-2 col-form-label">Member's Name</label>
  <div class="col-sm-10">
      <select class="form-select" id="nctMemberSelect" name="member_name" onchange="toggleOtherInput()">
          <option selected>Choose NCT member...</option>
                            <option value="Taeyong">Taeyong</option>
                            <option value="Johnny">Johnny</option>
                            <option value="Yuta">Yuta</option>
                            <option value="Doyoung">Doyoung</option>
                            <option value="Jungwoo">Jungwoo</option>
                            <option value="Jaehyun">Jaehyun</option>
                            <option value="Winwin">Winwin</option>
                            <option value="Mark Lee">Mark Lee</option>
                            <option value="Haechan">Haechan</option>
                            <option value="Jeno">Jeno</option>
                            <option value="Jaemin">Jaemin</option>
                            <option value="Jisung">Jisung</option>
                            <option value="Renjun">Renjun</option>
                            <option value="chenle">Chenle</option>
                            <option value="Kun">Kun</option>
                            <option value="Yangyang">Yangyang</option>
                            <option value="Hendery">Hendery</option>
                            <option value="Ten">Ten</option>
                            <option value="Xiaojun">Xiaojun</option>
                            <option value="Sakuya">Sakuya</option>
                            <option value="Riku">Riku</option>
                            <option value="Sion">Sion</option>
                            <option value="Ryo">Ryo</option>
                            <option value="Yushi">Yushi</option>
                            <option value="Jaehee">Jaehee</option>
                        </select>
                    </div>
                </div>
                <!-- Other Member Input (hidden by default) -->
<div class="row mb-3" id="otherFigureRow" style="display: none;">
    <label for="otherFigureInput" class="col-sm-2 col-form-label">Figure's Name</label>
    <div class="col-sm-10">
        <input type="text" class="form-control" id="otherFigureInput" name="other_member_name" placeholder="Enter figure's name">
    </div>
</div>

                <!-- Subunit Dropdown -->
<div class="row mb-3" id="subunitRow" style="display: none;">
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


                <!-- Submit Button -->
                <div class="col-12 text-end">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>

        </div>
    </div>

    <!-- Bootstrap JS (with Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JavaScript for Sidebar Toggle -->
    <script>
        // Get the image element that will trigger the sidebar
        const sidebarToggle = document.getElementById('sidebarToggle');

        // Add click event to trigger sidebar
        sidebarToggle.addEventListener('click', function () {
            const sidebar = new bootstrap.Offcanvas(document.getElementById('offcanvasWithBothOptions'));
            sidebar.show(); // Show the sidebar when the image is clicked
        });

        document.addEventListener("DOMContentLoaded", function () {
        toggleMemberAndSubunit(); // Call once on load to set initial state
    });

    function toggleMemberAndSubunit() {
        const memberType = document.querySelector('input[name="member_type"]:checked').value;
        const nctMemberRow = document.getElementById('nctMemberRow');
        const subunitRow = document.getElementById('subunitRow');
        const otherFigureRow = document.getElementById('otherFigureRow');

        if (memberType === "NCT") {
            nctMemberRow.style.display = "flex";
            subunitRow.style.display = "flex";
            toggleOtherInput(); // Check if "Other" is selected in the dropdown
        } else {
            nctMemberRow.style.display = "none";
            subunitRow.style.display = "none";
            otherFigureRow.style.display = "flex";
        }
    }

    function toggleOtherInput() {
        const selectedMember = document.getElementById('nctMemberSelect').value;
        const otherFigureRow = document.getElementById('otherFigureRow');

        if (selectedMember === "Other") {
            otherFigureRow.style.display = "flex";
        } else {
            otherFigureRow.style.display = "none";
        }
    }
    </script>
    <style>
        .container {
            max-width: 600px;
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