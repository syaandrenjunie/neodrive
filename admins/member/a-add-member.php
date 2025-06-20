<?php
include("../../include/auth.php"); 
check_role('admin');

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Member</title>
    <link rel="stylesheet" href="../../css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body>
    <header class="header-container">
        <div class="logo-title-container">
            <!-- Image will trigger the sidebar -->
            <img src="../../assets/image/clock.png" alt="Logo" class="timer-icon" data-bs-toggle="offcanvas"
                data-bs-target="#offcanvasWithBothOptions" aria-controls="offcanvasWithBothOptions"> <a
                class="link-offset-2 link-offset-3-hover link-underline link-underline-opacity-0 link-underline-opacity-75-hover"
                href="../maindb/admin-member-page.php">Add New Member</a>
        </div>
        <div class="header-buttons">

            <a class="link-offset-2 link-offset-3-hover link-underline link-underline-opacity-0 
     link-underline-opacity-75-hover" href="../maindb/admin-member-page.php">List</a>
            <a class="link-offset-2 link-offset-3-hover link-underline link-underline-opacity-0 
     link-underline-opacity-75-hover" href="#">New</a>
            <a href="../maindb/adminprofile.php" class="profile-icon">
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
            <h4 class="mb-4" style="color:rgb(142, 196, 92);">Add New Member</h4>

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

                <!-- Member Name Text Input -->
                <div class="row mb-3" id="nctMemberRow" style="display: none;">
                <label for="memberNameInput" class="col-sm-2 col-form-label">Member's Name</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="memberNameInput" name="member_name" placeholder="Enter NCT member's name">
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
                            <option value="NCT 127">NCT 127</option>
                            <option value="NCT Dream">NCT Dream</option>
                            <option value="NCT Wish">NCT Wish</option>
                            <option value="WayV">WayV</option>
                        </select>
                    </div>
                </div>


                <!-- Submit Button -->
                <div class="col-12 text-end">
<button type="submit" class="btn custom-save-btn">Add New</button>
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
    const subunitSelect = document.getElementById('inputGroupSelect01');

    if (memberType === "NCT") {
        // Show NCT name + subunit, hide Figure's Name
        nctMemberRow.style.display = "flex";
        subunitRow.style.display = "flex";
        otherFigureRow.style.display = "none";
        subunitSelect.disabled = false;
    } else {
        // Show Figure's Name, hide NCT fields
        nctMemberRow.style.display = "none";
        subunitRow.style.display = "none";
        otherFigureRow.style.display = "flex";
        subunitSelect.disabled = true;
    }
}


document.querySelector('form').addEventListener('submit', function(e) {
    const memberType = document.querySelector('input[name="member_type"]:checked').value;
    const subunitSelect = document.getElementById('inputGroupSelect01');

    if (memberType === "Other") {
        // Clear subunit value so nothing is sent
        subunitSelect.value = "";
    }
});


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

        .custom-save-btn {
            padding: 8px 16px;
            font-size: 1rem;
            background-color: rgb(172, 236, 134);
            color: black;
            border: none;
            transition: background-color 0.3s ease;
        }

        .custom-save-btn:hover {
            background-color: rgb(98, 151, 55);
            color: white;
        }

    </style>
</body>

</html>