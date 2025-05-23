<?php
include("../../include/auth.php"); // Include the authentication file
check_role('admin');

require("../../database/dbconn.php"); // Include DB connection if not already

// Fetch members grouped by type
$nct_members = [];
$other_members = [];

$query = "SELECT member_id, member_name, member_type FROM member";
$result = mysqli_query($conn, $query);

while ($row = mysqli_fetch_assoc($result)) {
    if ($row['member_type'] === 'NCT') {
        $nct_members[] = ['id' => $row['member_id'], 'name' => $row['member_name']];
    } else {
        $other_members[] = ['id' => $row['member_id'], 'name' => $row['member_name']];
    }
}
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body>
    <header class="header-container">
        <div class="logo-title-container">
            <img src="../../assets/image/timer2.png" alt="Logo" class="timer-icon" data-bs-toggle="offcanvas"
                data-bs-target="#offcanvasWithBothOptions" aria-controls="offcanvasWithBothOptions">
            <a class="link-underline link-underline-opacity-0" href="../maindb/admin-quotes-page.php">New Quotes</a>
        </div>
        <div class="header-buttons">
            <a class="link-underline link-underline-opacity-0" href="../maindb/admin-quotes-page.php">Lists</a>
            <a class="link-underline link-underline-opacity-0" href="../quotes/a-add-quotes.php">New</a>
            <a href="adminprofile.php" class="profile-icon">
                <i class="fa-solid fa-user-circle"></i>
            </a>
        </div>
    </header><br>

    <!-- Include Sidebar -->
    <?php include('../menus-sidebar.php'); ?>


    

    <div class="container mt-2">
        <div class="new-user-container">
            <h3 class="mb-4">Create New Quotes</h3><br>

            <form class="row g-3 needs-validation" action="a-confirm-quotes.php" method="POST" novalidate
                enctype="multipart/form-data">

                <!-- Quotes text input -->
                <div class="row mb-3">
                    <label for="inputQuotes3" class="col-sm-2 col-form-label">Quotes Text</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" id="exampleFormControlTextarea1" name="quotes_text" rows="3"></textarea>
                    </div>
                </div>

                <!-- Quotes Type Input -->
                <div class="row mb-3">
                    <label for="inputType3" class="col-sm-2 col-form-label">Quotes Type</label>
                    <div class="col-sm-10">
                        <select class="form-select" id="inputGroupSelect01" name="type">
                            <option selected>Choose quotes type...</option>
                            <option value="1">Motivational</option>
                            <option value="2">Funny</option>
                            <option value="3">Philisophical</option>
                            <option value="4">Romantic</option>
                            <option value="5">Lyrics</option>
                        </select>
                    </div>
                </div>

                <!-- Figure's Type Radio -->
<fieldset class="row mb-3">
    <legend class="col-form-label col-sm-2 pt-0">Figure's Type</legend>
    <div class="col-sm-10">
        <div class="form-check">
            <input class="form-check-input" type="radio" name="figure_type" value="NCT" id="typeNCT" checked onchange="toggleMemberSelect()">
            <label class="form-check-label" for="typeNCT">NCT</label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="figure_type" value="Other" id="typeOther" onchange="toggleMemberSelect()">
            <label class="form-check-label" for="typeOther">Other</label>
        </div>
    </div>
</fieldset>

<!-- NCT Member Dropdown -->
<div class="row mb-3 member-select" id="nctSelectBox">
    <label class="col-sm-2 col-form-label">NCT Member</label>
    <div class="col-sm-10">
        <select class="form-select" name="nct_member_id">
    <option selected disabled>Choose NCT member...</option>
    <?php foreach ($nct_members as $member): ?>
        <option value="<?= htmlspecialchars($member['id']) ?>"><?= htmlspecialchars($member['name']) ?></option>
    <?php endforeach; ?>
</select>

    </div>
</div>

<!-- Other Member Dropdown -->
<div class="row mb-3 member-select" id="otherSelectBox" style="display: none;">
    <label class="col-sm-2 col-form-label">Other Figure</label>
    <div class="col-sm-10">
        <select class="form-select" name="other_member_id">
    <option selected disabled>Choose Other figure...</option>
    <?php foreach ($other_members as $member): ?>
        <option value="<?= htmlspecialchars($member['id']) ?>"><?= htmlspecialchars($member['name']) ?></option>
    <?php endforeach; ?>
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
        function toggleMemberSelect() {
        const nctBox = document.getElementById('nctSelectBox');
        const otherBox = document.getElementById('otherSelectBox');
        const figureType = document.querySelector('input[name="figure_type"]:checked').value;

        if (figureType === 'NCT') {
            nctBox.style.display = 'flex';
            otherBox.style.display = 'none';
        } else {
            nctBox.style.display = 'none';
            otherBox.style.display = 'flex';
        }
    }

    document.addEventListener("DOMContentLoaded", function () {
        toggleMemberSelect(); // Ensure initial state
    });

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
    
    document.addEventListener('DOMContentLoaded', function () {
        const urlParams = new URLSearchParams(window.location.search);
        const status = urlParams.get('status');

        if (status === 'success') {
            Swal.fire({
                title: 'Success!',
                text: 'Quote added successfully!',
                icon: 'success',
                confirmButtonText: 'OK'
            }).then(() => {
                window.history.replaceState({}, document.title, "a-add-quotes.php");
            });
        }

        if (status === 'error') {
            Swal.fire({
                title: 'Error!',
                text: 'Failed to add quote.',
                icon: 'error',
                confirmButtonText: 'OK'
            }).then(() => {
                window.history.replaceState({}, document.title, "a-add-quotes.php");
            });
        }
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