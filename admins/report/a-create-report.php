<?php
include("../../include/auth.php");
include '../../database/dbconn.php';
check_role('admin');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generate New Report</title>
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
            <a class="link-offset-2 link-underline link-underline-opacity-0" href="../maindb/admin-report-page.php">Generate New Report</a>
        </div>
        <div class="header-buttons">
            <a class="link-underline link-underline-opacity-0" href="../report/a-create-report.php">New</a>
            <a class="link-underline link-underline-opacity-0" href="#">Lists</a>
            <a href="../maindb/adminprofile.php" class="profile-icon">
                <i class="fa-solid fa-user-circle"></i>
            </a>
        </div>
    </header><br><br>

    <!-- Include Sidebar -->
    <?php include('../menus-sidebar.php'); ?>


    <!-- Report Form as Container -->
    <div class="container mt-4 mb-5">
        <div class="card shadow p-4 mx-auto" style="max-width: 800px;">
            <h4 class="mb-4" style="color:rgb(142, 196, 92);">Generate Report</h4>

            <form action="a-confirm-report.php" method="POST">
                <div class="mb-3">
                    <label class="form-label">Select Report Type:</label>
                    <select name="report_type" class="form-select" required>
                        <option value="user">User</option>
                        <option value="pomodoro">Pomodoro</option>
                        <option value="photocard">Photocard</option>
                        <option value="user_pccollection">User's Photocard</option>
                        <option value="quotes">Quotes</option>
                        <option value="user_quotes">User's Quotes</option>
                        <option value="mindful_notes">Mindful Notes</option>
                        <option value="mood">Mood</option>
                        <option value="todolist">To-do List</option>
                        <option value="chatbot">Chatbot</option>
                        <option value="report">Report</option>

                        <option value="member">Member</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Include Parameters:</label><br>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" name="params[]" value="date_range" checked>
                        <label class="form-check-label">Date Range</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" name="params[]" value="user_id" checked>
                        <label class="form-check-label">User ID</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" name="params[]" value="status" checked>
                        <label class="form-check-label">Status</label>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Date From:</label>
                        <input type="date" class="form-control" name="from_date">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Date To:</label>
                        <input type="date" class="form-control" name="to_date">
                    </div>
                </div>

                <input type="hidden" name="admin_id" value="<?= $_SESSION['user_id'] ?>">

                <div class="text-end">
                    <button type="submit" name="generate_report" class="btn custom-save-btn">Generate PDF</button>

                </div>
            </form>
        </div>
    </div>


    <?php if (isset($_SESSION['report_status'])): ?>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                <?php if ($_SESSION['report_status'] === 'success'): ?>
                    Swal.fire({
                        icon: 'success',
                        title: 'Report Generated',
                        text: 'The PDF report was successfully created.',
                        confirmButtonColor: '#28a745'
                    });
                <?php else: ?>
                    Swal.fire({
                        icon: 'error',
                        title: 'Report Failed',
                        text: 'There was a problem generating the report.',
                        confirmButtonColor: '#dc3545'
                    });
                <?php endif; ?>
            });
        </script>
        <?php unset($_SESSION['report_status']); ?>
    <?php endif; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const sidebarToggle = document.getElementById('sidebarToggle');
        if (sidebarToggle) {
            sidebarToggle.addEventListener('click', function () {
                const sidebar = new bootstrap.Offcanvas(document.getElementById('offcanvasWithBothOptions'));
                sidebar.show();
            });
        }

        
    </script>
    <style>
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